<?php namespace Cabnet\MykonosInquiry\Components;

use Cabnet\MykonosInquiry\Classes\InquiryManager;
use Cms\Classes\ComponentBase;
use Flash;

class PlanBridge extends ComponentBase
{
    public function componentDetails(): array
    {
        return [
            'name' => 'Mykonos Plan Bridge',
            'description' => 'Receives public plan inquiries, stores them, and sends notifications.',
        ];
    }

    public function onSubmitInquiry(): array
    {
        $inquiry = InquiryManager::submit(post());

        Flash::success('Your request has been received. Reference: ' . $inquiry->request_reference);

        return [
            'request_reference' => $inquiry->request_reference,
            'source_type' => $inquiry->source_type,
            'source_title' => $inquiry->source_title,
            'source_url' => $inquiry->source_url,
            'requested_mode' => $inquiry->requested_mode,
            'full_name' => $inquiry->full_name,
            'email' => $inquiry->email,
            'guests' => $inquiry->guests,
            'arrival_date' => optional($inquiry->arrival_date)->format('Y-m-d'),
            'departure_date' => optional($inquiry->departure_date)->format('Y-m-d'),
            'focus' => (array) ($inquiry->services_json ?: []),
            'priority' => $inquiry->priority,
            'status' => $inquiry->status,
            'latest_request' => [
                'reference' => $inquiry->request_reference,
                'id' => $inquiry->id,
                'status' => $inquiry->status,
                'priority' => $inquiry->priority,
            ],
        ];
    }
}
