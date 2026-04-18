<?php namespace Cabnet\MykonosInquiry\Classes;

use Cabnet\MykonosInquiry\Models\Inquiry;
use Cabnet\MykonosInquiry\Models\InquiryNote;
use Mail;
use Schema;
use Session;
use Validator;
use October\Rain\Exception\ValidationException;

class InquiryManager
{
    public static function rules(): array
    {
        return [
            'request_reference' => 'nullable|max:60',
            'full_name' => 'required|min:2|max:120',
            'email' => 'required|email|max:120',
            'phone' => 'nullable|max:60',
            'country' => 'nullable|max:120',
            'guests' => 'nullable|integer|min:1',
            'arrival_date' => 'nullable|date',
            'departure_date' => 'nullable|date',
            'arrival_window' => 'nullable|max:120',
            'group_composition' => 'nullable|max:255',
            'children_travelling' => 'nullable|max:20',
            'budget' => 'nullable|max:120',
            'travel_style' => 'nullable|max:120',
            'stay_mood' => 'nullable|max:120',
            'arrival_mode' => 'nullable|max:120',
            'privacy_level' => 'nullable|max:120',
            'villa_area' => 'nullable|max:120',
            'occasion_type' => 'nullable|max:120',
            'special_moments' => 'nullable|max:500',
            'accommodation_status' => 'nullable|max:120',
            'dining_style' => 'nullable|max:120',
            'nightlife_interest' => 'nullable|max:120',
            'dietary_needs' => 'nullable|max:500',
            'contact_preference' => 'nullable|max:120',
            'details' => 'required|min:10',
            'source_type' => 'nullable|max:60',
            'source_slug' => 'nullable|max:120',
            'source_title' => 'nullable|max:255',
            'source_url' => 'nullable|max:500',
            'requested_mode' => 'nullable|max:40',
            'website' => 'nullable|max:10',
        ];
    }

