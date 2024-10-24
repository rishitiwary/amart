<!-- start footer -->
<footer class="footer">
  <ul class="container">
    <li class="box-info">
      <div class="heading">Store Information</div>
      <div>
        <figure><img src="<?= base_url('images/common/footer-location.svg')?>"></figure>
        <span>Block 3, Shop 104, Al Aweer Fruits & Vegetables Central Market Dubai UAE</span>
      </div>
      <div>
        <figure><img src="<?= base_url('images/common/call.svg')?>"></figure>
        <span>Call us:  +97154 365 8181 / 04 349 6045</span>
      </div>
      <div>
        <figure><img src="<?= base_url('images/common/email.svg')?>"></figure>
        <span>Email us: <a href="mailto:Yaldafresh@gmail.com">Yaldafresh@gmail.com</a></span>
      </div>

    </li>
    <li>
      <div class="heading">Products</div>
      <ul>
        <li><a href="<?=base_url('home/category/4')?>">Fruits</a></li>
        <li> <a href="<?=base_url('home/category/5')?>">Vegetables</a></li>
        <li><a href="<?=base_url('home/category/7')?>">Green Leaves</a></li>
        <li><a href="<?=base_url('home/category/98')?>">Snacks</a></li>
      </ul>
    </li>

    <li>

      <div class="heading">Information</div>
      <ul>
        <li><a href="<?= base_url('about')?>">About Us</a></li>
        <li><a href="<?= base_url('policy')?>">Privacy policy</a></li>
        <li><a href="<?= base_url('refund')?>">Return Policy</a></li>
        <li><a href="<?= base_url('terms')?>">Terms & Conditions</a></li>
        <li><a href="<?= base_url('faq')?>">FAQs</a></li>
        <li><a href="<?= base_url('delivery')?>">Delivery Information</a></li>
       
      </ul>
    </li>
    <li>
      <div class="heading">Your Account</div>
      <ul>
        <li><a href="<?= base_url('dashboard')?>">My Dashboard</a></li>
        <li><a href="<?= base_url('dashboard/profile')?>">Personal Details</a></li>
        <li><a href="<?= base_url('dashboard')?>">My Orders</a></li>
        <li><a href="<?= base_url('dashboard/address')?>">Address Book</a></li>
      </ul>
    </li>
  </ul>
  <div class="container">
   <img src="<?= base_url('images/common/payment.svg')?>"></figure>

    </div>
     <p class="container copyright">&copy; <?php echo date("Y"); ?> yaldafresh.com. All rights reserved.</p>
<div class="text-center">
<p>
Design and Developed by <a href="https://aimstormsolutions.com/" target="_blank">Aimstorm Solutions
</a>
</p>
</div>
</footer>
<script src="<?= base_url('js/jquery-3.2.1.slim.min.js')?>" ></script>
<script src="<?= base_url('js/popper.min.js')?>" ></script>
<script src="<?= base_url('js/bootstrap.min.js')?>" ></script>
<script src="<?= base_url('js/owl.carousel.min.js')?>" ></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5f5cb710d3589c001281076a&product=inline-share-buttons" async="async"></script>
<script>
//mobile
$(document).ready(function()
{
  if ($(window).width() < 767)
  {	

    $(".menu").appendTo( ".mobile-menu" );

    $(".m-menu").click(function(){
      jQuery('.mobile-menu').animate({left:'0'});
      $("body").addClass("no-scroll");
      $(".menu-overlay").addClass("active");
    });

    $(".menu-overlay").click(function(){
      jQuery(this).removeClass("active");
      $("body").removeClass("no-scroll");
      jQuery('.mobile-menu').animate({left:'-100%'});
    });

  }
});

$('.cartData').on('click',function(){
  location.href="<?php echo base_url('dashboard/cart')?>";
})

if(sessionStorage.getItem('username')!="" && sessionStorage.length>0){
  $('.withlogin').show();
  $('.nologin').hide();
  $('.loginTab').text(sessionStorage.getItem('username').toUpperCase());
}

