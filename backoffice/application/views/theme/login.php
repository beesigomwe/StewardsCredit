
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
	<link rel="icon" href="<?= base_url() ?>favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>favicon.ico" />
	<link href="https://fonts.googleapis.com/css?family=Cinzel&display=swap" rel="stylesheet">

	<!-- Generated: 2018-04-16 09:29:05 +0200 -->
	<title>Stewards Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
	<link href="https://fonts.googleapis.com/css?family=Yeseva+One&display=swap" rel="stylesheet">
	<script src="<?= base_url() ?>assets/js/require.min.js"></script>
	<script>
		requirejs.config({
			baseUrl: '<?= base_url() ?>'
		});
	</script>
	<!-- Dashboard Core -->
	<link href="<?= base_url() ?>assets/css/dashboard.css" rel="stylesheet" />
	<script src="<?= base_url() ?>assets/js/dashboard.js"></script>
	<!-- c3.js Charts Plugin -->
	<link href="<?= base_url() ?>assets/plugins/charts-c3/plugin.css" rel="stylesheet" />
	<script src="<?= base_url() ?>assets/plugins/charts-c3/plugin.js"></script>
	<!-- Google Maps Plugin -->
	<link href="<?= base_url() ?>assets/plugins/maps-google/plugin.css" rel="stylesheet" />
	<script src="<?= base_url() ?>assets/plugins/maps-google/plugin.js"></script>
	<!-- Input Mask Plugin -->
	<script src="<?= base_url() ?>assets/plugins/input-mask/plugin.js"></script>
	<style type="text/css">
		form.card  {
			background: #fffffffb;
			box-shadow: 0 0 10px #00000045;
		}
	</style>
</head>
<body class="login-body">
	<div class="block-ui">
		<div class="spinner">
			<div class="rect1"></div>
			<div class="rect2"></div>
			<div class="rect3"></div>
			<div class="rect4"></div>
			<div class="rect5"></div>
		</div>
	</div>  

	<div class="page">
		<div class="page-single">
			<div class="container">
				<div class="row">
					<div class="col col-login mx-auto">
						<div class="text-center mb-6">
							<h1 class="logo login"><?= get_current_setting('company_name'); ?></h1>
							<!-- <img src="<?= base_url() ?>/uploads/<?php  echo get_current_setting('logo_path'); ?>" class="h-6" alt="" style="width: 260px; height: auto!important; "> -->
						</div>
						<form id="login-form" action="<?= site_url('User/varifyUser') ?>" class="card" method="post" accept-charset="utf-8">
							<div class="card-body p-6">
								<div class="card-title text-center">Login to your account</div>
								<div class="form-group">
									<label class="form-label">Email address</label>
									<input type="text" autocomplete="off" name="email" class="form-control"
									placeholder="Username or email"
									value=""
									required >
								</div>
								<div class="form-group">
									<label class="form-label">
										Password
									</label>
									<input type="password" autocomplete="off" name="password" class="form-control"
									placeholder="Password"
									value=""
									required >
								</div>
								<div class="form-group">
									<label class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" />
										<span class="custom-control-label">Remember me</span>
									</label>
								</div>
								<div class="form-footer">
									<button type="submit" class="btn btn-primary btn-block">Login</button>
								</div>
							</div>

						</form>      
						<div class="text-center">
							<div class="alert ajax-notify"></div>
						</div>  
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

	<script src="<?php echo base_url() ?>/theme/js/jquery.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="<?php echo base_url() ?>/theme/js/bootstrap.js"></script>
	<!--<script src="js/jquery-ui.js"></script>-->

	<script type="text/JavaScript">
		$(document).ready(function(){
			$('#login-form').on('submit',function(){
				var link=$(this).attr("action");
				$.ajax({
					method : "POST",
					url : link,
					data : $(this).serialize(),
					beforeSend : function(){
						$(".my-btn").html('');
						//$(".my-btn").addClass('loading');
						$(".block-ui").css("display","block");
					},success : function(data){ 
						if(data=='true'){
							window.location.href ="<?php echo site_url('Admin/dashboard') ?>";
							$(".block-ui").css("display","none"); 
							if (!$(".ajax-notify").length){
								$(".system-alert-box").append("<div class='alert alert-success ajax-notify'></div>");
							}   
							$('.ajax-notify').css("display","block"); 
							$('.ajax-notify').addClass("alert-success"); 
							$('.ajax-notify').removeClass("alert-danger");     
							$('.ajax-notify').html('Login Sucessfully');  
							// $(".my-btn").removeClass('loading');
							$(".my-btn").html('Login');
							$(".block-ui").css("display","none");  

						}else{
							if (!$(".ajax-notify").length){
								$(".system-alert-box").append("<div class='alert alert-success ajax-notify'></div>");
							}   
							$('.ajax-notify').css("display","block"); 
							$('.ajax-notify').removeClass("alert-success"); 
							$('.ajax-notify').addClass("alert-danger");     
							$('.ajax-notify').html('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <i class="fa fa-times-circle"></i> Username or Password Is Incorrect !');  
							$(".my-btn").removeClass('loading');
							$(".my-btn").html('Login');
							$(".block-ui").css("display","none");  
						}
					}
				});
				return false;
			});

		});

	</script>
