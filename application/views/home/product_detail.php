<?php @$userId= $this->session->userdata('id'); ?>
<!-- start .page-heading -->
<div class="page-heading">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?=base_url('home/category')?>/<?=@$category->id?>/<?=@$details->product_type?>"><?=@$category->category?></a></li>
        <?php if(@$subcategory->category) {?>
        <li class="breadcrumb-item"><a href="<?=base_url()?>home/subcategory/<?=@$category->id?>/<?=$subcategory->id?>"><?=@$subcategory->category?></a></li>
      <?php } ?>
        <li class="breadcrumb-item active" aria-current="page">Product Details</li>
      </ol>
    </nav>
  </div>
</div>
<!-- end .page-heading -->
<div class="body-bg">
  <div class="container">
    <!--start .product-top -->
    <div class="product-top">
      <div class="left pro-owl-carousel">
    <figure>
    <?php if (file_exists('./uploads/products/'.$details->image)) { ?>
    <img src="<?= base_url('uploads/products/').$details->image ?>" width="300px" height="300px" alt="<?= $details->name ?>">
    <?php } else { ?>
    <img src="<?= base_url('images/home/product-1.png') ?>" class="img-responsive" alt="banner1">

    <?php } ?> 
              </figure>
      
      </div>

      <div class="right">
        <div class="title"><?= $details->name ?></div>
        <div class="price-box"> 
          <strong>₹ <?= number_format($details->offer_price, 2)?></strong> 
           <?php
        if($details->offer_percentage!="0" && $details->offer_price!=$details->price){
        ?>
          <strike>₹  <?= number_format($details->price, 2)?></strike> 
          <div class="offer"><?= $details->offer_percentage?>% OFF</div> 
          <?php } ?>
        </div>
        

        <!-- start .qty -->

        <div class="qty-top">
            <!--<label>Quantity</label><br>-->
            <!--<span><?= $details->weight ?></span>-->
            <h1><label>Quantity</label><br> 
           <span><?= $details->weight ?></span> 
           </h1>
          <div class="qty-main"> 
            <div class="qty-main">  
              <div class="qty">
                <input type="number" min="1" id="detailqty" class="count" name="qty" value="<?php if(@$cart){ echo $cart->quantity; } else { echo '1';} ?>">
                <span class="minus">-</span>
                <span class="plus">+</span>
              </div>
            </div> 
          </div>
          <!-- end .qty -->
          <button class="add-to-cart" onclick="updatedetailcart(<?= $details->id ?>,<?=$details->product_type?>);" class="cart-button add_cart">Add to Cart</button>
          <label>In Stock</label>
         
        </div>
       
      <!-- start .share-buttons -->
      <div class="share-buttons">
        <label>Share</label>
        <div class="right sharethis-inline-share-buttons">         
        </div>
      </div>

      <!-- end .share-buttons -->

    </div>
  </div>
  <!--end .product-top -->

  <!-- start .desc -->
  <div class="desc-detail">
    <label>Description</label>
    <p><?= $details->description ?></p>
  </div>
  <!-- end .desc -->

  <div class="also-like">
    <div class="heading-comman container">
      <div class="top">
        <span>Discovery</span>
      </div>
      <p>You may also like this</p>
    </div>
  </div>
  <!-- start .also-like -->
  <div class="also-like">

    <?php foreach ($latest as $key => $lat): ?>      
    
    <div class="product-box">
      <?php 
      if($this->session->userdata('id')!='')
      {
        $checkFav= $this->Commonmodel->count('wishlists', "user_id=$userId AND product_id=$lat->id AND product_type=$lat->product_type"); 
      }
      ?>
      <a href="javascript:void(0)" onclick="addWishlist(<?=$lat->id?>, <?=$lat->product_type?>)" class="<?php if((@$checkFav>0) > 0){ echo 'wishlist-icon active';} else { echo 'wishlist-icon';} ?> "></a>

      <a href="<?=base_url()?>home/productDetail/<?=$lat->id?>/<?=$lat->product_type?>">
        <figure>
          <?php if (file_exists('./uploads/products/'.$lat->image)) { ?>
            <img src="<?= base_url('uploads/products/').$lat->image ?>" width="190px" height="156px" alt="<?= $lat->name ?>">
          <?php } else { ?>
            <img src="<?= base_url('images/home/product-1.png') ?>" class="img-responsive" alt="banner1">
          <?php } ?>

        </figure>
      </a>
      <div class="bottom">
        <span class="title"><?=$lat->name?></span>
         <div class="inside-location">
                <label><?=$lat->country?></label>
                <label><?= $lat->weight?></label>
              </div>
        
        <div class="heading">
          <span class="offer-price">₹ <?= number_format($lat->offer_price, 2)?></span>
          <span class="price"><strike>₹  <?= number_format($lat->price, 2)?></strike></span>
          <span class="offer"><?= $lat->offer_percentage?>% OFF</span>
        </div>
      </div>
      <button onclick="addCart(<?= $lat->id ?>,<?=$lat->product_type?>)" class="cart-button add_cart">Add to Cart</button>
    </div>
    <?php endforeach ?>

  </div>
  <!-- end .also-like -->
</div>


</div>
