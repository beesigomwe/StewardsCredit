<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-header">
        <div class="left">
            <h3 class="card-title"><?= $title; ?>
            <div class="pull-right">
                <a href="<?= admin_url(); ?>create-account">
                    <button class="btn btn-success btn-add-new"
                    type="button">
                    <i class="fa fa-plus"></i> <?= trans('add_post'); ?>
                </button>                    
            </a>
        </div>
    </h3>
</div>
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
                <table class="table table-bordered table-striped" role="grid">
                    <?php $this->load->view('admin/includes/_filter_posts'); ?>
                    <thead>
                        <tr role="row">
                            <th width="20"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th width="20"><?= trans('id'); ?></th>
                            <th><?= trans('post'); ?></th>
                            <th><?= trans('post_type'); ?></th>
                            <th><?= trans('language'); ?></th>
                            <th><?= trans('category'); ?></th>
                            <th><?= trans('author'); ?></th>
                            <th></th>
                            <th><?= trans('date'); ?></th>
                            <th class="max-width-120"><?= trans('options'); ?></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($posts as $item): ?>
                            <tr>
                                <td><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?= $item->id; ?>"></td>
                                <td><?= html_escape($item->id); ?></td>
                                <td>
                                 <div class="post-item-table">
                                  <a href="<?= generate_post_url($item); ?>" target="_parent">
                                   <div class="post-image">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?= get_post_image($item, 'small'); ?>" alt="" class="lazyload img-responsive"/>
                                </div>
                                <?= html_escape($item->title); ?>
                            </a>
                        </div>
                    </td>
                    <td><?= trans($item->post_type); ?></td>
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
                     $category_array = get_category_array($item->category_id);
                     if (!empty($category_array['parent_category'])):?>
                      <label class="label label-table m-r-5 bg-primary">
                       <?= html_escape($category_array['parent_category']->name); ?>
                   </label>
               <?php endif;
               if (!empty($category_array['subcategory'])):?>
                  <label class="label label-table m-r-5 bg-gray">
                   <?= html_escape($category_array['subcategory']->name); ?>
               </label>
           <?php endif; ?>
       </td>
       <td>
        <?php $author = get_user($item->user_id);
        if (!empty($author)): ?>
            <a href="<?= base_url(); ?>profile/<?= html_escape($author->slug); ?>" target="_parent" class="table-link">
                <strong><?= html_escape($author->username); ?></strong>
            </a>
        <?php endif; ?>
    </td>
    <td class="td-post-sp">
        <?php if ($item->visibility == 1): ?>
            <label class="label label-success label-table"><i class="fa fa-eye"></i></label>
            <?php else: ?>
                <label class="label label-danger label-table"><i class="fa fa-eye"></i></label>
            <?php endif; ?>

            <?php if ($item->is_slider): ?>
                <label class="label bg-olive label-table"><?= trans('slider'); ?></label>
            <?php endif; ?>

            <?php if ($item->is_picked): ?>
                <label class="label bg-aqua label-table"><?= trans('our_picks'); ?></label>
            <?php endif; ?>

            <?php if ($item->need_auth): ?>
                <label class="label label-warning label-table"><?= trans('only_registered'); ?></label>
            <?php endif; ?>

        </td>
        <td class="nowrap"><?= formatted_date($item->created_at); ?></td>
        <td>
            <!-- form post options -->
            <?= form_open('post_controller/post_options_post'); ?>
            <input type="hidden" name="id" value="<?= html_escape($item->id); ?>">

            <div class="dropdown">
                <button class="btn bg-purple dropdown-toggle btn-select-option"
                type="button"
                data-toggle="dropdown"><?= trans('select_option'); ?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu options-dropdown">
                <?php if (user()->role == 'admin'): ?>
                    <li>
                        <button type="submit" name="option" value="approve" class="btn-list-button">
                            <i class="fa fa-check option-icon"></i><?= trans('approve'); ?>
                        </button>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="<?= admin_url(); ?>update-post/<?= html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="delete_item('post_controller/delete_post','<?= $item->id; ?>','<?= trans("confirm_post"); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                </li>
            </ul>
        </div>

        <?= form_close(); ?><!-- form end -->
    </td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

<div class="col-sm-12 table-ft">
    <div class="row">

        <div class="pull-right">
            <?= $this->pagination->create_links(); ?>
        </div>

        <?php if (count($posts) > 0): ?>
            <div class="pull-left">
                <button class="btn btn-sm btn-danger btn-table-delete" onclick="delete_selected_posts('<?= trans("confirm_posts"); ?>');"><?= trans('delete'); ?></button>
            </div>
        <?php endif; ?>
    </div>
</div>

</div>
</div>
</div>
</div><!-- /.box-body -->
</div>
