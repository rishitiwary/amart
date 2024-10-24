<?php
$this->load->view('admin_header');

?>
 <?php
    if (isset($error)){
        foreach($error as $err){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><?php echo $err;?></strong>
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <?php
        }
    }
?>
<div class="col-md-12">
    <div class="panel">
        <div class="panel-heading"> 
            <h3 class="panel-title">Import Products</h3>
        </div>
        <form action="<?php echo base_url();?>import/import" method="post" enctype="multipart/form-data" >
        <div class="panel-content">
        <div class="form-group row">
            <span class="label-text col-md-2 col-form-label text-md-right">File Input</span>
                <div class="col-md-10">
                    <label class="custom-file">
                        <input type="file" name="image_file" class="custom-file-input" required>
                        <span class="custom-file-label">Choose File</span> 
                        <small>choose Excel File only</small>
                    </label>
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
$this->load->view('admin_footer');
?>