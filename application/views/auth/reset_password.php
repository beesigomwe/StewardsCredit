<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Section: main -->
<section id="main">
    <div class="container">
        <div class="row">
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= lang_base_url(); ?>"><?= trans("home"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?= html_escape($title); ?></li>
                </ol>
            </div>

            <div class="page-content">
                <div class="col-xs-12 col-sm-6 col-md-4 center-box">
                    <div class="content page-contact page-login">

                        <h1 class="page-title text-center"><?= html_escape($title); ?></h1>

                        <!-- include message block -->
                        <?php $this->load->view('partials/_messages'); ?>
                        <!-- form start -->
                        <?= form_open('auth_controller/reset_password_post', ['id' => 'form_validate']); ?>

                        <?php if (!empty($user)): ?>
                            <input type="hidden" name="id" value="<?= $user->id; ?>">
                        <?php endif; ?>
                        <?php if (!empty($success)): ?>
                            <div class="form-group m-t-30">
                                <a href="<?= lang_base_url(); ?>login" class="btn btn-md btn-custom btn-block"><?= trans("login"); ?></a>
                            </div>
                        <?php else: ?>
                            <div class="form-group">
                                <label><?= trans("new_password"); ?></label>
                                <input type="password" name="password" class="form-control form-input" value="<?= old("password"); ?>" placeholder="<?= trans("new_password"); ?>" required>
                            </div>
                            <div class="form-group m-b-30">
                                <label><?= trans("confirm_password"); ?></label>
                                <input type="password" name="password_confirm" class="form-control form-input" value="<?= old("password_confirm"); ?>" placeholder="<?= trans("confirm_password"); ?>" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-custom btn-block"><?= trans("submit"); ?></button>
                            </div>
                        <?php endif; ?>

                        <?= form_close(); ?>
                        <!-- form end -->
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
<!-- /.Section: main -->