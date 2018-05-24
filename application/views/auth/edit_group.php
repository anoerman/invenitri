	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<?php echo lang('edit_group_heading');?>
				<small><?php echo lang('edit_group_subheading');?></small>
			</h1>
			<ol class="breadcrumb">
				<li><i class="fa fa-users"></i> <a href="<?php echo base_url('auth') ?>"><?php echo lang('index_heading');?></a></li>
				<li class="active"><?php echo lang('edit_group_heading'); ?></li>
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
					
					<?php echo form_open(current_url(), array('class' => 'form form-horizontal'));?>

				      <div class="form-group">
			            <?php echo lang('edit_group_name_label', 'group_name', array('class' => 'control-label col-md-3'));?> 
			            <div class="col-md-7">
				            <?php echo form_input($group_name);?>
			            </div>
				      </div>

				      <div class="form-group">
			            <?php echo lang('edit_group_desc_label', 'description', array('class' => 'control-label col-md-3'));?> 
			            <div class="col-md-7">
				            <?php echo form_input($group_description);?>
			            </div>
				      </div>

				      <div class="form-group text-center"><?php echo form_submit('submit', lang('edit_group_submit_btn'), array('class' => 'btn btn-primary'));?></div>

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
