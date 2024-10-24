<?php
$this->load->view('admin_header');
?>   
   
    <div class="panel" style="padding:10px;">
            <h3>Order Details</h3>
            <table class="table">
                <thead>
                    <tr> 
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Customer Mobile</th>
                        <th>Delivery Address</th>
                        <th>Booking Date</th>
                        <th>Delivery Date</th>
                        
                    </tr>
                </thead>
                <tbody>
                <?php
                if(count($fetch_data) > 0)  
                {  
                ?>  
                    <tr>  
                        <td><?php echo $fetch_data[0]->order_id; ?></td>
                        <td><?php echo $fetch_data[0]->name; ?></td>
                        <td><?php echo $fetch_data[0]->mobile; ?></td>
                        <td><?php echo $fetch_data[0]->address; ?></td>  
                        <td><?php echo date("F j, Y",strtotime($fetch_data[0]->booking_date)) ?></td> 
                        <td><?php echo date("F j, Y",strtotime($fetch_data[0]->delivery_date)) ?></td> 
                    </tr> 
                <?php       
                  }  
                ?>
                  
                    </tbody>
            </table> 
        
        <h4>Product Summary</h4>
        <div class="records--list" data-title="Product Listing">
            <table class="table">
                <thead>
                    <tr> 
                        <th>No</th>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
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
                        <td><?php echo $counter; ?></td>  
                        <td><?php echo $row->product_code; ?></td>
                        <td><?php echo $row->product_name; ?></td>  
                        <td><?php echo $row->cart_product_quantity; ?></td>  
                        <td><?php echo ($row->offer_price); ?></td> 
                        <td><?php echo ($row->cart_product_quantity*$row->offer_price); ?></td> 
                    </tr>
                    
                <?php       
                   $counter++;
                   } 
                   $deliveryCharge=$subTotal > 80 ? 0 : 10;
                   ?>
                    <?php 
                    $sameDay= 0;
                    $type=@$fetch_data[0]->delivery_type;
                    
                    if($type=="Same day delivery")
                    {
                    $sameDay= 10;
                    }
                    
                    ?>
                   <tfoot>
                        <tr>
                            <td colspan="5" style="text-align:right;"><b>SubTotal :</b></td>
                            <td style="text-align:left;"><b><?php echo '₹ '.' '.$subTotal;?></b></td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align:right;"><b>VAT 5% :</b></td>
                            <td style="text-align:left;"><b><?php echo '₹ '.' '.$vat = (5 / 100) * @$subTotal;?></b></td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align:right;"><b>Delivery Charge :</b></td>
                            <td style="text-align:left;"><b><?php echo '₹ '.' '.$deliveryCharge;?></b></td>
                        </tr>
                         <tr>
                            <td colspan="5" style="text-align:right;"><b>Same Day Delivery Charges :</b></td>
                            <td style="text-align:left;"><b><?php echo '₹ '.' '. $sameDay;?></b></td>
                        </tr>
                        <?php if($fetch_data[0]->coupon_id <= 0){ ?>
                        <tr>
                            <td colspan="5" style="text-align:right;"><b>Grand Total :</b></td>
                            <td style="text-align:left;"><b><?php echo '₹ '.($deliveryCharge+$subTotal);?></b></td>
                        </tr>
                        <?php }else{ 
                        if($fetch_data[0]->referal_applied == 1){ 
                        $amount=50/100*$subTotal;
                        $amount=$subTotal-$amount;
                       ?>
                            <td colspan="5" style="text-align:right;"><b>Grand Total with 50% Discount;?> :</b></td>
                            <td style="text-align:left;"><b><?php echo '₹ '.($deliveryCharge+abs($amount));?></b></td>
                       <?php }else{ 
                       $amount=$fetch_data[0]->discount_percentage/100*$subTotal;
                       $amount=$subTotal-$amount;
                       ?>
                            <td colspan="5" style="text-align:right;"><b>Grand Total with <?php echo $fetch_data[0]->discount_percentage.' % Discount(Coupon Applied)';?> :</b></td>
                            <td style="text-align:left;"><b><?php echo '₹ '.($deliveryCharge+abs($amount));?></b></td>
                        <?php }
                        } ?>
                    </tfoot>
                   
                   <?php
                 }  ?>
                  
                    </tbody>
            </table> 
        </div>
</div>
<?php
$this->load->view('admin_footer');
?>