<?php
$email=$_SESSION['user'];
if($email==''){
   echo "<script>window.location.assign('index.php')</script>";
}

try{
    $connection= new PDO("mysql:host=localhost;dbname=Santoshbakers",'root','');

    $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $error){

    echo $error->getMessage();

    die();

}
$productId=$_REQUEST['edit_id'];
$query="SELECT * FROM tbl_product WHERE product_id=$productId";
$statement=$connection->prepare($query);
$statement->bindValue(1,$productId);
if($statement->execute()){
$row=$statement->fetch();

}
?>
<div class="panel">
                        <div class="records--body">
                            <div class="title"> 
                                <h6 class="h6">Update Product</h6>  
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab01">
                                    <form action="" method="post" enctype="multipart/form-data">                                       <div class="form-group row">
                                            <span class="label-text col-md-3 col-form-label">Product Name: *</span> 
                                            <div class="col-md-9"> 
                                                <input type="text" name="productname" value="<?php echo $row['product_name'];?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row"> 
                                            <span class="label-text col-md-3 col-form-label">Product Price:</span>
                                            <div class="col-md-9"> 
                                                <input type="number" name="productprice" value="<?php echo $row['price'];?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <span class="label-text col-md-3 col-form-label">Description: *</span>
                                            <div class="col-md-9">
                                                <textarea name="discription"  class="form-control" required><?php echo $row['discription'];?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <span class="label-text col-md-3 col-form-label">Category:</span>
                                            <div class="col-md-9">
                                               <select name="category" required>
                                                    <option  value="sugarfree" <?php if($row['category']=='sugarfree'){echo 'selected="selected"';}?>">SugarFree Cake</option>
                                                    <option  value="eggless"  <?php if($row['category']=='eggless'){echo 'selected="selected"';}?>">Egless Cake</option>
                                                    <option  value="pastry"  <?php if($row['category']=='pastry'){echo 'selected="selected"';}?>">Pastry</option>
                                                    <option  value="chocandcold" <?php if($row['category']=='chocandcold'){echo 'selected="selected"';}?>">Chocklate &Coldrink</option>
                                                    <option  value="decorative" <?php if($row['category']=='decorative'){echo 'selected="selected"';}?>">Decorative Material</option>
                                                    <option  value="eatable"<?php if($row['category']=='eatable'){echo 'selected="selected"';}?>">Eatable</option>
                                                </select>
                                        </div>
                                        </div>
                                        <div class="form-group row">
                                            <span class="label-text col-md-3 col-forcm-label">Image:</span>
                                            <div class="col-md-9">
                                                <input type="file" name="files" class="form-control" required > </div>
                                        </div>
                                        
                                        <div class="row mt-3">
                                            <div class="col-md-9 offset-md-3">
                                                <input type="submit" name="updateproduct" value="Update Product" class="btn btn-rounded btn-success">
                                            </div>
                                        </div>
                                    </form>
                                </div>
</div>
</div>
</div>

<?php
$dbimage="../img/product/".$row['picture'];
extract($_POST);
ob_start();
ini_set('dispay_errors',1);
error_reporting(E_ALL);
if(isset($updateproduct)){

if(isset($_FILES['files']))

{
    
$fileName=$_FILES['files']['name'];
$fileSize=$_FILES['files']['size'];
$fileType=$_FILES['files']['type'];
$fileTempName=$_FILES['files']['tmp_name'];

$location="../img/product/";

$ext=strtolower(end(explode('.',$fileName)));

    if(!file_exists($location.$fileName))
    {
     if($ext=='png' || $ext=='jpeg' || $ext=='jpg'){ 
if(unlink("$dbimage")){
    if(move_uploaded_file($fileTempName,$location.$fileName)){
            $query="UPDATE tbl_product SET product_name=?,price=?,discription=?,category=?,picture=? WHERE product_id=?";
            $statement=$connection->prepare($query);
            $statement->bindValue(1,$productname);
            $statement->bindValue(2,$productprice);
            $statement->bindValue(3,$discription);
            $statement->bindValue(4,$category);
            $statement->bindValue(5,$fileName);
            $statement->bindValue(6,$productId);
if($statement->execute()){
    echo "<script>alert('  Product Updated  Successfully')</script>";
}

// End Database codes    
    }else{
     echo "<script>alert('Sorry ! Can Not Be Update Product ')</script>";
    }     
}
    }else{
        echo "<script>alert('Sorry ! only jpg , jpeg , png file allowed ')</script>";
     
    }
     }
else{
    echo "<script>alert('image  allready exist ! Please Try Another file ')</script>";
   }

}
}
?>