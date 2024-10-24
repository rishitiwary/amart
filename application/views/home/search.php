<?php 
$this->load->model('Commonmodel');
@$userId= $this->session->userdata('id'); ?>
<!-- start .page-heading -->
<div class="page-heading">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Search</li>
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
      <div class="rights">
        <div class="header-banner">
          <figure><img src="<?= base_url()?>images/categorypage/banner.png"></figure>
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
          <?php foreach ($list as $key => $lt): 
              if($lt->product_type==1)
              {

              $prdDetails = $this->Commonmodel->fetch_row('products', "product_code='$lt->product_code'");
              }
              if($lt->product_type==2)
              {
                $prdDetails = $this->Commonmodel->fetch_row('offers', "product_code='$lt->product_code'");
              }
              if($lt->product_type==3)
              {
                 $prdDetails = $this->Commonmodel->fetch_row('promotional', "product_code='$lt->product_code'");
              }
             

            ?>

            <div  class="product-box">
                <?php 
                if($this->session->userdata('id')!='')
                {
                    $checkFav= $this->Commonmodel->count('wishlists', "user_id=$userId AND product_id=$prdDetails->id AND product_type=$lt->product_type"); 
                }
                ?>
            <a href="javascript:void(0)" onclick="addWishlist(<?=$prdDetails->id?>, <?=$lt->product_type?>)" class="<?php if((@$checkFav>0) > 0){ echo 'wishlist-icon active';} else { echo 'wishlist-icon';} ?> "></a>

                <a href="<?=base_url()?>home/productDetail/<?=$prdDetails->id?>/<?=$lt->product_type?>">
                  <figure>
                <?php if (file_exists('./uploads/products/'.$prdDetails->image)) { ?>
                  <img src="<?= base_url('uploads/products/').$prdDetails->image ?>" width="190px" height="156px" alt="<?= $prdDetails->name ?>">
                <?php } else { ?>
                  <img src="<?= base_url('images/home/product-1.png') ?>" class="img-responsive" alt="banner1">
                <?php } ?>
                </figure>
                </a> 
              
              <div class="bottom">
                <span class="title"><?=$prdDetails->name?></span>
                <div class="inside-location">
                <label><?=$prdDetails->country?></label>
                <label><?= $prdDetails->weight?></label>
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
                        
             <button onclick="addCart(<?= $lt->product_code ?>,<?=$lt->product_type?>)" class="cart-button add_cart">Add to Cart</button>  
             </div>      
            <!-- start .end-right-in -->
          <?php endforeach ?>
          <?php if((count($list))==0) { ?>
            <h3>Sorry, no results found!</h3>
<p class="error">Please check the spelling or try searching for something else</p>
          <?php }?>

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
                            <a class="page-link" href="<?= $_SERVER["REQUEST_URI"].'&page=1' ?>">«</a>
                          </li>
                        <?php } ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                          <li class="page-item <?= ($this->input->get('page') == $i)? 'active' : ''; ?>">
                            <a class="page-link" href="<?=$_SERVER["REQUEST_URI"].'&page='.$i ?>">
                              <?= $i ?> 
                              <?= ($this->input->get('page') == $i)? '<span class="sr-only">(current)</span>' : ''; ?>
                            </a>
                          </li>
                        <?php endfor; ?>

                        <?php if ($this->input->get('page') && $this->input->get('page') == $total_pages){ ?>
                          <li class="disabled page-item"><a href="#" class="page-link">»</a></li>
                        <?php } else { ?>
                          <li class="page-item">
                            <a class="page-link" href="<?= $_SERVER["REQUEST_URI"].'&page='.$total_pages ?>">»</a>
                          </li>
                        <?php } ?>
                      </ul>
                    <?php endif ?>
            </nav>
          </div>
        </ul> 
      </div>
      
    </div>
  </div>
</div>
