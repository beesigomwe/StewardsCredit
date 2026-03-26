<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
// Load existing alerts for this account
$account_alerts = [];
if (isset($post->id)) {
    $CI =& get_instance();
    $CI->db->where('post_id', $post->id);
    $CI->db->order_by('due_date', 'ASC');
    $att_query = $CI->db->get('alerts');
    $account_alerts = $att_query->result();
}
?>

<h3>Schedule Payment Alert</h3>
<p class="text-muted small mb-3">Alerts are sent automatically by email to the account owner on the due date.</p>
<form id="create-alert-form">
    <input type="hidden" name="post_id" value="<?= html_escape($post->id) ?>">
    <fieldset class="form-fieldset">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Due Date <span class="form-required">*</span></label>
                    <input type="date" name="due_date" class="form-control" required min="<?= date('Y-m-d') ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Amount Due (optional)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><?= html_escape($post->currency ?? 'UGX') ?></span>
                        </div>
                        <input type="number" step="0.01" min="0" name="amount_due" class="form-control" placeholder="Leave blank if not applicable">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Note / Description</label>
            <textarea name="description" class="form-control" rows="2" placeholder="e.g. Monthly loan repayment, Interest payment"></textarea>
        </div>
    </fieldset>
    <div class="form-footer">
        <button type="submit" class="btn btn-primary btn-block" id="create-alert-btn">
            <i class="fe fe-bell"></i> Schedule Alert
        </button>
    </div>
    <div id="alert-feedback" class="alert mt-2 d-none"></div>
</form>

</div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table card-table table-striped table-vcenter" id="alerts-table">
                <thead>
                    <tr>
                        <th>Due Date</th>
                        <th>Amount Due</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="alerts-tbody">
                    <?php if (empty($account_alerts)): ?>
                    <tr id="no-alerts-row">
                        <td colspan="5" class="text-center text-muted">No alerts scheduled yet.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($account_alerts as $alrt): ?>
                    <tr id="alert-row-<?= $alrt->alert_id ?>">
                        <td><?= date('d M Y', strtotime($alrt->due_date)) ?></td>
                        <td><?= !empty($alrt->amount_due) ? html_escape($post->currency) . ' ' . number_format((float)$alrt->amount_due, 2) : '—' ?></td>
                        <td><?= html_escape($alrt->description ?? '') ?></td>
                        <td>
                            <?php if ($alrt->is_sent): ?>
                                <span class="badge badge-success">Sent <?= !empty($alrt->sent_at) ? date('d/m/Y', strtotime($alrt->sent_at)) : '' ?></span>
                            <?php elseif (strtotime($alrt->due_date) < strtotime('today')): ?>
                                <span class="badge badge-danger">Overdue</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="icon text-danger"
                               onclick="deleteAlert(<?= $alrt->alert_id ?>)"
                               title="Delete Alert">
                                <i class="fe fe-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById('create-alert-form').addEventListener('submit', function(e) {
    e.preventDefault();
    var fb  = document.getElementById('alert-feedback');
    fb.className = 'alert d-none';

    var formData = new FormData(this);
    formData.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');

    document.getElementById('create-alert-btn').disabled = true;

    fetch('<?= base_url('cron_controller/create_alert_post') ?>', {
        method: 'POST',
        body: formData
    })
    .then(function(r) { return r.json(); })
    .then(function(res) {
        document.getElementById('create-alert-btn').disabled = false;
        if (res.success) {
            fb.className = 'alert alert-success';
            fb.textContent = res.message;
            // Add new row to table
            var tbody = document.getElementById('alerts-tbody');
            var noRow = document.getElementById('no-alerts-row');
            if (noRow) noRow.remove();
            var dueDateVal = document.querySelector('[name="due_date"]').value;
            var amountVal  = document.querySelector('[name="amount_due"]').value;
            var descVal    = document.querySelector('[name="description"]').value;
            var tr = document.createElement('tr');
            tr.id = 'alert-row-' + res.alert_id;
            var amountDisplay = amountVal ? '<?= html_escape($post->currency ?? "UGX") ?> ' + parseFloat(amountVal).toFixed(2) : '—';
            tr.innerHTML = '<td>' + dueDateVal + '</td>'
                + '<td>' + amountDisplay + '</td>'
                + '<td>' + descVal + '</td>'
                + '<td><span class="badge badge-warning">Pending</span></td>'
                + '<td><a href="javascript:void(0)" class="icon text-danger" onclick="deleteAlert(' + res.alert_id + ')" title="Delete"><i class="fe fe-trash"></i></a></td>';
            tbody.insertBefore(tr, tbody.firstChild);
            document.getElementById('create-alert-form').reset();
        } else {
            fb.className = 'alert alert-danger';
            fb.textContent = res.message || 'Failed to create alert.';
        }
    })
    .catch(function(err) {
        document.getElementById('create-alert-btn').disabled = false;
        fb.className = 'alert alert-danger';
        fb.textContent = 'Network error: ' + err;
    });
});

function deleteAlert(alertId) {
    if (!confirm('Delete this alert? This cannot be undone.')) return;
    var formData = new FormData();
    formData.append('alert_id', alertId);
    formData.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
    fetch('<?= base_url('cron_controller/delete_alert_post') ?>', {
        method: 'POST',
        body: formData
    })
    .then(function(r) { return r.json(); })
    .then(function(res) {
        if (res.success) {
            var row = document.getElementById('alert-row-' + alertId);
            if (row) row.remove();
        } else {
            alert(res.message || 'Delete failed.');
        }
    });
}
</script>
