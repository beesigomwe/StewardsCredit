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
					<li class="breadcrumb-item active"><?= trans("login"); ?></li>
				</ol>
			</div>

			<div class="page-content">
				<div class="col-xs-12 col-sm-6 col-md-4 center-box">
					<div class="content page-contact page-login">

						<h1 class="page-title text-center"><?= trans("login"); ?></h1>

						<!-- form start -->
						<?= form_open('auth_controller/login_post'); ?>
						<input type="hidden" name="redirect_url" value="<?= lang_base_url(); ?>">

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
								<span><?= trans("or_login_with_email"); ?></span>
							</p>
						<?php endif; ?>

						<!-- include message block -->
						<?php $this->load->view('partials/_messages'); ?>

						<div class="form-group has-feedback">
							<input type="text" name="username" class="form-control"
								   placeholder="<?= trans("username_or_email"); ?>"
								   value="<?= html_escape(old('username')); ?>"
								   required <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
						</div>

						<div class="form-group has-feedback">
							<input type="password" name="password" class="form-control"
								   placeholder="<?= trans("password"); ?>"
								   value="<?= html_escape(old('password')); ?>"
								   required <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
						</div>

						<div class="row">
							<div class="col-sm-12 col-xs-12">
								<button type="submit" class="btn btn-block btn-custom">
									<?= html_escape(trans("login")); ?>
								</button>
							</div>
							<div class="col-sm-12 col-xs-12 m-t-10">
								<a href="<?= lang_base_url(); ?>forgot-password" class="link-forget">
									<?= trans("forgot_password"); ?>?
								</a>
							</div>
						</div>

						<?= form_close(); ?><!-- form end -->

					</div>

				</div>

			</div>
		</div>
	</div>
</section>
<!-- /.Section: main -->

