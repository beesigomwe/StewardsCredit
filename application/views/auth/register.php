<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Section: main -->
<section id="main">
    <div class="container">
        <div class="row">
            <!-- breadcrumb -->
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= lang_base_url(); ?>"><?= trans("home"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?= trans("register"); ?></li>
                </ol>
            </div>

            <div class="page-content">
                <div class="col-xs-12 col-sm-6 col-md-4 center-box">
                    <div class="content page-contact page-login">

                        <h1 class="page-title text-center"><?= trans("register"); ?></h1>

                        <!-- form start -->
                        <?= form_open('auth_controller/register_post', ['id' => 'form_validate', 'class' => 'validate_terms']); ?>
						<?php if (!empty($general_settings->facebook_app_id)): ?>
							<a href="<?= base_url(); ?>connect-with-facebook" class="btn btn-social btn-social-facebook">
								<i class="icon-facebook"></i>&nbsp;<?= trans("connect_with_facebook"); ?>
							</a>
						<?php endif; ?>
						<?php if (!empty($general_settings->google_client_id)): ?>
							<a href="<?= base_url(); ?>connect-with-google" class="btn btn-social btn-social-google">
								<i class="icon-google"></i>&nbsp;<?= trans("connect_with_google"); ?>
							</a>
						<?php endif; ?>
						<?php if (!empty($general_settings->facebook_app_id) || !empty($general_settings->google_client_id)): ?>
							<p class="p-auth-modal-or">
								<span><?= trans("or_register_with_email"); ?></span>
							</p>
						<?php endif; ?>

						<!-- include message block -->
						<?php $this->load->view('partials/_messages'); ?>

                        <div class="form-group has-feedback">
                            <input type="text" name="username" class="form-control"
                                   placeholder="<?= html_escape(trans("username")); ?>"
                                   value="<?= old("username"); ?>" required <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> maxlength="<?= $this->username_character_limit; ?>">
                        </div>

                        <div class="form-group has-feedback">
                            <input type="email" name="email" class="form-control"
                                   placeholder="<?= html_escape(trans("email")); ?>"
                                   value="<?= old("email"); ?>" required <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group has-feedback">
                            <input type="password" name="password" class="form-control"
                                   placeholder="<?= html_escape(trans("password")); ?>"
                                   value="<?= old("password"); ?>" required <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group has-feedback">
                            <input type="password" name="confirm_password" class="form-control"
                                   placeholder="<?= html_escape(trans("confirm_password")); ?>" required <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>
                        <div class="form-group">
                            <label class="custom-checkbox">
                                <input type="checkbox" class="checkbox_terms_conditions" required>
                                <span class="checkbox-icon"><i class="icon-check"></i></span>
                                <?= trans("terms_conditions_exp"); ?>&nbsp;<a href="<?= lang_base_url(); ?>terms-conditions" class="link-terms" target="_blank"><strong><?= trans("terms_conditions"); ?></strong></a>
                            </label>
                        </div>
                        <?php generate_recaptcha(); ?>
                        <div class="col-sm-12 p0 form-group has-feedback">
                            <button type="submit" class="btn btn-block btn-custom margin-top-15">
                                <?= html_escape(trans("register")); ?>
                            </button>
                        </div>

                        <?= form_close(); ?><!-- form end -->

                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
<!-- /.Section: main -->

