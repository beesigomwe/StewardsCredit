<?php defined('BASEPATH') OR exit('No direct script accexss allowed'); ?>
<div class="col-sm-12">
  <?php $this->load->view('admin/includes/_messages'); ?>
</div>
<div class="card">
  <div class="card-body" style="background: whitesmoke;">

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?= trans('users'); ?></h3>
          </div>

          <div class="table-responsive">
            <table class="table table-striped table table-hover table-outline table-vcenter text-nowrap card-table" >
              <thead>
                <tr>
                  <th class="text-center w-1"><i class="icon-people"></i></th>
                  <th width="20%">Member Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Role</th>
                  <th>Status</th>
                  <th class="text-center"><i class="icon-settings"></i></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($users as $user): ?>
                  <tr data-userid="<?= html_escape($user->id); ?>">
                    <td class="text-center">
                      <div class="avatar d-block" style="background-image: url('<?php if (!empty($user->avatar)): ?> <?= base_url(); ?><?= html_escape($user->avatar); ?> <?php else: ?> <?= base_url(); ?>assets/img/user.png <?php endif; ?>')">
                        <span class="avatar-status bg-green"></span>
                      </div>
                    </td>
                    <td>
                      <div><a href="<?=base_url()?>member/<?=html_escape($user->id) ?>"><?= ucwords($user->firstname.' '.$user->lastname) ?></a></div>
                      <div class="small text-muted">
                        Registered: <?= formatted_date($user->created_at); ?>
                      </div>
                    </td>

                    <td>
                      <?= html_escape($user->email); ?>
                    </td>

                    <td class="text-right">
                      <?php if(trim($user->mobile) !== ''){ ?>
                        <?= $user->mobile ?>
                      <?php } ?>
                    </td>
                    <td>
                      <?php if ($user->role == "admin"): ?>
                        <label class="label bg-olive"><?= trans('admin'); ?></label>
                        <?php elseif ($user->role == "author"): ?>
                          <label class="label label-warning"><?= trans('author'); ?></label>
                          <?php else: ?>
                            <label class="label label-default"><?= trans('user'); ?></label>
                          <?php endif; ?>
                        </td>
                        <td>
                          <?php if ($user->status == 1): ?>
                            <label class="label label-success"><?= trans('active'); ?></label>
                            <?php else: ?>
                              <label class="label label-danger"><?= trans('banned'); ?></label>
                            <?php endif; ?>
                          </td>
                          <td class="text-center">
                            <?= form_open('admin_controller/user_options_post'); ?>
                            <input type="hidden" name="id" value="<?= html_escape($user->id); ?>">
                            <div class="item-action dropdown">
                              <a href="javascript:void(0)" data-toggle="dropdown" class="icon" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>
                              <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(15px, 20px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a href="<?=base_url()?>member/<?=html_escape($user->id) ?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> View </a>
                                <a href="mailto:<?= html_escape($user->email); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Send Email</a>
                                <div class="dropdown-divider"></div>
                                <?php  if ($user->status == "1"): ?>
                                  <a href="javascript:void(0)" class="dropdown-item"><button type="submit" name="option" value="ban" class="transparent"><i class="dropdown-icon fa fa-stop-circle option-icon"></i> <?= trans('ban_user'); ?></button></a>
                                  <?php else: ?>
                                    <a href="javascript:void(0)" class="dropdown-item"><button type="submit" name="option" value="remove_ban" class="transparent"><i class="dropdown-icon fa fa-stop-circle option-icon"></i> <?= trans('remove_ban'); ?></button></a>
                                  <?php endif;  ?>
                                  <a href="javascript:void(0)" class="dropdown-item" onclick="delete_item('admin_controller/delete_user_post','<?= $user->id; ?>','<?= trans("confirm_user"); ?>');"><i class="dropdown-icon fe fe-trash"></i> <?= trans('delete'); ?></a> 
                                  <a href="javascript:void(0)" class="dropdown-item"><button type="button" class="transparent" data-toggle="modal" data-target="#myModal" onclick="$('#modal_user_id').val('<?= html_escape($user->id); ?>');">
                                    <i class="fe fe-user dropdown-icon"></i> <?= trans('change_user_role'); ?>
                                  </button></a>
                                </div>
                              </div>
                              <?= form_close(); ?>
                            </td>
                          </tr>
                        <?php endforeach; ?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

          <!-- Modal -->
          <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?= trans('change_user_role'); ?></h4>
                </div>
                <?= form_open('admin_controller/change_user_role_post'); ?>
                <div class="modal-body">
                  <div class="form-group">

                    <div class="row">
                      <input type="hidden" name="user_id" id="modal_user_id" value="">

                      <div class="col-sm-4 col-xs-12 col-option">
                        <input type="radio" id="role_user" name="role" value="user" class="square-purple">
                        <label for="role_user" class="cursor-pointer"><?= trans('user'); ?></label>
                      </div>

                      <div class="col-sm-4 col-xs-12 col-option">
                        <input type="radio" id="role_author" name="role" value="author" class="square-purple">
                        <label for="role_author" class="cursor-pointer"><?= trans('author'); ?></label>
                      </div>

                      <div class="col-sm-4 col-xs-12 col-option">
                        <input type="radio" id="role_admin" name="role" value="admin" class="square-purple" checked>
                        <label for="role_admin" class="cursor-pointer"><?= trans('admin'); ?></label>
                      </div>


                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success"><?= trans('save'); ?></button>
                  <button type="button" class="btn btn-default" data-dismiss="modal"><?= trans('close'); ?></button>
                </div>

                <?= form_close(); ?><!-- form end -->
              </div>

            </div>
          </div>

        </div>
      </div>