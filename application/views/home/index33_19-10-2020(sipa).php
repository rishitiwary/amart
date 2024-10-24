<?php 
@$userId= $this->session->userdata('id'); ?>
<!-- start .banner-->
<section class="banner"> 
    <div class="banner">
        <div class="carousel slide" id="main-carousel" data-ride="carousel">
			<ol class="carousel-indicators">
                <?php $i =1;  foreach ($banners as $key => $ban) { ?>
				<li data-target="#main-carousel" data-slide-to="0" class="<?php if($i=='1') { ?> active <?php }?>"></li>
                 <?php $i++; } ?>
				
			</ol>
			
			<div class="carousel-inner">
                <?php $i =1;  foreach ($banners as $key => $ban) { ?>
                    <div class="carousel-item <?php if($i=='1') { ?> active <?php }?>">
                       <?php if (file_exists('./uploads/galleries/'.$ban->image)) { ?>
                        <img src="<?= base_url('uploads/galleries/').$ban->image ?>" alt="">
                    <?php } else { ?>
                        <img src="<?= base_url('images/home/home-banner.png') ?>"  alt="banner">
                    <?php } ?>
                </div>
                <?php $i++; } ?>
				
			</div>
			
			<a href="#main-carousel" class="carousel-control-prev" data-slide="prev">
				<span class="carousel-control-prev-icon"></span>
				<span class="sr-only" aria-hidden="true">Prev</span>
			</a>
			<a href="#main-carousel" class="carousel-control-next" data-slide="next">
				<span class="carousel-control-next-icon"></span>
				<span class="sr-only" aria-hidden="true">Next</span>
			</a>
		</div>
       
      </div>
</section>
<!-- end .banner-->
<div class="body-bg">
<!-- start .how-it-works-->
<section class="container how-it-works">
    <div class="heading">How it works</div>
<ul>
    <li><span>
        <figure><img src="<?= base_url()?>images/home/how-it-works-1.svg"></figure>
        <p>Place Order</p>
    </span>
    </li>
    <li>
        <figure><img src="<?= base_url()?>images/home/how-it-works-2.svg"></figure>
        <p>Earn Rewards</p>
    </li>
    <li>
        <figure><img src="<?= base_url()?>images/home/how-it-works-1.svg"></figure>
        <p>Order Confirmation</p>
    </li>
    <li>
        <figure><img src="<?= base_url()?>images/home/how-it-works-4.svg"></figure>
        <p>Delivery in transit</p>
    </li>
    <li>
        <figure><img src="<?= base_url()?>images/home/how-it-works-5.png"></figure>
        <p>Deliver at Home</p>
    </li>
</ul>
</section>
<!-- end .how-it-works-->

<!-- start .shopping-benefits-->
 <div class="why-choose-us">
            <div class="container">
                <div class="heading">
                    <span>Why choose us?</span>
                    <!-- <p>Tristique gravida odio, justo interdu porta lacus mattis tincidunt.</p> -->
                </div>
                <div class="bottom">
                    <div class="left">
                        <img src="<?= base_url()?>images/home/VAN_yalda.png"  alt=""/> </div>
                        <div class="content">
                            <div class="feature-box-inner clearfix">
                                <div class="fbox-icon">
                                    <i class="fa fa-heart"></i>
                                </div>
                                <div class="fbox-content ">  
                                    <h3 class="ourservice-heading">Wide Assortment</h3>
                                    <div class="description">Choose from 5000+ products across food, personal care, households, and other categories..</div>  
                                </div> 
                            </div>
                            <div class="feature-box-inner clearfix">
                                <div class="fbox-icon">
                                    <i class="fa fa-gift"></i>
                                </div>
                                <div class="fbox-content ">  
                                    <h3 class="ourservice-heading">Antioxidant Capacity</h3>
                                    <div class="description">Choosing the food can lead to increased intake of nutritionally desirable antioxidants.</div>  
                                </div> 
                            </div>
                            <div class="feature-box-inner clearfix">
                                <div class="fbox-icon">
                                    <i class="fa fa-truck"></i>
                                </div>
                                <div class="fbox-content ">  
                                    <h3 class="ourservice-heading">Free Delivery</h3>
                                    <div class="description">Free delivery service is applied to shoppers with invoice equivalent to or above $400
                                    from our fields to your doorstep</div>  
                                </div> 
                            </div>
                        </div>

                    </div>
                </div>

            </div>

