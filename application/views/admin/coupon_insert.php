<?php 
$this->load->view('admin_header');
?>
<?php  
if(isset($user_data))  
{  
foreach($user_data as $row)  
{ 
?>
<div class="panel">
<div class="records--body">
    <div class="title"> 
        <h6 class="h6">Update Coupon</h6>  
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="tab01">
            <form action="<?php echo base_url();?>coupon/form_validation" method="post" enctype="multipart/form-data">                                       <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Coupon Title</span> 
                    <div class="col-md-9"> 
                        <input type="text" name="coupon_title" value="<?php echo $row->coupon_title;?>" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Coupon Code:</span>
                    <div class="col-md-9">
                        <input type="text" name="coupon_code" value="<?php echo $row->coupon_code;?>" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Discount Percentage:</span>
                    <div class="col-md-9">
                        <input type="text" name="discount_percentage" value="<?php echo $row->discount_percentage;?>"class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Min Order Price:</span>
                    <div class="col-md-9">
                        <input type="text" name="min_order_price" value="<?php echo $row->min_order_price;?>" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Max Order Price:</span>
                    <div class="col-md-9">
                        <input type="text" name="max_order_price" value="<?php echo $row->max_order_price;?>"class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Valid From:</span>
                    <div class="col-md-9">
                        <input type="text" name="valid_from" value="<?php echo date("d-m-Y",strtotime($row->valid_from));?>"class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Valid Upto:</span>
                    <div class="col-md-9">
                        <input type="text" name="valid_upto" value="<?php echo date("d-m-Y",strtotime($row->valid_upto));?>"class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Status*</span>
                    <div class="col-md-9"> 
                        <select name="status" required class="form-control">
                        <option value="">Choose...</option>
                        <option value="1" <?php if($row->status=='1'){echo 'selected';}?>>Active</option>
                        <option value="0" <?php if($row->status=='0'){echo 'selected';}?>>Deactive</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-9 offset-md-3">
                    <input type="hidden" name="hidden_id" value="<?php echo $row->coupon_id?>" class="form-control" required>
                        <input type="submit" name="updatecategory" value="Update Coupon" class="btn btn-rounded btn-success">
                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>

<?php
}

}else{
?>
<div class="panel">
<div class="records--body">
    <div class="title"> 
        <h6 class="h6">Add New Coupon</h6>  
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="tab01">
            <form action="<?php echo base_url();?>coupon/form_validation" method="post" enctype="multipart/form-data">                                       <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Coupon Title</span> 
                    <div class="col-md-9"> 
                        <input type="text" name="coupon_title" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Coupon Code:</span>
                    <div class="col-md-9">
                        <input type="text" name="coupon_code" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Discount Percentage:</span>
                    <div class="col-md-9">
                        <input type="text" name="discount_percentage" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Min Order Price:</span>
                    <div class="col-md-9">
                        <input type="text" name="min_order_price" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Max Order Price:</span>
                    <div class="col-md-9">
                        <input type="text" name="max_order_price" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Valid From:</span>
                    <div class="col-md-9">
                        <input type="date" name="valid_from" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Valid Upto:</span>
                    <div class="col-md-9">
                        <input type="date" name="valid_upto" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Status*</span>
                    <div class="col-md-9"> 
                        <select name="status" required class="form-control">
                        <option value="">Choose One....</option>
                        <option value="1">active</option>
                        <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-9 offset-md-3">
                        <input type="submit" name="insertcategory" value="Add Now" class="btn btn-rounded btn-success">
                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>

<?php
}
?>
<?php
$this->load->view('admin_footer');
?>