	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Locations
				<small>Place for your inventory</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-map-pin"></i> &nbsp; Locations</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Update Location Data box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Edit Location
					</h3>

					<div class="box-tools pull-right">
						<!-- <button class="btn btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
					</div>
				</div>
				<div class="box-body">

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php echo $message;?>
						<form action="<?php echo base_url('locations/edit/').$id ?>" method="post" autocomplete="off" class="form form-horizontal" enctype="multipart/form-data">
							<?php foreach ($data_list->result() as $data){
								$curr_code      = $data->code;
								$curr_name      = $data->name;
								$curr_detail    = $data->detail;
								$curr_photo     = $data->photo;
								$curr_thumbnail = $data->thumbnail;
							} ?>
							<div class="form-group">
								<label for="code" class="control-label col-md-2">Code</label>
								<div class="col-md-8">
									<p class="form-control-static"><?php echo $curr_code ?></p>
									<input type="hidden" name="code" value="<?php echo $curr_code ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="name" class="control-label col-md-2">* Name</label>
								<div class="col-md-8 <?php if (form_error('name')) {echo "has-error";} ?>">
									<input type="text" name="name" id="name" class="form-control" value="<?php echo $curr_name ?>" placeholder="Location Name" required>
								</div>
							</div>
							<div class="form-group">
								<label for="detail" class="control-label col-md-2">Detail</label>
								<div class="col-md-8">
									<textarea name="detail" id="detail" class="form-control text_editor" rows="4" style="resize:vertical; min-height:100px; max-height:200px;"><?php echo $curr_detail ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="photo" class="control-label col-md-2">Photo</label>
								<div class="col-md-8">
									<?php if ($curr_thumbnail!=""): ?>
									<img src="<?php echo base_url('assets/uploads/images/locations/').$curr_thumbnail ?>" alt="Current Location Photo">
									<?php endif ?>
									<input type="hidden" name="curr_photo" value="<?php echo $curr_photo ?>">
									<input type="hidden" name="curr_thumbnail" value="<?php echo $curr_thumbnail ?>">
									<input type="file" name="photo" id="photo" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
									<button type="submit" class="btn btn-primary" onclick="return confirm('Save your data?')">Submit</button>
									<a class="btn btn-danger" href="<?php echo base_url('locations'); ?>" role="button">Cancel</a>
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
