<?php  $this->load->model('Commonmodel'); 
$promo= 0;

?>
  <!-- start .page-heading -->
  <div class="page-heading">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- end .page-heading -->
  <div class="body-bg">
    <div class="container">
      <!-- start .cart -->
      <div class="cart-page cart-new">
       
        <!-- start .address-left -->
        <form action="<?=base_url('dashboard/placeOrder')?>" method="post" accept-charset="utf-8">
       
        <div class="address-left">
          <div id="accordion">
            <div class="card">
              <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                  <button type="button" class="" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                   Please fill in the details below for checkout
                  </button>
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
                  <?php } ?>
                  
                </h5>
              </div>

              <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body clearfix">
                  <div class="address checkout-add">
                    <div class="left">
                      <label>Address</label>
                      <p><?= @$address->name?>, <?= @$address->address?></p>
                      <p><?= @$address->landmark?>, <?= @$address->mobile?></p>
                    </div>
                    <?php if($address) {?>
                    <a href="#" data-toggle="modal" data-target="#addressModal">Changes Address</a>
                      <?php } else{?>
                    <a href="<?=base_url('dashboard/addAddress')?>">Add Address</a>
                     <?php } ?>
                     
                  <input type="hidden" name="address" value="<?= @$address->id ?>" class="form-control">
                  </div>
                    <div class="form-inner"><label>Delivery Type<sup>*</sup></label> 
                      <div class="select-box"> 
                        <select id="type" name="delivery_type">
                          <option value="" selected="">Choose Delivery Type</option>
                          <option value="10">Same Day delivery</option>
                          <option value="48">Delivery within 48hours</option>
                        </select>
                      </div> 
                   </div>
                <h3>PAYMENT METHOD</h3> 
                  <div class="payment-options">
                  <input type="radio" name="payment_method" value="0" checked="checked">
                  <label>Cash On Delivery</label><br>
                  <input type="radio" name="payment_method" value="1">
                  <label>Card On Delivery</label><br>                 
                  </div>
                  <div class="delivry-text">
                    <span>Add Comments About Your Order</span>
                     <textarea name="note" class="form-control"></textarea>
                     <span class="error"><?php echo form_error('note'); ?></span>
                  </div>
                </div>
              </div>
            </div>
           
          </div>

        </div>
         <div class="cart-right">
          <div class="right-inner">
            <div class="pp-box">
              <label>Total <?=count(@$collection)?> Items in Basket</label>
            </div>
             <div class="pp-box">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th class="text-left img">Pic</th>
                    <th class="text-left name">Product Name</th>
                    <th class="text-center quantity">Qty</th>
                    <th class="text-center checkout-price">Unit Price</th>
                    <th class="text-right total">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $subtotal=0; foreach ($collection as $key => $pro): ?>
                    <tr>
                    <td>
                      <?php if (file_exists('./uploads/products/'.$pro->image)) { ?>
                       <img width="50px" height="50px" src="<?= base_url('uploads/products/').$pro->image ?>" alt="<?= $pro->name ?>">
                    <?php } else { ?>
                        <img width="50px" height="50px" src="https://via.placeholder.com/150" class="img-responsive" alt="noImage">
                    <?php } ?>   

                    </td>
                    <td class="text-left name"><?= $pro->name ?></td>
                    <td class="text-center quantity"><?=$pro->cart_product_quantity?></td>
                    <td class="text-center checkout-price">₹ <?= number_format($pro->offer_price, 2)?></td>
                    <td class="text-right total"><?php @$totalprice= ((@$pro->cart_product_quantity)*(@$pro->offer_price)); echo '₹ '.number_format(@$totalprice, 2);?></td>
                  </tr> 
                   <?php @$subtotal=@$totalprice + $subtotal ?>                   
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
                <div>
              <label>
            
              <?php  
              $promo=0;
              if(@$_GET['coupon'])
              {

                $coupon= @$_GET['coupon'];
                $promoDe = $this->Commonmodel->fetch_row('coupons', "coupon_id=$coupon");
               
                $promo = ($promoDe->discount_percentage / 100) * @$subtotal ;
              } 
              ?>
                <input type="hidden" name="coupon_id" id="test3"  value="<?=@$coupon?>">
              </label>
            </div>
            <div class="pp-box green">              
              <button type="button" class="btn-danger btn" data-toggle="modal" data-target="#promoModal"> Have a promo code? </button>           
            </div>              
             <div class="pp-box green">
              <strong>Subtotal</strong>
              <strong>₹ <?= number_format(@$subtotal, 2) ?></strong>
            </div>

            <div class="pp-box green">
              <label>VAT 5% </label>
              <span>(+) ₹ <?php echo $vat = (5 / 100) * @$subtotal ; ?></span>
               <input type="hidden" name="vat" id="vat"  value="<?=@$vat?>">
            </div>
            <div class="pp-box green">
              <label>Delivery Charges</label>
              <span>(+) ₹ <?php if($subtotal<400)
              { 
                echo $charge= number_format(10, 2);
              } else{
                  echo $charge=number_format(0, 2);
              } ?></span>
            </div>
             <div class="pp-box green">
              <label>Promo Discount</label>
              <span>(-)₹ <?= number_format($promo, 2)?></span>
            </div>

            <div class="pp-box green" id="row_dim">
              <label>Same Day Delivery Charges</label>
              <strong>(+) ₹ <?php echo $sameDay=number_format(10, 2); ?></strong>
            </div>

            <div class="pp-box green">
              <strong>Total</strong>
              <?php $grand = ($subtotal + $vat+ $charge)-$promo; ?>
              <input style="width:100% !important; text-align:right;font-weight:bold" type="text" class="form-control green" name="grand" id='totalPrice' value="₹ <?= number_format($grand, 2)?>" disabled />
              
              <input type="hidden" class="form-control" id='total' value="<?= number_format($grand, 2)?>" disabled />
            </div>
            <?php
            if($subtotal<100){
                 $style="disabled";
                 $diplay=" display: block;";
            }
           else{
               $style="";
               
               $diplay=" display: none;";
           }
            
            ?>
            <label style="color:red;<?php echo $diplay;?>" >Minimum order is 100 AED</label>
            <?php if(count(@$collection)>0) {?>
              <button data-loading-text="Loading..." class="btn btn-primary button confirm-button" <?php echo $style;?>>CHECKOUT NOW</button>
            <?php } else {?>
              <button type="button" data-loading-text="Loading..." class="btn btn-danger button ">Your Cart is Empty</button>
               <?php } ?>

            <!-- end .cart-right -->
          </div>
        </div>
      </form>
        <!-- end .cart -->
      </div></div>
    </div>

  <!-- start coupon -->
      <!-- Modal -->
