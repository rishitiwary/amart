<div class="col-lg-4 col-lg-offset-4">
    <h2>Change Profile</h2>
    <h5>Hello <span><?php echo $name; ?></span>.</h5>     
<?php 
    $fattr = array('class' => 'form-signin');
    echo form_open(site_url().'main/changeuser/', $fattr); ?>
    
    <div class="form-group">
      <?php echo form_input(array('name'=>'name', 'id'=> 'firstname', 'placeholder'=>' Name', 'class'=>'form-control', 'value' => set_value('name', $groups->name))); ?>
      <?php echo form_error('name');?>
    </div>
    <div class="form-group">
      <?php echo form_input(array('name'=>'mobile', 'id'=> 'mobile', 'placeholder'=>'Mobile', 'class'=>'form-control', 'value'=> set_value('mobile', $groups->mobile))); ?>
      <?php echo form_error('mobile');?>
    </div>
    <div class="form-group">
      <?php echo form_input(array('name'=>'email', 'id'=> 'email', 'placeholder'=>'Email', 'class'=>'form-control', 'value'=> set_value('email', $groups->email))); ?>
    </div>
    <div class="form-group">
      <?php echo form_password(array('name'=>'password', 'id'=> 'password', 'placeholder'=>'Password', 'class'=>'form-control', 'value' => set_value('password'))); ?>
      <?php echo form_error('password') ?>
    </div>
    <div class="form-group">
      <?php echo form_password(array('name'=>'passconf', 'id'=> 'passconf', 'placeholder'=>'Confirm Password', 'class'=>'form-control', 'value'=> set_value('passconf'))); ?>
      <?php echo form_error('passconf') ?>
    </div>
    <?php echo form_submit(array('value'=>'Change', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
    <?php echo form_close(); ?>
</div>