<div class="slider">
    <div class="heading-comman container">
        <div class="top">
            <span>New Arrivals</span>
        </div>
        <div id="home-slider" class="carousel slide container" data-ride="carousel">
            <div class="carousel-inner">
                <?php 
                $totaldrinks= count($drinks); 
                $cat=@$drinks[0]->category_id; 
                $type=@$drinks[0]->product_type; ?>
                <?php $drinksseq=1; for ($i=0; $i<(ceil($totaldrinks/4)); $i++) { ?>
                    <div class="carousel-item <?php if($drinksseq=='1'){ echo 'active'; }?>">
                        <ul class="product-listing">
                            <?php
                            $where ="status='1' and category_id=$cat ";        
                            if($drinksseq=='1')
                            {
                                $offset = 0;
                            }else{
                                $offset = $key+1;
                            }
                            $drinkslimt = $this->Commonmodel->fetch_by_limit_offset('products', $where, 4, $offset);
                            foreach ($drinkslimt as $key => $drink): ?>
                                <li>
                                    <span><?= $drink->name?></span>
                                    <?php 
                                    if($this->session->userdata('id')!='')
                                    {
                                    $checkFav= $this->Commonmodel->count('wishlists', "user_id=$userId AND product_id=$drink->id AND product_type=$drink->product_type"); 
                                    }
                                    ?>
                                    <a href="javascript:void(0)" onclick="addWishlist(<?=$drink->id?>, <?=$drink->product_type?>)" class="<?php if((@$checkFav>0) > 0){ echo 'wishlist-icon active';} else { echo 'wishlist-icon';} ?> "></a>
                                    <a href="<?=base_url()?>home/productDetail/<?=$drink->id?>/<?=$drink->product_type?>">
                                        <figure>
                                            <?php if (file_exists('./uploads/products/'.$drink->image)) { ?>
                                            <img src="<?= base_url('uploads/products/').$drink->image ?>" width="190px" height="156px" alt="<?= $drink->name ?>">
                                            <?php } else { ?>
                                            <img src="<?= base_url('images/home/product-1.png') ?>" class="img-responsive" alt="banner1">
                                            <?php } ?>
                                        </figure>
                                    </a>
                                    <div class="inside-location">
                                        <label><?= $drink->country?></label>
                                        <label><?= $drink->weight?></label>
                                    </div>
                                    <div class="price-box">
                                        <div class="price">₹ <?= number_format($drink->offer_price, 2)?></div>
                                        <div class="discount"><strike>₹  <?= number_format($drink->price, 2)?></strike></div>
                                        <div class="offer-discount"><?= $drink->offer_percentage?>% OFF</div>
                                        <button onclick="addCart(<?= $drink->id ?>,<?=$drink->product_type?>)" class="cart-button add_cart">Add to Cart</button>
                                    </div>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php $drinksseq++; } ?> 
            </div>
        </div>
        <?php if($totaldrinks>4) { ?>
        <div class="slider-arrow">
            <div class="arrows">           
                <a class="carousel-control-prev" href="#home-slider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#home-slider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <a href="<?=base_url()?>home/category/<?=$cat?>/<?=$type?>" class="exlpore-button">EXPLORE ALL <img src="<?= base_url()?>images/common/next-arrow-button.svg"></a>
        </div>  
    </div>
    <?php } ?>
