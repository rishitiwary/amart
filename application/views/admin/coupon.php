<?php
$this->load->view('admin_header');
$auth=$this->session->userdata;
if($auth['role']==3){
    redirect(base_url().'main/logout');
}
?>
<?php if(!empty($this->session->flashdata('success'))){ ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong><?php echo $this->session->flashdata('success'); ?></strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php } ?>
<?php if(!empty($this->session->flashdata('error'))){ ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong><?php echo $this->session->flashdata('error'); ?></strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php } ?>
<div class="panel">
    <div class="records--list" data-title="Coupon  Listing">
        <table id="recordsListView">
            <thead>
                <tr> 
                    <th>S No.</th>
                    <th>Coupon Title</th>
                    <th>Coupon Code</th>
                    <th>Min Order Price</th>
                    <th>Max Order Price</th>
                    <th>Discount %</th>
                    <th>Valid From</th>
                    <th>Valid Upto</th>
                    <th>Status</th>
                    <th class="not-sortable">Delete</th> 
                    <th class="not-sortable">Edit</th> 
                </tr>
            </thead>
            <tbody>
            <?php  
                if(count($fetch_data) > 0)  
                {  
                    $i=1;
                    foreach($fetch_data as $row)  
                    {  
                ?>  
                    <tr>  
                            <td><?php echo $i; ?></td> 
                            <td><?php echo $row->coupon_title; ?></td>    
                            <td><?php echo $row->coupon_code; ?></td>    
                            <td><?php echo $row->min_order_price; ?></td>    
                            <td><?php echo $row->max_order_price; ?></td>    
                            <td><?php echo $row->discount_percentage; ?></td>    
                            <td><?php echo $row->valid_from; ?></td>    
                            <td><?php echo $row->valid_upto; ?></td>    
                            <td><?php if($row->status=='1'){echo 'Active';}?><?php if($row->status=='0'){echo 'Deactive';}?></td>  
                            
                            <td><a href="<?php echo base_url(); ?>coupon/delete/<?php echo $row->coupon_id;?>" onclick="return confirm('Are you sure you want to delete this?')" class="delete_data btn btn-danger" id="<?php echo $row->coupon_id; ?>">Delete</a></td>
                            
                            <td><a href="<?php echo base_url(); ?>coupon/update/<?php echo $row->coupon_id; ?>" class="btn btn-info">Edit</a></td> 
                    </tr>  
                <?php 
                $i++;      
                    }  
                }   
                ?> 
            </tbody>
        </table>
    </div>
</div>
<?php
$this->load->view('admin_footer');
?>

