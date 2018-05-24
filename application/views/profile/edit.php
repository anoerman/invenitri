	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Profile
				<small>Edit Profile</small>
			</h1>
			<ol class="breadcrumb">
				<li><i class="fa fa-user"></i> &nbsp; Profile</li>
				<li class="active"><i class="fa fa-pencil"></i> &nbsp; Edit</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Default box -->
			<div class="box">
				<form action="<?php echo base_url('profile/edit') ?>" method="post" class="form form-horizontal" enctype="multipart/form-data" autocomplete="off">
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
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="form-group">
									<label for="username" class="control-label col-sm-3">Username</label>
									<div class="col-sm-9">
										<p class="form-control-static"><?php echo $myprofile->username ?></p>
										<input type="hidden" name="username" id="username" value="<?php echo $myprofile->username; ?>">
										<input type="hidden" name="id" id="id" value="<?php echo $myprofile->id; ?>">
									</div>
								</div>
								<hr>
								<div class="form-group">
									<label for="first_name" class="control-label col-sm-3">First Name</label>
									<div class="col-sm-9">
										<input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $myprofile->first_name ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="last_name" class="control-label col-sm-3">Last Name</label>
									<div class="col-sm-9">
										<input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $myprofile->last_name ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="control-label col-sm-3">E-mail</label>
									<div class="col-sm-9">
										<input type="email" name="email" id="email" class="form-control" value="<?php echo $myprofile->email ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="phone" class="control-label col-sm-3">Phone</label>
									<div class="col-sm-9">
										<input type="text" name="phone" id="phone" class="form-control" value="<?php echo $myprofile->phone ?>">
									</div>
								</div>
								<hr>
								<div class="form-group">
									<label for="password" class="control-label col-sm-3">New Password</label>
									<div class="col-sm-9">
										<input type="password" name="password" id="password" class="form-control">
										<p class="help-block">Isikan hanya jika ingin mengubah password. Biarkan kosong jika ingin tetap menggunakan password lama.</p>
									</div>
								</div>
								<div class="form-group">
									<label for="password_confirm" class="control-label col-sm-3">Confirm Password</label>
									<div class="col-sm-9">
										<input type="password" name="password_confirm" id="password_confirm" class="form-control">
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="form-group">
									<label for="photo" class="control-label col-sm-3">Photo</label>
									<div class="col-sm-9">
										<input type="file" name="user_photo" id="user_photo" class="form-control">
										<img src="<?php echo base_url('assets/uploads/images/profile/'.$user_photo->photo); ?>" alt="Current User Photo" class="img img-thumbnail form-control-static">
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer text-center">
						<button type="submit" class="btn btn-primary">Save Changes</button>
						<a class="btn btn-danger" href="<?php echo base_url('profile') ?>" role="button">Cancel</a>
						<!-- Footer -->
					</div>
					<!-- /.box-footer-->
				</form>
			</div>
			<!-- /.box -->

		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- =========================== / CONTENT =========================== -->

