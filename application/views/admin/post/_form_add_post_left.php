<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="form-post-left col-lg-6 mx-auto">
	<div class="form-group">
		<label class="control-label">Account Holder</label>
		<select class="form-control" required name="userid" required>
			<option value=""></option>
			<?php foreach ($contacts as $contact) {
				if($contact->id !== user()->id){ ?>
					<option value="<?= $contact->id?>"><?= $contact->firstname?> <?= $contact->lastname?></option>
				<?php }
			} ?>
		</select>
	</div>
	<div class="form-group">
		<label class="control-label"><?= trans('summary'); ?></label>
		<textarea class="form-control text-area"
		name="summary" placeholder="<?= trans('summary'); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>><?= old('summary'); ?></textarea>
	</div>
</div>