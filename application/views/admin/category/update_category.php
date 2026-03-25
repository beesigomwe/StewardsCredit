<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= trans("update_category"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?= form_open('category_controller/update_category_post'); ?>

            <input type="hidden" name="id" value="<?= html_escape($category->id); ?>">
            <input type="hidden" name="parent_id" value="0">
            <input type="hidden" name="redirect_url" value="<?= $this->input->get('redirect_url'); ?>">

            <div class="card-body">

                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <label><?= trans("language"); ?></label>
                    <select name="lang_id" class="form-control">
                        <?php foreach ($languages as $language): ?>
                            <option value="<?= $language->id; ?>" <?= ($category->lang_id == $language->id) ? 'selected' : ''; ?>><?= $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><?= trans("category_name"); ?></label>
                    <input type="text" class="form-control" name="name" placeholder="<?= trans("category_name"); ?>"
                           value="<?= html_escape($category->name); ?>" maxlength="200" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans("slug"); ?>
                        <small>(<?= trans("slug_exp"); ?>)</small>
                    </label>
                    <input type="text" class="form-control" name="slug" placeholder="<?= trans("slug"); ?>"
                           value="<?= html_escape($category->slug); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans('description'); ?> (<?= trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="description"
                           placeholder="<?= trans('description'); ?> (<?= trans('meta_tag'); ?>)" value="<?= html_escape($category->description); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans('keywords'); ?> (<?= trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="keywords"
                           placeholder="<?= trans('keywords'); ?> (<?= trans('meta_tag'); ?>)" value="<?= html_escape($category->keywords); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>


                <div class="form-group">
                    <label><?= trans('order'); ?></label>
                    <input type="number" class="form-control" name="category_order" placeholder="<?= trans('order'); ?>"
                           value="<?= html_escape($category->category_order); ?>" min="1" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?= trans('show_on_menu'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="rb_show_on_menu_1" name="show_on_menu" value="1" class="square-purple" <?= ($category->show_on_menu == '1') ? 'checked' : ''; ?>>
                            <label for="rb_show_on_menu_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="rb_show_on_menu_2" name="show_on_menu" value="0" class="square-purple" <?= ($category->show_on_menu != '1') ? 'checked' : ''; ?>>
                            <label for="rb_show_on_menu_2" class="cursor-pointer"><?= trans('no'); ?></label>
                        </div>
                    </div>
                </div>
            </div>


            <!-- /.box-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?> </button>
            </div>
            <!-- /.box-footer -->
            <?= form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>

</div>
