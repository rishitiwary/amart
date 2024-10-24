<?php
$this->load->view('admin_header');
?>   
   
    <div class="panel" style="padding:10px;">
         <h3>Customer  Details</h3>
            <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr> 
                        <th>Email</th>
                        <th>Customer Name</th>
                        <th>Customer Mobile</th>
                        <th>Gender</th>
                        <th>Date Of Birth</th>
                        <th>Nationality</th>
                        
                    </tr>
                </thead>
                <tbody>
                <?php
                if(count($user) > 0)  
                { 
                ?>  
                    <tr>  
                        <td><?php echo $user[0]->email; ?></td>
                        <td><?php echo $user[0]->name; ?></td>
                        <td><?php echo $user[0]->mobile; ?></td>
                        <td><?php echo $user[0]->gender; ?></td>  
                        <td><?php echo date("F j, Y",strtotime($user[0]->dob)) ?></td>  
                        <td><?php echo $user[0]->nationality; ?></td>  
                    </tr> 
                <?php       
                  }  
                ?>
                  
                    </tbody>
            </table> 
            </div>
            <br/>
        <div class="records--list" data-title="Orders Listing">
            <table id="recordsListView">
                <thead>
                    <tr> 
                        <th>Order No</th>
                        <th>Order ID</th>
                        <th>Number of Product</th>
                        <th>Total Price</th>
                        <th>Ship To</th> 
                        <th>Booking Date</th>
                        <th class="not-sortable">Actions</th>
                        <th class="not-sortable">Cancel</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if(count($fetch_data) > 0)  
                {  
                    $counter=1;
                    foreach($fetch_data as $row)  
                    {  
                ?>  
                    <tr>  
                        <td><?php echo $counter; ?></td>  
                        <td><a href="<?php echo base_url();?>admin/booking_details/<?php echo $row->order_id;?>/<?php echo $row->user_id;?>"><?php echo $row->order_id; ?></a></td>
                        <td><?php echo $row->TotalProductQty; ?></td>  
                        <td><?php echo $row->TotalBookingPrice; ?></td>  
                        <td><?php echo $row->delivery_address; ?></td> 
                        <td><?php echo date("F j, Y",strtotime($row->booking_date)) ?></td> 
                         <?php if($row->status== 0){ ?>
                         <td><a href="<?php echo base_url(); ?>admin/updateStatus/1/<?php echo $row->order_id;?>/<?php echo $row->user_id;?>" class="btn btn-info">Accept</a></td> 
                         <?php }elseif($row->status=='1'){ ?>
                             <td><a href="<?php echo base_url(); ?>admin/updateStatus/2/<?php echo $row->order_id;?>/<?php echo $row->user_id;?>" class="btn btn-info">Processing</a></td>
                         <?php }elseif($row->status=='2'){ ?>
                         <td><a href="" class="btn btn-success">Delivered</a></td>
                         <td></td>
                         <?php }elseif($row->status=='3'){ ?>
                         <td><a class="btn btn-default">Cancelled</a></td>
                         <td></td>
                         <?php }
                         if($row->status < 2){ ?>
                         <td><a href="<?php echo base_url(); ?>admin/updateStatus/3/<?php echo $row->order_id;?>/<?php echo $row->user_id;?>" class="btn btn-info">Cancel</a></td> 
                         <?php }?>
                    </tr> 
                <?php       
                   $counter++;
                   }  
                 }  ?>
                  
                    </tbody>
            </table> 
        </div>
</div>
<?php
$this->load->view('admin_footer');
?>