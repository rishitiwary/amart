<?php
$this->load->view('admin_header');
?>

<body>
 <div class="wrapper">

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
  <div class="m-account-w">
   <div class="m-account"> <div class="row no-gutters flex-row-reverse"> 
    <div class="col-md-12"> <div class="m-account--form-w"> <div class="m-account--form"> <div class="logo"> <img src="assets/img/logo.png" alt=""> </div>
     <form action="" method="post">
        <label class="m-account--title">Create Admin Account</label>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <i class="fas fa-user"></i>
                </div>
                <input type="text" name="name" placeholder="Admin name" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group"> 
                <div class="input-group-prepend"> 
                    <i class="fas fa-envelope"></i> 
                </div>
                <input type="email" name="email" placeholder="Email" class="form-control" required> 
            </div>
        </div>
        <div class="form-group"> 
            <div class="input-group"> 
                <div class="input-group-prepend"> <i class="fas fa-key"></i> </div>
                <input type="password" name="password" placeholder="Password" class="form-control" required>
            </div>
        </div>
        <div class="form-group"> 
            <div class="input-group"> 
                <div class="input-group-prepend"> <i class="fas fa-key"></i> </div>
                <input type="number" name="mobile" placeholder="Mobile" class="form-control" required>
            </div>
        </div>
        <div class="m-account--actions"> 
            <button type="submit" class="btn btn-block btn-rounded btn-info">Register</button>
        </div>
     </form>
    </div>
  </div>
  </div>
  </div>

<?php
$this->load->view('admin_footer');
?>