</body>
</html>
<?php /* 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="user-scalable=no" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <!--<link rel="icon" type="image/png" href="">-->
  <title>Login</title>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Bootstrap -->
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <link href="<?php echo base_url() ?>/theme/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>/theme/css/login.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>/theme/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/jquery-ui.css" rel="stylesheet">-->


  </head>
  <body class="login-body">
    <div class="block-ui">
      <div class="spinner">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
      </div>
    </div>  

    <div id="wrapper">
      <div class="login-div">
        <div class="system-name col-md-4 col-lg-4 col-sm-6 col-md-offset-4 col-lg-offset-4 col-sm-offset-3">
          <div class="login-logo"><img src="<?php echo base_url() ?>/uploads/<?php  echo get_current_setting('logo_path'); ?>" alt=""/></div>
          <h3><?php  echo get_current_setting('company_name'); ?></h3>
        </div>

        <!--Alert-->
        <div class="system-alert-box col-md-4 col-lg-4 col-sm-6 col-md-offset-4 col-lg-offset-4 col-sm-offset-3">
          <div class="alert alert-success ajax-notify"></div>
        </div>
        <!--End Alert-->

        <div class="col-md-4 col-lg-4 col-sm-6 login-panel col-md-offset-4 col-lg-offset-4 col-sm-offset-3">
          <h3>Stewards</h3>
          <form class="login-form" method="post" action="<?php echo site_url('User/varifyUser') ?>">
            <input type="text" class="my-control email-icon" name="email" placeholder="Email"/>
            <input type="password" class="my-control pass-icon" name="password" placeholder="Password"/>
            <button type="submit" class="my-btn">Login</button>
          </form>

        </div>
      </div>
    </div><!-- End Wrapper -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

    <script src="<?php echo base_url() ?>/theme/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url() ?>/theme/js/bootstrap.js"></script>
    <!--<script src="js/jquery-ui.js"></script>-->

    <script type="text/JavaScript">
     $(document).ready(function(){
       $('.login-form').on('submit',function(){
        var link=$(this).attr("action");
        $.ajax({
          method : "POST",
          url : link,
          data : $(this).serialize(),
          beforeSend : function(){
            $(".my-btn").html('');
    //$(".my-btn").addClass('loading');
    $(".block-ui").css("display","block");
  },success : function(data){ 
    if(data=='true'){
      window.location.href ="<?php echo site_url('Admin/dashboard') ?>";
      $(".block-ui").css("display","none"); 
      if (!$(".ajax-notify").length){
        $(".system-alert-box").append("<div class='alert alert-success ajax-notify'></div>");
      }   
      $('.ajax-notify').css("display","block"); 
      $('.ajax-notify').addClass("alert-success"); 
      $('.ajax-notify').removeClass("alert-danger");     
      $('.ajax-notify').html('Login Sucessfully');  
    //$(".my-btn").removeClass('loading');
    $(".my-btn").html('Login');
    $(".block-ui").css("display","none");  

  }else{
    if (!$(".ajax-notify").length){
      $(".system-alert-box").append("<div class='alert alert-success ajax-notify'></div>");
    }   
    $('.ajax-notify').css("display","block"); 
    $('.ajax-notify').removeClass("alert-success"); 
    $('.ajax-notify').addClass("alert-danger");     
    $('.ajax-notify').html('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <i class="fa fa-times-circle"></i> Username or Password Is Incorrect !');  
    $(".my-btn").removeClass('loading');
    $(".my-btn").html('Login');
    $(".block-ui").css("display","none");  
  }
}
});
        return false;
      });

     });

   </script>

 </body>
 </html> */ ?>