	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<?php echo lang('create_user_heading');?>
				<small><?php echo lang('create_user_subheading');?></small>
			</h1>
			<ol class="breadcrumb">
				<li><i class="fa fa-users"></i> <a href="<?php echo base_url('auth') ?>"><?php echo lang('index_heading');?></a></li>
				<li class="active"><?php echo lang('create_user_heading'); ?></li>
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
					
					<?php echo form_open("auth/create_user", array('class' => 'form form-horizontal', 'autocomplete' => 'off'));?>

						<div class="form-group">
							<?php echo lang('create_user_fname_label', 'first_name', array('class' => 'control-label col-md-3'));?>
							<div class="col-md-7">
								<?php echo form_input($first_name);?>
							</div>
						</div>

						<div class="form-group">
							<?php echo lang('create_user_lname_label', 'last_name', array('class' => 'control-label col-md-3'));?>
							<div class="col-md-7">
								<?php echo form_input($last_name);?>
							</div>
						</div>
						
						<?php
						if($identity_column!=='email') {
								echo "<div class='form-group'>";
								echo lang('create_user_identity_label', 'identity', array('class' => 'control-label col-md-3'));
								echo "<div class='col-md-7'>";
								// echo form_error('identity');
								echo form_input($identity);
								echo '</div>';
								echo '</div>';
						}
						?>

						<div class="form-group">
							<?php echo lang('create_user_email_label', 'email', array('class' => 'control-label col-md-3'));?>
							<div class="col-md-7">
								<?php echo form_input($email);?>
							</div>
						</div>

						<div class="form-group">
							<?php echo lang('create_user_phone_label', 'phone', array('class' => 'control-label col-md-3'));?>
							<div class="col-md-7">
								<?php echo form_input($phone);?>
							</div>
						</div>

						<div class="form-group">
							<?php echo lang('create_user_password_label', 'password', array('class' => 'control-label col-md-3'));?>
							<div class="col-md-7">
								<?php echo form_input($password);?>
							</div>
						</div>

						<div class="form-group">
							<?php echo lang('create_user_password_confirm_label', 'password_confirm', array('class' => 'control-label col-md-3'));?>
							<div class="col-md-7">
								<?php echo form_input($password_confirm);?>
							</div>
						</div>

						<div class="form-group text-center"><?php echo form_submit('submit', lang('create_user_submit_btn'), array('class' => 'btn btn-primary', ));?></div>

					<?php echo form_close();?>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
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




