<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row" style="margin-bottom: 15px;">
    <div class="col-sm-12">
        <h3 style="font-size: 18px; font-weight: 600;"><?= trans('social_login_settings'); ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Facebook</h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?= form_open('admin_controller/social_login_facebook_post'); ?>
            <div class="card-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata('msg_social_facebook'))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="form-group">
                    <label class="label-sitemap"><?= trans('app_id'); ?></label>
                    <input type="text" class="form-control" name="facebook_app_id" placeholder="<?= trans('app_id'); ?>"
                           value="<?= $general_settings->facebook_app_id; ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="label-sitemap"><?= trans('app_secret'); ?></label>
                    <input type="text" class="form-control" name="facebook_app_secret" placeholder="<?= trans('app_secret'); ?>"
                           value="<?= $general_settings->facebook_app_secret; ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <!-- /.box-body -->
                <div class="card-footer" style="padding-left: 0; padding-right: 0;">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
                <!-- /.box-footer -->

                <?= form_close(); ?><!-- form end -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Google</h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?= form_open('admin_controller/social_login_google_post'); ?>
            <div class="card-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata('msg_social_google'))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="form-group">
                    <label class="label-sitemap"><?= trans('client_id'); ?></label>
                    <input type="text" class="form-control" name="google_client_id" placeholder="<?= trans('client_id'); ?>"
                           value="<?= $general_settings->google_client_id; ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
                <div class="form-group">
                    <label class="label-sitemap"><?= trans('client_secret'); ?></label>
                    <input type="text" class="form-control" name="google_client_secret" placeholder="<?= trans('client_secret'); ?>"
                           value="<?= $general_settings->google_client_secret; ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
                <!-- /.box-body -->
                <div class="card-footer" style="padding-left: 0; padding-right: 0;">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
                <!-- /.box-footer -->

                <?= form_close(); ?><!-- form end -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>

<style>
    h4 {
        color: #0d6aad;
        text-align: left;
        font-weight: 600;
        margin-bottom: 15px;
        margin-top: 30px;
    }
</style>
