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
		<h4 class="card-title">Loan Repayment</h4>
		<div class="card-options">
			<button type="button" class="close" onclick="$('#depositForm').fadeOut();"></button>
		</div>
	</div>
	<div class="card-body">
		<?php if (auth_check() && is_admin()): ?>
		<form id="make_deposit_transaction">
			<input type="hidden" name="parent_id" value="0">
			<input type="hidden" name="user_id" value="<?=user()->id?>">
			<input type="hidden" name="post_id" value="<?=$post->id?>">
			<input type="hidden" name="userid" value="<?=$post->userid?>">
			<input type="hidden" name="category_id" value="1">
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label class="control-label">Currency & Amount</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<input class="form-control" readonly name="currency" value="<?= $post->currency; ?>" style="border-radius: 3px 0 0 3px;max-width: 55px;">
							</div>
							<input type="<?php if(isset($post->currency) && $post->currency == 'UGX'){ echo 'text'; } else { echo 'number'; } ?>" autocomplete="off" class="deposit <?php if(isset($post->currency) && $post->currency == 'UGX'){ echo 'amount'; } ?> form-control" name="amount" placeholder="Amount" value="<?= old('amount'); ?>" step="<?= $step ?>" min="<?= $minimum ?>" max="500000000" required>
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
			<button type="submit" class="btn btn-md btn-custom"><?= trans("post_comment"); ?></button>
			<div id="message-comment-result" class="message-comment-result"></div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$("#make_deposit_transaction").submit(function (event) {
			event.preventDefault();
			var form_values = $(this).serializeArray();
			var data = {};
			var submit = true;
			$(form_values).each(function (i, field) {
				if ($.trim(field.value).length < 1) {
					$("#make_deposit_transaction [name='" + field.name + "']").addClass("is-invalid");
					submit = false;
				} else {
					$("#make_deposit_transaction [name='" + field.name + "']").removeClass("is-invalid");
					data[field.name] = field.value;
				}
			});
			data['limit'] = 1;
			data['lang_folder'] = '<?= $this->selected_lang->folder_name; ?>';
			data[csfr_token_name] = $.cookie(csfr_cookie_name);
			if (submit == true) {
				$.ajax({
					type: "POST",
					url: base_url + "home_controller/add_comment_post",
					data: data,
					success: function (response) {
						$('#depositForm').fadeOut();
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
						$("#make_deposit_transaction")[0].reset();
					}
				});
			}else{

			}
		});
	});
</script>
<?php endif; ?>
