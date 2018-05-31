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
				<li class="active">Search</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">
			<?php echo $message;?>

			<!-- Search Data box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Search Inventory
					</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button>
					</div>
				</div>
				<div class="box-body <?php echo (isset($results)) ? "hide" : "show" ?>" id="add_new">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<form id="search_form" action="<?php echo base_url('inventory/search/results') ?>" method="post" autocomplete="off" class="form form-horizontal" enctype="multipart/form-data">
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
									<div class="input-group input-group-lg">
									  <input type="text" name="keyword" id="keyword" class="form-control" value="<?php echo set_value("keyword"); ?>" placeholder="Search for..." required>
										<span class="input-group-btn">
							        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
							      </span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
									<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="CatFilter">
												<h4 class="panel-title">
													<a role="button" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
														<span class="fa fa-star"></span> &nbsp; Filter by Categories
														<span class="pull-right">
															<span class="caret"></span>
														</span>
													</a>
												</h4>
											</div>
											<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="CatFilter">
												<div class="panel-body">
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
																<label for="category_<?php echo $cls2->id; ?>">
																	<input type="checkbox" name="category[]" id="category_<?php echo $cls2->id; ?>" value="<?php echo $cls2->id; ?>" <?php echo set_checkbox('category[]', $cls2->id); ?>>
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
																	<label for="category_<?php echo $cls2->id; ?>">
																		<input type="checkbox" name="category[]" id="category_<?php echo $cls2->id; ?>" value="<?php echo $cls2->id; ?>" <?php echo set_checkbox('category[]', $cls2->id); ?>>
																		<?php echo $cls2->name ?>
																	</label>
																</div>
															<?php endforeach; ?>
														</div>
													<?php endif; ?>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="LocFilter">
												<h4 class="panel-title">
													<a class="collapsed" role="button" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
														<span class="fa fa-map-marker"></span> &nbsp; Filter by Locations
														<span class="pull-right">
															<span class="caret"></span>
														</span>
													</a>
												</h4>
											</div>
											<div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="LocFilter">
												<div class="panel-body">
													<?php if (count($loc_list->result())>3): ?>
														<?php
														$batas = ceil(count($loc_list->result())/2);
														$xs    = 0;
														foreach ($loc_list->result() as $lls):
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
																<label for="location_<?php echo $lls->id; ?>">
																	<input type="checkbox" name="location[]" id="location_<?php echo $lls->id; ?>" value="<?php echo $lls->id; ?>" <?php echo set_checkbox('location[]', $lls->id); ?>>
																	<?php echo $lls->name ?>
																</label>
															</div>
														<?php endforeach; echo "</div>"; ?>
													<?php else: ?>
														<div class="col-md-12">
															<?php $xs = 0;
															foreach ($loc_list->result() as $lls):
																$xs++; ?>
																<div class="radio">
																	<label for="location_<?php echo $lls->id; ?>">
																		<input type="checkbox" name="location[]" id="location_<?php echo $lls->id; ?>" value="<?php echo $lls->id; ?>" <?php echo set_checkbox('location[]', $lls->id); ?>>
																		<?php echo $lls->name ?>
																	</label>
																</div>
															<?php endforeach; ?>
														</div>
													<?php endif; ?>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="StatFilter">
												<h4 class="panel-title">
													<a class="collapsed" role="button" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
														<span class="fa fa-heart"></span> &nbsp; Filter by Status
														<span class="pull-right">
															<span class="caret"></span>
														</span>
													</a>
												</h4>
											</div>
											<div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="StatFilter">
												<div class="panel-body">
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
																	<label for="status_<?php echo $sls2->id; ?>">
																		<input type="checkbox" name="status[]" id="status_<?php echo $sls2->id; ?>" value="<?php echo $sls2->id; ?>" <?php echo set_checkbox('status[]', $sls2->id); ?>>
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
																	<label for="status_<?php echo $sls2->id; ?>">
																		<input type="checkbox" name="status[]" id="status_<?php echo $sls2->id; ?>" value="<?php echo $sls2->id; ?>" <?php echo set_checkbox('status[]', $sls2->id); ?>>
																		<?php echo $sls2->name ?>
																	</label>
																</div>
															<?php endforeach; ?>
														</div>
													<?php endif; ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->

		<?php if (isset($results)): ?>
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Search Results
					</h3>
					<div class="box-tools pull-right">
						<!-- <button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
					</div>
				</div>
				<div class="box-body show">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>Code</th>
									<th>Brand - Model</th>
									<th>Category</th>
									<th>Location</th>
									<th>Photo</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
							<?php if (count($results->result())>0): ?>
								<?php foreach ($results->result() as $result): ?>
								<tr>
									<td><?php echo $result->code; ?></td>
									<td><?php echo $result->brand. " " .$result->model; ?></td>
									<td><?php echo $result->category_name; ?></td>
									<td><?php echo $result->location_name; ?></td>
									<td><?php if ($result->thumbnail!="") :?><a href="<?php echo base_url('assets/uploads/images/inventory/').$result->photo ?>" data-fancybox data-caption="<?php echo $result->brand . " " . $result->model ?>">
										<img src="<?php echo base_url('assets/uploads/images/inventory/').$result->thumbnail ?>" alt="<?php echo $result->brand . " " . $result->model ?>"></a><?php endif ?></td>
									<td width="15%">
										<form action="<?php echo base_url('inventory/delete/'.$result->code) ?>" method="post" autocomplete="off">
											<div class="btn-group-vertical">
												<a class="btn btn-sm btn-default" href="<?php echo base_url('inventory/detail/'.$result->code) ?>" role="button"><i class="fa fa-eye"></i> Detail</a>
												<a class="btn btn-sm btn-primary" href="<?php echo base_url('inventory/edit/'.$result->code) ?>" role="button"><i class="fa fa-pencil"></i> Edit</a>
												<input type="hidden" name="id" value="<?php echo $result->id; ?>">
												<button type="submit" class="btn btn-sm btn-danger" role="button" onclick="return confirm('Delete this data?')"><i class="fa fa-trash"></i> Delete</button>
											</div>
										</form>
									</td>
								</tr>
								<?php endforeach ?>
							<?php else: ?>
								<tr>
									<td class="text-center" colspan="6">No Data Found!</td>
								</tr>
							<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- /.box-body -->
			</div>
		<?php endif; ?>
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- =========================== / CONTENT =========================== -->
