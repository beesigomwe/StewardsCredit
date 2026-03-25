<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= trans('add_image'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?= form_open_multipart('gallery_controller/add_gallery_image_post'); ?>

            <div class="card-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages_form'); ?>
                <div class="form-group">
                    <label><?= trans("language"); ?></label>
                    <select name="lang_id" class="form-control" onchange="get_albums_by_lang(this.value);">
                        <?php foreach ($languages as $language): ?>
                            <option value="<?= $language->id; ?>" <?= ($site_lang->id == $language->id) ? 'selected' : ''; ?>><?= $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?= trans("album"); ?></label>
                    <select name="album_id" id="albums" class="form-control" required onchange="get_categories_by_albums(this.value);">
                        <option value=""><?= trans('select'); ?></option>
                        <?php foreach ($albums as $album): ?>
                            <option value="<?= $album->id; ?>"><?= $album->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?= trans('category'); ?></label>
                    <select id="categories" name="category_id" class="form-control">
                        <option value=""><?= trans('select'); ?></option>
                        <?php foreach ($categories as $item): ?>
                            <?php if ($item->id == old('category_id')): ?>
                                <option value="<?= html_escape($item->id); ?>" selected>
                                    <?= html_escape($item->name); ?></option>
                            <?php else: ?>
                                <option value="<?= html_escape($item->id); ?>"><?= html_escape($item->name); ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?= trans('title'); ?></label>
                    <input type="text" class="form-control"
                           name="title" id="title" placeholder="<?= trans('title'); ?>"
                           value="<?= old('title'); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans('image'); ?></label>
                    <div class="col-sm-12">
                        <div class="row">
                            <a class='btn btn-success btn-sm btn-file-upload'>
                                <?= trans('select_image'); ?>
                                <input type="file" id="Multifileupload" name="files[]" size="40" accept=".png, .jpg, .jpeg, .gif" multiple="multiple" required>
                            </a>
                            <span>(<?= trans("select_multiple_images"); ?>)</span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div id="MultidvPreview">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary pull-right"><?= trans('add_image'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?= form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="left">
                    <h3 class="card-title"><?= trans('gallery'); ?></h3>
                </div>
            </div><!-- /.box-header -->

            <div class="card-body">
                <div class="row">
                    <!-- include message block -->
                    <div class="col-sm-12">
                        <?php $this->load->view('admin/includes/_messages'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dataTable" id="cs_datatable_lang" role="grid"
                                   aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= trans('id'); ?></th>
                                    <th><?= trans('image'); ?></th>
                                    <th><?= trans('title'); ?></th>
                                    <th><?= trans('language'); ?></th>
                                    <th><?= trans('album'); ?></th>
                                    <th><?= trans('category'); ?></th>
                                    <th><?= trans('date'); ?></th>
                                    <th class="max-width-120"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($images as $item): ?>
                                    <tr>
                                        <td><?= html_escape($item->id); ?></td>
                                        <td>
                                            <div style="position: relative">
                                                <img src="<?= base_url() . html_escape($item->path_small); ?>" alt="" class="img-responsive" style="max-width: 140px; max-height: 140px;">
                                                <?php if ($item->is_album_cover): ?>
                                                    <label class="label label-success" style="position: absolute;left: 0;top: 0;"><?= trans("album_cover"); ?></label>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td><?= html_escape($item->title); ?></td>
                                        <td>
                                            <?php
                                            $lang = get_language($item->lang_id);
                                            if (!empty($lang)) {
                                                echo html_escape($lang->name);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $album = get_gallery_album($item->album_id);
                                            if (!empty($album)) {
                                                echo html_escape($album->name);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $category = get_gallery_category($item->category_id);
                                            if (!empty($category)) {
                                                echo html_escape($category->name);
                                            }
                                            ?>
                                        </td>
                                        <td class="nowrap"><?= formatted_date($item->created_at); ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                        type="button"
                                                        data-toggle="dropdown"><?= trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <?php if ($item->is_album_cover == 0): ?>
                                                        <li>
                                                            <a href="javascript:void(0)" onclick="set_as_album_cover('<?= $item->id; ?>');"><i class="fa fa-check option-icon"></i><?= trans('set_as_album_cover'); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li>
                                                        <a href="<?= admin_url(); ?>update-gallery-image/<?= html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_item('gallery_controller/delete_gallery_image_post','<?= $item->id; ?>','<?= trans("confirm_image"); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>


