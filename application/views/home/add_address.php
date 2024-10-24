<div class="container">
  <!--start .my-account -->
  <div class="my-account-page">

    <div class="left-sidebar">
      <ul>
        <li><a href="<?= base_url('dashboard') ?>">My Orders</a></li>
        <li class="active"><a href="<?= base_url('dashboard/address') ?>">Address</a></li>
        <li><a href="<?= base_url('dashboard/favourite')?>">Favourite</a></li>
        <li><a href="<?= base_url('dashboard/password')?>">Change Password</a></li>
        <li><a href="<?= base_url('dashboard/profile')?>">Personal Details</a></li>
      </ul>
    </div>

    <div class="right-bx">
      <div class="bx-header">
        <label>Add Address</label>
      </div>
      <div class="bottom-box address-left add-address clearfix">
        <div class="map">
          <div class="head"><span>Location Name</span><a href="#"><!-- Change --></a></div>
          <div class="addre">Building No.XXX, Fruit & Vegetable Market - Dubai - United Arab Emirates</div>
        </div>
        <form action="<?= base_url('dashboard/createAddress');?>" method="post">
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
            <label>Full Address</label>
            <input type="text"  name="flat" value="<?php echo set_value('flat'); ?>" />
          </div>
          <div class="form-inner"> <label></label><span class="error"><?php echo form_error('flat'); ?></span></div>
          <div class="form-inner">
            <label>Landmark</label>
            <input type="text" name="landmark" value="<?php echo set_value('landmark'); ?>">
            <span>Optional</span>
          </div>
          <div class="form-inner">
            <label>Contact Name</label>
            <input type="text" name="name" value="<?php echo set_value('name'); ?>">
          </div>
           <div class="form-inner"><label></label><span class="error"><?php echo form_error('name'); ?></span></div>
          <div class="form-inner phone-no">
            <label>Phone</label>
            <div class="slct-box select-box">
              <select>
                <option>+971</option>
              </select>
            </div>
            <input type="number" name="mobile" value="<?php echo set_value('mobile'); ?>">
          </div>
           <div class="form-inner"><label></label><span class="error"><?php echo form_error('mobile'); ?></span></div>
          
          <div class="form-inner">
            <label></label> 
            <button type="submit"  class="continue-button">Save Address</button>
            <br/>
            
          </div>
        </form>
        <a class="btn btn-success waves-effect waves-light m-l-30" href="<?= base_url('dashboard/address') ?>">
              Back
            </a>
      </div>

     
    </div>
  </div>
  
</div>
