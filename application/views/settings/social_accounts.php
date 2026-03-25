<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Section: main -->
<section id="main">
    <div class="container">
        <div class="row">
            <!-- breadcrumb -->
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= lang_base_url(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= lang_base_url(); ?>settings"><?= trans("settings"); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
                </ol>
            </div>
            <div class="page-content">
                <div class="col-sm-12">
                    <h1 class="page-title"><?= trans("settings"); ?></h1>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="profile-tab-content">
                        <!-- include message block -->
                        <?php $this->load->view('partials/_messages'); ?>

                        <?= form_open("profile_controller/social_accounts_post"); ?>

                        <div class="form-group">
                            <label class="control-label">Facebook <?= trans('url'); ?></label>
                            <input type="text" class="form-control form-input" name="facebook_url"
                                   placeholder="Facebook <?= trans('url'); ?>" value="<?= html_escape($user->facebook_url); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Twitter <?= trans('url'); ?></label>
                            <input type="text" class="form-control form-input"
                                   name="twitter_url" placeholder="Twitter <?= trans('url'); ?>"
                                   value="<?= html_escape($user->twitter_url); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Instagram <?= trans('url'); ?></label>
                            <input type="text" class="form-control form-input" name="instagram_url" placeholder="Instagram <?= trans('url'); ?>"
                                   value="<?= html_escape($user->instagram_url); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Pinterest <?= trans('url'); ?></label>
                            <input type="text" class="form-control form-input" name="pinterest_url" placeholder="Pinterest <?= trans('url'); ?>"
                                   value="<?= html_escape($user->pinterest_url); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Linkedin <?= trans('url'); ?></label>
                            <input type="text" class="form-control form-input" name="linkedin_url" placeholder="Linkedin <?= trans('url'); ?>"
                                   value="<?= html_escape($user->linkedin_url); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label class="control-label">VK <?= trans('url'); ?></label>
                            <input type="text" class="form-control form-input" name="vk_url"
                                   placeholder="VK <?= trans('url'); ?>" value="<?= html_escape($user->vk_url); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Youtube <?= trans('url'); ?></label>
                            <input type="text" class="form-control form-input" name="youtube_url"
                                   placeholder="Youtube <?= trans('url'); ?>" value="<?= html_escape($user->youtube_url); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <button type="submit" class="btn btn-md btn-custom"><?= trans("save_changes") ?></button>
                        <?= form_close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.Section: main -->
