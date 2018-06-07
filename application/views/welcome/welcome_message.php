<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Home
				<!-- <small>it all starts here</small> -->
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-dashboard"></i> Home</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Default box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Dashboard</h3>

					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
						<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-lg-6 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-blue">
									<div class="inner">
										<h3><?php echo $total_inventory ?></h3>

										<p>Inventory</p>
									</div>
									<div class="icon">
										<i class="ion ion-laptop"></i>
									</div>
									<a href="<?php echo base_url('inventory/all') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<!-- ./col -->
							<div class="col-lg-6 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-green">
									<div class="inner">
										<h3><?php echo $total_category ?></h3>

										<p>Categories</p>
									</div>
									<div class="icon">
										<i class="ion ion-star"></i>
									</div>
									<a href="<?php echo base_url('categories') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<!-- ./col -->
							<div class="col-lg-6 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-red">
									<div class="inner">
										<h3><?php echo $total_location ?></h3>

										<p>Locations</p>
									</div>
									<div class="icon">
										<i class="ion ion-compass"></i>
									</div>
									<a href="<?php echo base_url('locations') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<!-- ./col -->
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<!-- Inventory by category chart -->
						<canvas id="chart" class="chartjs" width="100%"></canvas>
					</div>
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
