<?php
require_once('database.php');
$email=$_SESSION['user'];
if($email==''){
   echo "<script>window.location.assign('index.php')</script>";
}
ini_set('display_errors',1);
error_reporting(E_ALL);
?>
<div class="panel">
    <div class="records--list" data-title="Product Listing">
        <table id="recordsListView">
            <thead>
                <tr> 
                    <th>S No.</th>
                    <th class="not-sortable">User Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Mobile</th>
                    <th>Date</th>

                     <th class="not-sortable">Actions</th> 
                </tr>
            </thead>
            	
           <?php
			$i=1;
			$select="SELECT * FROM tbl_registration";
            $rows=$connection->query($select);
            while($row=$rows->fetch())
            {

             ?>
			

            <tbody>
                <tr>
                    <td>
                       <?php  echo $i;  ?>
                    </td>
                    <td>
                    <?php  echo $row['user_name'];  ?>                        
                    </td>
                    <td> 
                    <?php  echo $row['email'];  ?>
                    </td> <td> 
                    <?php  echo $row['password'];  ?>
                    </td> <td> 
                    <?php  echo $row['mobile'];  ?>
                    </td> <td> 
                    <?php  echo $row['date'];  ?>
                    </td>                    
                    <td>
                    <a href="deleteuser.php?registrationId=<?php echo $row['user_id']; ?>  " class="btn btn primary">Delete</a>
                    </td>
                </tr>
                <?php
                $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


