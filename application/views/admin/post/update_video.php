<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">

        <!-- form start -->
        <?= form_open_multipart('post_controller/update_post_post'); ?>
        <input type="hidden" name="post_type" value="video">
        <div class="row">
            <div class="col-sm-12 form-header">
                <h1 class="form-title"><?= trans('update_video'); ?></h1>
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
                        <?php $this->load->view("admin/post/_form_update_post_left"); ?>
                    </div>

                    <div class="form-post-right">
                        <div class="row">
							<div class="col-sm-12">
								<?php $this->load->view('admin/post/_video_edit_box'); ?>
							</div>
							<div class="col-sm-12">
								<?php $this->load->view('admin/post/_upload_file_box'); ?>
							</div>

							<?php if (is_admin()): ?>
								<div class="col-sm-12">
									<div class="card">
										<div class="card-header">
											<div class="left">
												<h3 class="card-title"><?= trans('post_owner'); ?></h3>
											</div>
										</div><!-- /.box-header -->
										<div class="card-body">
											<div class="form-group">
												<select name="user_id" class="form-control">
													<?php foreach ($users as $user): ?>
														<option value="<?= $user->id; ?>" <?= ($post->user_id == $user->id) ? 'selected' : ''; ?>><?= $user->username; ?>&nbsp;(<?= $user->role; ?>)</option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
									</div>
								</div>
							<?php else: ?>
								<input type="hidden" name="user_id" value="<?= $post->user_id; ?>">
							<?php endif; ?>

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
													<option value="<?= $language->id; ?>" <?= ($post->lang_id == $language->id) ? 'selected' : ''; ?>><?= $language->name; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
										<div class="form-group">
											<label class="control-label"><?= trans('category'); ?></label>
											<select id="categories" name="category_id" class="form-control max-600" onchange="get_sub_categories(this.value);" required>
												<option value=""><?= trans('select'); ?></option>
												<?php foreach ($categories as $item): ?>
													<option value="<?= html_escape($item->id); ?>" <?= ($item->id == $category_id) ? 'selected' : ''; ?>><?= html_escape($item->name); ?></option>
												<?php endforeach; ?>
											</select>
										</div>

										<div class="form-group">
											<label class="control-label"><?= trans('subcategory'); ?></label>
											<select id="subcategories" name="subcategory_id" class="form-control max-600">
												<option value="0"><?= trans('select'); ?></option>
												<?php foreach ($subcategories as $item): ?>
													<option value="<?= html_escape($item->id); ?>" <?= ($item->id == $subcategory_id) ? 'selected' : ''; ?>><?= html_escape($item->name); ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>
							</div>

                            <div class="col-sm-12">
                                <?php $this->load->view('admin/includes/_post_publish_edit_box'); ?>
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


