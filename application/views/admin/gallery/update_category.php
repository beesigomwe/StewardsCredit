<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= trans('update_category'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?= form_open('category_controller/update_gallery_category_post'); ?>

            <input type="hidden" name="id" value="<?= html_escape($category->id); ?>">

            <div class="card-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="form-group">
                    <label><?= trans("language"); ?></label>
                    <select name="lang_id" class="form-control" onchange="get_albums_by_lang(this.value);">
                        <?php foreach ($languages as $language): ?>
                            <option value="<?= $language->id; ?>" <?= ($category->lang_id == $language->id) ? 'selected' : ''; ?>><?= $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?= trans("album"); ?></label>
                    <select name="album_id" id="albums" class="form-control" required>
                        <option value=""><?= trans('select'); ?></option>
                        <?php foreach ($albums as $album): ?>
                            <option value="<?= $album->id; ?>" <?= ($category->album_id == $album->id) ? 'selected' : ''; ?>><?= $album->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?= trans('category_name'); ?></label>
                    <input type="text" class="form-control" name="name" placeholder="<?= trans('category_name'); ?>"
                           value="<?= html_escape($category->name); ?>" maxlength="200" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
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
