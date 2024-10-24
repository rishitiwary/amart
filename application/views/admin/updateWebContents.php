<?php
$this->load->view('admin_header');
if(count($webContents)>0){
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
<div class="records--body">
    <div class="title"> 
        <h6 class="h6">Update Home Page Contents</h6>  
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="tab01">
            <form action="<?php echo base_url();?>admin/updateWebContents" method="post" enctype="multipart/form-data">                                       <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Hearder Text Title: *</span> 
                    <div class="col-md-9"> 
                        <input type="text" value="<?php echo $webContents->header_text_title;?>" name="header_text_title" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row"> 
                    <span class="label-text col-md-3 col-form-label">Header Text Description*:</span>
                    <div class="col-md-9"> 
                        <input type="text" value="<?php echo $webContents->header_text_description;?>" name="header_text_description" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row"> 
                <span class="label-text col-md-3 col-form-label">Contact Number*:</span>
                    <div class="col-md-9"> 
                        <input type="text" value="<?php echo $webContents->footer_contact;?>" name="footer_contact" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row"> 
                <span class="label-text col-md-3 col-form-label">Email*:</span>
                    <div class="col-md-9"> 
                        <input type="email" value="<?php echo $webContents->footer_email;?>" name="footer_email" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Address*:</span>
                    <div class="col-md-9">
                        <textarea name="footer_address" class="form-control" required><?php echo $webContents->footer_address;?></textarea>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-9 offset-md-3">
                        <input type="submit" name="updatecontents" value="UPDATE NOW" class="btn btn-rounded btn-success">
                    </div>
                </div>
            </form>
        </div>
</div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php
}
$this->load->view('admin_footer');
?>