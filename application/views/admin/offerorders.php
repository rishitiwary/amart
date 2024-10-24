<?php
require_once('database.php');
$email=$_SESSION['user'];
if($email==''){
   echo "<script>window.location.assign('index.php')</script>";
}

ini_set('display_errors',1);
error_reporting(E_ALL);
$select="SELECT tbl_invoice_bill.first_name,tbl_invoice_bill.last_name,tbl_invoice_bill.bill_address,tbl_invoice_bill.bill_address2,tbl_offer_order.offe_order_no,tbl_offer_order.purchased_on,tbl_offer_order.price,tbl_offer_order.product_name from tbl_invoice_bill INNER JOIN tbl_offer_order on tbl_invoice_bill.invoiceBill_id= tbl_offer_order.invoiceBill_id";
   $rows=$connection->query($select);
   extract($_POST);

?>   
   
    <div class="panel">
        <div class="records--list" data-title="Orders Listing">
            <table id="recordsListView">
                <thead>
                    <tr> 
                        <th>Order No</th>
                        <th>Product Name</th>
                        <th>Purchesed On</th>
                        <th>Customer Name</th> 
                        <th>Address</th> 
                        <th>Price</th>
                        <th class="not-sortable">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php

                $i=1;
                while($row=$rows->fetch())
                {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td> <a href="#" class="btn-link"><?php echo $row['product_name']; ?></a> </td>
                        <td><?php echo $row['purchased_on']; ?></td>
                        <td> <a href="#" class="btn-link"><?php echo $row['first_name']; ?><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['bill_address'];?><?php echo $row['bill_address2']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td>
                            <div class="dropleft">
                                    <a href="offerorderdelete.php?orderdelid=<?php echo $row['offe_order_no']; ?>" class="dropdown-item">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
                    ?>
                    </tbody>
            </table> 
        </div>
</div>
    