</div>
<!-- end .product-listing-->
<div class="slider">
    <div class="heading-comman container">
        <div class="top">
            <span>Gift Fruit Basket</span>
        </div>
        <div id="home-slider_fruits" class="carousel slide container" data-ride="carousel">
            <div class="carousel-inner">
                <?php
                $cat=@$latest[0]->category_id; 
                $type=@$latest[0]->product_type; 
                $latestpro = $this->Commonmodel->fetch_by_limit_offset('products', $where, 4, $offset);
                $totallatest= count($latestpro); ?>
                <?php $latestseq=1; for ($i=0; $i<(ceil($totallatest/4)); $i++) { ?>
                    <div class="carousel-item <?php if($latestseq=='1'){ echo 'active'; }?>">
                        <ul class="product-listing">
                            <?php
                            $where ="status='1' and category_id=$cat ";        
                            if($latestseq=='1')
                            {
                                $offset = 0;
                            }else{
                                $offset = $key+1;
                            }
                            $latestlimt = $this->Commonmodel->fetch_by_limit_offset('products', $where, 4, $offset);
                            
                            foreach ($latestlimt as $key => $latests): ?>
                                <li>
                                    <span><?= $latests->name?></span>
                                    <?php 
                                    if($this->session->userdata('id')!='')
                                    {
                                    $checkFav= $this->Commonmodel->count('wishlists', "user_id=$userId AND product_id=$latests->id AND product_type=$latests->product_type"); 
                                    }
                                    ?>
                                    <a href="javascript:void(0)" onclick="addWishlist(<?=$latests->id?>, <?=$latests->product_type?>)" class="<?php if((@$checkFav>0) > 0){ echo 'wishlist-icon active';} else { echo 'wishlist-icon';} ?> "></a>
                                    <a href="<?=base_url()?>home/productDetail/<?=$latests->id?>/<?=$latests->product_type?>">
                                        <figure>
                                            <?php if (file_exists('./uploads/products/'.$latests->image)) { ?>
                                            <img src="<?= base_url('uploads/products/').$latests->image ?>" width="190px" height="156px" alt="<?= $latests->name ?>">
                                            <?php } else { ?>
                                            <img src="<?= base_url('images/home/product-1.png') ?>" class="img-responsive" alt="banner1">
                                            <?php } ?>
                                        </figure>
                                    </a>
                                    <div class="inside-location">
                                        <label><?= $latests->country?></label>
                                        <label><?= $latests->weight?></label>
                                    </div>
                                    <div class="price-box">
                                        <div class="price">₹ <?= number_format($latests->offer_price, 2)?></div>
                                        <div class="discount"><strike>₹  <?= number_format($latests->price, 2)?></strike></div>
                                        <div class="offer-discount"><?= $latests->offer_percentage?>% OFF</div>
                                        <button onclick="addCart(<?= $latests->id ?>,<?=$latests->product_type?>)" class="cart-button add_cart">Add to Cart</button>
                                    </div>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php $latestseq++; } ?> 
            </div>
        </div>
        <?php if(count($latestlimt)>4) { ?>
        <div class="slider-arrow">
            <div class="arrows">           
                <a class="carousel-control-prev" href="#home-slider_fruits" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#home-slider_fruits" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <a href="<?=base_url()?>home/category/<?=$cat?>/<?=$type?>" class="exlpore-button">EXPLORE ALL <img src="<?= base_url()?>images/common/next-arrow-button.svg"></a>
        </div>  
    </div>
<?php } ?>
</div>
<!-- end .product-listing-->


<!-- start .common-heading-->
<div class="heading-comman container">
<div class="top">
    <!--<span>Discovery</span>-->
    <span>Trending Products</span>
