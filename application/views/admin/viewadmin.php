<?php
$this->load->view('admin_header');
?>
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
<div class="panel">
<div class="records--list" data-title="Admin Listing">
    <div class="records--list">
        <table id="recordsListView">
            <thead>
                <tr> 
                    <th>S No.</th>
                    <th>Admin Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Last Login</th>
                    <th>Status</th>
                </tr>
            </thead>
            	
            <?php
            if(count($fetch_data) >0){
                $i=1;
                foreach($fetch_data as $row){
            ?>
            <tbody>
                <tr>
                    <td>
                    <?php  echo $i;  ?>
                    </td>
                    <td> 
                    <?php  echo $row['name'];  ?>  
                    </td>
                    <td> 
                    <?php  echo $row['email'];  ?>
                    </td>
                    <td> 
                    <?php  echo $row['mobile'];  ?>
                    </td>
                    <td> 
                    <?php  echo $row['last_login'];  ?>
                    </td> 
                    <td><a href="<?php echo base_url();?>admin/approveUser/<?php echo $row['id'];?>/<?php if($row['banned_users']=='unban'){ echo 'ban'; }else{ echo 'unban'; } ?>" class="btn btn-info" onclick="return confirm('Are You Sure ???');"><?php if($row['banned_users']=='unban'){ echo 'Active'; }else{ echo 'Deactive'; } ?></a></td>                   
                </tr>
                <?php
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

