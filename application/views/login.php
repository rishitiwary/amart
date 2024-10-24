<!DOCTYPE html><html dir="ltr" lang="en" class="no-outlines">
<head> <meta charset="UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>Yalda Fruits - Admin</title>
   <meta name="author" content=""> 
   <meta name="description" content=""> 
   <meta name="keywords" content=""> 
   <link rel="icon" href="<?=base_url('images/common/logo.png')?>" type="image/png"> 
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CMontserrat:400,500"> 
   <link rel="stylesheet" href="<?php echo base_url();?>public/admin/assets/css/jquery-ui.min.css"> 
   <link rel="stylesheet" href="<?php echo base_url();?>public/admin/assets/css/bootstrap.min.css"> <link rel="stylesheet" href="assets/css/fontawesome-all.min.css"> 
   <link rel="stylesheet" href="<?php echo base_url();?>public/admin/assets/css/perfect-scrollbar.min.css"> 
   <link rel="stylesheet" href="<?php echo base_url();?>public/admin/assets/css/morris.min.css"> 
   <link rel="stylesheet" href="<?php echo base_url();?>public/admin/assets/css/select2.min.css"> 
   <link rel="stylesheet" href="<?php echo base_url();?>public/admin/assets/css/jquery-jvectormap.min.css"> 
   <link rel="stylesheet" href="<?php echo base_url();?>public/admin/assets/css/horizontal-timeline.min.css"> 
   <link rel="stylesheet" href="<?php echo base_url();?>public/admin/assets/css/weather-icons.min.css"> 
   <link rel="stylesheet" href="<?php echo base_url();?>public/admin/assets/css/dropzone.min.css"> 
   <link rel="stylesheet" href="<?php echo base_url();?>public/admin/assets/css/ion.rangeSlider.min.css"> 
   <link rel="stylesheet" href="<?php echo base_url();?>public/admin/assets/css/ion.rangeSlider.skinFlat.min.css"> 
   <link rel="stylesheet" href="<?php echo base_url();?>public/admin/assets/css/datatables.min.css"> 
   <link rel="stylesheet" href="<?php echo base_url();?>public/admin/assets/css/fullcalendar.min.css"> 
   <link rel="stylesheet" href="<?php echo base_url();?>public/admin/assets/css/style.css"> 
</head>
<body>
     <div class="wrapper" style="width:100%;">
          <div class="m-account-w" > 
          <div class="m-account">
                <div class="row no-gutters"> 
                    <div class="col-md-6">

                        <div class="m-account--content-w" data-bg-img="<?=base_url('images/common/yalda.jpg')?>"> 
                        <div class="m-account--content">
                             <h2 class="h2">Login to your account</h2>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="m-account--form-w">
                            <div class="m-account--form">
                                <div class="logo">
                                      <a href="<?=base_url()?>"><img src="<?php echo base_url();?>public/admin/assets/img/logo.png" alt=""></a>
                                </div>
                                <form action="" method="post">
                                <label class="m-account--title"></label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend"> <i class="fa fa-user"></i> </div>
                                        <input type="email" name="email" placeholder="Enter Email Address " class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend"> 
                                            <i class="fa fa-key"></i> 
                                        </div>
                                        <input type="password" name="password" placeholder="Password" class="form-control" required>
                                        <input type="hidden" name="fcm_token" value="EfdfxfdW6565465dfder4dsews" class="form-control" required>
                                    </div>
                                </div>
                                <div class="m-account--actions"> 
                                    <a href="<?php echo base_url();?>main/forgot" class="btn-link">Forgot Password?</a>
                                    <input type="submit"name="loginbtn"value='Login' class="btn btn-rounded btn-info"> 
                                </div>
                                <div class="m-account--footer">  
                                <p>&copy; <?php echo date('Y');?> Yalda. All rights reserved <a href="https://aimstormsolutions.com/" target="_blank" style="color:#CEA525">Aimstorm Solutions</a></p>
                                </div></form>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
     </div>
     <script src="<?php echo base_url();?>public/admin/assets/js/jquery.min.js"></script> 
     <script src="<?php echo base_url();?>public/admin/assets/js/jquery-ui.min.js"></script> 
     <script src="<?php echo base_url();?>public/admin/assets/js/bootstrap.bundle.min.js"></script> 
     <script src="<?php echo base_url();?>public/admin/assets/js/perfect-scrollbar.min.js"></script> 
     <script src="<?php echo base_url();?>public/admin/assets/js/jquery.sparkline.min.js"></script> 
     <script src="<?php echo base_url();?>public/admin/assets/js/raphael.min.js"></script> 
     <script src="<?php echo base_url();?>public/admin/assets/js/morris.min.js"></script> 
     <script src="<?php echo base_url();?>public/admin/assets/js/select2.min.js"></script> 
     <script src="<?php echo base_url();?>public/admin/assets/js/jquery-jvectormap.min.js"></script> 
     <script src="<?php echo base_url();?>public/admin/assets/js/jquery-jvectormap-world-mill.min.js"></script> 
     <script src="<?php echo base_url();?>public/admin/assets/js/horizontal-timeline.min.js"></script> 
     <script src="<?php echo base_url();?>public/admin/assets/js/jquery.validate.min.js"></script> 
     <script src="<?php echo base_url();?>public/admin/assets/js/jquery.steps.min.js"></script> 
     <script src="<?php echo base_url();?>public/admin/assets/js/dropzone.min.js"></script> 
     <script src="<?php echo base_url();?>public/admin/assets/js/ion.rangeSlider.min.js"></script> 
     <script src="<?php echo base_url();?>public/admin/assets/js/datatables.min.js"></script> 
     <script src="<?php echo base_url();?>public/admin/assets/js/main.js"></script> 
     
     </body>
</html>