</div>
<!-- end .common-heading-->
<!-- start --tabs -->
<div class="slider">
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="featured-tab" data-toggle="tab" href="#featured" role="tab" aria-controls="featured" aria-selected="true">Vegetables</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" id="best-selling-tab" data-toggle="tab" href="#best-selling" role="tab" aria-controls="best-selling" aria-selected="false">Best Sellings</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="featured" role="tabpanel" aria-labelledby="home-tab">

    <div id="home-slider_trending" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
             <?php 
             $total= count($data[1]['products']);
             $cat=$data[1]['products'][0]->category_id;
             $vegseq=1;
             for ($i=0; $i<(ceil($total/4)); $i++)
             { ?>

                <div class="carousel-item <?php if($vegseq=='1'){ echo 'active'; }?>">
                    <ul class="product-listing">
                        <?php
                        $where ="status='1' and category_id=$cat";        
                        if($vegseq=='1')
                        {
                            $offset = 0;
                        }else{
                            $offset = $key+1;
                        }

                        $veglimt = $this->Commonmodel->fetch_by_limit_offset('promotional', $where, 4, $offset);
                        foreach ($veglimt as $key => $veg): ?>
                            <li>
                                <span><?= $veg->name?></span>

                                <?php 
                                if($this->session->userdata('id')!='')
                                {
                                    $checkFav= $this->Commonmodel->count('wishlists', "user_id=$userId AND product_id=$veg->id AND product_type=3"); 
                                }
                                ?>

                                <a href="javascript:void(0)" onclick="addWishlist(<?=$veg->id?>, 3)" class="<?php if((@$checkFav>0) > 0){ echo 'wishlist-icon active';} else { echo 'wishlist-icon';} ?> "></a>

                                <a href="<?=base_url()?>home/productDetail/<?=$veg->id?>/3"><figure>
                                    <?php if (file_exists('./uploads/products/'.$veg->image)) { ?>
                                        <img src="<?= base_url('uploads/products/').$veg->image ?>" width="190px" height="156px" alt="<?= $veg->name ?>">
                                    <?php } else { ?>
                                        <img src="<?= base_url('images/home/product-1.png') ?>" class="img-responsive" alt="banner1">
                                    <?php } ?>
                                </figure>
                            </a>
                                <div class="inside-location">
                                    <label><?= $veg->country?></label>
                                    <label><?= $veg->weight?></label>
                                </div>
                                <div class="price-box">
                                    <div class="price">₹ <?= number_format($veg->offer_price, 2)?></div>
                                    <div class="discount"><strike>₹  <?= number_format($veg->price, 2)?></strike></div>
                                    <div class="offer-discount"><?= $veg->offer_percentage?>% OFF</div>

                                   <button onclick="addCart(<?= $veg->id ?>,<?=$veg->product_type?>)" class="cart-button add_cart">Add to Cart</button>
                                </div>

                            </li>
                        <?php endforeach ?>

                    </ul>
                </div>
                <?php $vegseq++; } ?>
        </div>

    </div>
     <?php if($total>4) { ?>
    <div class="slider-arrow">
        <div class="arrows">           
            <a class="carousel-control-prev" href="#home-slider_trending" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#home-slider_trending" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
       
        </div>
        <a href="<?=base_url()?>home/category/<?=$cat?>/3" class="exlpore-button">EXPLORE ALL <img src="<?= base_url()?>images/common/next-arrow-button.svg"></a>
    </div>
     <?php } ?>

  </div>

  <div class="tab-pane fade" id="best-selling" role="tabpanel" aria-labelledby="best-selling-tab">
    <div id="profile-slider" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php $total= count($data[0]['products']);  $cat=$data[0]['products'][0]->category_id; ?>

            <?php $bestseq=1; for ($i=0; $i<(ceil($total/4)); $i++) { ?>

                <div class="carousel-item <?php if($bestseq=='1'){ echo 'active'; }?>">
                    <ul class="product-listing">
                        <?php
                        $where ="status='1' and category_id=$cat";        
                        if($bestseq=='1')
                        {
                            $offset = 0;
                        }else{
                            $offset = $key+1;
                        }

                        $bestlimt = $this->Commonmodel->fetch_by_limit_offset('promotional', $where, 4, $offset);
                        foreach ($bestlimt as $key => $bes): ?>
                            <li>
                                <span><?= $bes->name?></span>

                                <?php 
                                if($this->session->userdata('id')!='')
                                {
                                    $checkFav= $this->Commonmodel->count('wishlists', "user_id=$userId AND product_id=$bes->id AND product_type=3"); 
                                }
                                ?>

                                <a href="javascript:void(0)" onclick="addWishlist(<?=$bes->id?>, 3)" class="<?php if((@$checkFav>0) > 0){ echo 'wishlist-icon active';} else { echo 'wishlist-icon';} ?> "></a>
                                

                                <a href="<?=base_url()?>home/productDetail/<?=$bes->id?>/3"><figure>
                                    <?php if (file_exists('./uploads/products/'.$bes->image)) { ?>
                                        <img src="<?= base_url('uploads/products/').$bes->image ?>" width="190px" height="156px" alt="<?= $bes->name ?>">
                                    <?php } else { ?>
                                        <img src="<?= base_url('images/home/product-1.png') ?>" class="img-responsive" alt="banner1">
                                    <?php } ?>
                                </figure>
                            </a>
                                <div class="inside-location">
                                    <label><?= $bes->country?></label>
                                    <label><?= $bes->weight?></label>
                                </div>
                                <div class="price-box">
                                    <div class="price">₹ <?= number_format($bes->offer_price, 2)?></div>
                                    <div class="discount"><strike>₹  <?= number_format($bes->price, 2)?></strike></div>
                                    <div class="offer-discount"><?= $bes->offer_percentage?>% OFF</div>

                                    <button onclick="addCart(<?= $bes->id ?>,<?=$bes->product_type?>)" class="cart-button add_cart">Add to Cart</button>
                                </div>

                            </li>
                        <?php endforeach ?>

                    </ul>
                </div>
                <?php $bestseq++; } ?>

            </div>
        </div>
        <?php if($total>4) { ?>
        <div class="slider-arrow">
            <div class="arrows">
                
                <a class="carousel-control-prev" href="#profile-slider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#profile-slider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
           
            </div>
            <a href="<?=base_url()?>home/category/<?=$cat?>/3" class="exlpore-button">EXPLORE ALL <img src="<?= base_url()?>images/common/next-arrow-button.svg"></a>


        </div>
         <?php } ?>

    </div>


</div>

</div>
<!-- end --tabs -->
</div>
<!-- end slides -->


  </div> 
  </div>
</section>
  <!-- END tabs -->

 
</div>


    <!-- start .shipping-middle-box -->
    <section class="shipping-middle-box">
        <ul class="container">
            <li>
                <a href="#">
                <figure><i></i></figure>
                <div class="right">
                    <span>Free Shipping</span>
                    <!-- <p>Lorem ipsum is simply dummy text</p> -->
                </div>
            </a>
            </li>
            <li>
                <a href="#">
                <figure><i></i></figure>
                <div class="right">
                    <span>Free Store Pickup</span>
                    <!-- <p>Lorem ipsum is simply dummy text</p> -->
                </div>
            </a>
            </li>
            <li>
                <a href="#">
                <figure><i></i></figure>
                <div class="right">
                    <span>Deals of the Day</span>
                   <!--  <p>Lorem ipsum is simply dummy text</p> -->
                </div>
            </a>
            </li>
        </ul>
    </section>
    <!-- end .shipping-middle-box -->

    <!-- start .common-heading-->
