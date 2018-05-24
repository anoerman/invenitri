    <!-- =========================== CONTENT =========================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo lang('forgot_password_heading');?>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-users"></i> Forgot Password</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
	                    <?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?>
                    </h3>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <?php echo $message;?>

                    <?php echo form_open("auth/forgot_password", array('class' => 'form form-horizontal', 'autocomplete' => 'off'));?>

						<div class="form-group">
							<label for="identity" class="control-label col-md-3"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label>
							<div class="col-md-7">
								<?php echo form_input($identity);?>
							</div>
						</div>

						<div class="form-group text-center">
							<?php echo form_submit('submit', lang('forgot_password_submit_btn'), array('class' => 'btn btn-primary'));?>
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



