<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<div class="row">

    <?= form_open('admin_controller/seo_tools_post'); ?>

    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= trans('seo_tools'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <div class="card-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages');?>
                <div class="form-group">
                    <label><?= trans("language"); ?></label>
                    <select name="lang_id" class="form-control" onchange="window.location.href = '<?= admin_url(); ?>'+'seo-tools?lang='+this.value;">
                        <?php foreach ($languages as $language): ?>
                            <option value="<?= $language->id; ?>" <?= ($selected_lang == $language->id) ? 'selected' : ''; ?>><?= $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?= trans('site_title'); ?></label>
                    <input type="text" class="form-control" name="site_title"
                           placeholder="<?= trans('site_title'); ?>" value="<?= html_escape($settings->site_title); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans('home_title'); ?></label>
                    <input type="text" class="form-control" name="home_title"
                           placeholder="<?= trans('home_title'); ?>" value="<?= html_escape($settings->home_title); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans('site_description'); ?></label>
                    <input type="text" class="form-control" name="site_description"
                           placeholder="<?= trans('site_description'); ?>"
                           value="<?= html_escape($settings->site_description); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans('keywords'); ?></label>
                    <textarea class="form-control text-area" name="keywords"
                              placeholder="<?= trans('keywords'); ?>"
                              style="min-height: 100px;" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>><?= html_escape($settings->keywords); ?></textarea>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans('google_analytics'); ?></label>
                    <textarea class="form-control text-area" name="google_analytics"
                              placeholder="<?= trans('google_analytics_code'); ?>"
                              style="min-height: 100px;" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>><?= html_escape($general_settings->google_analytics); ?></textarea>
                </div>

                <!-- /.box-body -->
                <div class="card-footer" style="padding-left: 0; padding-right: 0;">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
                <!-- /.box-footer -->

            </div>
            <!-- /.box -->
        </div>

    </div>
    <?= form_close(); ?><!-- form end -->


    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= trans('sitemap'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?= form_open('sitemap_controller/generate_sitemap_post'); ?>
            <div class="card-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages_form'); ?>

                <div class="form-group">
                    <label class="label-sitemap"><?= trans('frequency'); ?></label>
                    <small class="small-sitemap"><?= trans('frequency_exp'); ?></small>

                    <select name="frequency" class="form-control">
                        <option value="none"><?= trans('none'); ?></option>
                        <option value="always"><?= trans('always'); ?></option>
                        <option value="hourly"><?= trans('hourly'); ?></option>
                        <option value="daily"><?= trans('daily'); ?></option>
                        <option value="weekly"><?= trans('weekly'); ?></option>
                        <option value="monthly" selected><?= trans('monthly'); ?></option>
                        <option value="yearly"><?= trans('yearly'); ?></option>
                        <option value="never"><?= trans('never'); ?></option>
                    </select>

                </div>

                <div class="form-group">
                    <label class="label-sitemap"><?= trans('last_modification'); ?></label>
                    <small class="small-sitemap"><?= trans('last_modification_exp'); ?></small>
                    <div class="form-radio">
                        <input type="radio" id="last_modification_1" name="last_modification" value="none" class="square-purple">
                        <label for="last_modification_1" class="col-option">&nbsp;<?= trans('none'); ?></label><br>
                    </div>

                    <div class="form-radio">
                        <input type="radio" id="last_modification_2" name="last_modification" value="server_response" class="square-purple" checked>
                        <label for="last_modification_2">&nbsp;<?= trans('server_response'); ?></label>
                    </div>

                    <div class="form-radio">
                        <input type="radio" id="last_modification_3" name="last_modification" value="custom" class="square-purple">
                        <label for="last_modification_3">&nbsp;<?= trans('use_this_date'); ?></label>
                        <input type="text" class="form-control input-custom-time" name="lastmod_time"
                               value="<?= date("Y-m-d"); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="label-sitemap"><?= trans('priority'); ?></label>
                    <small class="small-sitemap"><?= trans('priority_exp'); ?></small>
                    <div class="form-radio">
                        <input type="radio" id="priority_1" name="priority" value="none" class="square-purple">
                        <label for="priority_1">&nbsp;<?= trans('none'); ?></label>
                    </div>

                    <div class="form-radio">
                        <input type="radio" id="priority_2" name="priority" value="automatically" class="square-purple" checked>
                        <label for="priority_2">&nbsp;<?= trans('priority_none'); ?></label>
                    </div>

                </div>
            </div>
            <!-- /.box-body -->
            <div class="card-footer">
                <button type="submit" name="process" value="generate" class="btn btn-primary pull-right"><?= trans('download_sitemap'); ?></button>
                <button type="submit" name="process" value="update" class="btn btn-success pull-right m-r-10"><?= trans('update_sitemap'); ?></button>
            </div>
            <!-- /.box-footer -->

            <?= form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->

        <div class="callout" style="margin-top: 30px;background-color: #fff; border-color:#00c0ef;max-width: 600px;">
            <h4>Cron Job</h4>
            <p><strong>http://domain.com/cron/update-sitemap</strong></p>
            <small><?= trans('msg_cron_sitemap'); ?></small>
        </div>

    </div>
</div>

<style>
    .form-radio{
        min-height: 34px;
    }
</style>


