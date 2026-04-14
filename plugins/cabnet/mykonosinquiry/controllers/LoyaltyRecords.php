<?php namespace Cabnet\MykonosInquiry\Controllers;

use BackendAuth;
use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use Backend\Classes\Controller;
use BackendMenu;
use Cabnet\MykonosInquiry\Models\Inquiry;
use Cabnet\MykonosInquiry\Models\LoyaltyRecord;
use Carbon\Carbon;
use Flash;

class LoyaltyRecords extends Controller
{
    public $implement = [ListController::class, FormController::class];

    public $listConfig = 'config_list.yaml';

    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = ['cabnet.mykonosinquiry.manage_loyalty_continuity'];

    protected array $pendingTouchpointEntry = [];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Cabnet.MykonosInquiry', 'mykonosinquiry', 'loyaltyrecords');
    }

    public function index()
    {
        $this->pageTitle = 'Loyalty Continuity';

        $this->asExtension('ListController')->index();
    }

    public function listExtendQuery($query): void
    {
        $query->with('source_inquiry');
    }

    public function create()
    {
        $this->asExtension('FormController')->create();

        $seedInquiry = $this->resolveCreateSeedInquiry();
        $reference = $seedInquiry && $seedInquiry->request_reference
            ? $seedInquiry->request_reference
            : ($seedInquiry && $seedInquiry->full_name ? $seedInquiry->full_name : null);

        $this->pageTitle = $reference
            ? 'New Loyalty Record · ' . $reference
            : 'New Loyalty Record';
    }

    public function update($recordId = null, $context = null)
    {
        if ($recordId && request()->isMethod('post') && post('_loyalty_action')) {
            return $this->dispatchContinuityActionFromUpdate($recordId);
        }

        $this->asExtension('FormController')->update($recordId, $context);

        $record = $recordId ? LoyaltyRecord::find($recordId) : null;
        $reference = $record && $record->request_reference ? $record->request_reference : ($record->guest_name ?? 'Loyalty Record');

        $this->pageTitle = 'Loyalty Record · ' . $reference;
    }

    protected function resolveCreateSeedInquiry(): ?Inquiry
    {
        $seedId = (int) input('source_inquiry_id', 0);

        if ($seedId <= 0) {
            return null;
        }

        return Inquiry::find($seedId);
    }
}
