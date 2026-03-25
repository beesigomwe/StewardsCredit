<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= trans("add_category"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?= form_open('category_controller/add_category_post'); ?>
            <input type="hidden" name="parent_id" value="0">
            <div class="card-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages_form'); ?>

                <div class="form-group">
                    <label><?= trans("language"); ?></label>
                    <select name="lang_id" class="form-control">
                        <?php foreach ($languages as $language): ?>
                            <option value="<?= $language->id; ?>" <?= ($site_lang->id == $language->id) ? 'selected' : ''; ?>><?= $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><?= trans("category_name"); ?></label>
                    <input type="text" class="form-control" name="name" placeholder="<?= trans("category_name"); ?>"
                           value="<?= old('name'); ?>" maxlength="200" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans("slug"); ?>
                        <small>(<?= trans("slug_exp"); ?>)</small>
                    </label>
                    <input type="text" class="form-control" name="slug" placeholder="<?= trans("slug"); ?>"
                           value="<?= old('slug'); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans('description'); ?> (<?= trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="description"
                           placeholder="<?= trans('description'); ?> (<?= trans('meta_tag'); ?>)" value="<?= old('description'); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?= trans('keywords'); ?> (<?= trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="keywords"
                           placeholder="<?= trans('keywords'); ?> (<?= trans('meta_tag'); ?>)" value="<?= old('keywords'); ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label><?= trans('order'); ?></label>
                    <input type="number" class="form-control" name="category_order" placeholder="<?= trans('order'); ?>"
                           value="1" min="1" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?= trans('show_on_menu'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="rb_show_on_menu_1" name="show_on_menu" value="1" class="square-purple" checked>
                            <label for="rb_show_on_menu_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="rb_show_on_menu_2" name="show_on_menu" value="0" class="square-purple">
                            <label for="rb_show_on_menu_2" class="cursor-pointer"><?= trans('no'); ?></label>
                        </div>
                    </div>
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


    <div class="col-lg-7 col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="pull-left">
                    <h3 class="card-title"><?= trans('categories'); ?></h3>
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
                                    <th><?= trans('language'); ?></th>
                                    <th><?= trans('order'); ?></th>
                                    <th class="max-width-120"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($categories as $item): ?>
                                    <tr>
                                        <td><?= html_escape($item->id); ?></td>
                                        <td><?= html_escape($item->name); ?></td>
                                        <td>
                                            <?php
                                            $lang = get_language($item->lang_id);
                                            if (!empty($lang)) {
                                                echo html_escape($lang->name);
                                            }
                                            ?>
                                        </td>
                                        <td><?= html_escape($item->category_order); ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                        type="button"
                                                        data-toggle="dropdown"><?= trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <li>
                                                        <a href="<?= admin_url(); ?>update-category/<?= html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_item('category_controller/delete_category_post','<?= $item->id; ?>','<?= trans("confirm_category"); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
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