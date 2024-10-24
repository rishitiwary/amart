<?php
$this->load->view('admin_header');
?>
<?php  
if(isset($user_data))  
{  
foreach($user_data as $row)  
{ 
?> 
<div class="panel">
<div class="records--body">
    <div class="title"> 
        <h6 class="h6">Update Offer</h6>  
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="tab01">
            <form action="<?php echo base_url();?>offer/store" method="post" enctype="multipart/form-data">                                       <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Product Name: *</span> 
                    <div class="col-md-9"> 
                        <input type="text" value="<?php echo $row->name;?>" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row"> 
                    <span class="label-text col-md-3 col-form-label">Price & Percentage:</span>
                    <div class="col-md-3"> 
                        <input id="ProductPrice" type="number" step="any" value="<?php echo $row->price;?>" name="price" class="form-control" required>
                    </div>
                    <div class="col-md-3"> 
                        <input id="OfferPercentage" type="number" step="any" value="<?php echo $row->offer_percentage;?>" name="offer_percentage" class="form-control" required>
                    </div>
                    <div class="col-md-3"> 
                        <input id="OfferPrice" type="number" step="any" value="<?php echo $row->offer_price;?>" name="offer_price" class="form-control" readonly required>
                    </div>
                </div>
                <div class="form-group row"> 
                <span class="label-text col-md-3 col-form-label">Product Code:</span>
                    <div class="col-md-9"> 
                        <input type="text" value="<?php echo $row->product_code;?>" name="product_code" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row"> 
                <span class="label-text col-md-3 col-form-label">Country:</span>
                    <div class="col-md-9"> 
                        <input type="text" value="<?php echo $row->country;?>" name="country" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row"> 
                <span class="label-text col-md-3 col-form-label">Weight:</span>
                    <div class="col-md-9"> 
                        <input type="text" value="<?php echo $row->weight;?>" name="measure" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row"> 
                <span class="label-text col-md-3 col-form-label">Product Quantity:</span>
                    <div class="col-md-9"> 
                        <input type="number" value="<?php echo $row->quantity;?>" name="quantity" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Description: *</span>
                    <div class="col-md-9">
                        <textarea name="description" class="form-control" required> <?php echo $row->description; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Category:</span>
                    <div class="col-md-4">
                    <select id="categoryId" class="form-control" name="category" required onchange="fetchSubcategories()">
                        <option value="">Select Category ....</option>
                        <?php
                        
                        if(count($fetch_subcategory) > 0)  
                        {  
                            foreach($fetch_subcategory as $row2)  
                            { 
                                if($row2->id==$row->category_id){ 
                                    $parentCategoryHidden=$row2->parent_category;
                                    break;
                                }
                            }
                        }
                        
                        if(count($fetch_category) > 0)  
                        {  
                            
                            foreach($fetch_category as $row2)  
                            { ?>
                            <option value="<?php echo $row2->id; ?>" <?php if($row2->id==$parentCategoryHidden){ echo 'selected'; } ?>><?php echo $row2->category; ?></option>
                            <?php }
                        }
                        ?>  
                    </select>
                    </div>
                    <div class="col-md-5">
                    <select name="category_id" id="subcategoryId" class="form-control" required>
                        <option value="">Select an Sub-Category ....</option>
                        <?php  
                        if(count($fetch_subcategory) > 0)  
                        {  
                            foreach($fetch_subcategory as $row2)  
                            { 
                                if($row2->id==$row->category_id){ $parentCategoryHidden=$row2->parent_category; }
                            ?>
                            <option value="<?php echo $row2->id; ?>" <?php if($row2->id==$row->category_id){ echo 'selected'; } ?>><?php echo $row2->category; ?></option>
                            <?php }
                        }
                        ?> 
                    </select>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Image:</span>
                    <div class="col-md-9">
                        <input type="file" name="image_file" class="form-control"> </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Status:</span>
                    <div class="col-md-9">
                    <select id="" class="form-control" name="status" required>
                    <option value="">Choose...</option>
                    <option value="1" <?php if($row->status=='1'){echo 'selected';}?>>Active</option>
                    <option value="0" <?php if($row->status=='0'){echo 'selected';}?>>Deactive</option>
                    </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-9 offset-md-3">
                        <input type="hidden" value="<?php echo $row->id;?>" name="hidden_id" class="form-control" required>
                        <input type="submit" name="updateproduct" value="Update Product" class="btn btn-rounded btn-success">
                    </div>
                </div>
            </form>
        </div>
</div>
</div>
</div>

<?php
}
}else{
?>
<div class="panel">
<div class="records--body">
    <div class="title"> 
        <h6 class="h6">Insert Offer</h6>  
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="tab01">
            <form action="<?php echo base_url();?>offer/store" method="post" enctype="multipart/form-data">                                       <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Product Name: *</span> 
                    <div class="col-md-9"> 
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row"> 
                    <span class="label-text col-md-3 col-form-label">Price & Percentage:</span>
                    <div class="col-md-3"> 
                        <input id="ProductPrice" placeholder="Enter Price" type="number" step="any" name="price" class="form-control" required>
                    </div>
                    <div class="col-md-3"> 
                        <input id="OfferPercentage" placeholder="Percentage" type="number" value="0" step="any" name="offer_percentage" class="form-control" required>
                    </div>
                    <div class="col-md-3"> 
                        <input id="OfferPrice" placeholder="Offer Price" type="number" step="any" name="offer_price" class="form-control" readonly required>
                    </div>
                </div>
                <div class="form-group row"> 
                <span class="label-text col-md-3 col-form-label">Product Code:</span>
                    <div class="col-md-9"> 
                        <input type="text" name="product_code" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row"> 
                <span class="label-text col-md-3 col-form-label">Country:</span>
                    <div class="col-md-9"> 
                        <input type="text" name="country" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row"> 
                <span class="label-text col-md-3 col-form-label">Weight:</span>
                    <div class="col-md-9"> 
                        <input type="text" name="measure" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row"> 
                <span class="label-text col-md-3 col-form-label">Product Quantity:</span>
                    <div class="col-md-9"> 
                        <input type="number" name="quantity" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Description: *</span>
                    <div class="col-md-9">
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Category:</span>
                    <div class="col-md-4">
                    <select id="categoryId" class="form-control" name="category" required onchange="fetchSubcategories()">
                        <option value="">Select Category ....</option>
                        <?php  
                        if(count($fetch_category) > 0)  
                        {  
                            foreach($fetch_category as $row2)  
                            { ?>
                            <option value="<?php echo $row2->id; ?>"><?php echo $row2->category; ?></option>
                            <?php }
                        }
                        ?>  
                    </select>
                    </div>
                    <div class="col-md-5">
                    <select name="category_id" id="subcategoryId" class="form-control" required>
                        <option value="">Select an Sub-Category ....</option>
                    </select>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Image:</span>
                    <div class="col-md-9">
                        <input type="file" name="image_file" class="form-control" required> </div>
                </div>
                <div class="form-group row">
                    <span class="label-text col-md-3 col-form-label">Status:</span>
                    <div class="col-md-9">
                    <select id="" class="form-control" name="status" required>
                        <option value="">Select Status ....</option>
                        <option value="1">Active</option>
                        <option value="0">Deactive</option>
                    </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-9 offset-md-3">
                        <input type="submit" name="insertproduct" value="Insert Product" class="btn btn-rounded btn-success">
                    </div>
                </div>
            </form>
        </div>
</div>
</div>
</div>
<?php } ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $.isNumeric($('#ProductPrice').val())? $('#OfferPercentage').removeAttr('readonly') : $('#OfferPercentage').attr('readonly','true');
    $('#ProductPrice').keyup(function(){
        $.isNumeric($('#ProductPrice').val())? $('#OfferPercentage').removeAttr('readonly') : $('#OfferPercentage').attr('readonly','true');
   }) ; 
   $('#OfferPercentage').keyup(function(){
       var ProductPrice=$('#ProductPrice').val();
       if($.isNumeric($('#OfferPercentage').val())){
           var OfferPrice=(ProductPrice - ( ProductPrice * $('#OfferPercentage').val() / 100 )).toFixed(2);
           $('#OfferPrice').val(OfferPrice);
       }
   }) ;
});
function fetchSubcategories(){
    var category= $('#categoryId').val();
    if(category.trim() !=''){
    $.ajax({
        "url":"<?php echo base_url();?>product/fetchCategory/"+category,
        "method":"POST",
        "success":function(response){
            var obj=JSON.parse(response);
            console.log(obj);
            var output='<option value="">Select an Sub-Category</option>';
            for(var i=0;i<obj.length;i++){
               output+='<option value="'+obj[i].id+'">'+obj[i].category+'</option>'; 
            }
            $('#subcategoryId').html(output);
        },
        "error":function(err){
            console.log(err);
        }
    });
    }
}
</script>
<?php
$this->load->view('admin_footer');
?>