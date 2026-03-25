<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="form-post-right col-lg-6 mx-auto">
	<?php if($category > 0){ ?>
		<input type="hidden" name="category_id" value="<?= $category ?>">
	<?php }else{ ?>
		<div class="row">
			<div class="col-12">
				<div class="form-group">
					<label class="control-label"><?= trans('category'); ?></label>
					<select id="categories" name="category_id" class="form-control" onchange="get_sub_categories(this.value);" required>
						<option value=""><?= trans('select'); ?></option>
						<?php foreach ($top_categories as $item){ ?> 
							<?php if ($item->id == old('category_id') || $item->id == $category){  
								$selected = 'selected';
							}else{ 
								$selected = '';
							} ?>
							<option value="<?= html_escape($item->id); ?>" <?=$selected?>> <?= html_escape($item->name); ?> </option> 		
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
	<?php } ?>
	<div class="row">
		<div class="col-6">
			<div class="form-group">
				<label class="control-label">Currency & Amount</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<select class="form-control" name="currency" value="<?= old('currency'); ?>" style="border-radius: 3px 0 0 3px;">
							<option>UGX</option>
							<option>USD</option>
						</select>
					</div>
					<input type="text" autocomplete="off" id="amount_infigures" class="form-control" name="amount" placeholder="Amount" value="<?= old('amount'); ?>" step="0.01" min="0" max="500000000" required>
				</div>
			</div>
		</div>
		<div class="col-3">
			<div class="form-group">
				<label class="control-label">Interest Rate</label>
				<div class="input-group">
					<input type="text" class="form-control text-right" required name="interestrate" placeholder="10" aria-label="Interest Rate" value="<?= old('rate'); ?>">
					<span class="input-group-append">
						<span class="input-group-text">%</span>
					</span>
				</div>
			</div>
		</div>
		<div class="col-3">
			<div class="form-group">
				<label class="control-label">Interest Mode</label>
				<select type="text" class="form-control" name="interestperiod" value="<?= old('currency'); ?>" required>
					<option>Annually</option>
					<option>Monthly</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-6">
			<div class="form-group">
				<label class="control-label">Payment Method</label>
				<div class="input-group">
					<select name="payment_method" class="form-control" id="payment_method"> 
						<?php foreach ($p_method as $method) {?>
							<option value="<?= $method->p_method_id ?>"><?= $method->p_method_name ?></option>
						<?php } ?> 
					</select>
				</div>
			</div>
		</div>
		<div class="col-6">
			<div class="form-group">
				<label class="control-label">Account Name</label>
				<div class="input-group">
					<input type="hidden" name="uuid" value="<?= $this->post_model->uuid() ?>">
					<select name="account" class="form-control" id="account">  
						<?php foreach ($accounts as $account) {?>
							<option value="<?= $account->accounts_id ?>"><?= $account->accounts_name ?></option>
						<?php } ?>  
					</select>   
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-6">
			<div class="form-group">
				<label class="control-label">Start Date</label>
				<input type="date" class="form-control" name="startdate" placeholder="Start Date" 
				value="<?php print_r(old('startdate')); $date = old('startdate'); if(null !== $date){echo old('startdate'); }else{echo date('Y-m-d'); } ?>" required>
			</div>
		</div>
		<div class="col-6">
			<div class="form-group">
				<label class="control-label">End Date</label>
				<input type="date" class="form-control" name="enddate" placeholder="End Date" value="<?= old('enddate'); ?>">
			</div>
		</div>
	</div>
	<div class="row container">
		<div class="col-12">
			<?php $this->load->view('admin/post/_upload_file_box'); ?>
		</div>
	</div>
</div>


