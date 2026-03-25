<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= trans('ad_spaces'); ?></h3>
                </div>
                <!-- /.box-header -->

                <div class="card-body">
					<!-- include message block -->
					<?php if (empty($this->session->flashdata("mes_adsense"))):
						$this->load->view('admin/includes/_messages');
					endif; ?>
                    <div class="form-group">
                        <label><?= trans('select_ad_spaces'); ?></label>
                        <select class="form-control custom-select" name="parent_id" onchange="window.location.href = '<?= admin_url(); ?>'+'ad-spaces?ad_space='+this.value;">
                            <?php foreach ($array_ad_spaces as $key => $value): ?>
                                <option value="<?= $key; ?>" <?= ($key == $ad_codes->ad_space) ? 'selected' : ''; ?>><?= $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <?= form_open_multipart('admin_controller/ad_spaces_post'); ?>

                    <input type="hidden" name="ad_space" value="<?= $ad_codes->ad_space; ?>">

                    <?php if ($ad_codes->ad_space == "sidebar_top" || $ad_codes->ad_space == "sidebar_bottom"): ?>
                        <div class="form-group">
                            <?php if (!empty($array_ad_spaces[$ad_codes->ad_space])): ?>
                                <h4><?= trans($ad_codes->ad_space . "_ad_space"); ?></h4>
                            <?php endif; ?>

                            <p><label class="control-label label bg-red">300x250 <?= trans('banner'); ?></label></p>
                            <div class="row row-ad-space">
                                <div class="col-sm-6">
                                    <label class="control-label"><?= trans('paste_ad_code'); ?></label>
                                    <textarea class="form-control text-area-adspace" name="ad_code_300"
                                              placeholder="<?= trans('paste_ad_code'); ?>"><?= $ad_codes->ad_code_300; ?></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label"><?= trans('upload_your_banner'); ?></label>
                                    <input type="text" class="form-control" name="url_ad_code_300" placeholder="<?= trans('paste_ad_url'); ?>">
                                    <div class="row m-t-15">
                                        <div class="col-sm-12">
                                            <a class='btn bg-olive btn-sm btn-file-upload'>
                                                <?= trans('select_image'); ?>
                                                <input type="file" name="file_ad_code_300" size="40"
                                                       accept=".png, .jpg, .jpeg, .gif"
                                                       onchange="$('#upload-file-info2').html($(this).val());">
                                            </a>
                                        </div>
                                    </div>

                                    <span class='label label-info' id="upload-file-info2"></span>
                                </div>
                            </div>

                            <p><label class="control-label label bg-red">234x60 <?= trans('banner'); ?></label></p>
                            <div class="row row-ad-space">
                                <div class="col-sm-6">
                                    <label class="control-label"><?= trans('paste_ad_code'); ?></label>
                                    <textarea class="form-control text-area-adspace" name="ad_code_234"
                                              placeholder="<?= trans('paste_ad_code'); ?>"><?= $ad_codes->ad_code_234; ?></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label"><?= trans('upload_your_banner'); ?></label>
                                    <input type="text" class="form-control" name="url_ad_code_234" placeholder="<?= trans('paste_ad_url'); ?>">
                                    <div class="row m-t-15">
                                        <div class="col-sm-12">
                                            <a class='btn bg-olive btn-sm btn-file-upload'>
                                                <?= trans('select_image'); ?>
                                                <input type="file" name="file_ad_code_234" size="40"
                                                       accept=".png, .jpg, .jpeg, .gif"
                                                       onchange="$('#upload-file-info3').html($(this).val());">
                                            </a>
                                        </div>
                                    </div>

                                    <span class='label label-info' id="upload-file-info3"></span>
                                </div>
                            </div>
                            <div class="row row-ad-space row-button">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                                </div>
                            </div>

                        </div>
                    <?php else: ?>
                        <div class="form-group">
                            <?php if (!empty($array_ad_spaces[$ad_codes->ad_space])): ?>
                                <h4><?= trans($ad_codes->ad_space . "_ad_space"); ?></h4>
                            <?php endif; ?>

                            <p><label class="control-label label bg-red">728x90 <?= trans('banner'); ?></label></p>
                            <div class="row row-ad-space">
                                <div class="col-sm-6">
                                    <label class="control-label"><?= trans('paste_ad_code'); ?></label>
                                    <textarea class="form-control text-area-adspace" name="ad_code_728"
                                              placeholder="<?= trans('paste_ad_code'); ?>"><?= $ad_codes->ad_code_728; ?></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label"><?= trans('upload_your_banner'); ?></label>
                                    <input type="text" class="form-control" name="url_ad_code_728" placeholder="<?= trans('paste_ad_url'); ?>">
                                    <div class="row m-t-15">
                                        <div class="col-sm-12">
                                            <a class='btn bg-olive btn-sm btn-file-upload'>
                                                <?= trans('select_image'); ?>
                                                <input type="file" name="file_ad_code_728" size="40"
                                                       accept=".png, .jpg, .jpeg, .gif"
                                                       onchange="$('#upload-file-info1').html($(this).val());">
                                            </a>
                                        </div>
                                    </div>

                                    <span class='label label-info' id="upload-file-info1"></span>
                                </div>
                            </div>

                            <p><label class="control-label label bg-red">468x60 <?= trans('banner'); ?></label></p>
                            <div class="row row-ad-space">
                                <div class="col-sm-6">
                                    <label class="control-label"><?= trans('paste_ad_code'); ?></label>
                                    <textarea class="form-control text-area-adspace" name="ad_code_468"
                                              placeholder="<?= trans('paste_ad_code'); ?>"><?= $ad_codes->ad_code_468; ?></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label"><?= trans('upload_your_banner'); ?></label>
                                    <input type="text" class="form-control" name="url_ad_code_468" placeholder="<?= trans('paste_ad_url'); ?>">
                                    <div class="row m-t-15">
                                        <div class="col-sm-12">
                                            <a class='btn bg-olive btn-sm btn-file-upload'>
                                                <?= trans('select_image'); ?>
                                                <input type="file" name="file_ad_code_468" size="40"
                                                       accept=".png, .jpg, .jpeg, .gif"
                                                       onchange="$('#upload-file-info2').html($(this).val());">
                                            </a>
                                        </div>
                                    </div>

                                    <span class='label label-info' id="upload-file-info2"></span>
                                </div>
                            </div>

                            <p><label class="control-label label bg-red">234x60 <?= trans('banner'); ?></label></p>
                            <div class="row row-ad-space">
                                <div class="col-sm-6">
                                    <label class="control-label"><?= trans('paste_ad_code'); ?></label>
                                    <textarea class="form-control text-area-adspace" name="ad_code_234"
                                              placeholder="<?= trans('paste_ad_code'); ?>"><?= $ad_codes->ad_code_234; ?></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label"><?= trans('upload_your_banner'); ?></label>
                                    <input type="text" class="form-control" name="url_ad_code_234" placeholder="<?= trans('paste_ad_url'); ?>">
                                    <div class="row m-t-15">
                                        <div class="col-sm-12">
                                            <a class='btn bg-olive btn-sm btn-file-upload'>
                                                <?= trans('select_image'); ?>
                                                <input type="file" name="file_ad_code_234" size="40"
                                                       accept=".png, .jpg, .jpeg, .gif"
                                                       onchange="$('#upload-file-info3').html($(this).val());">
                                            </a>
                                        </div>
                                    </div>

                                    <span class='label label-info' id="upload-file-info3"></span>
                                </div>
                            </div>
                            <div class="row row-ad-space row-button">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                                </div>
                            </div>

                        </div>
                    <?php endif; ?>




                    <?= form_close(); ?>

                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>

	<div class="row">
		<div class="col-lg-6 col-md-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title"><?= trans('google_adsense_code'); ?></h3>
				</div>
				<!-- /.box-header -->

				<!-- form start -->
				<?= form_open('admin_controller/google_adsense_code_post'); ?>
				<div class="card-body">
					<!-- include message block -->
					<?php if (!empty($this->session->flashdata("mes_adsense"))):
						$this->load->view('admin/includes/_messages');
					endif; ?>
					<div class="form-group">
						<textarea name="google_adsense_code" class="form-control" placeholder="<?= trans('google_adsense_code'); ?>" style="min-height: 140px;"><?= $general_settings->google_adsense_code; ?></textarea>
					</div>
				</div>

				<!-- /.box-body -->
				<div class="card-footer">
					<button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
				</div>
				<!-- /.box-footer -->
				<!-- /.box -->
				<?= form_close(); ?><!-- form end -->
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

        .row-ad-space {
            padding: 15px 0;
            background-color: #f7f7f7;
            margin-bottom: 20px;
        }

        .row-button {
            background-color: transparent !important;
            min-height: 60px;
        }
        textarea{
            resize: vertical;
            min-height: 80px;
        }
    </style>

<?php if ($site_lang->text_direction == "rtl"): ?>

    <style>
        h4 {
            text-align: right;
        }
    </style>
<?php endif; ?>
