  <div class="container">
    <!--start .my-account -->
    <div class="my-account-page">

      <div class="left-sidebar">
        <ul>
          <li><a href="<?= base_url('dashboard') ?>">My Orders</a></li>
          <li><a href="<?= base_url('dashboard/address') ?>">Address</a></li>
          <li class="active"><a href="<?= base_url('dashboard/favourite') ?>">Favourite</a></li>
          <li ><a href="<?= base_url('dashboard/password') ?>">Change Password</a></li>
          <li><a href="<?= base_url('dashboard/profile') ?>">Personal Details</a></li>
        </ul>
      </div>

      <div class="right-bx">

        <div class="bx-header">
          <label>My Favorites List</label>
        </div>

        <div class="bottom-box">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Product image</th>
                  <th scope="col">Product Name</th>
                  <th scope="col">Unit Price</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($myfav as $key => $fav): ?>
                   <tr>
                  <th scope="row">
                    <a href="<?=base_url()?>home/productDetail/<?=$fav->id?>/<?=$fav->product_type?>">
                      <figure>
                        <?php if (file_exists('./uploads/products/'.$fav->image)) { ?>
                          <img src="<?= base_url('uploads/products/').$fav->image ?>" width="60px" height="30px" alt="<?= $fav->name ?>">
                        <?php } else { ?>
                          <img src="<?= base_url('images/home/product-1.png') ?>" width="60px" height="30px" class="img-responsive" alt="banner1">
                        <?php } ?>
                      </figure>
                    </a>

                  </th>
                  <td><?=$fav->name?></td>
                  <td>₹ <?= number_format($fav->offer_price, 2)?></td>
                  <td>
                    <button type="button" data-toggle="tooltip" title="Remove From Wishlist" class="btn btn-danger" onclick="deletewishlist('<?= $fav->wishlist_id ?>');" ><i class="fa fa-times-circle"></i></button>
                  </td>
                </tr>                  
                <?php endforeach ?>

              </tbody>
            </table>     
          </div>

        </div>

      </div>

    </div>
    <!--end .my-account -->
  </div>

