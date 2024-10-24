<?php $this->load->view('home/header');?>
<?php
$auth=$this->session->userdata;
@$user_id=$auth['id'];
?>
<main id="content" class="page-main">
            
<div class="main-container container">
    <ul class="breadcrumb">
        <li><a href=""><i class="fa fa-home"></i></a></li>
        <li><a href=""><?php echo $product->category;?></a></li><li><a href="#"><?php echo $product->name;?></a></li>
    </ul>
    <div class="row" style="margin-top:15px;">

        <div id="content" class="col-md-12 col-sm-12 col-xs-12 mb-0">
                <input type="hidden" value="230" id="ItemIdHidden" />
                <div class="product-view row">
                    <div class="left-content-product col-lg-12 col-xs-12 mb-0">
                        <div class="row">
                            <div class="content-product-left class-honizol col-sm-5 col-xs-12 hidden-xs">
                                <div class="large-image" id="ItemImageBlock">
                                    <img itemprop="image" class="product-image-zoom" src="<?php echo base_url();?>uploads/products/<?php echo $product->image;?>" alt="<?php echo $product->name;?>" data-zoom-image="<?php echo base_url();?>uploads/products/<?php echo $product->image;?>" alt="<?php echo $product->name;?>" title="" alt="" />
                                </div>
                            </div>
                            <div class="content-product-left visible-xs">
                                <div id="sohomepage-slider-home3">
                                    <div class="slider-container" style="position:relative">
                                        <div id="so-slideshow" class="">
                                            <div class="module slideshow no-margin">
                                                    <div class="item">
                                                        <a href="#"><img src="<?php echo base_url();?>uploads/products/<?php echo $product->image;?>" alt="<?php echo $product->name;?>" class="img-responsive slider-image" /></a>
                                                    </div>
                                            </div>
                                            <div class="loadeding"></div>
                                        </div>
                                    </div>
                                </div>


                                

                            </div>
                            <div class="content-product-right col-sm-7 col-xs-12">

                                <div class="title-product">
                                    <h1><?php echo $product->name;?></h1>
                                    
                                </div>
                                
                                <div class="product-box-desc hidden-xs">
                                    <div class="inner-box-desc">
                                        <div class="brand"><span>Category : </span><a href="#"><?php echo $product->category?></a>		</div>
                                        <div class="model"><span>Item Code : </span><?php echo $product->product_code;?></div>
                                        <div class="reward"><span>Country of Origin : <?php echo $product->country;?></span> </div>
                                    </div>
                                </div>

                                <div class="alert alert-success item-details-qty-select">
                                    <div class="product-label form-group" style="margin-bottom:0px!important">
                                        <div class="stock hidden-xs"><span>Availability:</span> <span class="status-stock">In Stock</span></div>
                                        <div class="price" id="ItemPriceBlock" style="min-height:20px;display:none;">
                                                <span class="price-new"><?php echo $product->offer_price;?></span> <span class="unit">/ <i><?php echo $product->weight;?></i></span>
                                        </div>

                                    </div>
                                    <div id="product">
                                        <div class="form-group box-info-product">
                                            
                                            <input type="hidden" id="item_qty" value="278">
                                            <div class="col-md-12 col-sm-12 col-xs-12 no-padding-left no-padding-right">

                                                        <div style="padding:0px 5px;border:1px solid #ddd;margin-bottom:5px;">
                                                            <div class="radio radio-success">
                                                                <input type="radio" name="radio1" id="radio_278" value="278" checked="" style="margin-left:0px;">
                                                                <label for="radio1">
                                                                    <?php echo $product->weight;?><strong style="font-size:14px;"> | ₹ <?php echo $product->offer_price;?></strong>&nbsp;
                                                                </label>
                                                            </div>
                                                        </div>
                                            </div>
                                            
                                            <div class="col-md-3 col-sm-12 col-xs-12  no-padding-left no-padding-right pl-1 AddToCartContainer" id="AddToCartContainer<?php echo $product->id.$product->product_type;?>">
                                
                                                <?php if(!empty($user_id)){ ?>
                                                <form id="AddToCartForm<?php echo $product->id.$product->product_type;?>">
                                                   <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                                                   <input type="hidden" name="product_id" value="<?php echo $product->id;?>">
                                                   <input type="hidden" name="product_type" value="<?php echo $product->product_type;?>">
                                                   <input type="hidden" name="quantity" value="1">
                                                   <input type="hidden" name="flag" value="plus">
                                                </form>
                                                <input type="button" onclick="AddToMyCart(<?php echo $product->id;?>,<?php echo $product->product_type;?>)" id="AddToCartButton<?php echo $product->id;?>" value="Add To Cart" class="btn btn-mega btn-lg btn-add-to-cart cart"  style="width:100%" />
                                                <?php }else{
                                                ?>
                                                <form id="AddToCartForm<?php echo $product->id.$product->product_type;?>">
                                                   <input type="hidden" name="user_id" value="0">
                                                   <input type="hidden" name="product_id" value="<?php echo $product->id;?>">
                                                   <input type="hidden" name="product_type" value="<?php echo $product->product_type;?>">
                                                   <input type="hidden" name="quantity" value="1">
                                                   <input type="hidden" name="flag" value="plus">
                                                </form>
                                                <input type="button" onclick="AddToMyCart(<?php echo $product->id;?>,<?php echo $product->product_type;?>)" id="AddToCartButton<?php echo $product->id;?>" value="Add To Cart" class="btn btn-mega btn-lg btn-add-to-cart cart"  style="width:100%" />
                                                <?php
                                                }
                                                ?>
                                                
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12  no-padding-left no-padding-right pl-1 UpdateToCartContainer" id="UpdateToCartContainer<?php echo $product->id.$product->product_type;?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>



                                <!-- Review ---->
                                <!-- end box info product -->
                                <div class="producttab hidden-xs">
                                    <div class="tabsslider  col-xs-12">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab" href="#tab-1">Description</a></li>
                                           
                                        </ul>
                                        <div class="tab-content col-xs-12">
                                            <div id="tab-1" class="tab-pane fade active in">
                                                <?php echo $product->description;?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="panel-group visible-xs" id="accordion">
                                    
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-parent="#accordion" data-toggle="collapse" class="accordion-toggle collapsed" href="#accordion-1" aria-expanded="false">Description <i class="fa fa-caret-down"></i></a>
                                            </h4>
                                        </div>
                                        <div id="accordion-1"
                                             class="panel-collapse collapse"
                                             aria-expanded="true"
                                             style="height: 0px;">
                                            <div class="panel-body">
                                               <?php echo $product->description;?> 
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div id="loadingDiv_details" class="loadingDiv">
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Product Tabs -->

            <!-- //Product Tabs -->
            <!-- Related Products -->

        </div>
        <div class="col-md-9 col-xs-12">
            <div class="related titleLine products-list grid module item1">
                <h3 class="modtitle"><span>More Options</span></h3>
                <div class="releate-products">
                    
                       <!-- Single Product Layout -->
                        <!--<div class="product-layout">-->
                        <!--    <div class="product-item-container">-->
                        <!--        <div class="left-block">-->
                        <!--            <div class="product-image-container second_img">-->
                        <!--                <div class="image">-->
                        <!--                    <a class="lt-image" href="#" target="_self" title="Blackberries" id="ItemImageBlock_229">-->
                        <!--                        <img src="Images/ProductImages/imagepath/b5ec97be-bd9c-493c-be84-59c1f3821abe.jpg" class="img-1 img-responsive" alt="">-->
                        <!--                        <img src="Images/ProductImages/imagepath/b5ec97be-bd9c-493c-be84-59c1f3821abe.jpg" class="img-2 img-responsive" alt="">-->
                        <!--                    </a>-->
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--        <div class="right-block">-->
                        <!--            <div class="caption">-->
                        <!--                <h4 class="item-title">-->
                        <!--                    <a href="#" title="Blackberries" target="_self">Blackberries</a>-->
                        <!--                    <br /><span>Origin: Mexico</span>-->
                        <!--                </h4>-->
                        <!--                <div class="price" id="ItemPriceBlock_229">-->
                        <!--                    <span class="price-new">₹ 15.50 </span> <span class="unit">/ <i>1PKT</i></span><br />-->
                        <!--                    <span class="unit">(Approx. 170g)</span>-->
                        <!--                    <input type="hidden" id="itemprice_0" value="15.50" />-->
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--            <div class="form-group box-info-product">-->
                        <!--                <div class="col-md-6 col-sm-6 col-xs-6 no-padding-left no-padding-right">-->
                        <!--                    <select class="form-control qty-select-box" data-itemid="229" data-val="true" data-val-number="The field _item_price_id must be a number." data-val-required="The _item_price_id field is required." id="_item_price_id229" name="_item_price_id"><option value="277">1PKT</option>-->
                        <!--                    </select>-->
                        <!--                </div>-->
                        <!--                <div class="col-md-6 col-sm-6 col-xs-6 pl-1 no-padding-right">-->
                                            
                        <!--                        <div class="option quantity hidden" id="qty-cart229">-->
                        <!--                            <div class="input-group quantity-control" unselectable="on" style="-webkit-user-select: none;">-->
                        <!--                                <input class="form-control" type="text" name="quantity229"-->
                        <!--                                       value="1" readonly id="quantity229">-->
                        <!--                                <input type="hidden" name="product_id229" value="50">-->
                        <!--                                <span class="input-group-addon product_quantity_down" onclick="UpdateCart_Qty(229,'Blackberries','_/Images/ProductImages/imagepath/b5ec97be-bd9c-493c-be84-59c1f3821abe.html')">−</span>-->
                        <!--                                <span class="input-group-addon product_quantity_up" onclick="AddToCart_Qty(229,'Blackberries','_/Images/ProductImages/imagepath/b5ec97be-bd9c-493c-be84-59c1f3821abe.html')">+</span>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!--                        <input type="button" data-toggle="tooltip" title="" value="Add" data-loading-text="Loading..." id="button-cart229" class="btn btn-mega btn-lg btn-add-to-cart cart" onclick="AddToCart_Qty(229,'Blackberries','_/Images/ProductImages/imagepath/b5ec97be-bd9c-493c-be84-59c1f3821abe.html')" style="width:100%" />-->
                        <!--                </div>-->
                                        
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--        <div id="loadingDivDetials" class="loadingDiv">-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <!-- End Single Product layout -->
                        <?php if(count($similer_data) >0){ 
                        foreach($similer_data as $product){ 
                        ?>
                        <!-- Single Product layout -->
                        <div class="item product-layout " id="item-box838">
                            <div class="item-inner product-thumb transition product-item-container">
                                <div class="left-block">
                                    <div class="product-image-container second_img">
                                        <div class="image">

                                            <a class="lt-image"  href="<?php echo base_url();?>home/productDetail/<?php echo $product->id;?>/<?php echo $product->product_type;?>" title="<?php echo $product->name;?>" id="ItemImageBlock_838">
                                                <img id="productImgs" src="<?php echo base_url();?>uploads/products/<?php echo $product->image;?>" class="img-1 img-responsive lazy" alt="">
                                                <img id="productImgs" src="<?php echo base_url();?>uploads/products/<?php echo $product->image;?>" class="img-2 img-responsive lazy" alt="">
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
                                        <div class="price" id="ItemPriceBlock_838">
                                            <span class="price-new">₹ <?php echo $product->offer_price;?> </span> <span class="unit">/ <i><?php echo $product->weight;?></i></span>
                                            <br />
                                            <span class="unit"></span>
                    
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
            </div>
            <div class="module tags-product titleLine visible-xs" style="margin-top:20px;">
                <h3 class="modtitle"><span>Quick Explore</span></h3>
                <div class="modcontent" style="margin-top: 20px;">
                    <ul class="tags_cloud">
                        <li><a href="#" class="button_grey">Fresh Fruits</a></li>
                        <li><a href="#" class="button_grey">Fresh Veggies</a></li>
                        <li><a href="#" class="button_grey">Cut Fruits &amp; Veggies</a></li>
                        <li><a href="#" class="button_grey">Ice Creams</a></li>
                        <li><a href="#" class="button_grey">Fresh Juices</a></li>
                        <li><a href="#" class="button_grey">Fresh Soups &amp; Salads</a></li>

                    </ul>
                </div>
            </div>

        </div>

        <div class="col-md-3 hidden-xs">
            <div class="module latest-product titleLine item1 ">
                <h3 class="modtitle"><span>Related Item</span></h3>
                <div class="modcontent ">
                        
                        <?php if(count($similer_data) >0){ 
                        foreach($similer_data as $product){ 
                        ?>
                        <div class="product-latest-item">
                            <div class="media">
                                <div class="media-left">
                                    <a href="<?php echo base_url();?>home/productDetail/<?php echo $product->id;?>/<?php echo $product->product_type;?>"><img src="<?php echo base_url();?>uploads/products/<?php echo $product->image;?>" alt="" title="" class="img-responsive" style="width: 90px; height: 90px;"></a>
                                </div>

                                <div class="media-body">
                                    <div class="caption">
                                        <h4><a href="#"><?php echo $product->name;?></a><br /><span>Country of origin : <?php echo $product->country;?></span></h4>

                                        <div class="price">
                                            <span class="price-new-small"><?php echo $product->offer_price;?></span><span class="unit">/ <i>1PKT</i></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                         <?php
                             }
                         }?>
                </div>
            </div>

        </div>
    </div>
</div>
</main>

<?php $this->load->view('home/footer');?>