    public static function submit(array $input): Inquiry
    {
        $validator = Validator::make($input, self::rules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        if (!empty($input['website'])) {
            abort(404);
        }

        $services = array_values(array_filter((array) ($input['services'] ?? [])));
        $requestReference = trim((string) ($input['request_reference'] ?? ''));
        $operatorIntent = self::buildOperatorIntent($input, $services);
        $guestSummary = self::buildGuestSummary($input, $services);
        $urgencyHint = self::makeUrgencyHint($input);
        $priority = self::makePriority($input, $services, $urgencyHint);

        $inquiry = new Inquiry();
        $inquiry->fill([
            'request_reference' => $requestReference ?: null,
            'source_type' => $input['source_type'] ?? null,
            'source_slug' => $input['source_slug'] ?? null,
            'source_title' => $input['source_title'] ?? null,
            'source_url' => $input['source_url'] ?? null,
            'requested_mode' => $input['requested_mode'] ?? null,
            'full_name' => $input['full_name'] ?? null,
            'email' => $input['email'] ?? null,
            'phone' => $input['phone'] ?? null,
            'country' => $input['country'] ?? null,
            'guests' => (($input['guests'] ?? '') !== '' ? (int) $input['guests'] : null),
            'arrival_date' => $input['arrival_date'] ?? null,
            'departure_date' => $input['departure_date'] ?? null,
            'arrival_window' => $input['arrival_window'] ?? null,
            'group_composition' => $input['group_composition'] ?? null,
            'children_travelling' => $input['children_travelling'] ?? null,
            'budget' => $input['budget'] ?? null,
            'travel_style' => $input['travel_style'] ?? null,
            'stay_mood' => $input['stay_mood'] ?? null,
            'arrival_mode' => $input['arrival_mode'] ?? null,
            'privacy_level' => $input['privacy_level'] ?? null,
            'villa_area' => $input['villa_area'] ?? null,
            'occasion_type' => $input['occasion_type'] ?? null,
            'special_moments' => $input['special_moments'] ?? null,
            'accommodation_status' => $input['accommodation_status'] ?? null,
            'dining_style' => $input['dining_style'] ?? null,
            'nightlife_interest' => $input['nightlife_interest'] ?? null,
            'dietary_needs' => $input['dietary_needs'] ?? null,
            'contact_preference' => $input['contact_preference'] ?? null,
            'details' => $input['details'] ?? null,
            'services_json' => $services,
            'payload_json' => $input,
            'status' => 'new',
            'priority' => $priority,
            'urgency_hint' => $urgencyHint,
            'operator_intent' => $operatorIntent,
            'guest_summary' => $guestSummary,
        ]);
        $inquiry->save();
        $inquiry = Inquiry::find($inquiry->id);

        self::createInitialSystemNote($inquiry, $services);

        try {
            self::sendNotification($inquiry);
        } catch (\Throwable $e) {
            \Log::warning('Mykonos inquiry notification failed', [
                'inquiry_id' => $inquiry->id,
                'request_reference' => $inquiry->request_reference,
                'message' => $e->getMessage(),
            ]);
        }

        try {
            $guestConfirmationResult = self::sendGuestConfirmation($inquiry);

            self::recordGuestConfirmationAttempt(
                $inquiry,
                $guestConfirmationResult,
                self::buildGuestConfirmationAttemptMessage($inquiry, $guestConfirmationResult)
            );
        } catch (\Throwable $e) {
            \Log::warning('Mykonos inquiry guest confirmation failed', [
                'inquiry_id' => $inquiry->id,
                'request_reference' => $inquiry->request_reference,
                'guest_email' => $inquiry->email,
                'message' => $e->getMessage(),
            ]);

            self::recordGuestConfirmationAttempt(
                $inquiry,
                'failed',
                self::buildGuestConfirmationFailureMessage($inquiry, $e)
            );
        }

        try {
            self::rememberLatestRequest($inquiry);
        } catch (\Throwable $e) {
            \Log::warning('Mykonos inquiry session persistence failed', [
                'inquiry_id' => $inquiry->id,
                'request_reference' => $inquiry->request_reference,
                'message' => $e->getMessage(),
            ]);
        }

        return $inquiry;
    }

    protected static function buildOperatorIntent(array $input, array $services): ?string
    {
        if (!empty($services)) {
            return implode(', ', $services);
        }

        $sourceTitle = trim((string) ($input['source_title'] ?? ''));
        if ($sourceTitle !== '') {
            return $sourceTitle;
        }

        return 'General luxury stay planning';
    }

    protected static function buildGuestSummary(array $input, array $services): string
    {
        $parts = [];
        if (!empty($input['full_name'])) {
            $parts[] = 'Guest: ' . trim((string) $input['full_name']);
        }
        if (!empty($input['arrival_date'])) {
            $parts[] = 'Arrival: ' . trim((string) $input['arrival_date']);
        }
        if (!empty($input['guests'])) {
            $parts[] = 'Guests: ' . trim((string) $input['guests']);
        }
        if (!empty($services)) {
            $parts[] = 'Focus: ' . implode(', ', $services);
        }
        if (!empty($input['details'])) {
            $parts[] = 'Brief: ' . trim((string) $input['details']);
        }

        return implode(PHP_EOL, $parts);
    }

    protected static function makeUrgencyHint(array $input): ?string
    {
        if (!empty($input['arrival_date'])) {
            try {
                $arrival = new \DateTime((string) $input['arrival_date']);
                $today = new \DateTime('today');
                $days = (int) $today->diff($arrival)->format('%r%a');
                if ($days >= 0 && $days <= 2) {
                    return 'urgent';
                }
                if ($days >= 3 && $days <= 7) {
                    return 'near-term';
                }
            } catch (\Throwable $e) {
                return null;
            }
        }

        return null;
    }

    protected static function makePriority(array $input, array $services, ?string $urgencyHint): string
    {
        if ($urgencyHint === 'urgent') {
            return 'urgent';
        }

        if ($urgencyHint === 'near-term') {
            return 'high';
        }

        $requestedMode = trim((string) ($input['requested_mode'] ?? ''));
        if (in_array($requestedMode, ['executive', 'celebration'], true)) {
            return 'vip';
        }

        if (in_array('villas', $services, true) && in_array('yachts', $services, true)) {
            return 'high';
        }

        return 'normal';
    }

    protected static function createInitialSystemNote(Inquiry $inquiry, array $services): void
    {
        try {
            if (!Schema::hasTable('cabnet_mykonos_inquiry_notes')) {
                return;
            }

            $lines = [
                'Inquiry created from public /plan flow.',
                'Reference: ' . ($inquiry->request_reference ?: 'Pending'),
                'Priority: ' . ($inquiry->priority ?: 'normal'),
                'Status: ' . ($inquiry->status ?: 'new'),
            ];

            if (!empty($services)) {
                $lines[] = 'Focus: ' . implode(', ', $services);
            }

            if (!empty($inquiry->source_title)) {
                $lines[] = 'Source: ' . $inquiry->source_title;
            }

            if (!empty($inquiry->requested_mode)) {
                $lines[] = 'Mode: ' . $inquiry->requested_mode;
            }

            $note = new InquiryNote();
            $note->inquiry_id = $inquiry->id;
            $note->note_type = 'system';
            $note->author_name = 'System';
            $note->body = implode(PHP_EOL, $lines);
            $note->is_internal = true;
            $note->save();
        } catch (\Throwable $e) {
            // Do not block the public form if the history layer is unavailable.
        }
    }

    protected static function sendNotification(Inquiry $inquiry): void
    {
        $to = config('cabnet.mykonosinquiry::notification_email', 'mykonos@cabnet.app');
        $subject = 'New Mykonos Inquiry - ' . $inquiry->request_reference;
        $body = self::buildEmailBody($inquiry);

        Mail::raw($body, function ($message) use ($to, $subject, $inquiry) {
            $message->to($to, 'Mykonos Cabnet');
            $message->subject($subject);

            if (!empty($inquiry->email)) {
                $message->replyTo($inquiry->email, $inquiry->full_name ?: 'Guest');
            }
        });
    }

    protected static function sendGuestConfirmation(Inquiry $inquiry): string
    {
        $guestEmail = trim((string) ($inquiry->email ?: ''));
        if ($guestEmail === '' || !filter_var($guestEmail, FILTER_VALIDATE_EMAIL)) {
            return 'skipped_invalid_email';
        }

        if (!config('cabnet.mykonosinquiry::guest_confirmation_enabled', true)) {
            return 'skipped_disabled';
        }

        $subject = self::buildGuestConfirmationSubject($inquiry);
        $body = self::buildGuestConfirmationBody($inquiry);

        $htmlBody = self::buildGuestConfirmationHtml($inquiry);

        Mail::send([], [], function ($message) use ($guestEmail, $subject, $inquiry, $body, $htmlBody) {
            $message->to($guestEmail, $inquiry->full_name ?: 'Guest');
            $message->subject($subject);
            $message->setBody($htmlBody, 'text/html');
            $message->addPart($body, 'text/plain');

            $replyTo = config('cabnet.mykonosinquiry::notification_email', 'mykonos@cabnet.app');
            if ($replyTo) {
                $message->replyTo($replyTo, config('cabnet.mykonosinquiry::guest_confirmation_reply_name', 'Mykonos Luxury Tours & Concierge'));
            }
        });

        return 'attempted';
    }

    protected static function buildGuestConfirmationSubject(Inquiry $inquiry): string
    {
        return 'We received your Mykonos request - ' . ($inquiry->request_reference ?: 'Mykonos Inquiry');
    }

    protected static function buildGuestConfirmationBody(Inquiry $inquiry): string
    {
        $services = is_array($inquiry->services_json) ? array_values(array_filter($inquiry->services_json)) : [];
        $serviceLine = !empty($services) ? implode(', ', $services) : 'Luxury planning';

        $lines = [
            'Hello ' . ($inquiry->full_name ?: 'Guest') . ',',
            '',
            'Thank you for contacting Mykonos Luxury Tours & Concierge.',
            'We have received your request and your reference is: ' . ($inquiry->request_reference ?: 'Pending'),
            '',
            'What happens next:',
            '- We review the essentials first and follow up with the most useful next questions.',
            '- If your stay is time-sensitive, reply directly to this email and we can accelerate the planning sequence.',
            '- Your request is now visible to our operator workflow for follow-up.',
            '',
            'Request summary:',
            'Reference: ' . ($inquiry->request_reference ?: ''),
            'Planning mode: ' . ($inquiry->requested_mode ?: 'General'),
            'Focus: ' . $serviceLine,
            'Arrival date: ' . ($inquiry->arrival_date ?: 'Not provided'),
            'Departure date: ' . ($inquiry->departure_date ?: 'Not provided'),
            'Guests: ' . ($inquiry->guests ?: 'Not provided'),
            '',
            'Your brief:',
            (string) ($inquiry->details ?: ''),
            '',
            'Direct email: ' . config('cabnet.mykonosinquiry::notification_email', 'mykonos@cabnet.app'),
            'Location: Mykonos, Cyclades, Greece',
            '',
            'Thank you,',
            config('cabnet.mykonosinquiry::guest_confirmation_reply_name', 'Mykonos Luxury Tours & Concierge'),
        ];

        return implode(PHP_EOL, $lines);
    }


    protected static function buildOperatorEmailHtml(Inquiry $inquiry): string
    {
        $summaryRows = [
            'Reference' => $inquiry->request_reference ?: 'Pending',
            'Status' => $inquiry->status ?: 'new',
            'Priority' => $inquiry->priority ?: 'normal',
            'Planning mode' => $inquiry->requested_mode ?: 'detailed',
            'Full name' => $inquiry->full_name ?: '',
            'Email' => $inquiry->email ?: '',
            'Phone' => $inquiry->phone ?: '',
            'Guests' => $inquiry->guests ?: '',
            'Arrival date' => $inquiry->arrival_date ?: '',
            'Departure date' => $inquiry->departure_date ?: '',
        ];

        $focus = is_array($inquiry->services_json) ? implode(', ', array_values(array_filter($inquiry->services_json))) : '';
        if ($focus !== '') {
            $summaryRows['Focus'] = $focus;
        }

        return self::renderEmailTemplate(
            config('cabnet.mykonosinquiry::operator_email_view', 'emails/operator_inquiry.php'),
            [
                'title' => 'New Mykonos Inquiry',
                'intro' => 'A new inquiry has been received and saved into the operator workflow.',
                'summaryRows' => $summaryRows,
                'contentBlocks' => [
                    'Guest brief' => nl2br(e((string) ($inquiry->details ?: ''))),
                ],
                'greeting' => '',
                'brandName' => config('cabnet.mykonosinquiry::guest_confirmation_reply_name', 'Mykonos Luxury Tours & Concierge'),
                'directEmail' => config('cabnet.mykonosinquiry::notification_email', 'mykonos@cabnet.app'),
            ]
        );
    }

    protected static function buildGuestConfirmationHtml(Inquiry $inquiry): string
    {
        $focus = is_array($inquiry->services_json) ? implode(', ', array_values(array_filter($inquiry->services_json))) : 'Luxury planning';

        $summaryRows = [
            'Reference' => $inquiry->request_reference ?: 'Pending',
            'Planning mode' => $inquiry->requested_mode ?: 'General',
            'Focus' => $focus,
            'Arrival date' => $inquiry->arrival_date ?: 'Not provided',
            'Departure date' => $inquiry->departure_date ?: 'Not provided',
            'Guests' => $inquiry->guests ?: 'Not provided',
        ];

        $nextSteps = implode('', [
            '<li>We review the essentials first and follow up with the most useful next questions.</li>',
            '<li>If your stay is time-sensitive, reply directly to this email and we can accelerate the planning sequence.</li>',
            '<li>Your request is now visible to our operator workflow for follow-up.</li>',
        ]);

        return self::renderEmailTemplate(
            config('cabnet.mykonosinquiry::guest_confirmation_view', 'emails/guest_confirmation.php'),
            [
                'title' => 'We received your Mykonos request',
                'intro' => 'Thank you for contacting Mykonos Luxury Tours & Concierge. Your request has been received and recorded.',
                'summaryRows' => $summaryRows,
                'contentBlocks' => [
                    'What happens next' => '<ul style="margin:0;padding-left:18px;">' . $nextSteps . '</ul>',
                    'Your brief' => nl2br(e((string) ($inquiry->details ?: ''))),
                    'Direct email' => e(config('cabnet.mykonosinquiry::notification_email', 'mykonos@cabnet.app')),
                ],
                'greeting' => 'Hello ' . e($inquiry->full_name ?: 'Guest') . ',',
                'brandName' => config('cabnet.mykonosinquiry::guest_confirmation_reply_name', 'Mykonos Luxury Tours & Concierge'),
                'directEmail' => config('cabnet.mykonosinquiry::notification_email', 'mykonos@cabnet.app'),
            ]
        );
    }

    protected static function renderEmailTemplate(string $relativeTemplatePath, array $data = []): string
    {
        $templatePath = __DIR__ . '/../views/' . ltrim($relativeTemplatePath, '/');
        if (!is_file($templatePath)) {
            throw new \RuntimeException('Email template not found: ' . $templatePath);
        }

        extract($data, EXTR_SKIP);

        ob_start();
        include $templatePath;
        return (string) ob_get_clean();
    }

    protected static function buildEmailBody(Inquiry $inquiry): string
    {
        $services = is_array($inquiry->services_json) ? implode(', ', $inquiry->services_json) : '';

        return implode(PHP_EOL, [
            'Request Reference: ' . ($inquiry->request_reference ?: ''),
            'Status: ' . ($inquiry->status ?: ''),
            'Priority: ' . ($inquiry->priority ?: ''),
            'Urgency Hint: ' . ($inquiry->urgency_hint ?: ''),
            'Operator Intent: ' . ($inquiry->operator_intent ?: ''),
            '',
            'Source Type: ' . ($inquiry->source_type ?: ''),
            'Source Slug: ' . ($inquiry->source_slug ?: ''),
            'Source Title: ' . ($inquiry->source_title ?: ''),
            'Source URL: ' . ($inquiry->source_url ?: ''),
            'Requested Mode: ' . ($inquiry->requested_mode ?: ''),
            '',
            'Full Name: ' . ($inquiry->full_name ?: ''),
            'Email: ' . ($inquiry->email ?: ''),
            'Phone: ' . ($inquiry->phone ?: ''),
            'Country: ' . ($inquiry->country ?: ''),
            'Guests: ' . ($inquiry->guests ?: ''),
            'Arrival Date: ' . ($inquiry->arrival_date ?: ''),
            'Departure Date: ' . ($inquiry->departure_date ?: ''),
            'Arrival Window: ' . ($inquiry->arrival_window ?: ''),
            'Group Composition: ' . ($inquiry->group_composition ?: ''),
            'Children Travelling: ' . ($inquiry->children_travelling ?: ''),
            'Budget: ' . ($inquiry->budget ?: ''),
            'Travel Style: ' . ($inquiry->travel_style ?: ''),
            'Stay Mood: ' . ($inquiry->stay_mood ?: ''),
            'Arrival Mode: ' . ($inquiry->arrival_mode ?: ''),
            'Privacy Level: ' . ($inquiry->privacy_level ?: ''),
            'Villa Area: ' . ($inquiry->villa_area ?: ''),
            'Occasion Type: ' . ($inquiry->occasion_type ?: ''),
            'Special Moments: ' . ($inquiry->special_moments ?: ''),
            'Accommodation Status: ' . ($inquiry->accommodation_status ?: ''),
            'Dining Style: ' . ($inquiry->dining_style ?: ''),
            'Nightlife Interest: ' . ($inquiry->nightlife_interest ?: ''),
            'Dietary Needs: ' . ($inquiry->dietary_needs ?: ''),
            'Contact Preference: ' . ($inquiry->contact_preference ?: ''),
            'Services: ' . $services,
            '',
            'Guest Summary:',
            (string) ($inquiry->guest_summary ?: ''),
            '',
            'Trip Details:',
            (string) ($inquiry->details ?: ''),
        ]);
    }

    protected static function rememberLatestRequest(Inquiry $inquiry): void
    {
        Session::put('mykonos_latest_request', [
            'id' => $inquiry->id,
            'reference' => $inquiry->request_reference,
            'full_name' => $inquiry->full_name,
            'source_type' => $inquiry->source_type,
            'source_slug' => $inquiry->source_slug,
            'source_title' => $inquiry->source_title,
            'source_url' => $inquiry->source_url,
            'requested_mode' => $inquiry->requested_mode,
            'status' => $inquiry->status,
            'priority' => $inquiry->priority,
            'created_at' => optional($inquiry->created_at)->toDateTimeString(),
        ]);
    }
}
