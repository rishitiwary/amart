<div class="container">
  <!--start .my-account -->
  <div class="my-account-page">

    <div class="left-sidebar">
      <ul>
        <li><a href="<?= base_url('dashboard') ?>">My Orders</a></li>
        <li class="active"><a href="<?= base_url('dashboard/address') ?>">Address</a></li>
        <li><a href="<?= base_url('dashboard/favourite')?>">Favourite</a></li>
        <li><a href="<?= base_url('dashboard/password')?>">Change Password</a></li>
        <li><a href="<?= base_url('dashboard/profile')?>">Personal Details</a></li>
      </ul>
    </div>

    <div class="right-bx">
         <?php if($this->session->flashdata('success')){ ?>
          <div class="alert alert-success">
            <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
            <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php }else if($this->session->flashdata('error')){  ?>
          <div class="alert alert-danger">
            <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
            <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php }else if($this->session->flashdata('warning')){  ?>
          <div class="alert alert-warning">
            <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
            <strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
          </div>
        <?php }else if($this->session->flashdata('info')){  ?>
          <div class="alert alert-info">
            <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
            <strong>Info!</strong> <?php echo $this->session->flashdata('info'); ?>
          </div>
        <?php } ?>
      <div class="bx-header">
        <label>My Address</label>
        <div class="right-select">
          
            <div class="btn btn-primary"><a href="<?= base_url('dashboard/addAddress') ?>"> Add New Address</a> </div>
        
        </div>
      </div>

      <div class="bottom-box">


        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Landmark</th>
                <th scope="col">Mobile</th>
                 <th scope="col">Edit</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>
              
              <?php foreach ($addList as $key => $add): ?>
                 <tr>
                <th scope="row"><?=$add->name?></th>
                <td><?=$add->address?></td>
                <td><?=$add->landmark?></td>
                <td><?=$add->mobile?></td>
                 <td><a href="<?=base_url()?>dashboard/editaddress/<?=$add->id?>" class="btn btn-primary" target="_blank" data-toggle="tooltip" title="Edit Address"><i class="fa fa-edit" aria-hidden="true"></i></td>
                <td><a href="<?=base_url()?>dashboard/deleteaddress/<?=$add->id?>" class="btn btn-danger" target="_blank" data-toggle="tooltip" title="Delete Address"><i class="fa fa-trash" aria-hidden="true"></i></td>
              </tr>
                
              <?php endforeach ?>
              <?php if(count($addList) =='0'){ ?>
               <tr>
                <td colspan="4">             
                  <p>No Address found</p>            
                </td>
              </tr>
              <?php }?>

            </tbody>
          </table>     
        </div>

      </div>

    </div>

  </div>
  <!--end .my-account -->
</div>