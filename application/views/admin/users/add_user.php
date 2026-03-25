<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= trans("add_user"); ?></h3>
                <div class="card-options">
                    
                </div>
            </div>


            <!-- /.box-header -->

            <!-- form start -->
            <?= form_open_multipart('admin_controller/add_user_post'); ?>

            <div class="card-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" autocomplete="off" name="firstname" class="form-control auth-form-input" placeholder="First Name" value="<?= old("firstname"); ?>" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" autocomplete="off" name="lastname" class="form-control auth-form-input" placeholder="Last Name" value="<?= old("lastname"); ?>" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label><?= trans("email"); ?></label>
                    <input type="email" autocomplete="off" name="email" class="form-control auth-form-input" placeholder="<?= trans("email"); ?>" value="<?= old("email"); ?>">
                </div>
                <div class="form-group">
                    <label>Mobile</label>
                    <input type="tel" autocomplete="off" name="mobile" class="form-control auth-form-input" placeholder="Mobile" value="<?= old("mobile"); ?>" required>
                </div>
                <div class="form-group hide password">
                    <label><?= trans("password"); ?></label>
                    <input type="password" name="password" class="form-control auth-form-input" placeholder="<?= trans("password"); ?>" value="<?= old("password"); ?>">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?= trans('role'); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="role_1" name="role" value="admin" class="square-purple" onclick="$('.password').removeClass('hide');">
                            <label for="role_1" class="cursor-pointer"><?= trans('admin'); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="role_2" name="role" value="author" class="square-purple" onclick="$('.password').addClass('hide');">
                            <label for="role_2" class="cursor-pointer"><?= trans('author'); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="role_3" name="role" value="user" class="square-purple" checked onclick="$('.password').addClass('hide');">
                            <label for="role_3" class="cursor-pointer"><?= trans('user'); ?></label>
                        </div>
                    </div>
                </div>

            </div>

            <!-- /.box-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary pull-right mb-10"style="margin-bottom: 10px;"><?= trans('add_user'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?= form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>
