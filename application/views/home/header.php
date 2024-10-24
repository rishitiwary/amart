<?php 
$this->load->model('Commonmodel');
$sql= "SELECT * FROM categories WHERE status=1 AND parent_category=0 AND id!=95 LIMIT 6";
$category = $this->Commonmodel->fetch_all_join($sql);
$mainCategory = $this->Commonmodel->fetch_all_join("SELECT * FROM categories WHERE status=1 AND parent_category=0");
$limit=count($mainCategory);
$morecategory=$this->Commonmodel->fetch_all_join("SELECT * FROM categories WHERE status=1 AND parent_category=0 ORDER BY ID  LIMIT 6,$limit");
$setting=$this->Commonmodel->fetch_all_rows_limit("users","role=1",1);
 
?>
<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Ashamart</title>
  <link rel="shortcut icon" href="<?=base_url('images/common/logo.png')?>">
  <!-- fonts-->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Yesteryear&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?=base_url('css/bootstrap.min.css')?>">
  <!-- styles-->
  <link href="<?=base_url('css/main.css')?>" rel="stylesheet">

</head>
<body>

  <!-- start header-top -->
  <section class="header-top">
    <div class="container">
      <div class="phone-no common-box">Call us : <a href="#"> +916203950655 / +916203950655</a> </div>
      <div class="my-account common-box">
        <!-- <div>
          <a href="#" class="language-box common-inside" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">English</a>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#">English</a>
          </div>
        </div> -->

        <!-- my currency -->
      <!--   <div>
          <a href="#" class="language-box common-inside" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">AED</a>

          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#">Action</a>
          </div>
        </div> -->
        <!-- my account -->
        <div style=" text-align:center;padding-right: 244px;">Free Delivery above ₹ 400.00</div>
        <div>
          <a href="#" class="language-box common-inside loginTab" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>

          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

            <?php if(($this->session->userdata('id')!='') &&  ($this->session->userdata('role')=='3')){ ?>
              <span class="withlogin">
                <a class="dropdown-item" href="<?=base_url('dashboard')?>">My Dashboard</a>
                <a class="dropdown-item" href="<?= base_url('home/logout')?>" id="logoutbtn">Logout</a></span>
              <?php } else {?>
                <span class="nologin">
                  <a class="dropdown-item" href="<?=base_url('login')?>">Login</a>
                  <a class="dropdown-item" href="<?=base_url('signup')?>">Sign Up</a>
                </span>
              <?php }?>
            </div>
            <div>
            </div>
          </div>
        </section>
        <!-- end header-->

        <div class="mobile-menu">
        </div>
        <div class="menu-overlay"></div>
        <!-- start header part-->
        <header class="header">
          <div class="container">
            <a href="<?=base_url()?>" class="h-common"><img src="<?=base_url('uploads/admins/')?><?=$setting[0]->user_image?>"></a>
            <a href="#" class="m-menu"><img src="<?=base_url('images/common/mobile-menu.svg')?>"></a>

            <div class="search h-common">
              <form action="<?=base_url('home/search')?>" method="get" accept-charset="utf-8">                
               <input type="text" required name="keyword"  value="<?php echo @$_GET['keyword']?>" placeholder="Search our catalogue"/>
              <button type="submit"></button>
              </form>
             
            </div>
            <div class="menu-cart cartData" id="cartData" style="cursor:pointer">           

            <figure><img src="<?=base_url('images/common/smart-cart.svg')?>"></figure>
            <?php if(($this->session->userdata('id')!='') &&  ($this->session->userdata('role')=='3')){
              $userId=$this->session->userdata('id');
              $carts= $this->Commonmodel->fetch_all_rows('carts',"user_id=$userId");?>
              <div class="qty">Shopping Cart<span><?= count($carts)?> item</span></div>
           <?php }else { ?>
            <div class="qty">Shopping Cart<span>0 item</span></div>
          <?php } ?>
          </div> 
        </div>
      </header>
      <!-- end header part-->
      <!-- start nav-->
<!--<marquee direction="down" width="250" height="200" behavior="alternate" >-->
<marquee direction="left" style="color:red;">
 All items listed are EXCLUDED of Vat*. Vat will be calculated in the final bill.</marquee>
</marquee>
      <nav class="navigation">
        <div class="container">
          <ul class="menu">
            <li class="active">
             
              
            
            <?php foreach ($category as $key => $cat): ?>
              <li>
              <a href="<?=base_url()?>home/category/<?=$cat->id?>" class="language-box common-inside"><?=$cat->category?></a>
            </li>              
            <?php endforeach ?>
            </li><li class="active"><a href="#" class="language-box common-inside" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More Categories</a>
             <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php foreach ($morecategory as $key => $cat): ?>
                  <a class="dropdown-item" href="<?=base_url()?>home/category/<?=$cat->id?>"><?=$cat->category?></a>
                <?php endforeach ?>
              </div></li>
          </ul>                   
        </div>
      </nav>
      <!-- end nav-->

