<div class="container">
    <!--start .my-account -->
    <div class="my-account-page">

        <div class="left-sidebar">
            <ul>
                <li><a href="<?= base_url('dashboard') ?>">My Orders</a></li>
                <li><a href="<?= base_url('dashboard/address') ?>">Address</a></li>
                <li><a href="<?= base_url('dashboard/favourite') ?>">Favourite</a></li>
               <li><a href="<?= base_url('dashboard/password') ?>">Change Password</a></li>
                <li class="active"><a href="<?= base_url('dashboard/profile') ?>">Personal Details</a></li>
            </ul>
        </div>
        <div class="right-bx right_bx_per_n">

            <div class="bx-header">
                <label>PERSONAL DETAILS</label>

            </div>

            <div class="personal_d_r">

                <div class="card-body clearfix">

                    <form action="<?=base_url('dashboard/updateProfile')?>" method="post">
                        <div class="form-inner">
                            <label>Name</label>
                            <input type="text" name="name" value="<?=$profile->name?>" />
                             <span class="error"><?php echo form_error('name'); ?></span>
                        </div>
                       
                        <div class="form-inner">
                            <label>Mobile Number</label>
                            <input type="text" name="mobile" value="<?=$profile->mobile?>" />
                             <span class="error"><?php echo form_error('mobile'); ?></span>
                        </div>
                        <div class="form-inner">
                            <label>Email ID</label>
                              <input type="text"  readonly value="<?=$profile->email?>" />
                        </div>
                        <div class="form-inner">
                            <label></label> 
                            <button type="submit" class="saved_n_button">Update Profile</button> 
                        </div>
                    </form>
                </div>


            </div>


        </div>



    </div>
    <!--end .my-account -->
</div>
