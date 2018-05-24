    <!-- =========================== CONTENT =========================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo lang('change_password_heading');?>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-users"></i> <?php echo lang('change_password_heading');?></li>
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

                    <?php echo form_open("auth/change_password", array('class' => 'form form-horizontal', 'autocomplete' => 'off'));?>

                        <div class="form-group">
                            <?php echo lang('change_password_old_password_label', 'old_password', array('class' => 'control-label col-md-3'));?> 
                            <div class="col-md-7">
                                <?php echo form_input($old_password);?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_password" class="control-label col-md-3"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label> 
                            <div class="col-md-7">
                                <?php echo form_input($new_password);?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm', array('class' => 'control-label col-md-3'));?> <br />
                            <div class="col-md-7">
                                <?php echo form_input($new_password_confirm);?>
                            </div>
                        </div>

                        <?php echo form_input($user_id);?>
                        <div class="form-group text-center">
                            <hr>
                            <?php echo form_submit('submit', lang('change_password_submit_btn'), array('class' => 'btn btn-primary'));?>
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
