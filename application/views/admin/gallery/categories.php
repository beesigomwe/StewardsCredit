<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= trans('add_category'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?= form_open('category_controller/add_gallery_category_post'); ?>

            <input type="hidden" name="parent_id" value="0">

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
                    <select name="album_id" id="albums" class="form-control" required>
                        <option value=""><?= trans('select'); ?></option>
                        <?php foreach ($albums as $album): ?>
                            <option value="<?= $album->id; ?>"><?= $album->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?= trans('category_name'); ?></label>
                    <input type="text" class="form-control" name="name" placeholder="<?= trans('category_name'); ?>"
                           value="<?= old('name'); ?>" maxlength="200" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>
            </div>

            <!-- /.box-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary pull-right"><?= trans('add_category'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?= form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>


    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="pull-left">
                    <h3 class="card-title"><?= trans('gallery_categories'); ?></h3>
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
                                    <th><?= trans('category_name'); ?></th>
                                    <th><?= trans('album'); ?></th>
                                    <th><?= trans('language'); ?></th>
                                    <th class="max-width-120"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($categories as $item): ?>
                                    <tr>
                                        <td><?= html_escape($item->id); ?></td>
                                        <td><?= html_escape($item->name); ?></td>
                                        <td>
                                            <?php $album = get_gallery_album($item->album_id);
                                            if (!empty($album)) {
                                                echo html_escape($album->name);
                                            } ?>
                                        </td>
                                        <td>
                                            <?php
                                            $lang = get_language($item->lang_id);
                                            if (!empty($lang)) {
                                                echo html_escape($lang->name);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                        type="button"
                                                        data-toggle="dropdown"><?= trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <li>
                                                        <a href="<?= admin_url(); ?>update-gallery-category/<?= html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_item('category_controller/delete_gallery_category_post','<?= $item->id; ?>','<?= trans("confirm_category"); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
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
