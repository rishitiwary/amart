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
    <div class="records--list" data-title="Category Listing">
        <table id="recordsListView">
            <thead>
                <tr> 
                    <th>S No.</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Number Of Subcategory</th>
                     <th class="not-sortable">Delete</th> 
                     <th class="not-sortable">Edit</th> 
                     <th class="not-sortable">View</th> 
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
                            <td><?php echo $i; ?></td> 
                            <td><a href="<?php echo base_url().'uploads/categories/'.$row->image; ?>" target="_blank"><img src="<?php echo base_url().'uploads/categories/'.$row->image; ?>" class="adminGridImg"></a></td>
                            <td><?php echo $row->category; ?></td>    
                            <td><?php if($row->status=='1'){echo 'Active';}?><?php if($row->status=='0'){echo 'Deactive';}?></td>  
                            <td><?php
                            $this->db->where(array('parent_category'=>$row->id));
                            $this->db->from('categories');
                            echo $this->db->count_all_results();
                            ?></td>
                            <td><a href="<?php echo base_url(); ?>category/delete/<?php echo $row->id;?>/<?php echo $row->image;?>" onclick="return confirm('Are you sure you want to delete this?')" class="delete_data btn btn-danger" id="<?php echo $row->id; ?>">Delete</a></td>
                            
                            <td><a href="<?php echo base_url(); ?>category/update/<?php echo $row->id; ?>" class="btn btn-info">Edit</a></td> 
                            <?php if($row->parent_category==0){ ?>
                                <td><a href="<?php echo base_url(); ?>category/view/<?php echo $row->id; ?>" class="btn btn-info">View</a></td> 
                            <?php } else{ ?> 
                                <td><a class="btn btn-danger">View</a></td> 
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

