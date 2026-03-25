<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="card">
    <div class="box-header">
        <div class="left">
            <h3 class="card-title"><?= trans('subscribers'); ?></h3>
        </div>
    </div><!-- /.box-header -->

    <div class="card-body">
        <?php $this->load->view('admin/includes/_messages'); ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid"
                           aria-describedby="example1_info">
                        <thead>
                        <tr role="row">
                            <th width="20"><?= trans('id'); ?></th>
                            <th><?= trans('email'); ?></th>
                            <th><?= trans('date'); ?></th>
                            <th class="max-width-120"><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($subscribers as $item): ?>
                            <tr>
                                <td><?= html_escape($item->id); ?></td>
                                <td><?= html_escape($item->email); ?></td>
                                <td class="nowrap"><?= formatted_date($item->created_at); ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                type="button"
                                                data-toggle="dropdown"><?= trans('select_option'); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_subscriber_post','<?= $item->id; ?>','<?= trans("confirm_subscriber"); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
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
