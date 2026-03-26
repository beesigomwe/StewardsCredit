		<table class="table table-striped table table-hover table-outline table-vcenter text-nowrap card-table datatable" role="grid" style="background: #fffef4;">
			<thead>
				<tr role="row">
					<th width="10">NO.</th>
					<!-- <th>TYPE</th> -->
					<th>NARRATION</th>
					<th style="min-width: 10%"><?= trans('date'); ?></th>
					<th width="160" class="text-center">
					DR</th>
					<th width="160" class="text-center">
					CR</th>
					<th width="160" class="text-center">
					Status</th>
					<?php if (user()->role == 'admin'){ ?>
						<th class="hidden-print" colspan="2"></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php 
				$category_array = get_category_array($post->category_id);
				$i=1; foreach ($pending as $item):
				switch ($category_array['parent_category']->name) {case 'Deposits': if($item->trans_type == 'CR'){$ttype = 'Deposit'; }else{$ttype = 'Withdraw'; } break; case 'Loans': if($item->trans_type == 'DR'){$ttype = 'Withdraw'; }else{$ttype = 'Deposit'; } break; }
				?>
				<tr>
					<td class="text-right"><?= html_escape($i); $i++; ?>.</td>
					<!-- <td class="break-word"><?= html_escape($ttype); ?></td> -->
					<td class="break-word"><?= html_escape($item->comment); ?></td>
					<td class="nowrap text-center"><?= formatted_date($item->trans_date); ?></td>
					<td class="text-right">
						<?php if($item->trans_type == 'DR'){
							echo html_escape($item->currency).' '.positive_number($item->amount);
						}else{
							echo '';
						} ?>
					</td>
					<td class="text-right">
						<?php if($item->trans_type == 'CR'){
							echo html_escape($item->currency).' '.positive_number($item->amount);
						} ?>
					</td>
					<td class="text-center">
						Pending
					</td>
					<?php if (user()->role == 'admin'){ ?>
						<td class="hidden-print">
							<?php echo form_open('post_controller/post_options_post'); ?>
							<input type="hidden" name="id" value="<?= html_escape($item->id); ?>">
							<div class="input-group">
								<button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: none;background: transparent;">Options</button>
								<div class="dropdown-menu" style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
									<?php if($item->trans_type == "CR"){ ?>
										<a class="dropdown-item" href="<?= base_url() ?>receipt/<?= $item->id ?>"><i class="dropdown-icon fe fe-printer"></i> View Receipt</a>
									<?php }else{ ?>
										<a class="dropdown-item" href="<?= base_url() ?>transaction/<?= $item->id ?>"><i class="dropdown-icon fe fe-printer"></i> View Transaction</a>
									<?php } ?>
									<a class="dropdown-item" href="javascript:void(0)" onclick="openEditTransactionModal('<?= $item->id; ?>')"><i class="dropdown-icon fe fe-edit"></i> Edit Transaction</a>
									<?php if (auth_check() && is_admin()){ ?>
										<div role="separator" class="dropdown-divider"></div>
										<a class="dropdown-item color-red" href="javascript:void(0)" onclick="delete_transaction('admin_controller/delete_comment_post','<?= $item->id; ?>','<?= trans("confirm_comment"); ?>');"><i class="dropdown-icon fe fe-trash"></i> Delete Transaction</a>
									<?php } ?>
								</div>
							</div>
							<?= form_close(); ?><!-- form end -->
						</td>
						<td class="p-0">
							<?php if ($item->status != 1): ?>
								<?= form_open('admin_controller/approve_comment_post'); ?>
								<input type="hidden" name="id" value="<?= $item->id; ?>">
								<li class="dropdown-item p-0">
									<button class="btn btn-secondary btn-sm px-4" type="submit"><i class="dropdown-icon fe fe-check option-icon"></i> <?= trans("approve"); ?></button>
								</li>
								<?= form_close(); ?>
							<?php endif; ?>
						</td>
					<?php } ?>
				</tr>
			<?php endforeach; ?>

		</tbody>
	</table>
<!-- ============================================================
     EDIT TRANSACTION MODAL
     Allows admins to update the amount, date, and note of a
     pending (unapproved) transaction before it is approved.
     ============================================================ -->
<div class="modal fade" id="editTransactionModal" tabindex="-1" role="dialog" aria-labelledby="editTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTransactionModalLabel"><i class="fe fe-edit"></i> Edit Pending Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-muted small mb-3">Only <strong>pending</strong> transactions can be edited. Approved transactions are locked to preserve the audit trail.</p>
                <input type="hidden" id="edit_txn_id">
                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" step="0.01" id="edit_txn_amount" class="form-control" placeholder="Enter new amount">
                </div>
                <div class="form-group">
                    <label>Transaction Date</label>
                    <input type="date" id="edit_txn_date" class="form-control">
                </div>
                <div class="form-group">
                    <label>Note / Narration</label>
                    <textarea id="edit_txn_note" class="form-control" rows="2" placeholder="Optional note"></textarea>
                </div>
                <div id="edit_txn_feedback" class="alert d-none"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitEditTransaction()">
                    <i class="fe fe-save"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openEditTransactionModal(id) {
    // Reset feedback
    var fb = document.getElementById('edit_txn_feedback');
    fb.className = 'alert d-none';
    fb.textContent = '';

    // Fetch the transaction data via AJAX
    fetch('<?= base_url('admin_controller/get_transaction_json') ?>?id=' + id)
        .then(function(r){ return r.json(); })
        .then(function(res) {
            if (res.success) {
                document.getElementById('edit_txn_id').value     = res.data.id;
                document.getElementById('edit_txn_amount').value = res.data.amount;
                document.getElementById('edit_txn_date').value   = res.data.trans_date;
                document.getElementById('edit_txn_note').value   = res.data.comment || '';
                $('#editTransactionModal').modal('show');
            } else {
                alert(res.message || 'Could not load transaction.');
            }
        })
        .catch(function(e){ alert('Network error: ' + e); });
}

function submitEditTransaction() {
    var id         = document.getElementById('edit_txn_id').value;
    var amount     = document.getElementById('edit_txn_amount').value;
    var trans_date = document.getElementById('edit_txn_date').value;
    var note       = document.getElementById('edit_txn_note').value;
    var fb         = document.getElementById('edit_txn_feedback');

    if (!amount || !trans_date) {
        fb.className = 'alert alert-danger';
        fb.textContent = 'Amount and date are required.';
        return;
    }

    var formData = new FormData();
    formData.append('id', id);
    formData.append('amount', amount);
    formData.append('trans_date', trans_date);
    formData.append('note', note);
    // CodeIgniter CSRF token
    var csrfName  = '<?= $this->security->get_csrf_token_name(); ?>';
    var csrfHash  = '<?= $this->security->get_csrf_hash(); ?>';
    formData.append(csrfName, csrfHash);

    fetch('<?= base_url('admin_controller/edit_transaction_post') ?>', {
        method: 'POST',
        body: formData
    })
    .then(function(r){ return r.json(); })
    .then(function(res) {
        if (res.success) {
            fb.className = 'alert alert-success';
            fb.textContent = res.message;
            setTimeout(function(){ location.reload(); }, 1200);
        } else {
            fb.className = 'alert alert-danger';
            fb.textContent = res.message || 'Update failed.';
        }
    })
    .catch(function(e){
        fb.className = 'alert alert-danger';
        fb.textContent = 'Network error: ' + e;
    });
}
</script>
