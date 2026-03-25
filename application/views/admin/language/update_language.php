<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= trans("update_language"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?= form_open('language_controller/update_language_post'); ?>

            <input type="hidden" name="id" value="<?= html_escape($language->id); ?>">

            <div class="card-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <label><?= trans("language_name"); ?></label>
                    <input type="text" class="form-control" name="name" placeholder="<?= trans("language_name"); ?>"
                           value="<?= $language->name; ?>" maxlength="200" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                    <small>(Ex: English)</small>
                </div>

                <?php if ($language->short_form == "en"): ?>
                    <div class="form-group">
                        <label class="control-label"><?= trans("short_form"); ?> </label>
                        <input type="text" class="form-control" name="short_form" placeholder="<?= trans("short_form"); ?>"
                               value="<?= $language->short_form; ?>" maxlength="200" readonly <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        <small>(Ex: en)</small>
                    </div>
                <?php else: ?>
                    <div class="form-group">
                        <label class="control-label"><?= trans("short_form"); ?> </label>
                        <input type="text" class="form-control" name="short_form" placeholder="<?= trans("short_form"); ?>"
                               value="<?= $language->short_form; ?>" maxlength="200" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        <small>(Ex: en)</small>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label class="control-label"><?= trans("language_code"); ?> </label>
                    <input type="text" class="form-control" name="language_code" placeholder="<?= trans("language_code"); ?>"
                           value="<?= $language->language_code; ?>" maxlength="200" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                    <small>(Ex: en_us)</small>
                </div>

                <div class="form-group">
                    <label><?= trans('order_1'); ?></label>
                    <input type="number" class="form-control" name="language_order" placeholder="<?= trans('order_1'); ?>"
                           value="<?= $language->language_order; ?>" min="1" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?= trans('text_direction'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="rb_type_1" name="text_direction" value="ltr" class="square-purple" <?= ($language->text_direction == "ltr") ? 'checked' : ''; ?>>
                            <label for="rb_type_1" class="cursor-pointer"><?= trans('left_to_right'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="rb_type_2" name="text_direction" value="rtl" class="square-purple" <?= ($language->text_direction == "rtl") ? 'checked' : ''; ?>>
                            <label for="rb_type_2" class="cursor-pointer"><?= trans('right_to_left'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?= trans('status'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="status1" name="status" value="1" class="square-purple" <?= ($language->status == "1") ? 'checked' : ''; ?>>
                            <label for="status1" class="cursor-pointer"><?= trans('active'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="status2" name="status" value="0" class="square-purple" <?= ($language->status != "1") ? 'checked' : ''; ?>>
                            <label for="status2" class="cursor-pointer"><?= trans('inactive'); ?></label>
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
