<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= trans('send_email_subscribers'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?= form_open('admin_controller/send_email_subscribers_post'); ?>

            <div class="card-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="form-group">
                    <label><?= trans('subject'); ?></label>
                    <input type="text" name="subject" class="form-control" placeholder="<?= trans('subject'); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>
                <div class="form-group">
                    <label><?= trans('content'); ?></label>
					<div class="row">
						<div class="col-sm-12 editor-buttons">
							<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#image_file_manager" data-image-type="editor"><i class="fa fa-image"></i>&nbsp;&nbsp;&nbsp;<?= trans("add_image"); ?></button>
						</div>
					</div>
					<textarea class="tinyMCE form-control" name="message"></textarea>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary pull-right"><?= trans('send_email'); ?></button>
            </div>
            <!-- /.box-footer -->

            <?= form_close(); ?><!-- form end -->

        </div>
        <!-- /.box -->
    </div>
</div>

<?php $this->load->view('admin/file-manager/_load_file_manager', ['load_images' => true, 'load_files' => false]); ?>
