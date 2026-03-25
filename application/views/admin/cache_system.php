<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-lg-7 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= trans('cache_system'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?= form_open('admin_controller/cache_system_post'); ?>
            <div class="card-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-5 col-xs-12">
                            <label><?= trans('cache_system'); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="cache_system" value="1" id="cache_system_1"
                                   class="square-purple" <?= ($general_settings->cache_system == 1) ? 'checked' : ''; ?>>
                            <label for="cache_system_1" class="option-label"><?= trans('enable'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="cache_system" value="0" id="cache_system_2"
                                   class="square-purple" <?= ($general_settings->cache_system != 1) ? 'checked' : ''; ?>>
                            <label for="cache_system_2" class="option-label"><?= trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-5 col-xs-12">
                            <label><?= trans('refresh_cache_database_changes'); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="refresh_cache_database_changes" value="1" id="refresh_cache_database_changes_1"
                                   class="square-purple" <?= ($general_settings->refresh_cache_database_changes == 1) ? 'checked' : ''; ?>>
                            <label for="refresh_cache_database_changes_1" class="option-label"><?= trans('yes'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="refresh_cache_database_changes" value="0" id="refresh_cache_database_changes_2"
                                   class="square-purple" <?= ($general_settings->refresh_cache_database_changes != 1) ? 'checked' : ''; ?>>
                            <label for="refresh_cache_database_changes_2" class="option-label"><?= trans('no'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?= trans('cache_refresh_time'); ?></label>&nbsp;
                    <small>(<?= trans("cache_refresh_time_exp"); ?>)</small>
                    <input type="number" class="form-control" name="cache_refresh_time" placeholder="<?= trans('cache_refresh_time'); ?>"
                           value="<?php echo($general_settings->cache_refresh_time / 60); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <!-- /.box-body -->
                <div class="card-footer" style="padding-left: 0; padding-right: 0;">
                    <button type="submit" name="action" value="save" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                    <button type="submit" name="action" value="reset" class="btn btn-warning pull-right m-r-10"><?= trans('reset_cache'); ?></button>
                </div>
                <!-- /.box-footer -->
                <?= form_close(); ?><!-- form end -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>