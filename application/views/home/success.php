<?php $this->load->view('home/header');?>
<main id="content" class="page-main">
    <strong id="HeaderPriceContainer"> <div class="main-container container"> 
     <ul class="breadcrumb"> 
     <li><a href="<?php echo base_url();?>"><i class="fa fa-home"></i></a></li> <li><a href="#">Success</a></li> </ul> 
     <div class="row" style="margin-top:15px;"> 
     <div id="content" class="col-md-12 col-sm-12 col-xs-12 mb-0">
          <h3 class="text-success"><b>Order Placed Successfully ! You will Receive a mail soon...</b></h3>
          <h5><b>For Continue Shopping</b><a href="<?php echo base_url();?>home/shop/"> Click here...</a></h5>
          <h5><b>For Check Your Orders</b><a href="<?php echo base_url();?>home/account/"> Click here...</a></h6>
     </div> 
     </div>
     </div>
     </strong>
</main>
<?php $this->load->view('home/footer');?>