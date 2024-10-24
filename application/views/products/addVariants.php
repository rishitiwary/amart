<?php
$this->load->view('admin_header');
?>

<div class="panel">
    <div class="records--body">
        <div class="title">
            <h6 class="h6"><?php if ($res[0]->id != '') {
                                echo 'Update';
                            } else {
                                echo 'Insert';
                            } ?> Variant</h6>
        </div>
        <div class="tab-content">
        <?php
            $message = $this->session->flashdata('success');
            if (isset($message)) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' . $message . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>';
            }
            ?>
            <div class="tab-pane fade show active" id="tab01">
                <form action="<?php echo base_url(); ?>product/AddVariants" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?= $productId ?>" />
                    <input type="hidden" name="vid" value="<?= $res[0]->id ?>">
                    <div class="form-group row">
                        <span class="label-text col-md-3 col-form-label">Cost Price:</span>
                        <div class="col-md-9">
                            <input type="number" step="any" value="<?= $res[0]->cost_price ?>" name="cost_price" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <span class="label-text col-md-3 col-form-label">Product Price:</span>
                        <div class="col-md-9">
                            <input type="number" step="any" name="price" value="<?= $res[0]->price ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <span class="label-text col-md-3 col-form-label">Selling Price:</span>
                        <div class="col-md-9">
                            <input type="number" step="any" value="<?= $res[0]->offer_price ?>" name="offer_price" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <span class="label-text col-md-3 col-form-label">Product Code:</span>
                        <div class="col-md-9">
                            <input type="text" name="product_code" value="<?= $res[0]->product_code ?>" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <span class="label-text col-md-3 col-form-label">Unit:</span>
                        <div class="col-md-9">
                            <input type="text" name="unit" value="<?= $res[0]->unit ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <span class="label-text col-md-3 col-form-label">Value:</span>
                        <div class="col-md-9">
                            <input type="number" min=1 name="value" value="<?= $res[0]->value ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <span class="label-text col-md-3 col-form-label">Packing Type:</span>
                        <div class="col-md-9">
                            <input type="text" name="packing_type" value="<?= $res[0]->packing_type ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <span class="label-text col-md-3 col-form-label">Product Quantity:</span>
                        <div class="col-md-9">
                            <input type="number" name="quantity" value="<?= $res[0]->quantity ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <span class="label-text col-md-3 col-form-label">Minimum Order Quantity:</span>
                        <div class="col-md-9">
                            <input type="number" min=1 value="<?= $res[0]->min_order_qty ?>" name="min_order_qty" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <span class="label-text col-md-3 col-form-label"> Expiry Date:</span>
                        <div class="col-md-9">
                            <input type="date" min=1 value="<?= $res[0]->expiry_date ?>" name="expiry_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <span class="label-text col-md-3 col-form-label">Image:</span>
                        <div class="col-md-9">
                            <input type="file" name="image_file[]" multiple class="form-control" <?php if ($res[0]->id == "") echo 'required'; ?>>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-9 offset-md-3">




                            <input type="submit" name="insertproduct" value=<?php if ($res[0]->id != '') {
                                                                                echo '"Update Variants"';
                                                                            } else {
                                                                                echo '"Insert Variant"';
                                                                            } ?> class="btn btn-rounded btn-success">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php
$this->load->view('admin_footer');
?>