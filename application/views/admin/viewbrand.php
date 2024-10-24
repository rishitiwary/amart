<?php
$this->load->view('admin_header');
$auth=$this->session->userdata;
if($auth['role']==3){
redirect(base_url().'main/logout');
}

?>
<style>
.dataTables_length{
padding: 0.5em 46px 10px;
border: 0 ;
border-right:0 !important;
}
.dataTables_filter input {
margin-top: 0.5em;
margin-right: 4.5em;
border-color: grey;border-width: thin;
}
.dataTables_info {
padding: 23px  46px 10px !important;

}
</style>
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
<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
<div class="panel">
<div class="records--list" data-title="Product Listing">
<div class="topbar">
<div class="toolbar">PRODUCT LISTING</div>
<div class="right">
<div class="dataTables_length" id="recordsListView_length"></div>
</div>
</div>
<table id="tableproduct">
<thead>
<tr> 
<th>S No.</th>
<th class="not-sortable">Image</th>
<th>Name</th>

<th>Description</th>

<th>Status</th>  

<th class="not-sortable">Delete</th>  
<th class="not-sortable">Update</th>


</tr>
</thead>
<tbody>
<?php  
if(count($brand) > 0)  
{  
$i=1;
foreach($brand as $row)  
{  
?>  
<tr>  
<td><?php echo $i; ?></td>  
<td><a href="<?php echo base_url().'uploads/products/'.$row->image; ?>" target="_blank"><img src="<?php echo base_url().'uploads/products/'.$row->image; ?>" class="adminGridImg"></a></td>  
<td><?php echo $row->bname; ?></td>
<td><?php echo $row->description; ?></td>

<td><?php if($row->status=='1'){echo 'Active';}?><?php if($row->status=='0'){echo 'Deactive';}?></td>  

<td><a href="<?php echo base_url(); ?>product/deletebrand/<?php echo $row->id;?>/<?php echo $row->image;?>" onclick="return confirm('Are you sure you want to delete this?')" class="delete_data btn btn-danger" id="<?php echo $row->id; ?>">Delete</a></td>  
<td><a href="<?php echo base_url(); ?>product/updatebrand/<?php echo $row->id; ?>" class="btn btn-info">Edit</a></td> 

</tr>  
<?php 
$i++;      
}  
}  
?>           
</tbody>
</table>
</div>
</div>
<script>
$(document).ready(function() {
$('#tableproduct').DataTable( {
"paging":   true,
"ordering": true,
"info":     true
} );
} );
</script>
<?php
$this->load->view('admin_footer');
?>

