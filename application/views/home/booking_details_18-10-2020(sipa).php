<?php //echo "<pre>";print_r($fetch_data);exit;?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Ashamart </title>
<link rel="stylesheet" href="<?=base_url('css/bootstrap.min.css')?>">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="<?=base_url('js/bootstrap.min.js')?>"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,700;1,600&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="<?=base_url('images/common/logo.png')?>">
</head>
<body style="margin: 0; padding: 0;">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  style="background:#efefef">
<tr>
<td>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family: 'Poppins', sans-serif; background: #fff">
<tbody>
<tr>
<td>
<table width="100%" align="center">
    <tr>
        <td align="center" style="border-bottom: 8px solid green; padding: 10px 0">
            <img src="<?=base_url('images/common/logo.png')?>" width="75" height="100" alt="Ashamart"/></td>
        </tr>
    </table>
    <table width="100%" align="center" style="background: #F5F5F5">
        <tr>
            <td height="100" align="center" valign="bottom"><img src="<?=base_url('images/common/tick.png')?>" width="59" height="59" alt="Ashamart"/></td>
        </tr>
        <tr>
            <td height="70" align="center" valign="top" style="font-size: 20px; font-weight: bold">Thank You for your order at Ashamart</td>
        </tr>
    </table>

    <table width="100%" align="center" style="background: #E3E3E3; padding: 30px 30px; font-size: 14px">
        <tr>
            <td width="50%" align="left" valign="top">
                <table>
                    <tr><td><strong>Order No -</strong></td></tr>
                    <tr><td><?= @$fetch_data[0]->order_id; ?></td></tr>
                    <tr><td height="10"></td></tr>
                    <tr><td><strong>Booking Date</strong></td></tr>
                    <tr><td><?php echo date("F j, Y",strtotime($fetch_data[0]->booking_date)) ?></td></tr>
                    <td></td>  
                </table>
            </td>

            <td width="50%" align="left" valign="top">
                <table>
                    <tr><td><strong>Delivery Date</strong></td></tr>
                    <tr><td><?php echo date("F j, Y",strtotime($fetch_data[0]->delivery_date)) ?></td></tr>
                    <tr><td><strong>Delivery Address</strong></td></tr>
                    <tr><td height="10"></td></tr>
                    <tr><td><strong><?= @$fetch_data[0]->name; ?></strong></td></tr>
                    <tr><td><?= @$fetch_data[0]->address; ?></td></tr>
                    <tr><td><strong>Mobile - <?= @$fetch_data[0]->mobile; ?></strong></td></tr>
                </table>
            </td>
        </tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0" style="background: #fff;  font-size: 14px">
        <tr style="background: #F5F5F5; font-weight: bold">
            <td style="padding-left:30px" height="40" valign="middle">Sr. No</td>
            <td style="padding-left:30px" height="40" valign="middle">Item Details</td>
            <td style="padding-left:30px" height="40" valign="middle">Qty</td>
            <td style="padding-left:30px" height="40" valign="middle">Unite Price</td>
            <td style="padding-left:30px" height="40" valign="middle">Sub Total</td>
        </tr>

        <?php
        if(count($fetch_data) > 0)  
        {  
            $counter=1;
            $subTotal=0;

            foreach($fetch_data as $row)  
            { 
                $subTotal+=($row->cart_product_quantity*$row->offer_price);  
                ?> 

                <tr>
                    <td style="padding-left:30px; border-bottom: 1px solid #F5F5F5 " height="40"><?=@$counter?></td>
                    <td style="padding-left:30px; border-bottom: 1px solid #F5F5F5" height="40">[<?=@$row->product_code; ?>] <?=@$row->product_name; ?></td>
                    <td style="padding-left:30px; border-bottom: 1px solid #F5F5F5" height="40"><?=@$row->cart_product_quantity?></td>
                    <td style="padding-left:30px; border-bottom: 1px solid #F5F5F5" height="40">₹ <?=@$row->offer_price?></td>
                    <td style="padding-left:30px; border-bottom: 1px solid #F5F5F5" height="40">₹ <?=($row->cart_product_quantity*$row->offer_price)?></td>
                </tr>
                <?php $counter++;
            } 
            $deliveryCharge=$subTotal > 80 ? 0 : 10;
        }    ?>


        <tr>
            <td height="40" colspan="4" align="right" style="padding-right:30px; border-bottom: 1px solid #F5F5F5"><strong>Sub Total</strong></td>
            <td style="padding-left:30px" height="40"><strong><?php echo '₹ '.' '.$subTotal;?></strong></td>
        </tr>

          <tr>
            <td height="40" colspan="4" align="right" style="padding-right:30px; border-bottom: 1px solid #F5F5F5"><strong>VAT 5%</strong></td>
            <td style="padding-left:30px" height="40"><strong>₹ <?php echo $vat = (5 / 100) * @$subTotal ; ?></strong></td>
        </tr>

        <tr>
            <td height="40" colspan="4" align="right" style="padding-right:30px; border-bottom: 1px solid #F5F5F5"><strong>Delivery Charges</strong></td>
            <td style="padding-left:30px" height="40"><strong><?php echo '₹ '.' '.$deliveryCharge;?></strong></td>
        </tr>
        <?php 
        $sameDay= 0;
       $type=@$fetch_data[0]->delivery_type;
        
        if($type=="Same day delivery")
        {
            $sameDay= 10;
        }

         ?>
        <tr>
            <td height="40" colspan="4" align="right" style="padding-right:30px; border-bottom: 1px solid #F5F5F5"><strong>Same Day Delivery Charges</strong></td>
            <td style="padding-left:30px" height="40"><strong>₹ <?= $sameDay ?></strong></td>
        </tr>
        <?php  $deliveryCharge = $deliveryCharge +$vat +$sameDay; ?> 

        <?php if($fetch_data[0]->coupon_id <= 0){ ?>
            <tr style="background: #383838 ; color: #fff">
                <td height="40" colspan="4" align="right" style="padding-right:30px; border-bottom: 1px solid #F5F5F5"><strong>Grand Total</strong></td>
                <td style="padding-left:30px" height="40"><strong><?php echo '₹ '.($deliveryCharge+$subTotal);?></strong></td>
            </tr>
            <?php } else{ 

            if($fetch_data[0]->referal_applied == 1)
            { 
                $amount=50/100*$subTotal;
                $amount=$subTotal-$amount;
                ?>
                <tr style="background: #383838 ; color: #fff">
                    <td height="40" colspan="4" align="right" style="padding-right:30px; border-bottom: 1px solid #F5F5F5"><strong>Grand Total</strong></td>
                    <td style="padding-left:30px" height="40"><strong><?php echo '₹ '.($deliveryCharge+abs($amount));?></strong></td>
                </tr>

            <?php } else { 
                $amount=$fetch_data[0]->discount_percentage/100*$subTotal;
                $amount=$subTotal-$amount;
                ?>

                <tr style="background: #383838 ; color: #fff">
                    <td height="40" colspan="4" align="right" style="padding-right:30px; border-bottom: 1px solid #F5F5F5"><strong>Grand Total with <?php echo $fetch_data[0]->discount_percentage.' % Discount(Coupon Applied)';?> :</strong></td>
                    <td style="padding-left:30px" height="40"><strong><?php echo '₹ '.($deliveryCharge+abs($amount));?></strong></td>
                </tr>
            <?php } } ?>



    </table>

    <table width="100%">
        <tr align="center"><td height="50" align="center" valign="bottom">Happy Shopping</td></tr>
        <tr><td height="50" align="center" valign="top" style="font-size: 20px; font-weight: bold">Team Ashamart</td></tr>
    </table>
     <table width="100%">
        <td align="right" valign="middle" style="padding-right: 5px">
            <?php if($fetch_data[0]->order_status!=3) {?>
            <!--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Cancel</button>-->
            <?php } ?>
        </td>
    </table>
    <table width="100%" style="background: #F5F5F5; padding: 20px 0 ">
        <tr align="center"><td height="50" colspan="2" align="center" style="font-size: 20px; font-weight: bold" valign="middle">DOWNLOAD OUR APP</td></tr>
        <tr>
            <td align="right" valign="middle" style="padding-right: 5px"><a href="#"><img src="<?=base_url('images/common/google.png')?>" width="140" height="40" alt=""/></a></td>
            <td align="left" valign="middle" style="padding-left: 5px"><a href="#"><img src="<?=base_url('images/common/ios.png')?>" width="140" height="40" alt=""/></a></td></tr>
        </table>


        <table width="100%" style="background:#B60008; color: #fff; padding: 30px">
            <tr><td><strong>Have questions?</strong></td></tr>
            <tr><td>We are here to help, learn more about us here  <a href="mailto:customerservice@yaldatrading.com" style="color: #fff; text-decoration: none">Contact us</a></td></tr>
        </table>

    </td>
</tr>
</tbody>
</table>
</td>
</tr>
</table>
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
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
              <input type="hidden" id="order_id" name="order_id" value="<?= @$fetch_data[0]->order_id; ?>">
              <input type="hidden" id="user_id" name="user_id" value="<?= @$fetch_data[0]->user_id; ?>">
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
</body>
</html>
