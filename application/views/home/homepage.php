<?php $this->load->view('home/header');?>
<?php
$this->db->where(['id'=>1]);
$webContents=$this->db->get('web_contents')->first_row();

$auth=$this->session->userdata;
@$user_id=$auth['id'];
?>


        <main id="content" class="page-main">

            <!-- Block Spotlight1  -->
            <div class="so-spotlight1 mt-127" id="">
                <div class="">
                    <div class="row m-0">
                        <div class="slide-area">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box_slider pl-0">
                                <div id="sohomepage-slider-home3">
                                    <div class="slider-container" style="position:relative">
                                        <div id="so-slideshow" class="">
                                            <?php 
                                            $banners=$this->db->where(['status'=>1])->get('galleries')->result();
                                            ?>
                                            <div class="module slideshow no-margin hidden-md hidden-sm hidden-xs">
                                                <?php if(count($banners)>0){
                                                foreach($banners as $banner){
                                                ?>
                                                <div class="item">
                                                    <a href=""><img src="<?php echo base_url();?>uploads/galleries/<?php echo $banner->image;?>" alt="Offer" class="img-responsive slider-image" /></a>
                                                </div>
                                                <?php } 
                                                } ?>
                                                
                                            </div>
                                            <div class="module slideshow no-margin visible-md visible-sm visible-xs">
                                                
                                                <?php if(count($banners)>0){
                                                foreach($banners as $banner){
                                                ?>
                                                <div class="item">
                                                    <a href=""><img src="<?php echo base_url();?>uploads/galleries/<?php echo $banner->image;?>" alt="Offer" class="img-responsive slider-image" /></a>
                                                </div>
                                                <?php } 
                                                } ?>
                                                

                                            </div>
                                            <div class="loadeding"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div style="clear:both"></div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="so-spotlight2 hidden-md hidden-sm hidden-xs" style="margin-top:3px!important;">
                <div class="container">
                    <div class="module custom-polyci">
                        <div class="row box-polyci">
                            <div class="col-lg-3 col-md-3 col-sm-6 pr-0 hidden-xs">
                                <div class="banner-info banner-info2">
                                    <div class="inner">
                                        <img src="<?php echo base_url();?>public/home/Content/image/policy_2_2.png" alt="Image Client" />
                                        <div class="banner-cont">
                                            <span>FREE DELIVERY</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 pl-0 pr-0 hidden-xs">
                                <div class="banner-info banner-info3">
                                    <div class="inner">
                                        <img src="<?php echo base_url();?>public/home/Content/image/tag-32.png" alt="Image Client" />
                                        <div class="banner-cont">
                                            <span>COMPETITIVE PRICES</span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 pl-0 pr-0 hidden-xs">
                                <div class="banner-info banner-info4">
                                    <div class="inner">
                                        <img src="<?php echo base_url();?>public/home/Content/image/padlock-3-32.png" alt="Image Client" />
                                        <div class="banner-cont">
                                            <span>SAFE &amp; SECURE SHOPPING</span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 pl-0 plm">
                                <div class="banner-info banner-info1 border-right" style="background-color:#FF6600;">
                                    <img src="<?php echo base_url();?>public/home/Content/image/return-32.png" alt="Image Client" />
                                    <div class="banner-cont">
                                        <a href="#" style="color:#fff;font-size:15px;" data-toggle="modal" data-target="#myModal6">HOW IT WORKS</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="so-spotlight3 hidden-xs">
                <div class="container">
                    
                    <?php 
                    $promotional_category=$this->basic_operation->UniqueSelect('promotional_category',['status'=>1]);
                    if(count($promotional_category)>0){
                        foreach($promotional_category as $promoCategory){
                          $this->db->select('promotional.*,promotional_category.*,promotional.image as image,promotional_category.id as category_id,promotional.id as id');
                          $this->db->from('promotional');
                          $this->db->limit(16);
                          $this->db->join('promotional_category','promotional_category.id=promotional.category_id','left');
                          $this->db->where(['promotional.status'=>1,'promotional.quantity >'=>0,'category_id'=>$promoCategory->id]);
                          $fetch_promotionals= $this->db->get()->result();

                          ?>
                            <!-- Mod Category Slider -->
                            <div id="so_category_slider_home7" class="container-slider module item1" style="margin-top:25px;">
                                <div class="page-top popover-example">
                                    <a data-original-title="Fresh Fruits">
                                        <span style="font-size:25px;"><img src="<?php echo base_url();?>uploads/categories/<?php echo $promoCategory->image;?>" /></span>
                                    </a>
                                </div> 
                                <div class="modcontent">
                                    <div class="categoryslider-content products-list grid show preset01-4 preset02-4 preset03-4 preset04-2 preset05-1">
                                        <div class="item-sub-cat">
                                            <a href="" title="Banner"><img src="<?php echo base_url();?>public/home/Content/image/234X160px%20group%20sub%20image%20fruits%20image.jpg" alt="Banner" style="width:100%" /></a>
                                            <ul>
                                                <?php
                                                $this->db->select('categories.*');
                                                $this->db->from('categories');
                                                $this->db->limit(6);
                                                $this->db->order_by('id','RANDOM');
                                                $this->db->where(['categories.status'=>1,'categories.parent_category !='=>0]);
                                                $categories2 = $this->db->get()->result();
                                                ?> 
                                                <!-- Single category menu-->
                                                <?php
                                                if(count($categories2) > 0){
                                                    foreach($categories2 as $cat){
                                                ?>
                                                <li><a title="" style="text-transform :capitalize;" href="<?php echo base_url();?>home/shop/<?php echo $cat->id?>"><?php echo $cat->category; ?></a></li>
                                                <?php 
                                                    }
                                                }
                                                ?>
                                                <!-- End Single category menu-->
                                            </ul>
                                        </div>
        
                                        <div id="Fruits">
                                            <div class="slider slider-h7 so-category-slider not-js product-layout">
                                                
                                                <?php if(count($fetch_promotionals) >0){ 
                                                foreach($fetch_promotionals as $product){ 
                                                ?>
                                                <!-- Single Product layout -->
                                                <div class="item product-layout " id="item-box838">
                                                    <div class="item-inner product-thumb transition product-item-container">
                                                        <div class="left-block">
                                                            <div class="product-image-container second_img">
                                                                <div class="image">
        
                                                                    <a class="lt-image"  href="<?php echo base_url();?>home/productDetail/<?php echo $product->id;?>/<?php echo $product->product_type;?>" title="<?php echo $product->name;?>" id="">
                                                                        <img  id="productImgs" src="<?php echo base_url();?>uploads/products/<?php echo $product->image;?>" class="img-1 img-responsive lazy" alt="">
                                                                        <img  id="productImgs" src="<?php echo base_url();?>uploads/products/<?php echo $product->image;?>" class="img-2 img-responsive lazy" alt="">
                                                                    </a>
                                                                </div>
                                                            </div>
        
        
                                                        </div>
                                                        <div class="right-block">
                                                            <div class="caption">
                                                                <h4 class="item-title">
                                                                    <a href="#" title="Cherry Fresh" target="_self"><?php echo $product->name;?></a>
                                                                    <br /><span>Origin: <?php echo $product->country;?></span>
                                                                </h4>
                                                                <div class="price" id="ItemPriceBlock_481">
                                                                    <span class="price-new"><?php echo $product->offer_price;?></span> <span class="unit">/ <i><?php echo $product->weight;?></i></span>
                                                                    <br>
                                                                    <span class="price-old">₹ <?php echo $product->price;?></span>
                                                                    <span class="label label-percent"><?php echo $product->offer_percentage;?>% off</span>
                                                                    <br>
                                                                </div>
        
                                                            </div>
                                                            <div class="form-group box-info-product">
                                                                
        
                                                                <div class="col-md-12 col-sm-12 col-xs-12  no-padding-left no-padding-right pl-1 AddToCartContainer" id="AddToCartContainer<?php echo $product->id.$product->product_type;?>">
                                                                
                                                                    <?php if(!empty($user_id)){ ?>
                                                                    <form id="AddToCartForm<?php echo $product->id.$product->product_type;?>">
                                                                       <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                                                                       <input type="hidden" name="product_id" value="<?php echo $product->id;?>">
                                                                       <input type="hidden" name="product_type" value="<?php echo $product->product_type;?>">
                                                                       <input type="hidden" name="quantity" value="1">
                                                                       <input type="hidden" name="flag" value="plus">
                                                                    </form>
                                                                    <input type="button" onclick="AddToMyCart(<?php echo $product->id;?>,<?php echo $product->product_type;?>)" id="AddToCartButton<?php echo $product->id;?>" value="Add" class="btn btn-mega btn-lg btn-add-to-cart cart"  style="width:100%" />
                                                                    
                                                                    <?php }else{
                                                                    ?>
                                                                    <form id="AddToCartForm<?php echo $product->id.$product->product_type;?>">
                                                                       <input type="hidden" name="user_id" value="0">
                                                                       <input type="hidden" name="product_id" value="<?php echo $product->id;?>">
                                                                       <input type="hidden" name="product_type" value="<?php echo $product->product_type;?>">
                                                                       <input type="hidden" name="quantity" value="1">
                                                                       <input type="hidden" name="flag" value="plus">
                                                                    </form>
                                                                    <input type="button" onclick="AddToMyCart(<?php echo $product->id;?>,<?php echo $product->product_type;?>)" id="AddToCartButton<?php echo $product->id;?>" value="Add" class="btn btn-mega btn-lg btn-add-to-cart cart"  style="width:100%" />
                                                                    <?php
                                                                    }
                                                                    ?>
        
                                                                </div>
                                                               <div class="col-md-12 col-sm-12 col-xs-12  no-padding-left no-padding-right pl-1 UpdateToCartContainer" id="UpdateToCartContainer<?php echo $product->id.$product->product_type;?>">
                                                               </div> 
                                                               
        
                                                            </div>
                                                        </div>
        
                                                        <div id="loadingDiv_838" class="loadingDiv">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Single Product layout -->
                                                <?php }
                                                }
                                                ?>
                                            </div>
                                            <div id="loadingDiv_fruit" class="loadingDiv">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Mod -->
                            
                            <?php
                        }
                    }
                    ?>
                    
                    <!-- Mod Category Slider -->
                    <div id="so_category_slider_home7" class="container-slider module item1">
                        <div class="page-top popover-example">
                            <a data-original-title="Fresh Fruits" ><img src="<?php echo base_url();?>public/home/Content/image/fresh-fruits-wooden.png" /></a>
                        </div> 
                        <div class="modcontent">
                            <div class="categoryslider-content products-list grid show preset01-4 preset02-4 preset03-4 preset04-2 preset05-1">
                                <div class="item-sub-cat">
                                    <a href="" title="Banner"><img src="<?php echo base_url();?>public/home/Content/image/234X160px%20group%20sub%20image%20fruits%20image.jpg" alt="Banner" style="width:100%" /></a>
                                    <ul>
                                       <?php
                                        $this->db->select('categories.*');
                                        $this->db->from('categories');
                                        $this->db->limit(6);
                                        $this->db->order_by('id','RANDOM');
                                        $this->db->where(['categories.status'=>1,'categories.parent_category !='=>0]);
                                        $categories2 = $this->db->get()->result();
                                        ?> 
                                        <!-- Single category menu-->
                                        <?php
                                        if(count($categories2) > 0){
                                            foreach($categories2 as $cat){
                                        ?>
                                        <li><a style="text-transform :capitalize;" title="" href="<?php echo base_url();?>home/shop/<?php echo $cat->id?>"><?php echo $cat->category; ?></a></li>
                                        <?php 
                                            }
                                        }
                                        ?>
                                        <!-- End Single category menu-->
                                    </ul>
                                </div>

                                <div id="Fruits">
                                    <div class="slider slider-h7 so-category-slider not-js product-layout">
                                        
                                        <?php if(count($fetch_offers) >0){ 
                                        foreach($fetch_offers as $offer){ 
                                        ?>
                                        <!-- Single Product layout -->
                                        <div class="item product-layout " id="item-box838">
                                            <div class="item-inner product-thumb transition product-item-container">
                                                <div class="left-block">
                                                    <div class="product-image-container second_img">
                                                        <div class="image">

                                                            <a class="lt-image"  href="<?php echo base_url();?>home/productDetail/<?php echo $offer->id;?>/<?php echo $offer->product_type;?>" title="<?php echo $offer->name;?>" id="">
                                                                <img  id="productImgs" src="<?php echo base_url();?>uploads/products/<?php echo $offer->image;?>" class="img-1 img-responsive lazy" alt="">
                                                                <img  id="productImgs" src="<?php echo base_url();?>uploads/products/<?php echo $offer->image;?>" class="img-2 img-responsive lazy" alt="">
                                                            </a>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="right-block">
                                                    <div class="caption">
                                                        <h4 class="item-title">
                                                            <a href="#" title="Cherry Fresh" target="_self"><?php echo $offer->name;?></a>
                                                            <br /><span>Origin: <?php echo $offer->country;?></span>
                                                        </h4>
                                                        <div class="price" id="ItemPriceBlock_481">
                                                            <span class="price-new"><?php echo $offer->offer_price;?></span> <span class="unit">/ <i><?php echo $offer->weight;?></i></span>
                                                            <br>
                                                            <span class="price-old">₹ <?php echo $offer->price;?></span>
                                                            <span class="label label-percent"><?php echo $offer->offer_percentage;?>% off</span>
                                                            <br>
                                                        </div>

                                                    </div>
                                                    <div class="form-group box-info-product">
                                                        
                                                        <div class="col-md-12 col-sm-12 col-xs-12  no-padding-left no-padding-right pl-1 AddToCartContainer" id="AddToCartContainer<?php echo $offer->id.$offer->product_type;?>">
                                                            <?php if(!empty($user_id)){ ?>
                                                            <form id="AddToCartForm<?php echo $offer->id.$offer->product_type;?>">
                                                               <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                                                               <input type="hidden" name="product_id" value="<?php echo $offer->id;?>">
                                                               <input type="hidden" name="product_type" value="<?php echo $offer->product_type;?>">
                                                               <input type="hidden" name="quantity" value="1">
                                                               <input type="hidden" name="flag" value="plus">
                                                            </form>
                                                            <input type="button" onclick="AddToMyCart(<?php echo $offer->id;?>,<?php echo $offer->product_type;?>)" id="AddToCartButton<?php echo $offer->id;?>" value="Add" class="btn btn-mega btn-lg btn-add-to-cart cart"  style="width:100%" />
                                                            
                                                            <?php }else{
                                                            ?>
                                                            <form id="AddToCartForm<?php echo $offer->id.$offer->product_type;?>">
                                                               <input type="hidden" name="user_id" value="0">
                                                               <input type="hidden" name="product_id" value="<?php echo $offer->id;?>">
                                                               <input type="hidden" name="product_type" value="<?php echo $offer->product_type;?>">
                                                               <input type="hidden" name="quantity" value="1">
                                                               <input type="hidden" name="flag" value="plus">
                                                            </form>
                                                            <input type="button" onclick="AddToMyCart(<?php echo $offer->id;?>,<?php echo $offer->product_type;?>)" id="AddToCartButton<?php echo $offer->id;?>" value="Add" class="btn btn-mega btn-lg btn-add-to-cart cart"  style="width:100%" />
                                                            <?php
                                                            }
                                                            ?>

                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12  no-padding-left no-padding-right pl-1 UpdateToCartContainer" id="UpdateToCartContainer<?php echo $offer->id.$offer->product_type;?>">
                                                       </div>

                                                    </div>
                                                </div>

                                                <div id="loadingDiv_838" class="loadingDiv">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Single Product layout -->
                                        <?php }
                                        }
                                        ?>
                                    </div>
                                    <div id="loadingDiv_fruit" class="loadingDiv">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Mod -->
                    
                    
            
            
        
    </div>
    </div>
    <div class="so-spotlight3 visible-xs" style="margin-top:5px">
        <div class="container">
            <div class="">
                <?php
                $this->db->select('categories.*');
                $this->db->from('categories');
                $this->db->limit(8);
                $this->db->where(['categories.status'=>1,'categories.parent_category'=>0]);
                $categories = $this->db->get()->result();
                ?>
                 <?php if(count($categories) >0){ 
                 foreach($categories as $category){
                 ?>
                <div class="col-xs-6 item-block p-0" style="min-height:180px;max-height:200px;vertical-align:middle;height:auto;">
                    <a href="<?php echo base_url();?>home/shop/<?php echo $category->id;?>">
                        <img src="<?php echo base_url();?>uploads/categories/<?php echo $category->image;?>" alt="<?php echo $category->category;?>" />
                    </a>
                    <?php echo strtoupper($category->category);?>
                </div>
                <?php
                    }
                }?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal6" tabindex="-1" role="dialog" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="color-line"></div>
                <div class="modal-body" id="quick_item">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="modal-close" style="float:right"><i class="fa fa-times" aria-hidden="true"></i></button>
                    <img src="<?php echo base_url();?>public/home/Content/image/process.jpg" alt="" style="width:100%" />
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('home/footer');?>