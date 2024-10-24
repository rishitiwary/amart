<!-- login-popup -->
<div class="login-popup" id="login-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
      <figure><img src="<?= base_url('images/common/logo.png')?>"> </figure>
   
      </div>
      <form action="<?=base_url('login')?>" method="post" id="loginForm">

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
        <div class="modal-body">
          <div class="heading">Sign In</div>
          <div class="form-group">
          <figure class="f-icon"><img src="<?= base_url()?>images/popup/email.svg" alt=""></figure>
            <input type="email" class="form-control" name="email" id="email1" aria-describedby="emailHelp" placeholder="xyz@gmail.com">
            <input type="hidden" name="fcm_token" value="noval">
          </div>
          <div class="form-group">
          <figure class="f-icon"><img src="<?= base_url()?>images/popup/lock.svg" alt=""></figure>
            <input type="password" class="form-control" name="password" id="password1" placeholder="Password">
           <a href="<?=base_url('register/forget');?>" class="forgot-password">Forgot Password </a>

          </div>
      
        </div>
        <div class="modal-footer border-top-0 d-flex buttons-login">
          <!--<button type="submit" class="skip-button">Skip</button> -->
          <button type="submit" class="sign-in-button">Sign In</button>
        </div>

        <p class="register-text">Don't have an account? <a href="<?=base_url('signup');?>">Sign Up</a></p>
      </form>
    </div>
  </div>
</div>

<!-- end login-popup -->


<!--login script start-->
<script>
$('#loginForm').submit(function(e) {
      e.preventDefault();
      var me = $(this);
      var formData = new FormData(this);
        $.ajax({
         url: me.attr('action'),
         type: 'post',
         data: formData,
         cache: false,
         processData:false,
         contentType:false,
         dataType: 'json',
         success: function(response) 
         {
              $('.has-invalid').remove();
              if(response.error == false){
                  sessionStorage.setItem("username", response.user_detail.name);
                  sessionStorage.setItem("token", response.token);
                  sessionStorage.setItem("user_id", response.user_detail.user_id);
                  sessionStorage.setItem("device_id", response.user_detail.device_id);
                  
                  alert(response.message);
                  location.href="<?php echo base_url('/')?>";
              }
                      
              if(response.error==true){
                
                $.each(response, function(key, value) {
                var element = $("[name="+key+"]");
                element.closest('.form-group')
                .removeClass('has-error')
                .addClass(value.length > 0 ? 'has-error' : 'has-success')
                .find('.text-danger')
                .remove();
                element.after(value);
              });
               if(response.message)
               {
                $("[name='password']").after('<p class="has-invalid">'+response.message+'</p>')
               }
              }
               
              else{
                    $.each(response, function(key, value) {
                    var element = $("[name="+key+"]");
                    element.closest('.form-group')
                    .removeClass('has-error')
                    .addClass(value.length > 0 ? 'has-error' : 'has-success')
                    .find('.text-danger')
                    .remove();
                    
                    element.after(value);
                  });
               }
        }
        
    });
});
</script>

