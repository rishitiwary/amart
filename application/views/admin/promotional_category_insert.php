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
        <h6 class="h6">Update Promotional Category</h6>  
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="tab01">
            <form action="<?php echo base_url();?>PromotionalCategory/form_validation" method="post" enctype="multipart/form-data">                                       <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Category Name</span> 
                    <div class="col-md-9"> 
                        <input type="text" name="category" value="<?php echo $row->category?>" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Image:</span>
                    <div class="col-md-9">
                        <input type="file" name="image_file" class="form-control"> </div>
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
                    <input type="hidden" name="hidden_id" value="<?php echo $row->id?>" class="form-control" required>
                        <input type="submit" name="updatecategory" value="Update Category" class="btn btn-rounded btn-success">
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
        <h6 class="h6">Insert Promotional Category</h6>  
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="tab01">
            <form action="<?php echo base_url();?>PromotionalCategory/form_validation" method="post" enctype="multipart/form-data">                                       <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Category Name</span> 
                    <div class="col-md-9"> 
                        <input type="text" name="category" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Image:</span>
                    <div class="col-md-9">
                        <input type="file" name="image_file" class="form-control"> </div>
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
                        <input type="submit" name="insertcategory" value="Insert Category" class="btn btn-rounded btn-success">
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