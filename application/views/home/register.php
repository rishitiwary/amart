<style>
  .error{
    color: red;
  }
</style>
<!-- signup-popup -->
<div class="login-popup signup" id="signup-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
      <figure><img src="<?= base_url('images/common/logo.png')?>"> </figure>
      <!--  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>  -->
      </div>
       <form action="<?= base_url('register')?>" method="post">
        <div class="modal-body">
          <div class="heading">Sign Up</div>
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
         
          <div class="form-group">
             
            <input type="text"  name="firstName" id="firstName" class="form-control"  placeholder="First Name" value="<?php echo set_value('firstName'); ?>">
            <span class="error"><?php echo form_error('firstName'); ?></span>
          </div>
          <div class="form-group">
            <input type="text" name="lastName" id="lastName" class="form-control" aria-describedby="lastName" placeholder="Last Name" value="<?php echo set_value('lastName'); ?>">
            <span class="error"><?php echo form_error('lastName'); ?></span>
          </div>
          <div class="form-group">
            <input type="text" name="phone" id="phone" class="form-control"  aria-describedby="phone" placeholder="Phone Number" value="<?php echo set_value('phone'); ?>">
            <span class="error"><?php echo form_error('phone'); ?></span>
          </div>
          <div class="form-group">
            <input type="email" name="email" id="email" class="form-control"  aria-describedby="email" placeholder="Email ID" value="<?php echo set_value('email'); ?>">
            <span class="error"><?php echo form_error('email'); ?></span>
          </div>
           <div class="form-group">
            <input type="password" name="password" id="" class="form-control" aria-describedby="password" placeholder="Password">
            <span class="error"><?php echo form_error('password'); ?></span>
          </div>

          <div class="form-group ">
            <input type="password" name="conpassword" id="conpassword" class="form-control" aria-describedby="conpassword" placeholder="Confirm Password">
            <span class="error"><?php echo form_error('conpassword'); ?></span>
          </div>
          <div class="form-group">
            <select class="form-control" name="gender" id="gender">
              <option value="" selected>Select Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
            <span class="error"><?php echo form_error('gender'); ?></span>
          </div>
          <div class="form-group select-box">
             <select class="form-control" name="nationality" id="nationality">
            <option value="" >Select Nationality</option>
            <?php for($i=0;$i<count($countries);$i++) { ?>
            <option value="<?php echo $countries[$i]->country;?>"><?php echo $countries[$i]->country;?></option>
            <?php } ?>
            </select>
            <span class="error"><?php echo form_error('nationality'); ?></span>
          </div>
         
      
        </div>
        <p class="terms-text">By continuing you agree for <a href="<?=base_url('terms')?>">Terms & Conditions</a></p>
        <div class="modal-footer border-top-0 d-flex buttons-login">
          <button type="submit" class="sign-in-button">Create Account</button>
        </div>

        <p class="register-text">Already have an account? <a href="<?php echo site_url('login');?>">Sign In</a></p>
      </form>
    </div>
  </div>
</div>
