    <!-- =========================== CONTENT =========================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo lang('reset_password_heading');?>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-users"></i> <?php echo lang('reset_password_heading');?></li>
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

                    <?php echo form_open('auth/reset_password/' . $code, array('class' => 'form form-horizontal', 'autocomplete' => 'off'));?>
						<div class="form-group">
							<label for="new_password" class="control-label col-md-3"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label> 
							<?php echo form_input($new_password);?>
						</div>

						<div class="form-group">
							<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm', array('class' => 'control-label col-md-3'));?> 
							<?php echo form_input($new_password_confirm);?>
						</div>

						<?php echo form_input($user_id);?>
						<?php echo form_hidden($csrf); ?>

						<div class="form-group"><?php echo form_submit('submit', lang('reset_password_submit_btn'), array('class' => 'btn btn-primary'));?></div>

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
