<?php $this->load->view('admin_header'); ?>

<div class="row"> 

<!-- Single Earnings Card Example --> 
<div class="col-xl-3 col-md-6 mb-4"> 
<div class="card border-left-primary shadow h-100 py-2"> 
<div class="card-body"> <div class="row no-gutters align-items-center"> 
<div class="col mr-2"> 
<a href="<?php echo site_url();?>admin/index"> 


<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Customers</div>
<div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $this->db->where('role', '3')->count_all_results('users');
?> </div>
</a>
</div>
<div class="col-auto">
<i class="fas fa-calendar fa-2x text-gray-300"></i> 
</div> 
</div> 
</div> 
</div> 
</div> 
<!-- Single Earnings Card Example  -->

<!-- Single Earnings Card Example --> 
<div class="col-xl-3 col-md-6 mb-4"> 
<div class="card border-left-primary shadow h-100 py-2"> 
<div class="card-body"> <div class="row no-gutters align-items-center"> 
<div class="col mr-2"> 
<a href="<?php echo site_url();?>admin/pending"> 
<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pending Customers</div>
<div class="h5 mb-0 font-weight-bold text-gray-800"> <?php $array = array('role' => '3' , 'status' => 'pending' );
echo $this->db->where($array)->count_all_results('users');
?> </div>
</a>
</div>
<div class="col-auto">
<i class="fas fa-calendar fa-2x text-gray-300"></i> 
</div> 
</div> 
</div> 
</div> 
</div> 
<!-- Single Earnings Card Example  -->

<!-- Single Earnings Card Example --> 
<div class="col-xl-3 col-md-6 mb-4"> 
<div class="card border-left-primary shadow h-100 py-2"> 
<div class="card-body"> <div class="row no-gutters align-items-center"> 
<div class="col mr-2"> 
<a href="<?php echo site_url();?>product/orders"> 
<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Bookings</div>
<div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $this->db->count_all_results('bookings');
?> </div>
</a>
</div>
<div class="col-auto">
<i class="fas fa-calendar fa-2x text-gray-300"></i> 
</div> 
</div> 
</div> 
</div> 
</div> 
<!-- Single Earnings Card Example  -->

<!-- Single Earnings Card Example --> 
<div class="col-xl-3 col-md-6 mb-4"> 
<div class="card border-left-primary shadow h-100 py-2"> 
<div class="card-body"> <div class="row no-gutters align-items-center"> 
<div class="col mr-2"> 
<a href="<?php echo site_url();?>product/index"> 
<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Products</div>
<div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $this->db->count_all_results('products');
?> </div>
</a>
</div>
<div class="col-auto">
<i class="fas fa-calendar fa-2x text-gray-300"></i> 
</div> 
</div> 
</div> 
</div> 
</div> 
<!-- Single Earnings Card Example  -->



</div>

<?php $this->load->view('admin_footer');?>