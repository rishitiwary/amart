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
            <div class="toolbar">VARIANT LISTING</div>
            <div class="right">
                <div class="dataTables_length" id="recordsListView_length">
                    <a href="<?=base_url()?>/product/addVariants/<?=$product_id;?>"><button class="btn btn-primary">Add Variants</button></a>
                </div>
            </div>
        </div>
        <table id="tableproduct">
            <thead>
                <tr>
                    <th>S No.</th>
                    <th class="not-sortable">Image</th>
                    <th>VId</th>
                    <th>ProductId</th>
                    <th>Cost Price</th>
                    <th>Product Price</th>
                    <th>Selling Price</th>

                    <th>Quantity</th>
                    <th>Min.Order Qty</th>
                    <th>Size</th>
                    <th>Type</th>
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
                            <td><button type="btn btn-sm" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    View
                                </button></td>
                            <td><?php echo $row->id; ?></td>
                            <td>
                                <?= $row->product_id ?>
                            </td>
                            <td><?php echo $row->cost_price; ?></td>
                            <td><?php echo $row->price; ?></td>
                            <td><?php echo $row->offer_price; ?></td>
                            <td><?php echo $row->quantity; ?></td>
                            <td><?php echo $row->min_order_qty; ?></td>
                            <td><?= $row->value ?>&nbsp;<?php echo $row->unit; ?></td>
                            <td><?php echo $row->packing_type; ?></td>
                            <td><?php if ($row->status == '1') {
                                    echo 'Active';
                                } ?><?php if ($row->status == '0') {
                                        echo 'Deactive';
                                    } ?></td>
                            <?php if ($auth['role'] == 1) { ?>
                                <td><a href="<?php echo base_url(); ?>product/variantDelete/<?php echo $row->id; ?>/<?= $row->product_id ?>" onclick="return confirm('Are you sure you want to delete this?')" class="delete_data btn btn-danger" id="<?php echo $row->id; ?>"><i class="fa fa-trash"></i></a>
                                    &nbsp;
                                    <a href="<?php echo base_url(); ?>product/VariantUpdate/<?php echo $row->id; ?>/<?=$row->product_id?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                </td>
                            <?php } ?>
                        </tr>
                <?php
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>
        <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Variant Images</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="row">
        <?php foreach($images as $rows){?>

      
        <div class="col-lg-6 col-xs-12">
            <img src="<?=base_url()?>uploads/products/<?=$rows->images?>" style="height:150px;">
        <a href="<?=base_url()?>product/deleteVariantImage/<?=$rows->id?>/<?=$rows->images?>"><i class="fa fa-trash"></i></a>
        </div>
        <?}?>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  
      </div>
    </div>
  </div>
</div>
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