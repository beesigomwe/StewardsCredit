<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= trans('update_image'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?= form_open_multipart('gallery_controller/update_gallery_image_post'); ?>

            <div class="card-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <input type="hidden" name="id" value="<?= html_escape($image->id); ?>">
                <input type="hidden" name="path_big" value="<?= html_escape($image->path_big); ?>">
                <input type="hidden" name="path_small" value="<?= html_escape($image->path_small); ?>">
                <div class="form-group">
                    <label><?= trans("language"); ?></label>
                    <select name="lang_id" class="form-control" onchange="get_albums_by_lang(this.value);">
                        <?php foreach ($languages as $language): ?>
                            <option value="<?= $language->id; ?>" <?= ($image->lang_id == $language->id) ? 'selected' : ''; ?>><?= $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?= trans("album"); ?></label>
                    <select name="album_id" id="albums" class="form-control" required onchange="get_categories_by_albums(this.value);">
                        <option value=""><?= trans('select'); ?></option>
                        <?php foreach ($albums as $album): ?>
                            <option value="<?= $album->id; ?>" <?= ($image->album_id == $album->id) ? 'selected' : ''; ?>><?= $album->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?= trans('category'); ?></label>
                    <select id="categories" name="category_id" class="form-control">
                        <option value=""><?= trans('select'); ?></option>
                        <?php foreach ($categories as $item): ?>
                            <?php if ($item->id == $image->category_id): ?>
                                <option value="<?= html_escape($item->id); ?>" selected>
                                    <?= html_escape($item->name); ?>
                                </option>
                            <?php else: ?>
                                <option value="<?= html_escape($item->id); ?>"><?= html_escape($item->name); ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans('title'); ?></label>
                    <input type="text" class="form-control"
                           name="title" id="title" placeholder="<?= trans('title'); ?>"
                           value="<?= html_escape($image->title); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans('image'); ?> </label>
                    <div class="row">
                        <div class="col-sm-4">
                            <img src="<?= base_url() . html_escape($image->path_small); ?>" alt=""
                                 class="thumbnail img-responsive">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <a class='btn btn-success btn-sm btn-file-upload'>
                                <?= trans('select_image'); ?>
                                <input type="file" id="Multifileupload" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" style="cursor: pointer;">
                            </a>
                        </div>
                    </div>

                    <div id="MultidvPreview"></div>
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