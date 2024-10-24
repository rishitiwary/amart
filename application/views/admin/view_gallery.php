<?php
$this->load->view('admin_header');
$auth=$this->session->userdata;
if($auth['role']==3){
    redirect(base_url().'main/logout');
}
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
    <div class="records--list" data-title="Banner Listing">
        <table id="recordsListView">
            <thead>
                <tr> 
                    <th>S No.</th>
                    <th class="not-sortable">Image</th>
                    <th>Status</th>
                    <th class="not-sortable">Delete</th> 
                    <th class="not-sortable">Edit</th> 
                </tr>
            </thead>
            <tbody>
            <?php  
                if(count($fetch_data) > 0)  
                {  
                    $i=1;
                    foreach($fetch_data as $row)  
                    {  
                ?>  
                  <tr>  
                     <td><?php echo $row->id; ?></td>  
                     <td><a href="<?php echo base_url().'uploads/galleries/'.$row->image; ?>" target="_blank"><img src="<?php echo base_url().'uploads/galleries/'.$row->image; ?>" class="adminGridImg"></a></td>  
                     <td><?php if($row->status=='1'){echo 'Active';}?><?php if($row->status=='0'){echo 'Deactive';}?></td>  
                     <?php if($auth['role'] ==1){ ?>
                     <td><a href="<?php echo base_url(); ?>gallery/delete/<?php echo $row->id;?>/<?php echo $row->image;?>" onclick="return confirm('Are you sure you want to delete this?')" class="delete_data btn btn-danger" id="<?php echo $row->id; ?>">Delete</a></td>  
                     <td><a href="<?php echo base_url(); ?>gallery/update/<?php echo $row->id; ?>" class="btn btn-info">Edit</a></td> 
                     <?php } ?>
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

<?php
$this->load->view('admin_footer');
?>

