<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Statement — <?= html_escape($settings->application_name ?? 'Stewards Credit') ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; color: #333; }
        .wrapper { max-width: 620px; margin: 30px auto; background: #fff; border-radius: 6px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .header { background: #1a3a5c; color: #fff; padding: 28px 32px; }
        .header h1 { margin: 0; font-size: 22px; }
        .header p { margin: 4px 0 0; font-size: 13px; opacity: 0.8; }
        .body { padding: 28px 32px; }
        .greeting { font-size: 16px; margin-bottom: 20px; }
        .summary-box { background: #f0f7ff; border-left: 4px solid #1a3a5c; padding: 14px 18px; border-radius: 4px; margin-bottom: 24px; }
        .summary-box p { margin: 4px 0; font-size: 14px; }
        .summary-box .balance { font-size: 20px; font-weight: bold; color: #1a3a5c; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; margin-bottom: 24px; }
        table thead tr { background: #1a3a5c; color: #fff; }
        table thead th { padding: 9px 10px; text-align: left; }
        table tbody tr:nth-child(even) { background: #f9f9f9; }
        table tbody td { padding: 8px 10px; border-bottom: 1px solid #eee; }
        .cr { color: #1a7a1a; font-weight: bold; }
        .dr { color: #b40404; font-weight: bold; }
        .footer { background: #f5f5f5; padding: 18px 32px; text-align: center; font-size: 12px; color: #888; }
        .footer a { color: #1a3a5c; text-decoration: none; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1><?= html_escape($settings->application_name ?? 'Stewards Credit Services') ?></h1>
        <p>Electronic Account Statement</p>
    </div>
    <div class="body">
        <p class="greeting">Dear <?= html_escape($post->fullname ?? 'Valued Client') ?>,</p>
        <p>Please find below your account statement as of <strong><?= date('d M Y') ?></strong>.</p>

        <div class="summary-box">
            <p><strong>Account Number:</strong> <?php if($post->category_id == 1){ echo 1010000 + $post->id; }else{ echo 2010000 + $post->id; } ?></p>
            <p><strong>Account Name:</strong> <?= html_escape($post->title ?? '') ?></p>
            <p><strong>Account Type:</strong> <?= html_escape($post->category ?? '') ?></p>
            <p class="balance">Current Balance: <?= html_escape($post->currency ?? '') ?> <?= number_format((float)($post->balance ?? 0), 2) ?></p>
        </div>

        <?php if (!empty($transactions)): ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Narration</th>
                    <th>DR</th>
                    <th>CR</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $txn): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($txn->trans_date)) ?></td>
                    <td><?= html_escape($txn->comment ?? '') ?></td>
                    <td><?= ($txn->trans_type == 'DR') ? '<span class="dr">' . html_escape($txn->currency) . ' ' . number_format((float)$txn->amount, 2) . '</span>' : '' ?></td>
                    <td><?= ($txn->trans_type == 'CR') ? '<span class="cr">' . html_escape($txn->currency) . ' ' . number_format((float)$txn->amount, 2) . '</span>' : '' ?></td>
                    <td><?= html_escape($txn->currency) ?> <?= number_format((float)$txn->closing_balance, 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="text-muted">No transactions found for this account.</p>
        <?php endif; ?>

        <p style="font-size:13px;color:#666;">This is an automated statement. Please do not reply to this email. For queries, contact us directly.</p>
    </div>
    <div class="footer">
        &copy; <?= date('Y') ?> <?= html_escape($settings->application_name ?? 'Stewards Credit Services') ?>. All rights reserved.
    </div>
</div>
</body>
</html>
