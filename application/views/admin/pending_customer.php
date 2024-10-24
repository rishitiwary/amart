<?php
$this->load->view('admin_header');
$auth=$this->session->userdata;
if($auth['role']==3){
    redirect(base_url().'main/logout');
}
?>
<?php if(!empty($this->session->flashdata('success'))){ ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong><?php echo $this->session->flashdata('success'); ?></strong>   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
    <div class="records--list" data-title="Customers  Listing">
        <table id="recordsListView">
            <thead>   
            <tr>  
             <th>ID</th>  
             <th>Referral CODE</th>  
             <th>Referral By</th>  
             <th>Name</th>
             <th>Email</th>  
             <th>Mobile</th>  
             <?php if($auth['role']==1){ ?>
             <th colspan="1">Action</th> 
             <th>Approval Status</th>
             <th>Status</th>
             <th>Delete</th>
             <?php } ?>
            </tr> 
            </thead>
      <tbody>
       <?php  
       if(count($fetch_data) > 0)  
       {  
           $counter=1;
            foreach($fetch_data as $row)  
            {  
       ?>  
            <tr>  
                 <td><?php echo $counter; ?></td>  
                 <td><?php echo $row->referal_code; ?></td>
                 <td><?php echo $row->referal_id; ?></td>
                 <td><?php echo $row->name; ?></td>
                 <td><?php echo $row->email;?></td>  
                 <td><?php echo $row->mobile;?></td>  
                 <?php if($auth['role']==1){ ?>
                 <td><a href="<?php echo base_url(); ?>admin/view/<?php echo $row->id; ?>" class="btn btn-info">See Details</a></td> 
                 <?php if($row->status=='pending'){ ?>
                     <td><a href="<?php echo base_url(); ?>admin/approval/<?php echo $row->id; ?>" onclick="return confirm('Are You Sure for Appove ?')" class="btn btn-info">Approve Now</a></td>
                 <?php }else{ ?>
                 <td><a href="" class="btn btn-success">Approved</a></td>
                 <?php } ?>
                 <td><a href="<?php echo base_url();?>admin/approveUser/<?php echo $row->id;?>/<?php if($row->banned_users=='unban'){ echo 'ban'; }else{ echo 'unban'; } ?>" class="btn btn-info" onclick="return confirm('Are You Sure for Approve ?');"><?php if($row->banned_users=='unban'){ echo 'Active'; }else{ echo 'Deactive'; } ?></a></td>
                 <td><a href="<?php echo base_url();?>admin/deleteUser/<?php echo $row->id; ?>" onclick="return confirm('Are You Sure for Delete ?')" class="btn btn-danger">Delete</a></td>
                     
                 <?php } ?>
                
            </tr>  
       <?php       
            $counter++;
                
            }  
       }  
       ?>     
            </tbody>
        </table>
    </div>
</div>
<?php
$this->load->view('admin_footer');
?>

