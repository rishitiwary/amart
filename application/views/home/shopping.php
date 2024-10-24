<?php $this->load->view('home/header');?>
<?php
$auth=$this->session->userdata;
@$user_id=$auth['id'];
?>
<main id="content" class="page-main">
<div class="main-container container mt--80">
    <ul class="breadcrumb">
        <li><a href="<?php echo base_url();?>home"><i class="fa fa-home"></i></a></li>
        <li><a href="#"><?php echo $categoryDetail[0]->category; ?></a></li>
    </ul>
    <div class="row" style="margin-top:15px;">
        <!--Left Part Start -->
        <aside class="col-sm-4 col-md-3 hidden-xs" id="column-left">
            <div class="module block-shopby titleLine">
                <h3 class="modtitle"><span><?php echo $categoryDetail[0]->category; ?> </span></h3>
                <div class="modcontent ">
                    <div class="type_2">
                        <div class="table_layout filter-shopby">
                            <div class="table_row">
                                <div class="table_cell">
                                    <fieldset>
                                        <ul class="checkboxes_list">

                                                <li>
                                                    <a href="" style="font-size:14px"><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;Regular Fruits</a>
                                                </li>
                                                
                                        </ul>

                                    </fieldset>

                                </div><!--/ .table_cell -->

                            </div><!--/ .table_row -->

                        </div><!--/ .table_layout -->
                    </div>



                </div>
            </div>
            <div class="module latest-product titleLine item1" style="margin-top:30px">
                <h3 class="modtitle"><span>Recommended</span></h3>
                <div class="modcontent ">
                 <?php 
    			   if(count($recommended_data) > 0){
    				   foreach($recommended_data as $product){
    			 ?> 
                        <div class="product-latest-item">
                            <div class="media">
                                <div class="media-left">
                                    <a href="<?php echo base_url();?>home/productDetail/<?php echo $product->id;?>/<?php echo $product->product_type;?>"><img src="<?php echo base_url();?>uploads/products/<?php echo $product->image;?>" alt="" title="" class="img-responsive" style="width: 90px; height: 90px;"></a>
                                </div>

                                <div class="media-body">
                                    <div class="caption">
                                        <h4><a href=""><?php echo $product->name;?></a><br /><span>Country of origin : <?php echo $product->country;?></span></h4>

                                        <div class="price">
                                            <span class="price-new-small">₹ <?php echo $product->offer_price;?></span><span class="unit">/ <i><?php echo $product->weight;?></i></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                <?php }
                }
                ?>
                </div>
            </div>

        </aside>
        
        <div id="content" class="col-md-9 col-sm-8">
            <div class="products-category">
                
             
                <div class="product-filter filters-panel">
                    <div class="row">
                        <div class="col-md-10">
                            <span><i class="fa fa-search" aria-hidden="true"></i> <?php echo $categoryDetail[0]->category; ?></span>
                        </div>
                    </div>
                </div>
                <br>
                <!-- //end Filters -->
                <!--changed listings-->
                <div id="itemlistpartial" class="products-list row list">
                 <?php 
    			   if(count($fetch_data) > 0){
    				   foreach($fetch_data as $product){
    			 ?>   
                <div class="product-layout  col-md-3 col-sm-6 col-xs-6 " id="item-box230">
        <div class="product-item-container no-padding">
            <div class="left-block">
                <div class="product-image-container">
                    <a href="<?php echo base_url();?>home/productDetail/<?php echo $product->id;?>/<?php echo $product->product_type;?>">
                        <img id="productImgs" src="<?php echo base_url();?>uploads/products/<?php echo $product->image;?>" class="img-1 img-responsive lazy" alt="App">
                        <img id="productImgs" src="<?php echo base_url();?>uploads/products/<?php echo $product->image;?>" class="img-2 img-responsive lazy" alt="">
                    </a>
                </div>
             </div>
            <div class="right-block">
                <div class="caption">
                    <h4 class="item-title">
                        <a href="" title="Blueberries-1pkt" target="_self"> <?php echo $product->name;?></a>
                        <br /><span>Origin: <?php echo $product->country;?></span>
                    </h4>
                    <div class="price" id="ItemPriceBlock_230">
                        <span class="price-new">₹ <?php echo $product->offer_price;?></span> <span class="unit">/ <i><?php echo $product->weight;?></i></span>
                        <br />
                        <span class="unit "></span>
                        
                    </div>

                    <div class="description item-desc hidden">
                        <?php echo $product->description;?>
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
                            <input type="button" onclick="AddToMyCart(<?php echo $product->id;?>,<?php echo $product->product_type ?>)" id="AddToCartButton<?php echo $product->id;?>" value="Add" class="btn btn-mega btn-lg btn-add-to-cart cart"  style="width:100%" />
                            
                            <?php }else{
                            ?>
                            <form id="AddToCartForm<?php echo $product->id.$product->product_type;?>">
                               <input type="hidden" name="user_id" value="0">
                               <input type="hidden" name="product_id" value="<?php echo $product->id;?>">
                               <input type="hidden" name="product_type" value="<?php echo $product->product_type;?>">
                               <input type="hidden" name="quantity" value="1">
                               <input type="hidden" name="flag" value="plus">
                            </form>
                            <input type="button" onclick="AddToMyCart(<?php echo $product->id;?>,<?php echo $product->product_type ?>)" id="AddToCartButton<?php echo $product->id;?>" value="Add" class="btn btn-mega btn-lg btn-add-to-cart cart"  style="width:100%" />
                            <?php
                            }
                            ?>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12  no-padding-left no-padding-right pl-1 UpdateToCartContainer" id="UpdateToCartContainer<?php echo $product->id.$product->product_type;?>">
                    </div>

                </div>
            </div>
            <!-- right block -->
        </div>
    </div>
                <?php
                    }
                }
               
                ?>
                </div>
            </div>
        </div>
        <!--Middle Part End-->
    </div>
</div>
</main>

<?php $this->load->view('home/footer');?>

