<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
// Load attachments for this account from the database
$attachments = [];
if (isset($post->id)) {
    $CI =& get_instance();
    $CI->db->where('post_id', $post->id);
    $CI->db->order_by('created_at', 'DESC');
    $att_query = $CI->db->get('account_attachments');
    $attachments = $att_query->result();
}
?>

<h3>Upload Attachment</h3>
<form id="attachment-upload-form" enctype="multipart/form-data">
    <input type="hidden" name="post_id" value="<?= html_escape($post->id) ?>">
    <fieldset class="form-fieldset">
        <div class="form-group">
            <label class="form-label">Attachment Name <span class="form-required">*</span></label>
            <input type="text" name="file_name" id="att_file_name" class="form-control" placeholder="e.g. National ID, Collateral Photo" required>
        </div>
        <div class="form-group">
            <div class="form-label">Select File <span class="form-required">*</span></div>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="att_file" name="attachment" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx" required>
                <label class="custom-file-label" for="att_file">Choose file</label>
            </div>
            <small class="text-muted">Accepted: PDF, JPG, PNG, DOC, DOCX, XLS, XLSX. Max 5MB.</small>
        </div>
    </fieldset>
    <div class="form-footer">
        <button type="submit" class="btn btn-primary btn-block" id="att-submit-btn">
            <i class="fe fe-upload"></i> Upload Attachment
        </button>
    </div>
    <div id="att-feedback" class="alert mt-2 d-none"></div>
</form>

</div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table card-table table-striped table-vcenter" id="attachments-table">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>Type</th>
                        <th>Size</th>
                        <th>Upload Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="attachments-tbody">
                    <?php if (empty($attachments)): ?>
                    <tr id="no-attachments-row">
                        <td colspan="5" class="text-center text-muted">No attachments uploaded yet.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($attachments as $att): ?>
                    <tr id="att-row-<?= $att->attachment_id ?>">
                        <td>
                            <i class="fe fe-file mr-1"></i>
                            <a href="<?= base_url(html_escape($att->file_path)) ?>" target="_blank">
                                <?= html_escape($att->file_name) ?>
                            </a>
                        </td>
                        <td><?= html_escape(strtoupper($att->file_type ?? '')) ?></td>
                        <td><?= $att->file_size ? number_format($att->file_size / 1024, 1) . ' KB' : '—' ?></td>
                        <td><?= formatted_date($att->created_at) ?></td>
                        <td>
                            <a href="javascript:void(0)" class="icon text-danger"
                               onclick="deleteAttachment(<?= $att->attachment_id ?>, <?= $post->id ?>)"
                               title="Delete">
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
// Show selected filename in the custom file input label
document.getElementById('att_file').addEventListener('change', function() {
    var label = this.nextElementSibling;
    label.textContent = this.files.length > 0 ? this.files[0].name : 'Choose file';
});

document.getElementById('attachment-upload-form').addEventListener('submit', function(e) {
    e.preventDefault();
    var fb = document.getElementById('att-feedback');
    fb.className = 'alert d-none';

    var formData = new FormData(this);
    formData.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');

    document.getElementById('att-submit-btn').disabled = true;
    document.getElementById('att-submit-btn').innerHTML = '<i class="fe fe-loader"></i> Uploading...';

    fetch('<?= base_url('admin_controller/upload_attachment_post') ?>', {
        method: 'POST',
        body: formData
    })
    .then(function(r) { return r.json(); })
    .then(function(res) {
        document.getElementById('att-submit-btn').disabled = false;
        document.getElementById('att-submit-btn').innerHTML = '<i class="fe fe-upload"></i> Upload Attachment';
        if (res.success) {
            fb.className = 'alert alert-success';
            fb.textContent = res.message || 'File uploaded successfully.';
            // Add new row to table
            var tbody = document.getElementById('attachments-tbody');
            var noRow = document.getElementById('no-attachments-row');
            if (noRow) noRow.remove();
            var tr = document.createElement('tr');
            tr.id = 'att-row-' + res.attachment_id;
            tr.innerHTML = '<td><i class="fe fe-file mr-1"></i><a href="' + res.file_url + '" target="_blank">' + res.file_name + '</a></td>'
                + '<td>' + (res.file_type || '') + '</td>'
                + '<td>' + (res.file_size ? (res.file_size / 1024).toFixed(1) + ' KB' : '—') + '</td>'
                + '<td>Just now</td>'
                + '<td><a href="javascript:void(0)" class="icon text-danger" onclick="deleteAttachment(' + res.attachment_id + ', <?= $post->id ?>)" title="Delete"><i class="fe fe-trash"></i></a></td>';
            tbody.insertBefore(tr, tbody.firstChild);
            document.getElementById('attachment-upload-form').reset();
            document.querySelector('.custom-file-label').textContent = 'Choose file';
        } else {
            fb.className = 'alert alert-danger';
            fb.textContent = res.message || 'Upload failed.';
        }
    })
    .catch(function(err) {
        document.getElementById('att-submit-btn').disabled = false;
        document.getElementById('att-submit-btn').innerHTML = '<i class="fe fe-upload"></i> Upload Attachment';
        fb.className = 'alert alert-danger';
        fb.textContent = 'Network error: ' + err;
    });
});

function deleteAttachment(attachmentId, postId) {
    if (!confirm('Are you sure you want to delete this attachment? This cannot be undone.')) return;
    var formData = new FormData();
    formData.append('attachment_id', attachmentId);
    formData.append('post_id', postId);
    formData.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
    fetch('<?= base_url('admin_controller/delete_attachment_post') ?>', {
        method: 'POST',
        body: formData
    })
    .then(function(r) { return r.json(); })
    .then(function(res) {
        if (res.success) {
            var row = document.getElementById('att-row-' + attachmentId);
            if (row) row.remove();
        } else {
            alert(res.message || 'Delete failed.');
        }
    });
}
</script>
