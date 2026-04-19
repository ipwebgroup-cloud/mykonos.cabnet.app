<?php
declare(strict_types=1);

$projectRoot = __DIR__;
$target = $projectRoot . '/plugins/cabnet/mykonosinquiry/controllers/inquiries/_confidence_strip.htm';

header('Content-Type: text/plain; charset=UTF-8');

echo "MYKONOS confidence strip direct hotfix\n";
echo "Project root: {$projectRoot}\n";
echo "Target: {$target}\n\n";

if (!is_file($target)) {
    echo "ERROR: Target file not found.\n";
    echo "Place this script in the real project root that contains /plugins/cabnet/mykonosinquiry.\n";
    exit(1);
}

$contents = file_get_contents($target);
if ($contents === false) {
    echo "ERROR: Could not read target file.\n";
    exit(1);
}

$original = $contents;

$patterns = [
    '/\bTrue\s*:\s*/' => 'true => ',
    '/\bFalse\s*:\s*/' => 'false => ',
];

$contents = preg_replace(array_keys($patterns), array_values($patterns), $contents, -1, $count);

if ($contents === null) {
    echo "ERROR: preg_replace failed.\n";
    exit(1);
}

if ($contents === $original) {
    echo "No changes were needed. The file may already be fixed.\n";
    exit(0);
}

$backup = $target . '.bak-v73601';
if (!file_exists($backup)) {
    if (file_put_contents($backup, $original) === false) {
        echo "ERROR: Could not create backup file: {$backup}\n";
        exit(1);
    }
    echo "Backup created: {$backup}\n";
} else {
    echo "Backup already exists: {$backup}\n";
}

if (file_put_contents($target, $contents) === false) {
    echo "ERROR: Could not write fixed file.\n";
    exit(1);
}

echo "Hotfix applied successfully.\n";
echo "Replacements made: {$count}\n";
echo "Next step: clear cache with `php artisan cache:clear` and reload the inquiry page.\n";
