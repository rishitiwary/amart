<div class="container">
    <!--start .my-account -->
    <div class="my-account-page">

        <div class="left-sidebar">
            <ul>
                <li><a href="<?= base_url('dashboard') ?>">My Orders</a></li>
                <li><a href="<?= base_url('dashboard/address') ?>">Address</a></li>
                <li><a href="<?= base_url('dashboard/favourite') ?>">Favourite</a></li>
                <li class="active"><a href="<?= base_url('dashboard/password') ?>">Change Password</a></li>
                <li ><a href="<?= base_url('dashboard/profile') ?>">Personal Details</a></li>
            </ul>
        </div>
        <div class="right-bx right_bx_per_n">               
            <div class="bx-header">
                <label>Change Password</label>
            </div>
            <div class="personal_d_r">
                
                <div class="card-body clearfix">
                    <p>A strong password includes number, letter, and punctuation marks. It must be 6 characters long.</p>
                    <br>
                    <form action="<?= base_url('dashboard/upadtepass') ?>" method="post">
                        <?php if($this->session->flashdata('success')){ ?>
                            <div class="alert alert-success">
                                <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
                                <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        <?php }else if($this->session->flashdata('error')){  ?>
                            <div class="alert alert-danger">
                                <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
                                <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php }else if($this->session->flashdata('warning')){  ?>
                            <div class="alert alert-warning">
                                <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
                                <strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
                            </div>
                        <?php }else if($this->session->flashdata('info')){  ?>
                            <div class="alert alert-info">
                                <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
                                <strong>Info!</strong> <?php echo $this->session->flashdata('info'); ?>
                            </div>
                        <?php } ?>
                        <div class="form-inner">
                            <label>Old Password</label>
                            <input type="password" name="oldpassword" value="<?php echo set_value('oldpassword');?>" placeholder="Your Old Password"  class="form-control">                           
                        </div>
                         <div class="form-inner"><label></label><span class="error"><?php echo form_error('oldpassword'); ?></span></div>
                        <div class="form-inner">
                            <label>New Password</label>
                            <input type="password" name="newpassword" value="<?php echo set_value('newpassword');?>" placeholder="Your New Password"  class="form-control">
                        </div>
                         <div class="form-inner"><label></label><span class="error"><?php echo form_error('newpassword'); ?></span></div>
                        <div class="form-inner">
                            <label>Confirm Password</label>
                            <input type="password" name="confirmpassword" value="<?php echo set_value('confirmpassword');?>" placeholder="Confirm New Password"  class="form-control">
                        </div>
                        <div class="form-inner"><label></label><span class="error"><?php echo form_error('confirmpassword'); ?></span></div>

                        <div class="form-inner">
                            <label></label> 
                            <button type="submit" class="saved_n_button">Reset Password</button> 
                        </div>

                    </form>
                </div>


            </div>
        </div>
    </div>
    <!--end .my-account -->
</div>
