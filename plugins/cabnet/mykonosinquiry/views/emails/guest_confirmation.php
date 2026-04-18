<?php
$summaryRows = isset($summaryRows) && is_array($summaryRows) ? $summaryRows : [];
$contentBlocks = isset($contentBlocks) && is_array($contentBlocks) ? $contentBlocks : [];
$brandName = $brandName ?? 'Mykonos Luxury Tours & Concierge';
$directEmail = $directEmail ?? 'mykonos@cabnet.app';

$summaryHtml = '';
foreach ($summaryRows as $label => $value) {
    if ($value === null || $value === '') {
        continue;
    }
    $summaryHtml .= '<tr><td style="padding:8px 10px;border-bottom:1px solid #edf1f7;font-weight:700;color:#20324d;width:170px;">' . e($label) . '</td><td style="padding:8px 10px;border-bottom:1px solid #edf1f7;color:#4a5c74;">' . e((string) $value) . '</td></tr>';
}

$blocksHtml = '';
foreach ($contentBlocks as $label => $content) {
    if ($content === null || $content === '') {
        continue;
    }
    $blocksHtml .= '<div style="margin-top:18px;"><div style="font-size:12px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:#8a6a2d;margin-bottom:8px;">' . e($label) . '</div><div style="font-size:16px;line-height:1.65;color:#44566e;">' . $content . '</div></div>';
}
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body style="margin:0;padding:0;background:#eef2f7;font-family:Arial,sans-serif;color:#22324a;">
<div style="max-width:760px;margin:0 auto;padding:28px 16px;">
    <div style="background:linear-gradient(135deg,#071326 0%,#0d1d39 60%,#142b52 100%);border-radius:22px 22px 0 0;padding:28px 30px;color:#fff;">
        <div style="font-size:12px;letter-spacing:.35em;text-transform:uppercase;color:#d8b36a;margin-bottom:12px;">Luxury services</div>
        <div style="font-size:28px;font-weight:700;line-height:1.2;">Mykonos</div>
        <div style="font-size:14px;line-height:1.7;color:#d8e2f0;margin-top:12px;"><?= e($title ?? '') ?></div>
    </div>
    <div style="background:#ffffff;border-radius:0 0 22px 22px;padding:30px;box-shadow:0 20px 50px rgba(20,35,62,0.10);">
        <?php if (!empty($greeting)): ?>
            <div style="font-size:20px;line-height:1.5;color:#22324a;margin-bottom:14px;"><?= $greeting ?></div>
        <?php endif; ?>
        <div style="font-size:16px;line-height:1.75;color:#50627a;margin-bottom:20px;"><?= e($intro ?? '') ?></div>
        <div style="border:1px solid #e9edf5;border-radius:18px;overflow:hidden;background:#fbfcfe;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse:collapse;"><?= $summaryHtml ?></table>
        </div>
        <?= $blocksHtml ?>
        <div style="margin-top:24px;padding-top:18px;border-top:1px solid #edf1f7;font-size:14px;line-height:1.7;color:#6a7890;">
            Mykonos, Cyclades, Greece<br>Direct email: <?= e($directEmail) ?><br>24/7 private planning support
        </div>
        <div style="margin-top:18px;font-size:14px;line-height:1.7;color:#6a7890;">Thank you,<br><?= e($brandName) ?></div>
    </div>
</div>
</body>
</html>
