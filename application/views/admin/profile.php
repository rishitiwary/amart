<?php
$this->load->view('admin_header');
$row=$row[0];
?>
<center style="color:red;">
<?php
if (isset($error)){
    foreach($error as $err){
            
    }
}
?>
</center>
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
<div class="panel-heading"> 
            <h3 class="panel-title">Profile details</h3>
        </div>
        <form action="<?php echo base_url();?>admin/updateProfileImg" method="post" enctype="multipart/form-data" >
        <div class="panel-content">
        <div class="form-group row">
            <span class="label-text col-md-2 col-form-label text-md-right">File Input</span>
                <div class="col-md-10">
                    <label class="custom-file">
                    <input type="file" name="image_file" class="custom-file-input"accept="image/*">
                    <span class="custom-file-label">Choose File</span> 
                    <small style="color:red;"><?php if(!empty($err)){ echo $err;}?></small>
                    </label>
                </div>
            </div>
            <div class="form-group row">
            <span class="label-text col-md-2 col-form-label text-md-right">File Input</span>
                <div class="col-md-10">
                    <input type="email" class="form-control"  value="<?php echo $row['email'];  ?>" name="email" readonly/>
                    </label>
                </div>
            </div>
            <div class="form-group row">
            <span class="label-text col-md-2 col-form-label text-md-right">Name</span>
                <div class="col-md-10">
                    <input type="text" class="form-control" value="<?php echo $row['name'];  ?>" name="name" required>
                    </label>
                </div>
            </div>
            <div class="form-group row">
            <span class="label-text col-md-2 col-form-label text-md-right">Mobile</span>
                <div class="col-md-10">
                    <input type="number"  class="form-control" value="<?php echo $row['mobile'];  ?>" name="mobile" required>
                    </label>
                </div>
                
                <hr>
            </div>
            <div class="form-group">
               <input type="hidden" name="prev_image_file" class="" value="<?php echo $row['user_image'];  ?>">
               <input type="submit" name="imginsert" class="btn btn-success" id="right">
            </div><hr>
            </form>
</div>
</div>


<?php
$this->load->view('admin_footer');
?>