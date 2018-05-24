	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Profile
				<small>Your Profile</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-user"></i> &nbsp; Profile</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Default box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">
					</h3>

					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<?php echo $message;?>
					<?php $myprofile = $this->ion_auth->user()->row(); ?>
					<form action="<?php echo base_url('profile/edit') ?>" method="post" class="form form-horizontal" autocomplete="off">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-right">
								<div class="form-group">
									<!-- <label for="photo" class="control-label col-sm-3">Photo</label> -->
									<div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
										<img src="<?php echo base_url('assets/uploads/images/profile/'.$user_photo->photo); ?>" alt="User Photo" class="img img-thumbnail form-control-static">
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="form-group">
									<label for="username" class="control-label col-sm-3">Username</label>
									<div class="col-sm-9">
										<p class="form-control-static"><?php echo $myprofile->username ?></p>
									</div>
								</div>
								<hr>
								<div class="form-group">
									<label for="first_name" class="control-label col-sm-3">First Name</label>
									<div class="col-sm-9">
										<p class="form-control-static"><?php echo $myprofile->first_name ?></p>
									</div>
								</div>
								<div class="form-group">
									<label for="last_name" class="control-label col-sm-3">Last Name</label>
									<div class="col-sm-9">
										<p class="form-control-static"><?php echo $myprofile->last_name ?></p>
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="control-label col-sm-3">E-mail</label>
									<div class="col-sm-9">
										<p class="form-control-static"><?php echo $myprofile->email ?></p>
									</div>
								</div>
								<div class="form-group">
									<label for="phone" class="control-label col-sm-3">Phone</label>
									<div class="col-sm-9">
										<p class="form-control-static"><?php echo $myprofile->phone ?></p>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				<!-- /.box-body -->
				<div class="box-footer text-center">
					<a class="btn btn-primary" href="<?php echo base_url('profile/edit') ?>" role="button">Edit Profile</a>
					<!-- Footer -->
				</div>
				<!-- /.box-footer-->
			</div>
			<!-- /.box -->

		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- =========================== / CONTENT =========================== -->

