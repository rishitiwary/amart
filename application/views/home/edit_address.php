<style type="text/css"> 
      #map {
        height: 100%;
      }
      #locationField,
      #controls {
        position: relative;
        width: 480px;
      }

      #autocomplete {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 99%;
      }

      .label {
        text-align: right;
        font-weight: bold;
        width: 100px;
        color: #303030;
        font-family: "Roboto", Arial, Helvetica, sans-serif;
      }

      #address {
        border: 1px solid #000090;
        background-color: #f0f9ff;
        width: 480px;
        padding-right: 2px;
      }

      #address td {
        font-size: 10pt;
      }

      .field {
        width: 99%;
      }

      .slimField {
        width: 80px;
      }

      .wideField {
        width: 200px;
      }

      #locationField {
        height: 20px;
        margin-bottom: 2px;
      }
    </style>
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
        <label>Edit Address</label>
      </div>
      <div class="bottom-box address-left add-address clearfix">
        <div class="map">
          <div class="head"><span>Location Name</span><a href="#"><!-- Change --></a></div>
          <div class="addre">Unmad Road, Model Colony, East Bhatia Nagar, Yamunaga Nagar, Haryana 135001, India</div>
        </div>
        <form action="<?= base_url('dashboard/updateAddress/'.$edit_data[0]->id);?>" method="post">
            <input type="hidden" name="hidden_address" id="hidden_address" value="<?php echo $edit_data[0]->id;?>">
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
            <input type="text"  name="flat" value="<?php echo $edit_data[0]->address; ?>" />
              <span class="error"><?php echo form_error('flat'); ?></span>
          </div>
          <div class="form-inner">
            <label>Landmark</label>
            <input type="text" name="landmark" value="<?php echo $edit_data[0]->landmark; ?>">
            <span>Optional</span>
          </div>
          <div class="form-inner">
            <label>Contact Name</label>
            <input type="text" name="name" value="<?php echo $edit_data[0]->name; ?>">
            <span class="error"><?php echo form_error('name'); ?></span>
          </div>
          <div class="form-inner phone-no">
            <label>Phone</label>
            <div class="slct-box select-box">
              <select>
                <option>+971</option>
              </select>
            </div>
            <input type="number" name="mobile" value="<?php echo $edit_data[0]->mobile; ?>">
            <span class="error"><?php echo form_error('mobile'); ?></span>
          </div>
          
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
