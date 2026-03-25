<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><?= trans("update_link"); ?></h3>
			</div>
			<!-- /.box-header -->

			<!-- form start -->
			<?= form_open('admin_controller/update_menu_link_post'); ?>

			<input type="hidden" name="id" value="<?= $page->id; ?>">
			<div class="card-body">
				<!-- include message block -->
				<?php $this->load->view('admin/includes/_messages_form'); ?>

				<div class="form-group">
					<label><?= trans("language"); ?></label>
					<select name="lang_id" class="form-control" onchange="get_menu_links_by_lang(this.value);">
						<?php foreach ($languages as $language): ?>
							<option value="<?= $language->id; ?>" <?= ($page->lang_id == $language->id) ? 'selected' : ''; ?>><?= $language->name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label><?= trans("title"); ?></label>
					<input type="text" class="form-control" name="title" placeholder="<?= trans("title"); ?>"
						   value="<?= $page->title; ?>" maxlength="200" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
				</div>

				<div class="form-group">
					<label><?= trans("link"); ?></label>
					<input type="text" class="form-control" name="link" placeholder="<?= trans("link"); ?>"
						   value="<?= $page->link; ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
				</div>

				<div class="form-group">
					<label><?= trans('order'); ?></label>
					<input type="number" class="form-control" name="page_order" placeholder="<?= trans('order'); ?>" value="<?= $page->page_order; ?>" min="0" max="99999" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
				</div>

				<div class="form-group">
					<label class="control-label"><?= trans('parent_link'); ?></label>
					<select id="parent_links" name="parent_id" class="form-control">
						<option value="0"><?= trans('none'); ?></option>
						<?php foreach ($menu_items as $menu_item): ?>
							<?php if ($menu_item->item_type != "category" && $menu_item->item_location == "header" && $menu_item->item_parent_id == "0"): ?>
								<option value="<?= $menu_item->item_id; ?>" <?= ($menu_item->item_id == $page->parent_id) ? 'selected' : ''; ?>><?= $menu_item->item_name; ?></option>
							<?php endif; ?>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-sm-4 col-xs-12">
							<label><?= trans('show_on_menu'); ?></label>
						</div>
						<div class="col-md-3 col-sm-4 col-xs-12 col-option">
							<input type="radio" id="rb_show_on_menu_1" name="page_active" value="1" class="square-purple" <?= ($page->page_active == '1') ? 'checked' : ''; ?>>
							<label for="rb_show_on_menu_1" class="cursor-pointer"><?= trans('yes'); ?></label>
						</div>
						<div class="col-md-3 col-sm-4 col-xs-12 col-option">
							<input type="radio" id="rb_show_on_menu_2" name="page_active" value="0" class="square-purple" <?= ($page->page_active != '1') ? 'checked' : ''; ?>>
							<label for="rb_show_on_menu_2" class="cursor-pointer"><?= trans('no'); ?></label>
						</div>
					</div>
				</div>

			</div>

			<!-- /.box-body -->
			<div class="card-footer">
				<button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
			</div>
			<!-- /.box-footer -->
			<?= form_close(); ?><!-- form end -->
		</div>
		<!-- /.box -->

	</div>
</div>