<div class="heading-comman container">
    <div class="top">
        <!--<span>We Recommend</span>-->
        <span>Top Categories</span>
    </div>
   </div>
    <!-- end .common-heading-->

    
    <!-- start .product-listing-->
    <!-- start tabs -->
    <div class="container">
        <div class="slider">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="fruits-tab" data-toggle="tab" href="#furits" role="tab" aria-controls="home" aria-selected="true">Fruits</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="vegetables-tab" data-toggle="tab" href="#vegetables" role="tab" aria-controls="profile" aria-selected="false">Vegetables</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="eggs-tab" data-toggle="tab" href="#eggs" role="tab" aria-controls="contact" aria-selected="false">Green Leaves</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="bulk-tab" data-toggle="tab" href="#bulk" role="tab" aria-controls="contact" aria-selected="false">Snacks</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="furits" role="tabpanel" aria-labelledby="fruits-tab">
      <!-- start top-categories-slider -->
  <div id="top-categories" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
  <?php $totalfruits= count($fruits); $cat=@$fruits[0]->category_id; $type=@$fruits[0]->product_type; ?>

   <?php $fruitsseq=1; for ($i=0; $i<(ceil($totalfruits/4)); $i++) { ?>
 
    <div class="carousel-item <?php if($fruitsseq=='1'){ echo 'active'; }?>">
    <ul class="product-listing">
        <?php
        $where ="status='1'";        
        if($fruitsseq=='1')
        {
            $offset = 0;
        }else{
            $offset = $key+1;
        }

        $fruitslimt = $this->Commonmodel->fetch_by_limit_offset('products', $where, 4, $offset);

         foreach ($fruitslimt as $key => $fruit): ?>
           <li>
            <span><?= $fruit->name?></span>

            <?php 
            if($this->session->userdata('id')!='')
            {
                $checkFav= $this->Commonmodel->count('wishlists', "user_id=$userId AND product_id=$fruit->id AND product_type=$fruit->product_type"); 
            }
            ?>
            <a href="javascript:void(0)" onclick="addWishlist(<?=$fruit->id?>, <?=$fruit->product_type?>)" class="<?php if((@$checkFav>0) > 0){ echo 'wishlist-icon active';} else { echo 'wishlist-icon';} ?> "></a>

            
            <a href="<?=base_url()?>home/productDetail/<?=$fruit->id?>/<?=$fruit->product_type?>">
                <figure>
                 <?php if (file_exists('./uploads/products/'.$fruit->image)) { ?>
                   <img src="<?= base_url('uploads/products/').$fruit->image ?>" width="190px" height="156px" alt="<?= $fruit->name ?>">
                <?php } else { ?>
                    <img src="<?= base_url('images/home/product-1.png') ?>" class="img-responsive" alt="banner1">
                <?php } ?>
            </figure>
        </a>
            <div class="inside-location">
                <label><?= $fruit->country?></label>
                <label><?= $fruit->weight?></label>
            </div>
            <div class="price-box">
                <div class="price">₹ <?= number_format($fruit->offer_price, 2)?></div>
                <div class="discount"><strike>₹  <?= number_format($fruit->price, 2)?></strike></div>
                <div class="offer-discount"><?= $fruit->offer_percentage?>% OFF</div>

                 <button onclick="addCart(<?= $fruit->id ?>,<?=$fruit->product_type?>)" class="cart-button add_cart">Add to Cart</button>
                </div>
            
            </li>
            <?php endforeach ?>
        
        </ul>
</div>
 <?php $fruitsseq++; } ?>

</div>
<!-- start slider -arrows -->
<?php if($totalfruits>4){?>
<div class="slider-arrow">
    <div class="arrows">        
            <a class="carousel-control-prev" href="#top-categories" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#top-categories" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
       
  </div>
  <a href="<?=base_url()?>home/category/<?=$cat?>/<?=$type?>" class="exlpore-button">EXPLORE ALL <img src="<?= base_url()?>images/common/next-arrow-button.svg"></a>
  </div>
 <?php }?>
<!-- end slider -arrows -->


