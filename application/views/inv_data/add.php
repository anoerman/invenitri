<!-- =========================== CONTENT =========================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Inventory
      <small>All your items data</small>
    </h1>
    <ol class="breadcrumb">
      <li class="active"><i class="fa fa-archive"></i> &nbsp; Inventory</li>
      <li class="active">Add New</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

		<!-- Insert New Data box -->
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Add New Data
				</h3>

				<div class="box-tools pull-right">
					<!-- <button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
				</div>
			</div>
			<div class="box-body" id="add_new">
        <?php echo $message;?>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<form id="input_form" action="<?php echo base_url('inventory/add') ?>" method="post" autocomplete="off" class="form form-horizontal" enctype="multipart/form-data">
							<h3>Basic Info</h3>
							<fieldset>
								<div class="form-group">
									<label for="code" class="control-label col-md-2">* Code</label>
									<div class="col-md-4">
										<input type="text" name="code" id="code" class="form-control required <?php if (form_error('code')) { echo "error"; } ?>" value="<?php echo set_value('code') ?>" required>
									</div>
								</div>
								<div class="form-group">
									<label for="brand" class="control-label col-md-2">* Brand</label>
									<div class="col-md-8">
										<input type="text" name="brand" id="brand" class="form-control required <?php if (form_error('brand')) { echo "error"; } ?>" value="<?php echo set_value('brand') ?>" required>
									</div>
								</div>
								<div class="form-group">
									<label for="model" class="control-label col-md-2">Model</label>
									<div class="col-md-8">
										<input type="text" name="model" id="model" class="form-control <?php if (form_error('model')) { echo "error"; } ?>" value="<?php echo set_value('model') ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="serial_number" class="control-label col-md-2">Serial Number</label>
									<div class="col-md-8">
										<input type="text" name="serial_number" id="serial_number" class="form-control <?php if (form_error('serial_number')) { echo "error"; } ?>" value="<?php echo set_value('serial_number') ?>">
									</div>
								</div>
								<hr>
								<div class="form-group">
									<label for="category" class="control-label col-md-2">* Category</label>
									<div class="col-md-8">
										<div class="row">
											<?php if (count($cat_list->result())>3): ?>
												<?php
												$batas = ceil(count($cat_list->result())/2);
												$xs    = 0;
												foreach ($cat_list->result() as $cls2):
													// Flagging untuk menentukan jumlah data kategori
													$xs++;
													// Jika 1, col 1.
													if ($xs==1) {
														echo "<div class='col-md-6'>";
													}
													// Jika sudah batas, col 2
													elseif($xs==$batas+1) {
														echo "</div>";
														echo "<div class='col-md-6'>";
													}
													?>
													<div class="radio">
														<label for="category2_<?php echo $cls2->id; ?>">
															<input type="radio" name="category2" id="category2_<?php echo $cls2->id; ?>" value="<?php echo $cls2->id; ?>" <?php echo set_radio('category2', $cls2->id); ?>>
															<?php echo $cls2->name ?>
														</label>
													</div>
												<?php endforeach; echo "</div>"; ?>
											<?php else: ?>
												<div class="col-md-12">
												<?php $xs = 0;
												foreach ($cat_list->result() as $cls2):
													$xs++; ?>
													<div class="radio">
														<label for="category2_<?php echo $cls2->id; ?>">
															<input type="radio" name="category2" id="category2_<?php echo $cls2->id; ?>" value="<?php echo $cls2->id; ?>"  <?php echo set_radio('category2', $cls2->id); ?>>
															<?php echo $cls2->name ?>
														</label>
													</div>
												<?php endforeach; ?>
												</div>
											<?php endif; ?>
										</div>
									</div>
									<?php /* ?>
									<!-- <div class="col-md-4">
										<select name="category" id="category" class="form-control select2 required" style="width:100%">
											<?php foreach ($cat_list->result() as $cls) {
												echo "<option value='".$cls->id."'>".$cls->name."</option>";
												} ?>
										</select>
									</div> --> <?php */ ?>
								</div>
								<div class="form-group">
									<label for="status" class="control-label col-md-2">* Status</label>
									<div class="col-md-8">
										<div class="row">
											<?php if (count($stat_list->result())>3): ?>
												<?php
												$batas = ceil(count($stat_list->result())/2);
												$xs    = 0;
												foreach ($stat_list->result() as $sls2):
													// Flagging untuk menentukan jumlah data status
													$xs++;
													// Jika 1, col 1.
													if ($xs==1) {
														echo "<div class='col-md-6'>";
													}
													// Jika sudah batas, col 2
													elseif($xs==$batas+1) {
														echo "</div>";
														echo "<div class='col-md-6'>";
													}
													?>
													<div class="radio">
														<label for="status2_<?php echo $sls2->id; ?>">
															<input type="radio" name="status2" id="status2_<?php echo $sls2->id; ?>" value="<?php echo $sls2->id; ?>" <?php echo set_radio('status2', $sls2->id); ?>>
															<?php echo $sls2->name ?>
														</label>
													</div>
												<?php endforeach; echo "</div>"; ?>
											<?php else: ?>
												<div class="col-md-12">
												<?php $xs = 0;
												foreach ($stat_list->result() as $sls2):
													$xs++; ?>
													<div class="radio">
														<label for="status2_<?php echo $sls2->id; ?>">
															<input type="radio" name="status2" id="status2_<?php echo $sls2->id; ?>" value="<?php echo $sls2->id; ?>" <?php echo set_radio('status2', $sls2->id); ?>>
															<?php echo $sls2->name ?>
														</label>
													</div>
												<?php endforeach; ?>
												</div>
											<?php endif; ?>
										</div>
									</div>
									<?php /* ?>
									<div class="col-md-4">
										<select name="status" id="status" class="form-control select2 required" style="width:100%">
											<?php foreach ($stat_list->result() as $sls) {
												echo "<option value='".$sls->id."'>".$sls->name."</option>";
												} ?>
										</select>
									</div><?php */ ?>
								</div>
								<div class="form-group">
									<label for="location" class="control-label col-md-2">* Location</label>
									<div class="col-md-4">
										<select name="location" id="location" class="form-control select2 required" style="width:100%">
											<?php foreach ($loc_list->result() as $lls) {
												echo "<option value='".$lls->id."' ".set_select('location', $lls->id).">".$lls->name."</option>";
												} ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<p class="col-md-8 col-md-offset-2">(*) Mandatory</p>
								</div>
							</fieldset>

							<h3>Specifications</h3>
							<fieldset>
								<div class="form-group">
									<label for="color" class="control-label col-md-2">Color</label>
									<div class="col-md-4">
										<div id="color_container">
											<select name="color" id="color" class="form-control select2 required" style="width:100%">
												<?php foreach ($col_list->result() as $crl) {
													echo "<option value='".$crl->name."' ".set_select('color', $crl->name).">".$crl->name."</option>";
												} ?>
											</select>
										</div>
										<input type="text" name="new_color" id="new_color" class="form-control" maxlength="30" placeholder="New Color" style="display:none">
									</div>
									<div class="col-md-6">
										<label for="color_switch">
											<input type="checkbox" name="color_switch" id="color_switch" value="color_switch">
											New Color
										</label>
									</div>
								</div>
								<hr>
								<div class="form-group">
									<label for="length" class="control-label col-md-2">Length</label>
									<div class="col-md-4">
										<div class="input-group">
											<input type="number" name="length" id="length" class="form-control" maxlength="12" min="0" value="<?php echo set_value('length') ?>">
											<span class="input-group-addon">Cm</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="width" class="control-label col-md-2">Width</label>
									<div class="col-md-4">
										<div class="input-group">
											<input type="number" name="width" id="width" class="form-control" maxlength="12" min="0" value="<?php echo set_value('width') ?>">
											<span class="input-group-addon">Cm</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="height" class="control-label col-md-2">Height</label>
									<div class="col-md-4">
										<div class="input-group">
											<input type="number" name="height" id="height" class="form-control" maxlength="12" min="0" value="<?php echo set_value('height') ?>">
											<span class="input-group-addon">Cm</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="weight" class="control-label col-md-2">Weight</label>
									<div class="col-md-4">
										<div class="input-group">
											<input type="number" name="weight" id="weight" class="form-control" maxlength="12" min="0" value="<?php echo set_value('weight') ?>">
											<span class="input-group-addon">Kg</span>
										</div>
									</div>
								</div>
							</fieldset>

							<h3>Additional Info</h3>
							<fieldset>
								<div class="form-group">
									<label for="price" class="control-label col-md-2">Price</label>
									<div class="col-md-4">
										<div class="input-group">
											<span class="input-group-addon">Rp</span>
											<input type="number" name="price" id="price" class="form-control" maxlength="12" min="0" value="<?php echo set_value('price') ?>">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="date_of_purchase" class="control-label col-md-2">Date of Purchase</label>
									<div class="col-md-4">
										<div class="input-group">
											<input type="text" name="date_of_purchase" id="date_of_purchase" class="form-control datepicker" maxlength="10" value="<?php echo set_value('date_of_purchase') ?>">
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
								</div>
								<hr>
								<div class="form-group">
									<label for="description" class="control-label col-md-2">Description</label>
									<div class="col-md-10">
										<textarea name="description" id="description" class="form-control text_editor" rows="4" style="resize:vertical; min-height:100px; max-height:200px;"><?php echo set_value('description') ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="photo" class="control-label col-md-2">Photo</label>
									<div class="col-md-10">
										<input type="file" name="photo" id="photo" class="form-control">
									</div>
								</div>
								<!-- <div class="form-group">
									<div class="col-md-8 col-md-offset-2">
										<button type="submit" class="btn btn-primary">Submit</button>
									</div>
								</div> -->
							</fieldset>
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
