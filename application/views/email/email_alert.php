<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Due Reminder</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; color: #333; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 6px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .header { background: #b40404; color: #fff; padding: 28px 32px; }
        .header h1 { margin: 0; font-size: 20px; }
        .header p  { margin: 4px 0 0; font-size: 13px; opacity: 0.85; }
        .body { padding: 28px 32px; }
        .alert-box { background: #fff5f5; border-left: 4px solid #b40404; padding: 14px 18px; border-radius: 4px; margin: 20px 0; }
        .alert-box .amount { font-size: 24px; font-weight: bold; color: #b40404; }
        .alert-box p { margin: 4px 0; font-size: 14px; }
        .footer { background: #f5f5f5; padding: 16px 32px; text-align: center; font-size: 12px; color: #888; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>&#9888; Payment Due Reminder</h1>
        <p><?= html_escape($settings->application_name ?? 'Stewards Credit Services') ?></p>
    </div>
    <div class="body">
        <p>Dear <strong><?= html_escape($post->fullname ?? 'Valued Client') ?></strong>,</p>
        <p>This is a reminder that a payment is due on your account. Please review the details below and make arrangements to settle the outstanding amount.</p>

        <div class="alert-box">
            <p><strong>Account:</strong> <?= html_escape($post->title ?? '') ?></p>
            <p><strong>Account Number:</strong> <?php if($post->category_id == 1){ echo 1010000 + $post->id; }else{ echo 2010000 + $post->id; } ?></p>
            <p><strong>Due Date:</strong> <?= date('d M Y', strtotime($alert->due_date)) ?></p>
            <?php if (!empty($alert->amount_due)): ?>
            <p class="amount"><?= html_escape($post->currency ?? '') ?> <?= number_format((float)$alert->amount_due, 2) ?></p>
            <?php endif; ?>
            <?php if (!empty($alert->description)): ?>
            <p><strong>Note:</strong> <?= html_escape($alert->description) ?></p>
            <?php endif; ?>
        </div>

        <p>If you have already made this payment, please disregard this notice. For any queries, please contact us directly.</p>
        <p>Thank you for your continued trust in us.</p>
        <p>Regards,<br><strong><?= html_escape($settings->application_name ?? 'Stewards Credit Services') ?></strong></p>
    </div>
    <div class="footer">
        &copy; <?= date('Y') ?> <?= html_escape($settings->application_name ?? 'Stewards Credit Services') ?>. This is an automated notification.
    </div>
</div>
</body>
</html>
