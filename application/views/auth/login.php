<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $this->config->item('site_name'); ?> | Log in</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="<?php echo base_url('assets/templates/adminlte-2-3-11/bootstrap/css/bootstrap.min.css'); ?>">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url('assets/templates/adminlte-2-3-11/dist/css/AdminLTE.min.css'); ?>">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/iCheck/square/blue.css'); ?>">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
	<div class="login-logo">
		<a href="<?php echo base_url(); ?>"><b><?php echo $this->config->item('site_name'); ?></b></a>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">Log in to start your session</p>
		<?php echo $message; ?>

		<?php echo form_open("auth/login".$redirect_to, array('autocomplete' => 'off'));?>
			<div class="form-group has-feedback">
					<input type="text" name="identity" id="identity" class="form-control"  value="<?php echo set_value('identity'); ?>" placeholder="Username" autofocus required/>
					<span class=" glyphicon glyphicon-user form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
					<input type="password" name="password" id="password" class="form-control" placeholder="Password" required/>
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="form-group">
				<label for="remember">
					<input type="checkbox" name="remember" id="remember" value="1"> &nbsp;
					Remember me
				</label>
			</div>
			<div class="row">
					<div class="col-xs-12">
							<button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
							<a href="<?php echo base_url(); ?>" class="btn btn-default btn-block btn-flat">Halaman Utama</a>
					</div><!-- /.col -->
			</div>
		<?php echo form_close();?>

		<div class="form-group text-center">
			<a href="<?php echo base_url('auth/forgot_password') ?>">I forgot my password</a><br>
		</div>

	</div>
	<!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('assets/templates/adminlte-2-3-11/bootstrap/js/bootstrap.min.js'); ?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/iCheck/icheck.min.js'); ?>"></script>
<script>
	$(function () {
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%' // optional
		});
	});
</script>
</body>
</html>
