<?php
declare(strict_types=1);

use Cabnet\MykonosInquiry\Models\LoyaltyRecord;
use Illuminate\Contracts\Console\Kernel;

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    echo "This script is CLI-only.\n";
    exit(1);
}

$root = dirname(__DIR__);
$autoload = $root . '/bootstrap/autoload.php';
$appFile = $root . '/bootstrap/app.php';

if (!is_file($autoload) || !is_file($appFile)) {
    fwrite(STDERR, "Bootstrap files not found under {$root}.\n");
    exit(1);
}

require $autoload;
$app = require $appFile;
$app->make(Kernel::class)->bootstrap();

if (!class_exists(LoyaltyRecord::class)) {
    fwrite(STDERR, "LoyaltyRecord model is not available. Confirm the Cabnet.MykonosInquiry plugin files are deployed.\n");
    exit(1);
}

$state = LoyaltyRecord::getWorkspaceInstallState();

$line = static function (string $label, string $value): void {
    echo str_pad($label, 30, ' ', STR_PAD_RIGHT) . $value . PHP_EOL;
};

$bool = static function ($value): string {
    return $value ? 'yes' : 'no';
};

$formatList = static function (array $items): string {
    return empty($items) ? 'none' : implode(', ', $items);
};

echo PHP_EOL;
echo 'Mykonos Loyalty Workspace Activation Check' . PHP_EOL;
echo str_repeat('=', 40) . PHP_EOL;
$line('Project root', $root);
$line('Record table ready', $bool($state['record_table_ready'] ?? false));
$line('Record schema ready', $bool($state['record_schema_ready'] ?? false));
$line('Touchpoint table ready', $bool($state['touchpoint_table_ready'] ?? false));
$line('Touchpoint schema ready', $bool($state['touchpoint_schema_ready'] ?? false));
$line('Workspace storage ready', $bool($state['workspace_storage_ready'] ?? false));

echo PHP_EOL;
echo 'Missing record columns:' . PHP_EOL;
echo '  ' . $formatList($state['missing_record_columns'] ?? []) . PHP_EOL;

echo PHP_EOL;
echo 'Missing touchpoint columns:' . PHP_EOL;
echo '  ' . $formatList($state['missing_touchpoint_columns'] ?? []) . PHP_EOL;

echo PHP_EOL;
if (!empty($state['workspace_storage_ready'])) {
    echo 'Result: loyalty workspace storage is ready.' . PHP_EOL;
    echo 'Next step: clear cache if needed and reopen Backend -> Mykonos Inquiries -> Loyalty Continuity.' . PHP_EOL;
    exit(0);
}

echo 'Result: loyalty workspace storage is still not ready.' . PHP_EOL;
echo 'Next step:' . PHP_EOL;
echo '  1. Run: php artisan october:up' . PHP_EOL;
echo '     or:  php artisan october:migrate' . PHP_EOL;
echo '  2. Run: php artisan cache:clear' . PHP_EOL;
echo '  3. Re-run this script and then reopen the Loyalty Continuity backend page.' . PHP_EOL;
exit(2);
