<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section: main -->
<section id="main">
    <div class="container">
        <div class="row">
            <!-- breadcrumb -->
            <!-- <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= lang_base_url(); ?>"><?= html_escape(trans("home")); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?= html_escape(trans("search")); ?></li>
                    </li>
                </ol>
            </div> -->

            <div class="page-content">
                <div class="col-xs-12 col-sm-12 col-md-8">

                    <div class="content">
                        <h1 class="page-title"> <?= html_escape(trans("search")); ?>: <?= html_escape($q); ?></h1>

                        <div class="row">

                            <?php foreach ($users as $user): ?>
                                <div class="col-12">
                                    <div class="card">
                                      <div class="card-body">
                                          <a href="<?=base_url()?>member/<?=html_escape($user->id) ?>">
                                            <div class="media">
                                              <span class="fred avatar avatar-xxl mr-5" style="background-image: url('<?php if (!empty($user->avatar)): ?> <?= base_url(); ?><?= html_escape($user->avatar); ?> <?php else: ?> <?= base_url(); ?>assets/img/user.png <?php endif; ?>')"></span>
                                              <div class="media-body">
                                                <h4 class="m-0"><?= ucwords($user->firstname.' '.$user->lastname) ?></h4>
                                                <p class="text-muted mb-0">Registered: <?= formatted_date($user->created_at); ?></p>
                                                <p>
                                                    <?php if ($user->role == "admin"): ?> <label class="label bg-olive"><?= trans('admin'); ?></label> <?php elseif ($user->role == "author"): ?> <label class="label label-warning"><?= trans('author'); ?></label> <?php else: ?> <label class="label label-default"><?= trans('user'); ?></label> <?php endif; ?><br> <?php if(trim($user->email) !== ''){ ?> Email: <?= $user->email ?><br> <?php } if(trim($user->mobile) !== ''){ ?> Mobile: <?= $user->mobile ?> <?php } ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>



                    <?php $count = 0; ?>



                    <?php foreach ($posts as $item): ?>

                        <?php if ($count != 0 && $count % 2 == 0): ?>
                            <div class="col-sm-12 col-xs-12"></div>
                        <?php endif; ?>

                        <!-- post item -->
                        <?php $this->load->view('post/_post_item', ['item' => $item]); ?>
                        <!-- /.post item -->


                        <?php if ($count == 1): ?>

                            <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "search_top"]); ?>

                        <?php endif; ?>

                        <?php $count++; ?>

                    <?php endforeach; ?>

            <?php /* if ($post_count < 1): ?>
                <p class="text-center"><?= html_escape(trans("search_noresult")); ?></p>
            <?php endif; */ ?>


        </div><!-- /.posts -->

        <!-- Pagination -->
        <div class="col-xs-12 col-sm-12">
            <div class="row">
                <?= $this->pagination->create_links(); ?>
            </div>
        </div>

    </div>

</div>

<div class="col-xs-12 col-sm-12 col-md-4">
    <!--Sidebar-->
    <?php $this->load->view('partials/_sidebar'); ?>
</div><!--/col-->

</div>
</div>
</div>
</section>
<!-- /.Section: main -->

