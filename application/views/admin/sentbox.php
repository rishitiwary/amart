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
                    <th class="not-sortable">From</th>
                    <th>To</th>
                    <th>Subject</th>
                    <th>Message</th>
                     <th>Date</th>
                     <th class="not-sortable">Actions</th> 
                </tr>
            </thead>
            	
           <?php
			$i=1;
			$select="SELECT * FROM tbl_compose where Fromm='$email'";
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
                    <?php  echo $row['Fromm'];  ?>                        
                    </td>
                    <td> 
                    <?php  echo $row['Too'];  ?>                        
                    </td>
                    <td> 
                    <?php  echo $row['subject'];  ?>                        
                    </td>
                    <td> 
                    <?php  echo $row['message'];  ?>                        
                    </td>
                    <td> 
                    <?php  echo $row['date'];  ?>
                    </td>                    
                    <td>
                    <a href="trashdelete.php?msgId=<?php echo $row['msg_id']; ?> " class="btn btn primary">Delete</a>
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


