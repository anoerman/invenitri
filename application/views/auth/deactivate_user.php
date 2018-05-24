	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<?php echo lang('deactivate_heading');?>
				<!-- <small><?php echo sprintf(lang('deactivate_subheading'), $user->username); ?></small> -->
			</h1>
			<ol class="breadcrumb">
				<li><i class="fa fa-users"></i> <a href="<?php echo base_url('auth') ?>"><?php echo lang('index_heading');?></a></li>
				<li class="active"><?php echo lang('deactivate_heading'); ?></li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Default box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">
					<?php echo sprintf(lang('deactivate_subheading'), $user->username); ?> ?
					</h3>

					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					
					<?php echo form_open("auth/deactivate/".$user->id);?>

					<div class="radio">
						<label>
							<input type="radio" name="confirm" value="yes" checked="checked" />
							Yes
						</label>
					</div>

					<div class="radio">
						<label>
							<input type="radio" name="confirm" value="no" />
							No
						</label>
					</div>

					<?php echo form_hidden($csrf); ?>
					<?php echo form_hidden(array('id'=>$user->id)); ?>

					<div class="form-group">
						<?php echo form_submit('submit', lang('deactivate_submit_btn'), array('class' => 'btn btn-primary'));?>
					</div>

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
