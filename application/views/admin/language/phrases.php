<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-header">
        <div class="left">
            <h3 class="card-title"><?= $language->name; ?></h3>
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
                    <div class="tab-content">
                        <h4><?= $title; ?></h4>

                        <?php for ($i = 1; $i <= $tab_count; $i++): ?>

                            <div id="tab<?= $i; ?>" class="tab-pane  <?= ($page == $i) ? 'active' : ''; ?>">

                                <?= form_open('language_controller/update_phrases_post'); ?>
                                <input type="hidden" name="id" class="form-control" value="<?= $language->id; ?>">
                                <input type="hidden" id="lang_folder" class="form-control" value="<?= $language->folder_name; ?>">

                                <table class="table table-bordered table-striped dataTable">
                                    <thead>
                                    <tr role="row">
                                        <th>#</th>
                                        <th><?= trans('phrase'); ?></th>
                                        <th><?= trans('label'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php $count = 1; ?>
                                    <?php foreach ($phrases as $item): ?>

                                        <?php if ($count > ($i - 1) * 50 && $count <= $i * 50): ?>
                                            <tr class="tr-phrase">
                                                <td style="width: 50px;"><?= $count; ?></td>
                                                <td style="width: 40%;"><input type="text" name="phrase[]" class="form-control" value="<?= $item["phrase"]; ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?> readonly></td>
                                                <td style="width: 60%;"><input type="text" name="label[]" class="form-control" value="<?= $item["label"]; ?>" <?= ($rtl == true) ? 'dir="rtl"' : ''; ?>></td>
                                            </tr>
                                        <?php endif; ?>

                                        <?php $count++; ?>
                                    <?php endforeach; ?>

                                    </tbody>
                                </table>

                                <div class="col-sm-12 m-t-30">
                                    <div class="row">
                                        <div class="pull-right">
                                            <a href="<?= admin_url(); ?>language-settings" class="btn btn-danger m-r-5"><?= trans('back'); ?></a>
                                            <button type="submit" class="btn btn-primary"><?= trans('save_changes'); ?></button>
                                        </div>
                                    </div>
                                </div>

                                <?= form_close(); ?><!-- form end -->

                            </div>

                        <?php endfor; ?>

                    </div>


                    <div class="col-sm-12 m-t-30">
                        <div class="row">
                            <div class="text-center">
                                <ul class="pagination">
                                    <?php for ($i = 1; $i <= $tab_count; $i++): ?>
                                        <li class="<?= ($page == $i) ? 'active' : ''; ?>">
                                            <a href="<?= admin_url(); ?>update-phrases/<?= $language->id; ?>?page=<?= $i; ?>"><?= $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        </div>
                    </div>


                </div>


            </div>
        </div>
    </div><!-- /.box-body -->
</div>

<?php if ($language->text_direction == "rtl"): ?>
    <link href="<?= base_url(); ?>assets/admin/css/rtl.css" rel="stylesheet"/>
<?php endif; ?>
