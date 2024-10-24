<div class="container">
<br>
<?php if($this->session->flashdata('success')){?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong><?php echo $this->session->flashdata('success'); ?></strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php } ?>
<!--start .my-account -->
<div class="my-account-page">

<div class="left-sidebar">
    <ul>
        <li class="active"><a href="<?= base_url('dashboard') ?>">My Orders</a></li>
        <li><a href="<?= base_url('dashboard/address') ?>">Address</a></li>
        <li><a href="<?= base_url('dashboard/favourite') ?>">Favourite</a></li>
        <li><a href="<?= base_url('dashboard/password') ?>">Change Password</a></li>
        <li><a href="<?= base_url('dashboard/profile') ?>">Personal Details</a></li>
    </ul>
</div>

<div class="right-bx">
    <div class="bx-header">
        <label>MY ORDERS</label>        
        <div class="right-select">
            <span>Sort by :</span>
             <div class="srt-by">
            <select class="dropdown" id="orderData">            
            <option value="all">All</option>
            <option value="com">Complete Order</option>
            <option value="can">Cancelled Order</option>
        </select> 
         </div>       
        </div>
    </div>
<div class="bottom-box">
<div class="table-responsive">
  <div class="all box">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Order Id</th>
          <th scope="col">Total</th>
          <th scope="col">Status</th>
          <th scope="col">Date</th>
          <th scope="col">Invoice</th>
          <th scope="col">Action</th>   
        </tr>
      </thead>
      <tbody>
        <?php foreach ($all as $key => $acc): ?>
          <tr>
              <!-- Modal -->
              <div class="modal fade" id="myModal<?= $acc->order_id; ?>" role="dialog">
                <div class="modal-dialog">
                 
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                      <h4 class="modal-title">Order Cancellation</h4>
                    </div>
                   <form action="<?=base_url()?>api/CancelledOrder" name="cancel_form" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                          <label for="exampleFormControlTextarea1">Please choose reason for cancellation</label>
                         <select class="form-control" name="option_message" id="option_message" required>
                            <option value="">No Selected</option>
                            <?php foreach($cancel_message as $row):?>
                            <option value="<?php echo $row->message;?>"><?php echo $row->message;?></option>
                            <?php endforeach;?>
                        </select>
                        </div>
                        <div class="form-group">
                          <textarea class="form-control rounded-0" id="message" name="message" placeholder="Comments(Optional)" ></textarea>
                          <input type="hidden" id="order_id" name="order_id" value="<?= $acc->order_id; ?>">
                          <input type="hidden" id="user_id" name="user_id" value="<?= $acc->user_id; ?>">
                          <input type="hidden" id="status" name="status" value="3">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                  </div>
                  
                </div>
              </div>
            <th scope="row"><?=$acc->order_id?></th>
            <td>₹ <?=number_format(@$acc->transection_amount, 2)?></td>
            <td>
              <?php 
              if ($acc->status == "3") { echo 'Cancelled';
              } else if ($acc->status == "1") {
                echo 'Delivered';
              }else {
                echo 'Pending';
              } ?>            
          </td>
            <td><?= date('d-m-Y', strtotime(@$acc->booking_date))?></td>
            <td>
                <?php if ($acc->status != "3") {?>
              <a href="<?=base_url()?>dashboard/orderDetails/<?=$acc->order_id?>" class="btn btn-primary" target="_blank" data-toggle="tooltip" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i> 
              </a><?php } ?>
            </td>
            <td><?php if ($acc->status != "3"  && $acc->status != "1") {?>
            <!--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal<?= $acc->order_id; ?>">Cancel</button>-->
            <button type="button" data-toggle="modal" data-target="#myModal<?= $acc->order_id; ?>" title="Cancel" class="btn btn-danger"  ><i class="fa fa-times-circle"></i></button>
            <?php } ?></td>
          </tr>
        <?php endforeach ?>
        <?php if(count($all)=='0') {?>
        <tr>
          <td colspan="5"> No Orders Found</td>
        </tr>
      <?php } ?>
      </tbody>
    </table>     
    </div>
    <div class="com box">
      <table class="table">
      <thead>
        <tr>
          <th scope="col">Order Id</th>
          <th scope="col">Total</th>
          <th scope="col">Status</th>
          <th scope="col">Date</th>
          <th scope="col">Invoice</th>
          <th scope="col">Action</th>              
        </tr>
      </thead>
      <tbody>
        <?php foreach ($normal as $key => $acc): ?>
          <tr>
            <th scope="row"><?=$acc->order_id?></th>
            <td>₹ <?=number_format(@$acc->transection_amount, 2)?></td>
            <td>
              <?php 
              if ($acc->status == "3") { echo 'Cancelled';
              } else if ($acc->status == "1") {
                echo 'Delivered';
              }else {
                echo 'Pending';
              } ?>            
          </td>
            <td><?= date('d-m-Y', strtotime(@$acc->booking_date))?></td>
            <td>
                <?php if ($acc->status != "3") {?>
              <a href="<?=base_url()?>dashboard/orderDetails/<?=$acc->order_id?>" class="btn btn-primary" target="_blank" data-toggle="tooltip" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i> 
              </a><?php } ?>
            </td>
            <td><?php if ($acc->status != "3") {?><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal<?= $acc->order_id; ?>">Cancel</button><?php } ?></td>
          </tr>
        <?php endforeach ?>
        <?php if(count($normal)=='0') {?>
        <tr>
          <td colspan="5"> No Orders Found</td>
        </tr>
      <?php } ?>
      </tbody>
    </table>  
    </div>
    <div class="can box">
      <table class="table">
      <thead>
        <tr>
          <th scope="col">Order Id</th>
          <th scope="col">Total</th>
          <th scope="col">Status</th>
          <th scope="col">Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cancelled as $key => $acc): ?>
          <tr>
            <th scope="row"><?=$acc->order_id?></th>
            <td>₹ <?=number_format(@$acc->transection_amount, 2)?></td>
            <td>
              <?php 
              if ($acc->status == "3") { echo 'Cancelled';
              } else if ($acc->status == "1") {
                echo 'Delivered';
              }else {
                echo 'Pending';
              } ?>            
          </td>
            <td><?= date('d-m-Y', strtotime(@$acc->booking_date))?></td>
          </tr>
        <?php endforeach ?>
        <?php if(count($cancelled)=='0') {?>
        <tr>
          <td colspan="5"> No Orders Found</td>
        </tr>
      <?php } ?>
      </tbody>
    </table>        
    </div>

        
      </div>
 
    </div>

</div>

</div>
<!--end .my-account -->
</div>


