<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?= htmlspecialchars($title); ?> - <?= trans("admin"); ?>&nbsp;<?= htmlspecialchars($settings->site_title); ?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?php if (empty($general_settings->favicon_path)): ?>
		<link rel="shortcut icon" type="image/png" href="<?= base_url(); ?>assets/img/favicon.png"/>
		<?php else: ?>
			<link rel="shortcut icon" type="image/png" href="<?= base_url() . html_escape($general_settings->favicon_path); ?>"/>
		<?php endif; ?>
		<!-- Google Font -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?= base_url(); ?>assets/admin/plugins/font-awesome/css/font-awesome.min.css">
		<!-- Theme style -->
<!-- 		<link rel="stylesheet" href="<?= base_url(); ?>assets/admin/css/AdminLTE.min.css">
 -->		<!-- AdminLTE Skins -->
<!-- 		<link rel="stylesheet" href="<?= base_url(); ?>assets/admin/css/_all-skins.min.css">
 -->
		<!-- Dashboard Core -->
      <link href="<?=base_url()?>assets/css/dashboard.css" rel="stylesheet" />
      <script src="<?=base_url()?>assets/js/dashboard.js"></script>
		<!-- Datatables -->
		<link rel="stylesheet" href="<?= base_url(); ?>assets/admin/plugins/datatables/dataTables.bootstrap.min.css">
		<link rel="stylesheet" href="<?= base_url(); ?>assets/admin/plugins/datatables/jquery.dataTables_themeroller.min.css">
		<!-- iCheck -->
		<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/icheck/square/purple.css">
		<!-- Page -->
		<link rel="stylesheet" href="<?= base_url(); ?>assets/admin/plugins/pace/pace.min.css">
		<!-- Tags Input -->
		<link rel="stylesheet" href="<?= base_url(); ?>assets/admin/plugins/tagsinput/jquery.tagsinput.min.css">
		<!-- File Manager css -->
		<link rel="stylesheet" href="<?= base_url(); ?>assets/admin/plugins/file-manager/file-manager-1.2.css">
		<!-- Custom css -->
		<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
		<!-- Datetimepicker css -->
		<link rel="stylesheet" href="<?= base_url(); ?>assets/admin/css/custom.css">
		<?php if ($site_lang->text_direction == "rtl"): ?>
			<!-- RTL -->
			<link href="<?= base_url(); ?>assets/admin/css/rtl.min.css" rel="stylesheet"/>
		<?php endif; ?>
		<!-- jQuery 2.1.4 -->
		<script src="<?= base_url(); ?>assets/admin/js/jquery.min.js"></script>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<script>
	var csfr_token_name = '<?= $this->security->get_csrf_token_name(); ?>';
	var csfr_cookie_name = '<?= $this->config->item('csrf_cookie_name'); ?>';
	var base_url = '<?= base_url(); ?>';
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<body class="">
		<div class="page">
			<div class="page-main">
				<div class="header py-4">
					<div class="container">
						<div class="d-flex">
							<a class="header-brand" href="<?=base_url()?>">
								<img src="<?=base_url()?>assets/img/logo.png" class="header-brand-img" alt="logo">
							</a>
							<div class="d-flex order-lg-2 ml-auto">
								<div class="dropdown d-none d-md-flex">
									<a class="nav-link icon" data-toggle="dropdown">
										<i class="fe fe-bell"></i>
										<span class="nav-unread"></span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a href="#" class="dropdown-item d-flex">
											<span class="avatar mr-3 align-self-center" style="background-image: url(demo/faces/male/41.jpg)"></span>
											<div>
												<strong>Nathan</strong> pushed new commit: Fix page load performance issue.
												<div class="small text-muted">10 minutes ago</div>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex">
											<span class="avatar mr-3 align-self-center" style="background-image: url(demo/faces/female/1.jpg)"></span>
											<div>
												<strong>Alice</strong> started new task: Tabler UI design.
												<div class="small text-muted">1 hour ago</div>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex">
											<span class="avatar mr-3 align-self-center" style="background-image: url(demo/faces/female/18.jpg)"></span>
											<div>
												<strong>Rose</strong> deployed new version of NodeJS REST Api V3
												<div class="small text-muted">2 hours ago</div>
											</div>
										</a>
										<div class="dropdown-divider"></div>
										<a href="#" class="dropdown-item text-center text-muted-dark">Mark all as read</a>
									</div>
								</div>
								<div class="dropdown">
									<a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
										<span class="avatar" style="background-image: url('<?= get_user_avatar(user()); ?>')"></span>
										<span class="ml-2 d-none d-lg-block">
											<span class="text-default"><?= ucwords(user()->username) ?></span>
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
								<form class="input-icon my-3 my-lg-0">
									<input type="search" class="form-control header-search" placeholder="Search&hellip;" tabindex="1">
									<div class="input-icon-addon">
										<i class="fe fe-search"></i>
									</div>
								</form>
							</div>
							<div class="col-lg order-lg-first">
								<ul class="nav nav-tabs border-0 flex-column flex-lg-row">
									<li class="nav-item">
										<a href="<?= admin_url(); ?>" class="nav-link active"><i class="fe fe-home"></i> <?= trans("home"); ?></a>
									</li>
									<?php if (is_admin()){ ?>
										<li class="nav-item dropdown">
											<a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-users"></i> Contacts</a>
											<div class="dropdown-menu dropdown-menu-arrow">
												<a href="<?= admin_url(); ?>users" class="dropdown-item "><?= trans("users"); ?></a>
												<a href="<?= admin_url(); ?>new-contact" class="dropdown-item "><?= trans("add_user"); ?></a>
											</div>
										</li>
										<li class="nav-item dropdown">
											<a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-file"></i> Transactions</a>
											<div class="dropdown-menu dropdown-menu-arrow">
												<a href="<?= admin_url(); ?>create-account" class="dropdown-item "><?= trans("add_post"); ?></a>
												<a href="<?= admin_url(); ?>posts" class="dropdown-item "><?= trans("posts"); ?></a>
												<a href="<?= admin_url(); ?>our-picks" class="dropdown-item "><?= trans("our_picks"); ?></a>
												<a href="<?= admin_url(); ?>pending-posts" class="dropdown-item "><?= trans("pending_posts"); ?></a>
												<a href="<?= admin_url(); ?>drafts" class="dropdown-item "><?= trans("drafts"); ?></a>
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
