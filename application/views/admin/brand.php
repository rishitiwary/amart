<?php
$this->load->view('admin_header');
?>


<div class="col-md-12">
<div class="panel">
<div class="panel-heading"> 
<h3 class="panel-title">Add Brand</h3>
<?php
$message = $this->session->flashdata('msg');
if (isset($message)) {
echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' . $message . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>';

} 
?>
</div>
<form action="<?php echo base_url();?>Product/brand" method="post" enctype="multipart/form-data" >
<div class="panel-content">
<div class="form-group row">
<span class="label-text col-md-2 col-form-label text-md-right">Add Brand</span>

<div class="col-md-10">
 
<input type="text" name="brand" class="form-control">
 
 
</div><hr>
</div>
<div class="form-group row">
<span class="label-text col-md-2 col-form-label text-md-right">Upload Image</span>

<div class="col-md-10">
<label class="custom-file">
<input type="file" name="brandimage" class="custom-file-input"accept="image/*">
<span class="custom-file-label">Choose File</span> 
</label>
<span>(Image Size should be 1690x390)</span>
</div><hr>
</div>
<div class="form-group row">
<span class="label-text col-md-2 col-form-label text-md-right">Description</span>
<div class="col-md-10">
<div class="form-group">
<label>Brand Description(optional)</label>
<textarea class="form-control" name="description" placeholder="Brand short description"></textarea>
</div>
</div>
</div>
<div class="form-group">
<input type="hidden" name="hidden_id"  required">
<input type="submit" name="updategallery" class="btn btn-success" id="right">
</div><hr>
</form>
</div>




</div>
</div>
</div>
</div>
</div>
<?php
$this->load->view('admin_footer');
?>