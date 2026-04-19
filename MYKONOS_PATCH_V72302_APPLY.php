<?php
/**
 * Mykonos inquiry strip boolean-key hotfix
 * v7.23.02
 *
 * Safe one-time patcher for backend partial parse errors caused by:
 *   True:  ['bg' => ...]
 *   False: ['bg' => ...]
 *
 * Converts them to valid PHP array syntax:
 *   true => [...]
 *   false => [...]
 */

declare(strict_types=1);

$root = __DIR__;
$targetDir = $root . '/plugins/cabnet/mykonosinquiry/controllers/inquiries';

header('Content-Type: text/plain; charset=utf-8');

echo "Mykonos Inquiry Strip Boolean-Key Hotfix v7.23.02\n";
echo "Target: {$targetDir}\n\n";

if (!is_dir($targetDir)) {
    http_response_code(500);
    echo "ERROR: Target directory not found.\n";
    exit(1);
}

$files = glob($targetDir . '/*.htm') ?: [];
if (!$files) {
    echo "No .htm strip files found.\n";
    exit(0);
}

$totalChanged = 0;
foreach ($files as $file) {
    $original = file_get_contents($file);
    if ($original === false) {
        echo "SKIP: Could not read {$file}\n";
        continue;
    }

    $updated = preg_replace('/(?m)^(\s*)True\s*:/', '$1true =>', $original);
    $updated = preg_replace('/(?m)^(\s*)False\s*:/', '$1false =>', $updated);

    if ($updated !== $original) {
        $backup = $file . '.bak-v72302';
        if (!file_exists($backup)) {
            file_put_contents($backup, $original);
        }
        file_put_contents($file, $updated);
        echo "PATCHED: {$file}\n";
        $totalChanged++;
    } else {
        echo "OK: {$file}\n";
    }
}

echo "\nDone. Changed {$totalChanged} file(s).\n";
echo "Now clear cache and reload the inquiry record.\n";
