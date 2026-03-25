<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
	<div class="col-sm-12">
		<!-- form start -->
		<?= form_open_multipart('post_controller/add_post_post'); ?>
		<input type="hidden" name="post_type" value="video">
		<div class="row">
			<div class="col-sm-12 form-header">
				<h1 class="form-title"><?= trans('add_video'); ?></h1>
				<a href="<?= admin_url(); ?>posts" class="btn btn-success btn-add-new pull-right">
					<i class="fa fa-bars"></i>
					<?= trans('posts'); ?>
				</a>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-post">
					<div class="form-post-left">
						<?php $this->load->view("admin/post/_form_add_post_left"); ?>
					</div>

					<div class="form-post-right">
						<div class="row">
							<div class="col-sm-12">
								<?php $this->load->view('admin/post/_video_upload_box'); ?>
							</div>
							<div class="col-sm-12">
								<?php $this->load->view('admin/post/_upload_file_box'); ?>
							</div>

							<div class="col-sm-12">
								<div class="card">
									<div class="card-header">
										<div class="left">
											<h3 class="card-title"><?= trans('category'); ?></h3>
										</div>
									</div><!-- /.box-header -->

									<div class="card-body">
										<div class="form-group">
											<label><?= trans("language"); ?></label>
											<select name="lang_id" class="form-control" onchange="get_top_categories_by_lang(this.value);">
												<?php foreach ($languages as $language): ?>
													<option value="<?= $language->id; ?>" <?= ($site_lang->id == $language->id) ? 'selected' : ''; ?>><?= $language->name; ?></option>
												<?php endforeach; ?>
											</select>
										</div>

										<div class="form-group">
											<label class="control-label"><?= trans('category'); ?></label>
											<select id="categories" name="category_id" class="form-control max-600" onchange="get_sub_categories(this.value);" required>
												<option value=""><?= trans('select'); ?></option>
												<?php foreach ($top_categories as $item): ?>
													<?php if ($item->id == old('category_id')): ?>
														<option value="<?= html_escape($item->id); ?>"
																selected><?= html_escape($item->name); ?></option>
													<?php else: ?>
														<option value="<?= html_escape($item->id); ?>"><?= html_escape($item->name); ?></option>
													<?php endif; ?>
												<?php endforeach; ?>
											</select>
										</div>

										<div class="form-group">
											<label class="control-label"><?= trans('subcategory'); ?></label>
											<select id="subcategories" name="subcategory_id" class="form-control max-600">
												<option value="0"><?= trans('select'); ?></option>
											</select>
										</div>

									</div>
								</div>
							</div>

							<div class="col-sm-12">
								<?php $this->load->view('admin/includes/_post_publish_box', ['post_type' => $post_type]); ?>
							</div>

						</div>

					</div>
				</div>
			</div>
		</div>
		<?= form_close(); ?><!-- form end -->

	</div>
</div>

<?php $this->load->view('admin/file-manager/_load_file_manager', ['load_images' => true, 'load_files' => true]); ?>

