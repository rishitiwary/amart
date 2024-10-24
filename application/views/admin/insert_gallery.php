<?php
$this->load->view('admin_header');
?>
<?php  
if(isset($user_data))  
{  
foreach($user_data as $row)  
{ 
?>
<div class="col-md-12">
    <div class="panel">
        <div class="panel-heading"> 
            <h3 class="panel-title">Update Banner</h3>
        </div>
        <form action="<?php echo base_url();?>gallery/form_validation" method="post" enctype="multipart/form-data" >
        <div class="panel-content">
        <div class="form-group row">
            <span class="label-text col-md-2 col-form-label text-md-right">File Input</span>
            
                <div class="col-md-10">
                    <label class="custom-file">
                        <input type="file" name="image_file" class="custom-file-input"accept="image/*">
                        <span class="custom-file-label">Choose File</span> 
                    </label>
                    <span>(Image Size should be 1690x390)</span>
                </div><hr>
            </div>

            <div class="form-group row">
            <span class="label-text col-md-2 col-form-label text-md-right">Status</span>
                <div class="col-md-10">
                    <select name="status" required class="form-control">
                    <option value="">Choose...</option>
                    <option value="1" <?php if($row->status=='1'){echo 'selected';}?>>Active</option>
                    <option value="0" <?php if($row->status=='0'){echo 'selected';}?>>Deactive</option>
                     </select>
                </div><hr>
            </div>
            
            <div class="form-group">
                <input type="hidden" name="hidden_id" value="<?php echo $row->id;?> required">
               <input type="submit" name="updategallery" class="btn btn-success" id="right">
            </div><hr>
            </form>
            
        </div>
    </div>
</div>

<?php 
}
}else{    
?>
<div class="col-md-12">
    <div class="panel">
        <div class="panel-heading"> 
            <h3 class="panel-title"> Insert Banner</h3>
        </div>
        <form action="<?php echo base_url();?>gallery/form_validation" method="post" enctype="multipart/form-data" >
        <div class="panel-content">
        <div class="form-group row">
            <span class="label-text col-md-2 col-form-label text-md-right">File Input</span>
             
                <div class="col-md-10">
                    <label class="custom-file">
                        <input type="file" name="image_file" class="custom-file-input"accept="image/*" required>
                        <span class="custom-file-label">Choose File</span> 
                    </label>
                    <span>(Image Size should be 1690x390)</span>
                </div>
                <hr>
            </div>

            <div class="form-group row">
            <span class="label-text col-md-2 col-form-label text-md-right">Status</span>
                <div class="col-md-10">
                    <select name="status" required class="form-control">
                        <option value="">Choose One....</option>
                        <option value="1">active</option>
                        <option value="0">Inactive</option>
                     </select>
                </div><hr>
            </div>
            
            <div class="form-group">
               <input type="submit" name="insertgallery" class="btn btn-success" id="right">
            </div><hr>
            </form>
            
        </div>
    </div>
</div>

<?php 
}
?>
<?php
$this->load->view('admin_footer');
?>