<?php
$this->load->view('admin_header');
?>
<div class="panel">
    <div class="records--list" data-title="Feedbacks Listing">
        <table id="recordsListView">
            <thead>
                <tr> 
                    <th>S No.</th>                    
                    <th>Email</th>                    
                    <th>Message</th>
                     <th>Date</th>
                     <th class="not-sortable">Actions</th> 
                </tr>
            </thead>
            <tbody>
                <tr><td></td>
                    <td></td>
                    <td colspan="" rowspan="" headers=""> No Data Found</td>
                    <td></td>
                    <td></td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>
<?php
$this->load->view('admin_footer');
?>

