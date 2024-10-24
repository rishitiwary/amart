
<div class="app_content col-lg-9">
          <div class="mail-compose">
           <h3 class="mail-compose__title">Compose New Message</h3> 
        <form action="" method="post">
        <div class="form-group"> 
            <input type="email" name="mail_from" value="<?php echo $email;?>" class="form-control" style="background-color:white;" readonly>
        </div>
        <div class="form-group"> 
            <input type="email" name="mail_to" placeholder="To:" class="form-control" required>
        </div>
            <div class="form-group">
         <input type="text" name="mail_subject" placeholder="Subject:" class="form-control" required>
        </div>
        <div class="form-group">
         <textarea name="mail_message" class="form-control" placeholder="Message:"data-trigger="summernote" required></textarea>
        </div>
        <div class="btn-list pt-3">
            <input type="submit" name="send" value="Send" class="btn btn-submit btn-primary" name="send"/>
        </div>
        </form>
        </div>
</div>
<?php
require_once('database.php');
$email=$_SESSION['user'];
if($email==''){
    echo "<script>window.location.assign('index.php')</script>";
}

ob_start();
if(isset($_POST['send'])){
    $to =$_POST['mail_to'];
    $subject =$_POST['mail_subject'];
    $txt = $_POST['mail_message'];
    $headers = "From:".$email;
    
$query="INSERT INTO tbl_compose(Fromm,Too,subject,message,date) VALUES (?,?,?,?,NOW())";
$statement=$connection->prepare($query);
$statement->bindValue(1,$email);
$statement->bindValue(2,$_POST['mail_to']);
$statement->bindValue(3,$_POST['mail_subject']);
$statement->bindValue(4,$_POST['mail_message']);
if($statement->execute()){    
$emailStatus= mail($to,$subject,$txt,$headers);
if($emailStatus) {
echo "<script>alert('Email Sent Successfully!')</script>";
} else {
echo "<script>alert('Sorry ! Email  Could Not Be Sent Please Try Again... ')</script>";
}    

}
else{
     echo "<script>alert('Sorry ! Something Went Wrong ')</script>";
         }


}
?>


