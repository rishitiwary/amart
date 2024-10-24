<!-- login-popup -->
<div class="login-popup" id="login-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
      <figure><img src="<?= base_url('images/common/logo.png')?>"> </figure>
   
      </div>
      <form action="<?=base_url('register/recoverPass')?>" method="post">

        <?php if($this->session->flashdata('success')){ ?>
          <div class="alert alert-success">
            <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
            <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php }else if($this->session->flashdata('error')){  ?>
          <div class="alert alert-danger">
            <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
             <?php echo validation_errors(); ?> 
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
          <div class="heading">Forget Password</div>
         
          <div class="form-group">

          <figure class="f-icon"><img src="<?= base_url()?>images/popup/email.svg" alt=""></figure>
            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="xyz@gmail.com">
          </div>
          <div class="form-group">          
           <a href="<?=base_url('login');?>" class="forgot-password">Sign In </a>
          </div>
      
        </div>
        <div class="modal-footer border-top-0 d-flex buttons-login">
          <button type="submit" class="sign-in-button">Reset</button>
        </div>

      
      </form>
    </div>
  </div>
</div>





