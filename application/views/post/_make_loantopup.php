<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php 
$step = '0.01';
$minimum = '0.01';
if(isset($post->currency) && $post->currency == 'UGX'){
	$step = '1';
	$minimum = '1';
}
?>
<!-- Modal content-->
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Withdraw</h4>
		<div class="card-options">
			<button type="button" class="close" onclick="$('#withdrawForm').fadeOut();"></button>
		</div>
	</div>
	<div class="card-body">
		<?php if (auth_check() && is_admin()): ?>
		<form id="make_withdraw_transaction">
			<input type="hidden" name="parent_id" value="0">
			<input type="hidden" name="user_id" value="<?=user()->id?>">
			<input type="hidden" name="post_id" value="<?=$post->id?>">
			<input type="hidden" name="userid" value="<?=$post->userid?>">
			<input type="hidden" name="category_id" value="2">
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label class="control-label">Currency & Amount</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<input class="form-control" readonly name="currency" value="<?= $post->currency; ?>" style="border-radius: 3px 0 0 3px;max-width: 55px;">
							</div>
							<input type="<?php if(isset($post->currency) && $post->currency == 'UGX'){ echo 'text'; } else { echo 'number'; } ?>" autocomplete="off" class="draw <?php if(isset($post->currency) && $post->currency == 'UGX'){ echo 'amount'; } ?> form-control" name="amount" placeholder="Amount" value="<?= old('amount'); ?>" step="<?= $step ?>" min="<?= $minimum ?>" max="500000000" required>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label class="control-label">Date</label>
						<input type="date" class="form-control" name="today" placeholder="Start Date" 
						value="<?= date('Y-m-d'); ?>" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<input type="hidden" name="uuid" value="<?= $this->post_model->uuid() ?>">
						<label class="control-label" for="p-method">Payment Method</label>
						<select name="payment_method" class="form-control" id="payment_method"> 
							<?php foreach ($p_method as $method) {?>
								<option value="<?= $method->p_method_id ?>"><?= $method->p_method_name ?></option>
							<?php } ?> 
						</select>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label class="control-label" for="p-method">On Account</label>
						<select name="account" class="form-control" id="account"> 
							<?php foreach ($accounts as $account) {?>
								<option value="<?= $account->accounts_id ?>"><?= $account->accounts_name ?></option>
							<?php } ?> 
						</select>
					</div>
				</div>
			</div>
		<div class="row">
			<div class="col-12">
				<div class="form-group">
					<label class="control-label">Narration</label>
					<textarea name="comment" class="form-control form-input form-textarea" placeholder="<?= trans("leave_your_comment"); ?>"></textarea>
				</div>
			</div>
		</div>
		<!-- LOAN TOP-UP MERGE OPTION -->
		<?php
		$outstanding = 0;
		if(isset($post->balance)) $outstanding = (float)$post->balance;
		?>
		<?php if($outstanding != 0): ?>
		<div class="row">
			<div class="col-12">
				<div class="alert alert-info py-2 mb-2">
					<strong>Outstanding Balance:</strong> <?= html_escape($post->currency) ?> <?= number_format(abs($outstanding), 2) ?>
				</div>
				<div class="form-group">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="merge_topup" name="merge_topup" value="1">
						<label class="custom-control-label" for="merge_topup">
							<strong>Merge with outstanding balance</strong>
							<small class="text-muted d-block">Tick this to add the new loan amount on top of the existing outstanding balance of <?= html_escape($post->currency) ?> <?= number_format(abs($outstanding), 2) ?>.</small>
						</label>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<button type="submit" class="btn btn-md btn-custom"><?= trans("post_comment"); ?></button>
			<div id="message-comment-result" class="message-comment-result"></div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$("#make_withdraw_transaction").submit(function (event) {
			event.preventDefault();
			var form_values = $(this).serializeArray();
			var data = {};
			var submit = true;
			$(form_values).each(function (i, field) {
				if ($.trim(field.value).length < 1) {
					$("#make_withdraw_transaction [name='" + field.name + "']").addClass("is-invalid");
					submit = false;
				} else {
					$("#make_withdraw_transaction [name='" + field.name + "']").removeClass("is-invalid");
					data[field.name] = field.value;
				}
			});
			data['limit'] = 1;
			data['lang_folder'] = '<?= $this->selected_lang->folder_name; ?>';
			data[csfr_token_name] = $.cookie(csfr_cookie_name);
			if (submit == true) {
				$('#withdrawForm').fadeOut();
				$.ajax({
					type: "POST",
					url: base_url + "home_controller/add_comment_post",
					data: data,
					success: function (response) {
						var obj = JSON.parse(response);
						if (obj.type == 'message') {
							swal.fire({
								'text':'Transaction Saved',
								'type':'success'
							}).then(function(){
								window.location.reload();
							});
						} else {
							document.getElementById("comment-result").innerHTML = obj.message;
						}
						$("#make_withdraw_transaction")[0].reset();
					}
				});
			}
		});
	});
</script>
<?php endif; ?>
