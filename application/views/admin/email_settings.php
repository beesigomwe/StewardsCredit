<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- form start -->

<div class="row">
    <?= form_open('admin_controller/email_settings_post'); ?>
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= trans('email_settings'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="card-body">
                <!-- include message block -->
                <?php
                $message = $this->session->flashdata('submit');
                if (!empty($message) && $message == "email") {
                    $this->load->view('admin/includes/_messages');
                }
                ?>

                <div class="form-group">
                    <label class="control-label"><?= trans('mail_library'); ?></label>
                    <select name="mail_library" class="form-control" onchange="window.location.href = '<?= admin_url(); ?>email-settings?library='+this.value;">
                        <option value="swift" <?= ($library == "swift") ? "selected" : ""; ?>>Swift Mailer</option>
                        <option value="php" <?= ($library == "php") ? "selected" : ""; ?>>PHP Mailer</option>
                        <option value="codeigniter" <?= ($library == "codeigniter") ? "selected" : ""; ?>>CodeIgniter Mail</option>
                    </select>
                </div>

				<div class=" form-group">
					<label class="control-label"><?= trans('protocol'); ?></label>
					<select name="mail_protocol" class="form-control">
						<option value="smtp" <?= ($general_settings->mail_protocol == "smtp") ? "selected" : ""; ?>><?= trans('smtp'); ?></option>
						<?php if ($library == "codeigniter"): ?>
							<option value="mail" <?= ($general_settings->mail_protocol == "mail") ? "selected" : ""; ?>><?= trans('mail'); ?></option>
						<?php endif; ?>
					</select>
				</div>

                <div class="form-group">
                    <label class="control-label"><?= trans('title'); ?></label>
                    <input type="text" class="form-control" name="mail_title"
                           placeholder="<?= trans('title'); ?>" value="<?= html_escape($general_settings->mail_title); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans('host'); ?></label>
                    <input type="text" class="form-control" name="mail_host"
                           placeholder="<?= trans('host'); ?>" value="<?= html_escape($general_settings->mail_host); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans('port'); ?></label>
                    <input type="text" class="form-control" name="mail_port"
                           placeholder="<?= trans('port'); ?>" value="<?= html_escape($general_settings->mail_port); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans('username'); ?></label>
                    <input type="text" class="form-control" name="mail_username"
                           placeholder="<?= trans('username'); ?>" value="<?= html_escape($general_settings->mail_username); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans('password'); ?></label>
                    <input type="password" class="form-control" name="mail_password"
                           placeholder="<?= trans('password'); ?>" value="<?= html_escape($general_settings->mail_password); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans('email_template'); ?></label>
                    <div class="row m-b-15 m-t-15">
                        <div class="category-block-box" style="width: 320px; height: 320px;margin-left: 15px;">
                            <div class="col-sm-12 text-center m-b-15">
                                <input type="radio" name="block_type" value="block-1" class="square-purple" checked>
                            </div>
                            <img src="<?= base_url(); ?>assets/admin/img/email-template-1.png" alt="" class="img-responsive">
                        </div>
                    </div>
                </div>

                <div class="callout" style="max-width: 500px;margin-top: 30px;">
                    <h4><?= trans('gmail_smtp'); ?></h4>
                    <p><?= trans("gmail_warning"); ?></p>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="card-footer">
                <button type="submit" name="submit" value="email" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->

        </div>
    </div>
    <?= form_close(); ?><!-- form end -->

    <?= form_open('admin_controller/email_options_post'); ?>
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= trans('email_options'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="card-body">
                <!-- include message block -->
                <?php
                if (!empty($message) && $message == "options") {
                    $this->load->view('admin/includes/_messages');
                } ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?= trans('email_option_contact_messages'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="send_email_contact_messages" value="1" id="send_email_contact_messages_1" class="square-purple" <?= ($general_settings->send_email_contact_messages == '1') ? 'checked' : ''; ?>>
                            <label for="send_email_contact_messages_1" class="option-label"><?= trans('yes'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="send_email_contact_messages" value="0" id="send_email_contact_messages_2" class="square-purple" <?= ($general_settings->send_email_contact_messages == '0') ? 'checked' : ''; ?>>
                            <label for="send_email_contact_messages_2" class="option-label"><?= trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans('email'); ?> (<?= trans("admin_emails_will_send"); ?>)</label>
                    <input type="text" class="form-control" name="mail_options_account"
                           placeholder="<?= trans('email'); ?>" value="<?= html_escape($general_settings->mail_options_account); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="card-footer">
                <button type="submit" name="submit" value="verification" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
            </div>
        </div>
    </div>
    <?= form_close(); ?><!-- form end -->

</div>


<style>
    h4 {
        color: #0d6aad;
        font-weight: 600;
        margin-bottom: 15px;
        margin-top: 30px;
    }

    .col-option {
        margin-top: 5px;
    }
</style>
