<?php
$this->load->view('admin_header');
?>
<body>
<?php if(!empty($this->session->flashdata('success'))){ ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong><?php echo $this->session->flashdata('success'); ?></strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php } ?>
<?php if(!empty($this->session->flashdata('error'))){ ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong><?php echo $this->session->flashdata('error'); ?></strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php } ?>
 <div class="wrapper">
  <div class="m-account-w">
   <div class="m-account"> <div class="row no-gutters flex-row-reverse"> 
    <div class="col-md-12"> <div class="m-account--form-w"> <div class="m-account--form"> <div class="logo"> <img src="assets/img/logo.png" alt=""> </div>
     <form action="" method="post">
        <label class="m-account--title">Change Your Password</label>
        <div class="form-group"> 
            <div class="input-group"> 
                <div class="input-group-prepend"> <i class="fas fa-key"></i> </div>
                <input type="password" name="current_password" placeholder="Old Password" class="form-control" autocomplete="off" required>
            </div>
        </div>
        <div class="form-group"> 
            <div class="input-group"> 
                <div class="input-group-prepend"> <i class="fas fa-key"></i> </div>
                <input type="password" name="new_password" placeholder="New Password" class="form-control" autocomplete="off" required>
            </div>
        </div>
        <div class="form-group"> 
            <div class="input-group"> 
                <div class="input-group-prepend"> <i class="fas fa-key"></i> </div>
                <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control" autocomplete="off" required>
            </div>
        </div>
        <div class="m-account--actions"> 
            <input type="submit"name="changepassword" value="Change Password" class="btn btn-block btn-rounded btn-info">
        </div>
     </form>
    </div>
  </div>
  </div>
  </div>

<?php
$this->load->view('admin_footer');
?>