$('#logoutbtn').on('click',function()
{
  var formdata=new FormData();
  formdata.append('token', sessionStorage.getItem("token"));
  formdata.append('device_id', sessionStorage.getItem("device_id"));
  formdata.append('user_id', sessionStorage.getItem("user_id"));
  $.ajax({
    url: '<?php echo site_url()."app/logout";?>',
    type: 'post',
    data: formdata,
    cache: false,
    processData:false,
    contentType:false,
    dataType: 'json',
    success: function(response) 
    {
      $('.has-invalid').remove();
      if(response.error == false){
        sessionStorage.clear();
        alert(response.message);
        location.href="<?php echo base_url()?>";
      }

    }

  });
})

$(function() {
  $('#mylist').on('click', function() {
    $('#grid').removeClass('prodect-right-box');
    $("#grid").toggleClass("prodect-right-box list-view");
  });
  $('#mygrid').on('click', function() {
    $('#grid').removeClass('prodect-right-box list-view');
    $("#grid").toggleClass("prodect-right-box");
  });
});


function updateSort(sId) 
{ 
  var baseUrl = "<?php echo base_url('home/category?') ?>";
  var searchUrl = window.location.href;
  $.ajax({
    type: "GET",
    url: searchUrl,
    data: "sort=" + sId,
    success: function (data) {
      if(window.location.search)
      { 
        if (history.pushState) {
          var newurl = searchUrl+'&sort='+sId;
          window.history.pushState({path:newurl},'',newurl);
          location.reload();
        }

      }else{
        if (history.pushState) {
          var newurl = searchUrl+'?sort='+sId;
          window.history.pushState({path:newurl},'',newurl);
          location.reload();
        }
      }              

    }

  });

} 
</script> 
<script type="text/javascript">
  <?php $session_value=(isset($_SESSION['id']))?$_SESSION['id']:''; ?>
  function addCart(id, type)
  { 
    var myvar='<?php echo $session_value;?>';
    if(myvar=="")
    {
      swal({title: 'Please Login', text: '', type: 
        "error"}).then(function(){            
          window.location.href = "<?php echo site_url('home/login')?>";
        }
        );

      }else{
        $.ajax({
          url : "<?php echo site_url('dashboard/addCart')?>",
          method : "POST",
          data : {id: id, type: type},
          success: function(data){
            swal({title: data, text: '', type: 
              "success"}).then(function(){ 
                location.reload();
              }
              );
            }
          });
      }
    }

    function addWishlist(id, type)
    { 
      var myvar='<?php echo $session_value;?>';
      if(myvar=="")
      {
        swal({title: 'Please Login', text: '', type: 
          "error"}).then(function(){            
            window.location.href = "<?php echo site_url('home/login')?>";
          }
          );

        }else{
          $.ajax({
            url : "<?php echo site_url('dashboard/addRemoveFav')?>",
            method : "POST",
            data : {pid: id, ptype: type},
            success: function(data){
               location.reload();
              }
            });
        }
      }

    function deleteCart(cid)
    { 
      $.ajax({
        url : "<?php echo site_url('dashboard/deleteProduct')?>",
        method : "POST",
        data : {cid: cid},
        success: function(data){
          swal({title: data, text: '', type: 
            "success"}).then(function(){ 
              location.reload();
            }
            );
          }
        });
    }

    function updateCart(cid, flag)
    {
      $.ajax({
        url : "<?php echo site_url('dashboard/updateCart')?>",
        method : "POST",
        data : {cid: cid, flag:flag},
        success: function(data){
          swal({title: '', text: data, type: 
            "success"}).then(function(){ 
              location.reload();
            }
            );
          }
        });
    }


  </script>
  <script>
    $(document).ready(function(){
      $("#orderData").change(function(){
        $(this).find("option:selected").each(function(){
          var optionValue = $(this).attr("value");
          if(optionValue){
            $(".box").not("." + optionValue).hide();
            $("." + optionValue).show();
          } else{
            $(".box").hide();
          }
        });
      }).change();
    });

    $(function() {
      $('#row_dim').hide(); 
      $('#type').change(function(){
        var total = parseFloat($('#total').val());
        if($('#type').val() == '10') {
          $('#row_dim').show(); 
          var surcharge = parseFloat(10);            
          $('#totalPrice').val(total +surcharge);
        } else {
          $('#row_dim').hide(); 
          $('#totalPrice').val(total);
        } 

      });
    });
  </script>
  <script type="text/javascript">
    function verifyCoupons(cid, total)
    {
      var baseUrl = "<?php echo base_url('dashboard/checkout') ?>";

      $.ajax({
        url : "<?php echo site_url('dashboard/verifyCoupons')?>",
        method : "POST",
        data : {cid: cid, total:total},
        success: function(msg) {
          var obj = JSON.parse(msg);
          if(obj.error == false)
          {          
            document.getElementById("test3").value = obj.data[0].coupon_id;
            var newurl = baseUrl+'?coupon='+obj.data[0].coupon_id;
            window.history.pushState({path:newurl},'',newurl);
            location.reload();         
            $('#alert-msg').html('<div class="alert alert-success">' + obj.message + '</div>');
          }
          else{
            $('#alert-msg').html('<div class="alert alert-danger">' + obj.message + '</div>');
          }
        }
      });
    }

    function changeAddress(add)
    {
      var baseUrl = "<?php echo base_url('dashboard/checkout') ?>";

      $.ajax({
        url : "<?php echo site_url('dashboard/changeAddress')?>",
        method : "POST",
        data : {aid: add},
        success: function(msg) {
          var obj = JSON.parse(msg);
          if(obj.error == false)
          {         
            $('#alert-msg').html('<div class="alert alert-success">' + obj.message + '</div>');
            location.reload();  
          }
          else{
            $('#alert-msg').html('<div class="alert alert-danger">' + obj.message + '</div>');
          }
        }
      });
    }
  </script>

  <script type="text/javascript">
    <?php $session_value=(isset($_SESSION['id']))?$_SESSION['id']:''; ?>
    function updatedetailcart(cid, type) 
    {

      var qty =  document.getElementById("detailqty").value;
      var myvar='<?php echo $session_value;?>';
      if(myvar=="")
      {
        swal({title: 'Please Login', text: '', type: 
          "error"}).then(function(){            
            window.location.href = "<?php echo site_url('home/login')?>";
          }
          );

        }else{         
          $.ajax({      
            url: "<?php echo base_url(); ?>dashboard/detailcart",       
            type: 'POST',       
            dataType: 'json',       
            data: {         
              qty: parseInt(qty),        
              pid: parseInt(cid),
              type:parseInt(type)   
            },
          })
          .done(function(data) {  
            window.location.reload();
            window.location.href = "<?php echo site_url('dashboard/cart')?>";
            console.log("updated");                  
          })

          .fail(function(data) {      
            console.log(data);       
          }); 
        }
      }

      function deletewishlist(id)
      {
         cnf=confirm("Are you confirm to remove from wish list?");
         if(cnf){
            $.ajax({
               type: "GET",
               url: "<?php echo base_url();?>dashboard/deletewishlist",
               data: "id=" + id,
               success: function (data) {
                  window.location.reload();
               }
            });
         }
      }
    </script>
    <script>
      $(document).ready(function(){
        $('.count').prop('disabled', true);
        $(document).on('click','.plus',function(){
          $('.count').val(parseInt($('.count').val()) + 1 );
        });
        $(document).on('click','.minus',function(){
          $('.count').val(parseInt($('.count').val()) - 1 );
          if ($('.count').val() == 0) {
            $('.count').val(1);
          }
        });
      });
    </script>  
  </body>
  </html>