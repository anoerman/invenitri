	<!-- =========================== MENU =========================== -->

	<!-- Left side column. contains the sidebar -->
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
			<!-- search form -->
			<form action="<?php echo base_url('inventory/search') ?>" method="post" class="sidebar-form" autocomplete="off">
				<div class="input-group">
					<input type="text" name="keyword" class="form-control" placeholder="Search for inventory">
					<span class="input-group-btn">
						<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
						</button>
					</span>
				</div>
			</form>
			<!-- /.search form -->
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li class="header">MAIN NAVIGATION</li>
				<li>
					<a href="<?php echo base_url() ?>">
						<i class="fa fa-home"></i> <span>Home</span>
					</a>
				</li>

			<?php if ($this->ion_auth->logged_in()): ?>
				<li class="treeview">
          <a href="#"><i class="fa fa-archive"></i> <span>Inventory</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('inventory') ?>"><i class="fa fa-plus"></i> Add New</a></li>
            <li><a href="<?php echo base_url('inventory/all') ?>"><i class="fa fa-list-alt"></i> All Data</a></li>
            <li><a href="<?php echo base_url('inventory/by_category') ?>"><i class="fa fa-star-o"></i> By Category</a></li>
            <li><a href="<?php echo base_url('inventory/by_location') ?>"><i class="fa fa-map-pin"></i> By Location</a></li>
            <li><a href="<?php echo base_url('inventory/search') ?>"><i class="fa fa-search"></i> Search</a></li>
          </ul>
        </li>
				<li class="header">MASTER</li>
				<li>
					<a href="<?php echo base_url('categories') ?>">
						<i class="fa fa-star"></i> <span>Categories</span>
					</a>
				</li>
				<li>
					<a href="<?php echo base_url('locations') ?>">
						<i class="fa fa-map-marker"></i> <span>Locations</span>
					</a>
				</li>
				<li>
					<a href="<?php echo base_url('color') ?>">
						<i class="fa fa-tint"></i> <span>Color</span>
					</a>
				</li>
				<?php if ($this->ion_auth->is_admin()): ?>
					<li>
						<a href="<?php echo base_url('status') ?>">
							<i class="fa fa-heart"></i> <span>Inventory Status</span>
						</a>
					</li>
					<!-- Menu Admin -->
					<li class="header">SETTINGS</li>
					<li>
						<a href="<?php echo base_url('auth') ?>">
							<i class="fa fa-users"></i> <span>Users</span>
						</a>
					</li>
				<?php endif ?>
				<li class="header">OPTIONS</li>
				<li>
					<a href="<?php echo base_url('auth/logout') ?>">
						<i class="fa fa-sign-out"></i> <span>Logout</span>
					</a>
				</li>
			<?php else: ?>
				<li>
					<a href="<?php echo base_url('auth/login') ?>">
						<i class="fa fa-sign-in"></i> <span>Login</span>
					</a>
				</li>
			<?php endif ?>
			</ul>
		</section>
		<!-- /.sidebar -->
	</aside>

	<!-- =========================== / MENU =========================== -->