</div>
  <!-- end top-categories-slider -->
  </div>
  <div class="tab-pane fade" id="vegetables" role="tabpanel" aria-labelledby="vegetables-tab">
      <div class="carousel-inner">
  <?php $total= count($data[1]['products']);  $cat=$data[1]['products'][0]->category_id;  $type=$data[1]['products'][0]->product_type;?>

   <?php $fruitsseq=1; for ($i=0; $i<(ceil($total/4)); $i++) { ?>
 
    <div class="carousel-item <?php if($fruitsseq=='1'){ echo 'active'; }?>">
    <ul class="product-listing">
        <?php
        $where ="status='1' AND category_id=$cat";        
        if($fruitsseq=='1')
        {
            $offset = 0;
        }else{
            $offset = $key+1;
        }

        $fruitslimt = $this->Commonmodel->fetch_by_limit_offset('promotional', $where, 4, $offset);
         foreach ($fruitslimt as $key => $fruit): ?>
           <li>
            <span><?= $fruit->name?></span>
             <?php 
            if($this->session->userdata('id')!='')
            {
                $checkFav= $this->Commonmodel->count('wishlists', "user_id=$userId AND product_id=$fruit->id AND product_type=$fruit->product_type"); 
            }
            ?>
            <a href="javascript:void(0)" onclick="addWishlist(<?=$fruit->id?>, <?=$fruit->product_type?>)" class="<?php if((@$checkFav>0) > 0){ echo 'wishlist-icon active';} else { echo 'wishlist-icon';} ?> "></a>
            <a href="<?=base_url()?>home/productDetail/<?=$fruit->id?>/<?=$fruit->product_type?>"><figure>
                 <?php if (file_exists('./uploads/products/'.$fruit->image)) { ?>
                   <img src="<?= base_url('uploads/products/').$fruit->image ?>" width="190px" height="156px" alt="<?= $fruit->name ?>">
                <?php } else { ?>
                   <img src="<?= base_url('images/home/product-1.png') ?>" class="img-responsive" alt="banner1">
                <?php } ?>
            </figure>
        </a>
            <div class="inside-location">
                <label><?= $fruit->country?></label>
                <label><?= $fruit->weight?></label>
            </div>
            <div class="price-box">
                <div class="price">₹ <?= number_format($fruit->offer_price, 2)?></div>
                <div class="discount"><strike>₹  <?= number_format($fruit->price, 2)?></strike></div>
                <div class="offer-discount"><?= $fruit->offer_percentage?>% OFF</div>

                <button onclick="addCart(<?= $fruit->id ?>,<?=$fruit->product_type?>)" class="cart-button add_cart">Add to Cart</button>
                </div>
            
            </li>
            <?php endforeach ?>
        
        </ul>
</div>
 <?php $fruitsseq++; } ?>

</div>
<!-- start slider -arrows -->
 <?php if($total>4){?>
<div class="slider-arrow">
   
    <div class="arrows">
<a class="carousel-control-prev" href="#top-categories" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#top-categories" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
  </div>

  <a href="<?=base_url()?>home/category/<?=$cat?>/<?=$type?>" class="exlpore-button">EXPLORE ALL <img src="<?= base_url()?>images/common/next-arrow-button.svg"></a>


  </div>
  <?php } ?>
<!-- end slider -arrows -->


  </div>
  <div class="tab-pane fade" id="eggs" role="tabpanel" aria-labelledby="eggs-tab">
       <div class="carousel-inner">
  <?php $total= count($eggs); @$cat=$eggs[0]->category_id; @$type=$eggs[0]->product_type;?>

   <?php $fruitsseq=1; for ($i=0; $i<(ceil($total/4)); $i++) { ?>
 
    <div class="carousel-item <?php if($fruitsseq=='1'){ echo 'active'; }?>">
    <ul class="product-listing">
        <?php
        $where ="status='1' AND category_id=$cat";        
        if($fruitsseq=='1')
        {
            $offset = 0;
        }else{
            $offset = $key+1;
        }

        $fruitslimt = $this->Commonmodel->fetch_by_limit_offset('products', $where, 4, $offset);
         foreach ($fruitslimt as $key => $fruit): ?>
           <li>
            <span><?= $fruit->name?></span>
             <?php 
            if($this->session->userdata('id')!='')
            {
                $checkFav= $this->Commonmodel->count('wishlists', "user_id=$userId AND product_id=$fruit->id AND product_type=$fruit->product_type"); 
            }
            ?>
            <a href="javascript:void(0)" onclick="addWishlist(<?=$fruit->id?>, <?=$fruit->product_type?>)" class="<?php if((@$checkFav>0) > 0){ echo 'wishlist-icon active';} else { echo 'wishlist-icon';} ?> "></a>
            <a href="<?=base_url()?>home/productDetail/<?=$fruit->id?>/<?=$fruit->product_type?>">
                <figure>
                 <?php if (file_exists('./uploads/products/'.$fruit->image)) { ?>
                    <img src="<?= base_url('uploads/products/').$fruit->image ?>" width="190px" height="156px" alt="<?= $fruit->name ?>">
                <?php } else { ?>
                    <img src="<?= base_url('images/home/product-1.png') ?>" class="img-responsive" alt="banner1">
                <?php } ?>
            </figure>
        </a>
            <div class="inside-location">
                <label><?= $fruit->country?></label>
                <label><?= $fruit->weight?></label>
            </div>
            <div class="price-box">
                <div class="price">₹ <?= number_format($fruit->offer_price, 2)?></div>
                <div class="discount"><strike>₹  <?= number_format($fruit->price, 2)?></strike></div>
                <div class="offer-discount"><?= $fruit->offer_percentage?>% OFF</div>

                <button onclick="addCart(<?= $fruit->id ?>,<?=$fruit->product_type?>)" class="cart-button add_cart">Add to Cart</button>
                </div>
            
            </li>
            <?php endforeach ?>
        
        </ul>
</div>
 <?php $fruitsseq++; } ?>