<div class="modal fade" id="promoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Promo Codes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
        <div id="alert-msg"></div>
        <?php foreach ($availableCoupon as $key => $cop): ?>
          <div class="coupon-box">
            <div class="left">
              <div class="heading"><?=$cop->coupon_title?></div>
              <div class="discount"><?=$cop->discount_percentage?>% Off</div>
              <p>Valid From : <?=$cop->valid_from?></p>
              <p>Valid Till :  <?=$cop->valid_upto?></p>
               <p>Min Price : <?=$cop->min_order_price?></p>
              <p>Max Price :  <?=$cop->max_order_price?></p>
            </div>
            <div class="right"><button class="btn btn-warning" type="button" onclick="verifyCoupons(<?= $cop->coupon_id ?>,<?=$subtotal?>)">Apply</button></div>
          </div>          
        <?php endforeach ?>
        <?php if(count($availableCoupon)=='0'){?>
          <div class="heading">No Coupon available</div>
        <?php } ?>
      
      </div>
      
    </div>
  </div>
</div>
      <!-- end coupon -->

<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="addressheading">
          <h5 class="modal-title">All Address</h5>
          <a href="<?=base_url('dashboard/addAddress')?>" class="addaddress">Add Address</a>
        </div>        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
        <div id="alert-msg"></div>
      <?php foreach ($addresslist as $key => $a): ?>
          <div class="coupon-box">
            <div class="left">
              <p><b>Address:</b> <?=$a->address?>
            </div>           
              <p><b>Landmark :</b> <?=$a->landmark?></p>            
              <div class="right">
                <button class="btn btn-warning" type="button" onclick="changeAddress(<?= $a->id ?>)">Change</button>
            </div>
            </div>
             <?php endforeach ?>
          </div>  
        <?php if(count($addresslist)=='0'){?>
          <div class="heading">No Address found</div>
        <?php } ?>
      
      </div>
      
    </div>
  </div>
</div>