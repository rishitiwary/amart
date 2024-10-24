<?php
$this->load->view('admin_header');
$auth = $this->session->userdata;
if ($auth['role'] == 3) {
    redirect(base_url() . 'main/logout');
}

?>
<style>
    .dataTables_length {
        padding: 0.5em 46px 10px;
        border: 0;
        border-right: 0 !important;
    }

    .dataTables_filter input {
        margin-top: 0.5em;
        margin-right: 4.5em;
        border-color: grey;
        border-width: thin;
    }

    .dataTables_info {
        padding: 23px 46px 10px !important;

    }
</style>
<?php if (!empty($this->session->flashdata('success'))) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><?php echo $this->session->flashdata('success'); ?></strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>
<?php if (!empty($this->session->flashdata('error'))) { ?>
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
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Add/View Variants</th>
                    <th>Sub Category</th>
                    <th>Product Code</th>
                    <th>Status</th>
                    <?php if ($auth['role'] == 1) { ?>
                        <th class="not-sortable">Action</th>
                      
                    <?php } ?>

                </tr>
            </thead>
            <tbody>
                <?php
                if (count($fetch_data) > 0) {
                    $i = 1;
                    foreach ($fetch_data as $row) {
                ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                           
                            <td><?php echo $row->name; ?></td>
                            <td><?=$row->brand;?></td>
                            <td>
                               <a href="<?=base_url()?>product/addVariants/<?=$row->id?>"> <i class="fa fa-plus"></i>
                               </a>
                              &nbsp; <a href="<?=base_url()?>product/viewVariants/<?=$row->id?>"> <i class="fa fa-eye"></i></a>
                        </td>
                             
                            <td><?php echo $row->category; ?></td>
                            <td><?php echo $row->product_code; ?></td>
                            
                            <td><?php if ($row->status == '1') {
                                    echo 'Active';
                                } ?><?php if ($row->status == '0') {
                                                                                    echo 'Deactive';
                                                                                } ?></td>
                            <?php if ($auth['role'] == 1) { ?>
                                <td><a href="<?php echo base_url(); ?>product/delete/<?php echo $row->id; ?>/<?php echo $row->image; ?>" onclick="return confirm('Are you sure you want to delete this?')" class="delete_data btn btn-danger" id="<?php echo $row->id; ?>"><i class="fa fa-trash"></i></a>
                                &nbsp;
                                <a href="<?php echo base_url(); ?>product/update/<?php echo $row->id; ?>" class="btn btn-info"><i class="fa fa-edit"></i></a></td>
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
<script>
    $(document).ready(function() {
        $('#tableproduct').DataTable({
            "paging": true,
            "ordering": true,
            "info": true
        });
    });
</script>
<?php
$this->load->view('admin_footer');
?>