</div>
<!-- start slider -arrows -->
 <?php if($total>4){?>
<div class="slider-arrow">
    <div class="arrows">
       
<a class="carousel-control-prev" href="#top-categories" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#top-categories" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>

  </div>
  <a href="<?=base_url()?>home/category/<?=$cat?>/<?=$type?>" class="exlpore-button">EXPLORE ALL <img src="<?= base_url()?>images/common/next-arrow-button.svg"></a>


  </div>
  <?php } ?>
<!-- end slider -arrows -->

  </div>
  <div class="tab-pane fade" id="bulk" role="tabpanel" aria-labelledby="bulk-tab">
       <div class="carousel-inner">
  <?php $total= count($items); $cat=$items[0]->category_id;  @$type=$items[0]->product_type;?>

   <?php $fruitsseq=1; for ($i=0; $i<(ceil($total/4)); $i++) { ?>
 
    <div class="carousel-item <?php if($fruitsseq=='1'){ echo 'active'; }?>">
    <ul class="product-listing">
        <?php
        $where ="status='1' AND category_id=$cat";        
        if($fruitsseq=='1')
        {
            $offset = 0;
        }else{
            $offset = $key+1;
        }

        $fruitslimt = $this->Commonmodel->fetch_by_limit_offset('products', $where, 4, @$offset);
         foreach ($fruitslimt as $key => $fruit): ?>
           <li>
            <span><?= $fruit->name?></span>
             <?php 
            if($this->session->userdata('id')!='')
            {
                $checkFav= $this->Commonmodel->count('wishlists', "user_id=$userId AND product_id=$fruit->id AND product_type=$fruit->product_type"); 
            }
            ?>
            <a href="javascript:void(0)" onclick="addWishlist(<?=$fruit->id?>, <?=$fruit->product_type?>)" class="<?php if((@$checkFav>0) > 0){ echo 'wishlist-icon active';} else { echo 'wishlist-icon';} ?> "></a>
            <a href="<?=base_url()?>home/productDetail/<?=$fruit->id?>/<?=$fruit->product_type?>"><figure>
                 <?php if (file_exists('./uploads/products/'.$fruit->image)) { ?>
                    <img src="<?= base_url('uploads/products/').$fruit->image ?>" width="190px" height="156px" alt="<?= $fruit->name ?>">
                <?php } else { ?>
                    <img src="<?= base_url('images/home/product-1.png') ?>" class="img-responsive" alt="banner1">
                <?php } ?>
                

            </figure></a>
            <div class="inside-location">
                <label><?= $fruit->country?></label>
                <label><?= $fruit->weight?></label>
            </div>
            <div class="price-box">
                <div class="price">₹ <?= number_format($fruit->offer_price, 2)?></div>
                <div class="discount"><strike>₹  <?= number_format($fruit->price, 2)?></strike></div>
                <div class="offer-discount"><?= $fruit->offer_percentage?>% OFF</div>

                <button onclick="addCart(<?= $fruit->id ?>,<?=$fruit->product_type?>)" class="cart-button add_cart">Add to Cart</button>
                </div>
            
            </li>
            <?php endforeach ?>
        
        </ul>
</div>
 <?php $fruitsseq++; } ?>

</div>
<!-- start slider -arrows -->
<?php if($total>4){?>
    <div class="slider-arrow">
        <div class="arrows">
            
            <a class="carousel-control-prev" href="#top-categories" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#top-categories" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        
        </div>
        <a href="<?=base_url()?>home/category/<?=$cat?>/<?=$type?>" class="exlpore-button">EXPLORE ALL <img src="<?= base_url()?>images/common/next-arrow-button.svg"></a>


    </div>
    <?php } ?>
    <!-- end slider -arrows -->
  </div>

