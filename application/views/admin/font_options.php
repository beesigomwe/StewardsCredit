<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= trans("font_options"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?= form_open('admin_controller/font_options_post'); ?>
            <div class="card-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <label class="label-sitemap"><?= trans("primary_font"); ?></label>
                    <select name="primary_font" class="form-control font-select">
                        <?php foreach ($fonts as $key => $value): ?>
                            <option value="<?= $key; ?>" <?= ($primary_font == $key) ? 'selected' : ''; ?>><?= $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="label-sitemap"><?= trans("secondary_font"); ?></label>
                    <select name="secondary_font" class="form-control font-select">
                        <?php foreach ($fonts as $key => $value): ?>
                            <option value="<?= $key; ?>" <?= ($secondary_font == $key) ? 'selected' : ''; ?>><?= $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- /.box-body -->
                <div class="card-footer" style="padding-left: 0; padding-right: 0;">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans("save_changes"); ?></button>
                </div>
                <!-- /.box-footer -->

                <?= form_close(); ?><!-- form end -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>

