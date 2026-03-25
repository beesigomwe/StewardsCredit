<!doctype html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta http-equiv="Content-Language" content="en" />
  <meta name="msapplication-TileColor" content="#314367">
  <meta name="theme-color" content="#314367">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <link rel="icon" href="<?=base_url()?>favicon.ico" type="image/x-icon"/>
  <link href="https://fonts.googleapis.com/css?family=Cinzel&display=swap" rel="stylesheet">
  <?php if (empty($general_settings->favicon_path)): ?>
    <link rel="shortcut icon" type="image/png" href="<?= base_url(); ?>assets/img/favicon.png"/>
    <?php else: ?>
      <link rel="shortcut icon" type="image/png" href="<?= base_url() . html_escape($general_settings->favicon_path); ?>"/>
    <?php endif; ?>
    <title><?= htmlspecialchars($title); ?> - <?= trans("admin"); ?>&nbsp;<?= htmlspecialchars($settings->site_title); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <script src="<?=base_url()?>assets/js/vendors/jquery-3.2.1.min.js"></script>
    <script src="<?=base_url()?>assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url()?>assets/admin/js/plugins.js"></script>
    <script src="<?=base_url()?>assets/js/sweetalert2.min.js"></script>
    <script src="<?=base_url()?>assets/js/require.min.js"></script>
    <script>
      requirejs.config({
        baseUrl: '<?=base_url()?>'
      });
      var csfr_token_name = '<?= $this->security->get_csrf_token_name(); ?>';
      var csfr_cookie_name = '<?= $this->config->item('csrf_cookie_name'); ?>';
      var base_url = '<?= base_url(); ?>';
    </script>

    <style>
      .hide {display: none!important;}
      .card {overflow-x: auto;}
    </style>

    <!-- Dashboard Core -->
    <link href="<?=base_url()?>assets/css/dashboard.css?<?=date('Ymd')?>" rel="stylesheet" />
    <script src="<?=base_url()?>assets/js/dashboard.js?<?=date('Ymd')?>"></script>
    <!-- Sweets -->
    <link href="<?=base_url()?>assets/css/sweetalert2.min.css?>assets/css/dashboard.css?<?=date('Ymd')?>" rel="stylesheet" />
    <!-- c3.js Charts Plugin -->
    <link href="<?=base_url()?>assets/plugins/charts-c3/plugin.css" rel="stylesheet" />
    <script src="<?=base_url()?>assets/plugins/charts-c3/plugin.js"></script>
    <!-- Google Maps Plugin -->
    <link href="<?=base_url()?>assets/plugins/maps-google/plugin.css" rel="stylesheet" />
    <script src="<?=base_url()?>assets/plugins/maps-google/plugin.js"></script>
    <!-- Input Mask Plugin -->
    <script src="<?=base_url()?>assets/plugins/input-mask/plugin.js"></script>

  </head>
  <body class="">
    <div class="page">
      <div class="page-main">
        <div class="header py-2">
          <div class="container">
            <div class="d-flex">
              <a class="header-brand" href="<?=base_url()?>">
                <h1 class="logo" style="margin: 0;">Stewards</h1>
              </a>
              <div class="d-flex order-lg-2 ml-auto">

                <?php // include '_inbox.php'; ?>

                <div class="dropdown">
                  <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                    <span class="avatar" style="background-image: url('<?= get_user_avatar(user()); ?>')"></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default"><?= ucwords(user()->firstname.' '.user()->lastname) ?></span>
                      <small class="text-muted d-block mt-1"><?= ucwords(user()->role) ?></small>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="<?= base_url(); ?>profile/<?= user()->slug; ?>">
                      <i class="dropdown-icon fe fe-user"></i> <?= trans("profile"); ?>
                    </a>
                    <a class="dropdown-item" href="<?= base_url(); ?>settings">
                      <i class="dropdown-icon fe fe-settings"></i> <?= trans("update_profile"); ?>
                    </a>
                    <a class="dropdown-item" href="<?= base_url(); ?>settings/change-password">
                      <i class="dropdown-icon fe fe-lock"></i> <?= trans("change_password"); ?>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="mailto:care@dilleva.com">
                      <i class="dropdown-icon fe fe-help-circle"></i> Need help?
                    </a>
                    <a class="dropdown-item" href="<?= base_url(); ?>logout">
                      <i class="dropdown-icon fe fe-log-out"></i> <?= trans("logout"); ?>
                    </a>
                  </div>
                </div>
              </div>
              <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>
            </div>
          </div>
        </div>
        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg-3 ml-auto">
                <form class="input-icon my-3 my-lg-0" action="<?=base_url()?>search" method="get" accept-charset="utf-8">
                  <input type="search" autocomplete="off" name="q" maxlength="300" pattern=".*\S+.*" required="" class="form-control header-search search" placeholder="Search&hellip;" tabindex="1">
                  <div class="input-icon-addon">
                    <i class="fe fe-search"></i>
                  </div>
                </form>
              </div>
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                  <li class="nav-item">
                    <a href="<?= admin_url(); ?>" class="nav-link"><i class="fe fe-home"></i> <?= trans("home"); ?></a>
                  </li>
                  <?php if (is_admin()){ ?>
                    <li class="nav-item dropdown">
                      <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-users"></i> <?= trans("users"); ?></a>
                      <div class="dropdown-menu dropdown-menu-arrow">
                        <a href="<?= admin_url(); ?>users" class="dropdown-item "><?= trans("users"); ?></a>
                        <a href="<?= admin_url(); ?>new-contact" class="dropdown-item "><?= trans("add_user"); ?></a>
                      </div>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-file"></i> <?= trans("posts"); ?></a>
                      <div class="dropdown-menu dropdown-menu-arrow">
                        <a href="<?= admin_url(); ?>create-account" class="dropdown-item "><?= trans("add_post"); ?></a>
                        <a href="<?= admin_url(); ?>accounts" class="dropdown-item "><?= trans("posts"); ?></a>
                        <?php $count_leads = $this->post_model->get_draft_count(); if($count_leads > 0){ ?>
                          <a href="<?= admin_url(); ?>drafts" class="dropdown-item "><?= trans("drafts"); ?></a>
                        <?php } ?>
                      </div>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-file"></i> <?= trans("comments"); ?></a>
                      <?php $pending_trans = $this->comment_model->get_pending_count();
                      if(isset($pending_trans) && $pending_trans > 0 && $pending_trans < 10){ ?>
                        <span class="nav-unread" style="position: absolute;top: 0;right: 0;background: #89959e;width: 20px;height: 18px;border-radius: 0 0 0 11px;font-size: 12px;text-align: center;box-shadow: 0px 2px 8px #00000052;"><?=$pending_trans?></span>
                      <?php } ?>
                      <div class="dropdown-menu dropdown-menu-arrow">
                        <a href="<?= admin_url(); ?>transactions" class="dropdown-item ">Approved <?= trans("comments"); ?></a>
                        <?php if($pending_trans > 0){?>
                          <a href="<?= admin_url(); ?>pending-transactions" class="dropdown-item ">Pending <?= trans("comments"); ?>&nbsp;&nbsp;<span class="tag tag-blue"><?=$pending_trans?></span></a>
                        <?php } ?>
                      </div>
                    </li>

                  <?php } ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="my-3 my-md-5">
          <div class="container">