<!-- end slider -arrows -->

</div>
</div>
<!-- end tabs -->

        </div>
        <!-- end .product-listing-->
   


    <!-- start .common-heading-->
<div class="heading-comman container">
    <div class="top">
        <!--<span>Best Deals</span>-->
        <span>Offers and Deals Today</span>
    </div>
    </div>
    <!-- end .common-heading-->
    
    <!-- start .product-listing-->
    <div class="container slider">
    <div id="offers" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
  <?php $total= count($offers);   @$type=$offers[0]->product_type; ?>

   <?php $seq=1; for ($i=0; $i<(ceil($total/4)); $i++) { ?>
 
    <div class="carousel-item <?php if($seq=='1'){ echo 'active'; }?>">
    <ul class="product-listing">
        <?php
        $where ="status='1'";        
        if($seq=='1')
        {
            $offset = 0;
        }else{
            $offset = $key+1;
        }

        $offerslimt = $this->Commonmodel->fetch_by_limit_offset('offers', $where, 4, $offset);
         foreach ($offerslimt as $key => $offer): ?>
           <li>
            <span><?= $offer->name?></span>
             <?php 
            if($this->session->userdata('id')!='')
            {
                $checkFav= $this->Commonmodel->count('wishlists', "user_id=$userId AND product_id=$offer->id AND product_type=$offer->product_type"); 
            }
            ?>
            <a href="javascript:void(0)" onclick="addWishlist(<?=$offer->id?>, <?=$offer->product_type?>)" class="<?php if((@$checkFav>0) > 0){ echo 'wishlist-icon active';} else { echo 'wishlist-icon';} ?> "></a>
            <a href="<?=base_url()?>home/productDetail/<?=$offer->id?>/<?=$offer->product_type?>"><figure>
                 <?php if (file_exists('./uploads/products/'.$offer->image)) { ?>
                    <img src="<?= base_url('uploads/products/').$offer->image ?>" width="190px" height="156px" alt="<?= $offer->name ?>">
                <?php } else { ?>
                    <img src="<?= base_url('images/home/product-1.png') ?>" class="img-responsive" alt="banner1">
                <?php } ?>
            </figure>
        </a>
            <div class="inside-location">
                <label><?= $offer->country?></label>
                <label><?= $offer->weight?></label>
            </div>
            <div class="price-box">
                <div class="price">₹ <?= number_format($offer->offer_price, 2)?></div>
                <div class="discount"><strike>₹  <?= number_format($offer->price, 2)?></strike></div>
                <div class="offer-discount"><?= $offer->offer_percentage?>% OFF</div>

               <button onclick="addCart(<?= $fruit->id ?>,<?=$fruit->product_type?>)" class="cart-button add_cart">Add to Cart</button>
                </div>
            
            </li>
            <?php endforeach ?>
        
        </ul>
</div>
 <?php $seq++; } ?>

</div>
<!-- start slider -arrows -->
<?php if($total>4){?>
<div class="slider-arrow">
    <div class="arrows">
        
<a class="carousel-control-prev" href="#offers" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#offers" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>

  </div>
  <a href="<?=base_url('home/offers')?>" class="exlpore-button">EXPLORE ALL <img src="<?= base_url()?>images/common/next-arrow-button.svg"></a>

  </div>
  <?php } ?>
<!-- end slider -arrows -->
</div>
  <!-- end top-categories-slider -->
        </div>
    
        <div class="f-newsletter">
            <div class="container"> 
                <div class="left">
                    <span>Subscribe To Our Newsletter</span>
                    <p>Sign up with your email to get updates about new resources releases and special offers</p>
                </div>

                <div class="right">
                    <?php if ($this->session->flashdata('succ_sub')){ ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Success!</strong>
                            <?php echo $this->session->flashdata('succ_sub'); ?>
                        </div>
                    <?php } else if ($this->session->flashdata('err_sub')){ ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Error!</strong> 
                            <?php echo $this->session->flashdata('err_sub'); ?>
                        </div>
                    <?php }  else if ($this->session->flashdata('warn_sub')){ ?>
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Warning!</strong> 
                            <?php echo $this->session->flashdata('warn_sub'); ?>
                        </div>
                    <?php } ?>
                    <form id ="newsletter" method="post" action="<?=base_url('home/subscribe') ?>">
                    <input type="email" name="email" required=""  placeholder="Enter your email" />
                    <button  type="submit" name="submit">Subscribe</button>
                    </form>

                </div>

            </div>

        </div>