<?php  $res= $this->db->where('id',$this->session->userdata('id'))->get('users')->row_array(); ?>

<!DOCTYPE html>
<html dir="ltr" lang="en" class="no-outlines">
<head>
  <meta charset="UTF-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard - Ashamart Admin</title>
  <meta name="author" content="">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <link rel="icon" href="<?=base_url('images/common/logo.png')?>" type="image/png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CMontserrat:400,500">
  <link rel="stylesheet" href="<?php echo base_url();?>public/admin/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>public/admin/assets/css/fontawesome-all.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>public/admin/assets/css/jquery-ui.min.css"> 
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
  <style>
    #dashboardAdminLogo{
      max-width: 100%;
      margin-top: -15px;
      margin-left: 35px;
      width: 150px;
      height: 80px;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <header class="navbar navbar-fixed">
      <div class="navbar--header">
        <div class="logo">
        <img id="dashboardAdminLogo" src="<?php echo base_url();?>uploads/admins/<?php echo $res['user_image'] ; ?>" alt="" style="width:100px; height:100px;" class="img-responsive rounded-circle"> <span><?php ?></span> 
 
        </div>
        <a href="javascript:void(0);" class="navbar--btn" data-toggle="sidebar" title="Toggle Sidebar">
          <i class="fa fa-bars"></i>
        </a>
      </div>
      <a href="javascript:void(0);" class="navbar--btn" data-toggle="sidebar" title="Toggle Sidebar"> 
        <i class="fa fa-bars"></i> 
      </a>

      <div class="navbar--nav ml-auto">
        <ul class="nav">
          <li class="nav-item dropdown nav--user online">
            <a href="javascript:void(0);" class="nav-link" data-toggle="dropdown"> 
             
              <img src="<?php echo base_url();?>uploads/admins/<?php echo $res['user_image'] ; ?>" alt="" style="width:50px; height:50px;" class="img-responsive rounded-circle"> <span><?php ?></span> 
              <i class="fa fa-angle-down"></i> 
            </a>
            <ul class="dropdown-menu">
              <li>
                <a href="<?php echo base_url();?>admin/profile">
                  <i class="far fa-user"></i>Profile
                </a>
              </li>
              <li>
                <a href="<?php echo base_url();?>main/logout"><i class="fa fa-power-off"></i>Logout</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </header>
    <aside class="sidebar" data-trigger="scrollbar">
      <div class="sidebar--profile">
        <div class="profile--name">
          <a href="" class="btn-link">Welcome <?php echo 'Admin' ?></a> 
        </div>
        <div class="profile--nav">
          <ul class="nav">
            <li class="nav-item"> 
              <a href="" class="nav-link" title="User Profile"> <i class="fa fa-user"></i> </a> 
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url();?>main/logout" class="nav-link" title="Logout"> <i class="fa fa-sign-out-alt"></i> 
              </a> 
            </li>
          </ul>
        </div>
      </div>
      <div class="sidebar--nav">
        <ul>
          <li>
            <ul>
              <li class="active">
                <a href="<?php echo base_url();?>main/login"> <i class="fa fa-home"></i> <span>Dashboard</span> </a>
              </li>
            <!--   <li class="active">
                <a href="<?php echo base_url();?>admin/updateWebContents"> <i class="fa fa-home"></i> <span>Contents</span> </a>
              </li> -->
              <li>
                <a href="javascript:void(0);"> <i class="fa fa-shopping-cart"></i> <span>Ecommerce</span> </a> 
                <ul>
                <li>
                    <a href="<?php echo base_url();?>product/brand">Add Brands</a>
                  </li>
                  <li>
                    <a href="<?php echo base_url();?>product/viewbrand">View Brands</a>
                  </li>
                  <li>
                    <a href="<?php echo base_url();?>product/index">Products</a>
                  </li>
                  <li>
                    <a href="<?php echo base_url();?>product/store">Insert Products</a>
                  </li>
                  <li>
                    <a href="<?php echo base_url();?>product/orders">Orders</a>
                  </li>
                  <li>
                    <a href="<?php echo base_url();?>admin/customers">Customers</a>
                  </li>
                </ul>
              </li>

              <li>
                <a href="javascript:void(0);"> <i class="fa fa-audio-description" aria-hidden="true"></i> <span>Promotional</span> </a> 
                <ul>
                 <!--  <li>
                    <a href="<?php echo base_url();?>promotional/index">Products</a>
                  </li>
                  <li>
                    <a href="<?php echo base_url();?>promotional/store">Insert Products</a>
                  </li>
 -->                  <li>
                    <a href="<?php echo base_url();?>PromotionalCategory/index">Category</a>
                  </li>
                  <li>
                    <a href="<?php echo base_url();?>PromotionalCategory/form_validation">Insert Category</a>
                  </li>
                </ul>
              </li>

              <li>
                <a href="javascript:void(0);"> <i class="fa fa-anchor" aria-hidden="true"></i> <span>Coupons</span> </a> 
                <ul>
                  <li>
                    <a href="<?php echo base_url();?>coupon/index">Coupons</a>
                  </li>
                  <li>
                    <a href="<?php echo base_url();?>coupon/form_validation">Add Coupon</a>
                  </li>

                </ul>
              </li>

            </ul>
          </li>
          <li>
            <a href="javascript:void(0);">Apps</a>
            <ul>
              <li>
                <a href="javascript:void(0);"> <i class="far fa-image"></i> <span>Banners</span> </a>
                <ul>
                  <li>
                    <a href="<?php echo base_url();?>gallery/store">Insert</a>
                  </li>
                  <li>
                    <a href="<?php echo base_url();?>gallery/index">View</a>
                  </li>
                </ul>
              </li>

              <li>
                <a href="javascript:void(0);"> <i class="fa fa-object-group" aria-hidden="true"></i> <span>Category</span> </a>
                <ul>
                  <li>
                    <a href="<?php echo base_url();?>category/form_validation">Insert</a>
                  </li>
                  <li>
                    <a href="<?php echo base_url();?>category/index">View</a>
                  </li>
                </ul>
              </li>


              <li>
                <a href="javascript:void(0);"> <i class="fas fa-gift"></i> <span>Offer</span> </a>
                <ul>
                  <li>
                    <a href="<?php echo base_url();?>offer/store">Insert</a>
                  </li>
                  <li>
                    <a href="<?php echo base_url();?>offer/index">View</a>
                  </li>
                </ul>
              </li>

<!--<li>-->
<!--  <a href="<?php echo base_url();?>admin/feedback"> <i class="far fa-comment"></i> <span>Feedback View</span> </a>-->
<!--</li>-->
<!--<li>-->
<!--  <a href="<?php echo base_url();?>admin/contact"> <i class="fa fa-phone" aria-hidden="true"></i> <span>Contact View</span> </a>-->
<!--</li>-->
<li>
  <a href="<?php echo base_url();?>admin/manage_subscriber"> <i class="fa fa-address-book" aria-hidden="true"></i> <span>Manage Subscriber</span> </a>
</li>
</ul>
</li>    



  <a href="javascript:void(0);">Admin</a>
  <ul>
    <li>
      <a href="javascript:void(0);"> <i class="fa fa-address-book" aria-hidden="true"></i> <span>Admin Options</span> </a>
      <ul>
        <li><a href="<?php echo base_url();?>admin/admins">Admin Details</a></li>
        <li><a href="<?php echo base_url();?>admin/addAdmins">Register</a></li>
        <li><a href="<?php echo base_url();?>admin/changePassword">Change Password</a></li>
      </ul>
    </li>
  </ul>
</li>
</ul>
</div>
</aside>

<main class="main--container">
  <section class="main--content">