	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Status
				<small>Know your data status</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-heart"></i> &nbsp; Status</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Update Data box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Edit Status
					</h3>

					<div class="box-tools pull-right">
						<!-- <button class="btn btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
					</div>
				</div>
				<div class="box-body">
					<?php echo $message;?>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<form action="<?php echo base_url('status/edit/').$id ?>" method="post" autocomplete="off" class="form form-horizontal">
							<?php foreach ($data_list->result() as $data){
								$curr_name        = $data->name;
								$curr_description = $data->description;
							} ?>
							<div class="form-group">
								<label for="name" class="control-label col-md-2">* Name</label>
								<div class="col-md-8 <?php if (form_error('name')) {echo "has-error";} ?>">
									<input type="text" name="name" id="name" class="form-control" value="<?php echo $curr_name ?>" placeholder="Status name" required>
								</div>
							</div>
							<div class="form-group">
								<label for="description" class="control-label col-md-2">Description</label>
								<div class="col-md-8">
									<textarea name="description" id="description" class="form-control text_editor" rows="4" style="resize:vertical; min-height:100px; max-height:200px;"><?php echo $curr_description ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
									<button type="submit" class="btn btn-primary" onclick="return confirm('Save your data?')">Submit</button>
									<a class="btn btn-danger" href="<?php echo base_url('status'); ?>" role="button">Cancel</a>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
								  <p class="help-block">(*) Mandatory</p>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->

		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- =========================== / CONTENT =========================== -->
