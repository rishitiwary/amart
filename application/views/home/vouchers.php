<div class="container">
<!--start .my-account -->
<div class="my-account-page">

<div class="left-sidebar">
    <ul>
        <li><a href="<?= base_url('dashboard') ?>">My Orders</a></li>
        <li><a href="<?= base_url('dashboard/address') ?>">Address</a></li>
        <li class="active"><a href="<?= base_url('dashboard/cards') ?>">Saved Cards</a></li>
        <li><a href="<?= base_url('dashboard/history') ?>">Historical Shopping</a></li>
        <li><a href="<?= base_url('dashboard/profile') ?>">Personal Details</a></li>
    </ul>
</div>

<div class="right-bx">

    <div class="bx-header">
        <label>SAVED CARDS</label>
        <div class="right-select">
            <span>Sort by :</span>
          <a href="#" class="add-new-button"> + Add New</a>
        </div>
    </div>

    <div class="bottom-box">
           

<div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
             
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Name on the Card</th>
              <td>xxxx xxxx 0034</td>
              <td>01/22</td>
              <td><img src="<?= base_url()?>images/common/delete.svg"></td>
            </tr>
            <tr>
              <th scope="row">Name on the Card</th>
              <td>xxxx xxxx 0034</td>
              <td>01/22</td>
              <td><img src="<?= base_url()?>images/common/delete.svg"></td>
            </tr>
            
           
            
          </tbody>
        </table>     
      </div>

    </div>

</div>

</div>
<!--end .my-account -->
</div>


