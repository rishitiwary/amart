<?php
$this->load->view('admin_header');
?>
<div class="panel">
    <div class="records--list" data-title="Subscriber Listing">
        <table id="recordsListView">
            <thead>
                <tr> 
                    <th>Sl No.</th>
                    <th>Email</th>
                    <th>Date</th>
                   <th >Status</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                $count=1;
                if(count($fetch_subscriber) > 0)  
                { 
                    for($i=0;$i<count($fetch_subscriber);$i++){ ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $fetch_subscriber[$i]['email']; ?></td>
                    <td><?php echo date("F j, Y",strtotime($fetch_subscriber[$i]['created'])) ?></td>
                    <td><?php echo $fetch_subscriber[$i]['status']==1 ? 'Subscribed' :'UnSubscribed'; ?></td>
                                
                   <!--<td><a href="<?php echo base_url();?>admin/approveUser/<?php echo $fetch_subscriber[$i]['newsletterId'];?>/<?php if($fetch_subscriber[$i]['status']==1){ echo 'Subscribed'; }else{ echo 'UnSubscribed'; } ?>" class="btn btn-info" onclick="return confirm('Are You Sure ???');"><?php if($fetch_subscriber[$i]['status']==1){ echo 'UnSubscribed'; }else{ echo 'Subscribed'; } ?></a></td>                   -->
                </tr>
                <?php $count++; }} ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$this->load->view('admin_footer');
?>

