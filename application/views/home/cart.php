<!-- start .page-heading -->
<div class="page-heading">
<div class="container">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">My Cart</li>
  </ol>
</nav>
</div>
</div>
<!-- end .page-heading -->
<div class="body-bg">
<div class="container">

<!-- start .cart -->
<div class="cart-page">
<!-- start .cart-left -->
<ul class="cart-left">
    <?php
   
    if(count($collection)>0)
    { ?>
        <?php  $subtotal=0; foreach ($collection as $key => $pro): ?>
            <li>
               <a href="<?=base_url()?>home/productDetail/<?=$pro->id?>/<?=$pro->product_type?>">
                <figure>
                    <?php if (file_exists('./uploads/products/'.$pro->image)) { ?>
                       <img src="<?= base_url('uploads/products/').$pro->image ?>" width="80px" height="56px" alt="<?= $pro->name ?>">
                    <?php } else { ?>
                        <img src="<?= base_url('images/home/pro-1.jpg') ?>" class="img-responsive" alt="banner1"></a>
                    <?php } ?>                   
                </figure>
                </a>
                <div class="product-details">
                    <div class="title"><?=$pro->name?></div>
                    <div class="desc"><?=$pro->country?></div>
                    <div class="price">₹ <?= number_format($pro->offer_price, 2)?></div>
                </div>
                <div class="qty-main">  
                    <div class="qty">
                        <input type="number" min="1" class="count1" value="<?=$pro->cart_product_quantity?>">
                        <span class="minus" onclick="updateCart('<?=$pro->cart_id?>','minus')">-</span>
                        <span class="plus" onclick="updateCart('<?=$pro->cart_id?>', 'plus')">+</span>
                </div>
            </div>
            <div class="price"><?php @$totalprice= ((@$pro->cart_product_quantity)*(@$pro->offer_price)); echo '₹ '.number_format(@$totalprice, 2);?></div>
            
            <button type="button" data-toggle="tooltip" title="Remove" class="btn" onclick="deleteCart(<?= $pro->cart_id ?>);" ><img src="<?= base_url()?>images/cart/delete-button.svg"></button>
        </li>
        <?php @$subtotal=@$totalprice + $subtotal ?>
        <?php endforeach ?>       

    <?php }else{?>

        <li>
            <h3>No Product found in your Cart list!</h3>
        </li>

   <?php }  ?>

</ul>
<!-- end .cart-left -->

<!-- start .cart-right -->
<div class="cart-right">
<div class="right-inner">
    <table class="table">
               <tbody>
                <tr>
                    <td colspan="2"  headers="">Total <?=count(@$collection)?> Items in Your Cart</td>
                </tr>   
                <!--<tr><td>Minimum order is 100AED</td></tr>-->
                </tr> 
                  <tr>
                     <td class="text-right">
                        <b>Sub Total:</b>
                     </td>
                     <td class="text-right">₹ <?= number_format(@$subtotal, 2) ?></td>
                  </tr>
               </tbody>
            </table>
   
    </div>
</div>
<!-- end .cart-right -->
 
 
</div>
<!-- end .cart -->  

<div class="cart-buttons">
<div class="shopping-continue pull-left"><a href="<?= base_url()?>">CONTINUE SHOPPING</a></div>

<div class="shopping-continue pull-right"><a href="<?= base_url('dashboard/checkout')?>">PROCEED CHECKOUT</a></div>
</div>

    </div>

</div>


 


