<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
    <div class="card-header">
        <div class="left">
            <h3 class="card-title"><?= trans('video'); ?></h3>
        </div>
    </div><!-- /.box-header -->
    <div class="card-body">
        <div class="form-group">
            <label class="control-label"><?= trans('video_url'); ?><br>
                <small>(Youtube, Vimeo, Dailymotion, Facebook)</small>
            </label>
            <input type="text" class="form-control" name="video_url" id="video_url" placeholder="<?= trans('video_url'); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
            <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right btn-get-embed" onclick="get_video_from_url();"><?= trans('get_video'); ?></a>
        </div>

        <div class="form-group m-t-45">
            <label class="control-label video-embed-lbl"><?= trans('video_embed_code'); ?></label>
            <textarea class="form-control text-embed"
                      name="video_embed_code" id="video_embed_code" placeholder="<?= trans('video_embed_code'); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>><?= old('video_embed_code'); ?></textarea>
        </div>

        <iframe src="" id="video_embed_preview" frameborder="0" allow="encrypted-media" allowfullscreen class="video-embed-preview"></iframe>

    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="left">
            <h3 class="card-title"><?= trans('video_thumbnails'); ?></h3>
        </div>
    </div><!-- /.box-header -->
    <div class="card-body">
        <div class="form-group m0">
            <label class="control-label"><?= trans('video_image'); ?></label>
            <div class="row">
                <div class="col-sm-12">
                    <a class='btn btn-sm bg-purple' data-toggle="modal" data-target="#image_file_manager" data-image-type="video_thumbnail">
                        <?= trans('select_image'); ?>
                    </a>
                </div>
                <div class="col-sm-12 m-t-15 m-b-10">
                    <img id="selected_image_file" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="" class="img-responsive"/>
                    <input type="hidden" name="post_image_id">
                </div>
                <div class="col-sm-12 m-b-10">
                    <label><?= trans('or'); ?><br></label>
                </div>
                <div class="col-sm-12 m-b-15">
                    <input type="text" class="form-control" name="image_url" id="video_thumbnail_url" placeholder="<?= trans('add_image_url'); ?>"
                           value="<?= old('image_url'); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
            </div>
        </div>
    </div>
</div>
