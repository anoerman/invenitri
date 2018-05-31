	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Inventory
				<small>Your data sorted per location</small>
			</h1>

			<ol class="breadcrumb">
				<li><a href="<?php echo base_url("inventory") ?>"><i class="fa fa-archive"></i> Inventory</a></li>
				<li><a href="<?php echo base_url("inventory/by_location"); ?>">Location</a></li>
				<li class="active"><?php echo $location_name ?></li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Default box -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Location : <?php echo $location_name ?>
					</h3>

					<div class="box-tools pull-right">
						<!-- <button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
						<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<?php echo $message;?>
					<?php echo $location_desc; ?>
					<hr>

					<div class="table-responsive">
						<table class="table table-hover table-bordered table-striped">
							<thead>
								<tr>
									<th>Code</th>
									<th>Brand - Model</th>
									<th>Category</th>
									<th>Photo</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
							<?php if (count($data_list->result())>0): ?>
								<?php foreach ($data_list->result() as $data): ?>
								<tr>
									<td><?php echo $data->code; ?></td>
									<td><?php echo $data->brand. " " .$data->model; ?></td>
									<td><?php echo $data->category_name; ?></td>
									<td><?php if ($data->thumbnail!="") :?><a href="<?php echo base_url('assets/uploads/images/inventory/').$data->photo ?>" data-fancybox data-caption="<?php echo $data->brand . " " . $data->model ?>">
										<img src="<?php echo base_url('assets/uploads/images/inventory/').$data->thumbnail ?>" alt="<?php echo $data->brand . " " . $data->model ?>"></a><?php endif ?></td>
									<td width="15%">
										<form action="<?php echo base_url('inventory/delete/'.$data->code) ?>" method="post" autocomplete="off">
											<div class="btn-group-vertical">
												<a class="btn btn-sm btn-default" href="<?php echo base_url('inventory/detail/'.$data->code) ?>" role="button"><i class="fa fa-eye"></i> Detail</a>
												<a class="btn btn-sm btn-primary" href="<?php echo base_url('inventory/edit/'.$data->code) ?>" role="button"><i class="fa fa-pencil"></i> Edit</a>
												<input type="hidden" name="id" value="<?php echo $data->id; ?>">
												<button type="submit" class="btn btn-sm btn-danger" role="button" onclick="return confirm('Delete this data?')"><i class="fa fa-trash"></i> Delete</button>
											</div>
										</form>
									</td>
								</tr>
								<?php endforeach ?>
							<?php else: ?>
								<tr>
									<td class="text-center" colspan="5">No Data Found!</td>
								</tr>
							<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer text-center">
					<?php echo $pagination; ?>
					<br>
					<a href="<?php echo base_url('inventory/by_location'); ?>" class="btn btn-primary">Back to Inventory by Location</a>
					<?php echo (isset($last_query)) ? $last_query : ""; ?>&nbsp;
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
