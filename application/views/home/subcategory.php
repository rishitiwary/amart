<?php @$userId= $this->session->userdata('id'); ?>
<!-- start .page-heading -->
<div class="page-heading">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="<?=base_url()?>home/category/<?=$category?>">Category</a></li>
      </ol>
    </nav>
  </div>
</div>
<!-- end .page-heading -->

<div class="body-bg">
  <div class="container">
    <!-- start .category-main -->
    <div class="category-main">
      <!--start cetegory right-->
      <div class="right">
        <div class="header-banner">
          <figure><img src="<?= base_url()?>images/categorypage/banner.png"></figure>
          <strong><?=@$cat->category ?></strong>
          <!-- <p>Lorem ipsum is a dummy content that is placed instead of text in the document.Lorem ipsum is a dummy content that is placed instead of text in the document.</p> -->
        </div>

        <ul class="filter-bar">
          <div class="box-left">
            <p id="mygrid" href="" class="grid-box">Grid</p>
            <p id="mylist" href="" class="list-box">List</p>
            <p>There are <?=count(@$list)?> Products.</p>
          </div>

          <div class="box-right">
            <span>Sort by :</span>
            <div class="dropdown">
               <select class="form-control sel-sercat" onchange="updateSort($(this).val())">
                <option value="" selected="">Relevance</option>
                <option value="asc" <?php if(@$_GET['sort']=='asc')  echo 'selected'; ?>>Name A - Z</option>
                <option value="desc" <?php if(@$_GET['sort']=='desc')  echo 'selected'; ?>>Name Z - A</option>
                <option value="low_to_high" <?php if(@$_GET['sort']=='low_to_high')  echo 'selected'; ?>>Price Low to High</option>
                <option value="high_to_low" <?php if(@$_GET['sort']=='high_to_low')  echo 'selected'; ?>>Price High to Low</option>                       
              </select>
            </div>
          </div>
        </ul>


        <div id="grid" class="prodect-right-box">
          <?php foreach ($list as $key => $lt): ?>
            <!-- start .apple-right-in -->
            <div class="product-box">
               <?php 
            if($this->session->userdata('id')!='')
            {
                $checkFav= $this->Commonmodel->count('wishlists', "user_id=$userId AND product_id=$lt->id AND product_type=$lt->product_type"); 
            }
            ?>
            <a href="javascript:void(0)" onclick="addWishlist(<?=$lt->id?>, <?=$lt->product_type?>)" class="<?php if((@$checkFav>0) > 0){ echo 'wishlist-icon active';} else { echo 'wishlist-icon';} ?> "></a>
               <a href="<?=base_url()?>home/productDetail/<?=$lt->id?>/<?=$lt->product_type?>">
                <figure>
                <?php if (file_exists('./uploads/products/'.$lt->image)) { ?>
                  <img src="<?= base_url('uploads/products/').$lt->image ?>" width="190px" height="156px" alt="<?= $lt->name ?>">
                <?php } else { ?>
                  <img src="<?= base_url('images/home/product-1.png') ?>" class="img-responsive" alt="banner1">
                <?php } ?>
                 </figure>
              </a>
             
              <div class="bottom">
                <span class="title"><?=$lt->name?></span>
                 <div class="inside-location">
                <label><?=$lt->country?></label>
                <label><?= $lt->weight?></label>
              </div>
                <div class="heading">
                  <span class="offer-price">₹ <?= number_format($lt->offer_price, 2)?></span>
                    <?php
                    if($lt->offer_percentage!="0" && $lt->offer_price!=$lt->price){
                    ?>
                    <span class="price"><strike>₹  <?= number_format($lt->price, 2)?></strike></span>
                    
                  <span class="offer"><?= $lt->offer_percentage?>% OFF</span>
                  <?php } ?>
                </div>
              </div>
              <button onclick="addCart(<?= $lt->id ?>,<?=$lt->product_type?>)" class="cart-button add_cart">Add to Cart</button>  
            </div>        
            <!-- start .end-right-in -->
          <?php endforeach ?>
          <?php if((count($list))==0) echo 'No Data Found'; ?>

        </div>

        <ul class="bottom-breadcrumbs">
          <div class="showing-left">
            <p>Showing 1 - <?= $per_page ?> of <?= $total_row ?> items</p>
          </div>

          <div class="showing-right">
             <nav aria-label="Page navigation example">
              <?php if ($total_pages > 0): ?>
                      <ul class="pagination">
                        <?php if (!$this->input->get('page') || $this->input->get('page') == 1){ ?>
                          <li class="disabled page-item"><a href="#" class="page-link">«</a></li>
                        <?php } else { ?>
                          <li class="page-item"> 
                            <a class="page-link" href="<?= current_url().'?page=1' ?>">«</a>
                          </li>
                        <?php } ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                          <li class="page-item <?= ($this->input->get('page') == $i)? 'active' : ''; ?>">
                            <a class="page-link" href="<?= current_url().'?page='.$i ?>">
                              <?= $i ?> 
                              <?= ($this->input->get('page') == $i)? '<span class="sr-only">(current)</span>' : ''; ?>
                            </a>
                          </li>
                        <?php endfor; ?>

                        <?php if ($this->input->get('page') && $this->input->get('page') == $total_pages){ ?>
                          <li class="disabled page-item"><a href="#" class="page-link">»</a></li>
                        <?php } else { ?>
                          <li class="page-item">
                            <a class="page-link" href="<?= current_url().'?page='.$total_pages ?>">»</a>
                          </li>
                        <?php } ?>
                      </ul>
                    <?php endif ?>
            </nav>
          </div>
        </ul>
      </div>
      <!-- end .category-main -->
      <div class="left">
        <div class="category-box-heading">
          <span class="text-cate">Related All Category</span>    
        </div>

        <div class="category-box">
          <ul>
            <?php if(count($subcatlist)>0) { ?>
            <?php foreach ($subcatlist as $key => $sub): ?>           
            <li> <a href="<?=base_url()?>home/subcategory/<?=$category?>/<?=$sub->id?>"><?=$sub->category?></a>  </li>
             <?php endforeach ?>
           <?php } else{?>
              <li> <a href="#">No Category Found</a>  </li>
           <?php } ?>
            
          </ul>
        </div>

        <div class="category-box-heading">
          <span class="text-cate">Best Selling</span>    
        </div>

        <!--start .sidebar-products-->
        <div class="sidebar-products">
          <?php foreach ($bestsellinglist as $key => $bes): ?>
          <!-- start .sidebar-products-list -->
          <a href="<?=base_url()?>home/productDetail/<?=$bes->id?>/<?=$bes->product_type?>" class="sidebar-products-list">
            <div class="left">
            <?php
            if($bes->offer_percentage!="0" && $bes->offer_price!=$bes->price){
            ?>
              <span class="text-off"><?= $bes->offer_percentage?>% OFF</span>
              <?php } ?>
              <div class="text-img-box">
                <?php if (file_exists('./uploads/products/'.$bes->image)) { ?>
                  <img src="<?= base_url('uploads/products/').$bes->image ?>" alt="<?= $bes->name ?>">
                <?php } else { ?>
                  <img src="<?= base_url()?>images/categorypage/apple.png" class="img-responsive" alt="banner1">
                <?php } ?>    
                
                </div>
            </div>
            <div class="right">
              <span class="title"><?= $bes->name?></span><br/>
              <span class="subtitle"> <?= $bes->country?></span>
              <p class="price">₹ <?= number_format($bes->offer_price, 2)?></p>
               <?php
                if($bes->offer_percentage!="0" && $bes->offer_price!=$bes->price){
                ?>
              <p class="discount"><strike>₹ <?= number_format($bes->price, 2)?></strike></p>
                <?php } ?>
            </div>

          </a>    
          <!-- end .sidebar-products-list -->
            <?php endforeach ?>          
          <a href="<?=base_url('home/category/1/3')?>" class="all-products-button">ALL PRODUCTS</a>
        </div>
        <!--end .sidebar-products-->

        <div class="category-box-heading">
          <span class="text-cate">All Offers</span>    
        </div>

        <!--start .sidebar-products-->
        <div class="sidebar-products">
          <?php foreach ($offerslist as $key => $off): ?>
          <!-- start .sidebar-products-list -->
          <a href="<?=base_url()?>home/productDetail/<?=$off->id?>/<?=$off->product_type?>" class="sidebar-products-list">
            <div class="left">
                <?php
                if($off->offer_percentage!="0" && $off->offer_price!=$off->price){
                ?>
                    <span class="text-off"><?= $off->offer_percentage?>% OFF</span>
              <?php } ?>
              <div class="text-img-box">
                <?php if (file_exists('./uploads/products/'.$off->image)) { ?>
                  <img src="<?= base_url('uploads/products/').$off->image ?>" alt="<?= $off->name ?>">
                <?php } else { ?>
                  <img src="<?= base_url()?>images/categorypage/apple.png" class="img-responsive" alt="banner1">
                <?php } ?>                
              </div>
            </div>
            <div class="right">
              <span class="title"><?= $off->name ?></span><br/>
              <span class="subtitle"> <?= $off->country?></span>
              <p class="price">₹ <?= number_format($off->offer_price, 2)?></p>
              <?php
                if($off->offer_percentage!="0" && $off->offer_price!=$off->price){
                ?>
              <p class="discount"><strike>₹ <?= number_format($off->price, 2)?></strike></p>
              <?php } ?>
            </div>
          </a>    
          <!-- end .sidebar-products-list -->
          <?php endforeach ?>
          <?php if((count($offerslist))==0) echo 'No Offers Found'; ?>

          <a href="<?=base_url('home/offers')?>" class="all-products-button">ALL OFFERS</a>
        </div>
        <!--end .sidebar-products-->
      </div>
      <!--end category main-->
    </div>
  </div>
</div>


