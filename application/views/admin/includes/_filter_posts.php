<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row table-filter-container">
	<div class="col-sm-12">
		<?= form_open($form_action, ['method' => 'GET']); ?>
		<div class="row">
			<div class="col-sm-12 col-md-6 col-lg-4" style="max-width: 305px; padding: 0;">
				<div class="item-table-filter" style="width: 80px; min-width: 80px;">
					<label><?= trans("show"); ?></label>
					<select name="show" class="form-control">
						<option value="15" <?= ($this->input->get('show', true) == '15') ? 'selected' : ''; ?>>15</option>
						<option value="30" <?= ($this->input->get('show', true) == '30') ? 'selected' : ''; ?>>30</option>
						<option value="60" <?= ($this->input->get('show', true) == '60') ? 'selected' : ''; ?>>60</option>
						<option value="100" <?= ($this->input->get('show', true) == '100') ? 'selected' : ''; ?>>100</option>
					</select>
				</div>

		<?php /* <div class="item-table-filter">
			<label><?= trans("language"); ?></label>
			<select name="lang_id" class="form-control" onchange="get_top_categories_by_lang(this.value);">
				<option value=""><?= trans("all"); ?></option>
				<?php foreach ($languages as $language): ?>
					<option value="<?= $language->id; ?>" <?= ($this->input->get('lang_id', true) == $language->id) ? 'selected' : ''; ?>><?= html_escape($language->name); ?></option>
				<?php endforeach; ?>
			</select>
			</div> */ ?>

			<?php if (user()->role == "admin"): ?>
				<div class="item-table-filter">
					<label><?= trans("user"); ?></label>
					<select name="author" class="form-control">
						<option value=""><?= trans("all"); ?></option>
						<?php foreach ($authors as $author): ?>
							<option value="<?= $author->id; ?>"
								<?= ($this->input->get('author', true) == $author->id) ? 'selected' : ''; ?>>
								<?= html_escape($author->username); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			<?php endif; ?>

			<div class="item-table-filter">
				<label><?= trans('category'); ?></label>
				<select id="categories" name="category" class="form-control" onchange="get_sub_categories(this.value);">
					<option value=""><?= trans("all"); ?></option>
					<?php
					$categories = $this->category_model->get_all_categories();
					if (!empty($this->input->get('lang_id', true))) {
						$categories = $this->category_model->get_categories_by_lang($this->input->get('lang_id', true));
					}
					foreach ($categories as $item): ?>
						<option value="<?= $item->id; ?>" <?= ($this->input->get('category', true) == $item->id) ? 'selected' : ''; ?>>
							<?= html_escape($item->name); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
<?php /*
		<div class="item-table-filter">
			<div class="form-group">
				<label class="control-label"><?= trans('subcategory'); ?></label>
				<select id="subcategories" name="subcategory" class="form-control">
					<option value=""><?= trans("all"); ?></option>
					<?php
					if (!empty($this->input->get('category', true))):
						$subcategories = helper_get_subcategories($this->input->get('category', true));
						if (!empty($subcategories)) {
							foreach ($subcategories as $item):?>
								<option value="<?= $item->id; ?>" <?= ($this->input->get('subcategory', true) == $item->id) ? 'selected' : ''; ?>><?= $item->name; ?></option>
							<?php endforeach;
						}
					endif;
					?>
				</select>
			</div>
			</div> */ ?>
		</div>
		<div class="col-sm-12 col-md-6 col-lg-4">
			<div class="item-table-filter">
				<label><?= trans("search"); ?></label>
				<input name="q" class="form-control" placeholder="Search" type="search" value="<?= html_escape($this->input->get('q', true)); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
			</div>

			<div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
				<label style="display: block">&nbsp;</label>
				<button type="submit" class="btn bg-purple"><?= trans("filter"); ?></button>
			</div>
			<?= form_close(); ?>
		</div>
	</div>
</div>
</div>
