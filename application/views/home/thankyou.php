
<div class="body-bg">
 <div class="container">
  
  <!-- start .checkout-main -->
  <!--thank main box-->
    <div class="thank-main">
        <div class="left">
         <figure><img src="<?=base_url('images/thankyou/preview.png')?>"></figure>
        </div>
        <div class="right">
          <?php if($this->session->flashdata('success')){ ?>
            <div class="alert alert-success">
              <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
              <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
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
            <strong>Thank you</strong>
            <?php //print_r($order_data[0]['order_id']); ?>
            <span>Your Order #<?=@$this->session->order_id?> </br>has been successfully placed</span>
            <p>Our Delivery Team will delivery</br> your items at your Doorstep</p>

        </div>
  
 </div>
 <div class="shopping-continue"><a href="<?php echo base_url();?>">CONTINUE SHOPPING</a></div>

</div>

 <!--thank main box-->
 <!-- end .checkout-main -->
</div>


