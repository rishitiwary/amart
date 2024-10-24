<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->helper('form');
    $this->load->model('Basic_operation', 'basic_operation');
    $this->load->model('Commonmodel');
    $this->load->library('password');

    if (!($this->session->userdata('id') && ($this->session->userdata('role')=='3')))
    { 
      $this->session->set_flashdata('warning', 'Please login to access this features!');
      redirect('login','refresh');
    }
  }

	public function index()
	{
		
    $data['title']="My Dashboard";		 
		$user_id=$user_id=$this->session->userdata('id');
    
    $this->db->select('bookings.*,SUM(bookings.price) as TotalPrice');
    $this->db->from('bookings');
    $this->db->where(array('bookings.user_id'=>$user_id,'bookings.status <'=>3));
    $this->db->group_by(array("bookings.user_id", "bookings.order_id"));
    $this->db->order_by('bookings.id','desc');
    $data1= $this->db->get()->result();
    
    foreach($data1 as $x)
    {
      $order_id=$x->order_id;
      $myBookingProduct=$this->basic_operation->matchedRowCount('bookings',array('order_id'=>$order_id));
      $x->TotalProductsQty="$myBookingProduct";
      $x->booking_date=date("F j, Y",strtotime($x->booking_date));
    }

    $this->db->select('bookings.*,SUM(bookings.price) as TotalPrice');
    $this->db->from('bookings');
    $this->db->where(array('bookings.user_id'=>$user_id,'bookings.status ='=>3));
    $this->db->group_by(array("bookings.user_id", "bookings.order_id"));
    $this->db->order_by('bookings.id','desc');
    $data2= $this->db->get()->result();

    foreach($data2 as $item)
    {
      $order_id=$item->order_id;
      $myBookingProduct=$this->basic_operation->matchedRowCount('bookings',array('order_id'=>$order_id));
      $item->TotalProductsQty="$myBookingProduct";
      $item->booking_date=date("F j, Y",strtotime($item->booking_date));
    }

    $data['cancelled']=$data2;
    $data['normal']=$data1;
    $data['all']= array_merge($data1, $data2);
		$this->load->view('home/header', $data);
		$this->load->view('home/account',$data);
		$this->load->view('home/footer');
	}

  public function address()
  {  
    $data['title']="Address List";
    $userId=$this->session->userdata('id');
    $data['addList'] = $this->Commonmodel->fetch_all_rows('address_books', "user_id=$userId");
    $this->load->view('home/header', $data);
    $this->load->view("home/address", $data);
    $this->load->view('home/footer');  
  }
  
  public function addAddress()
  {  
    $data['title']="Address List";
    $this->load->view('home/header', $data);
    $this->load->view("home/add_address", $data);
    $this->load->view('home/footer');  
  }

  public function alpha_dash_space($name){
    if (! preg_match('/^[a-zA-Z\s]+$/', $name)) {
        $this->form_validation->set_message('alpha_dash_space', 'Other than character is not allowed.');
        return FALSE;
    } else {
        return TRUE;
    }
}

  public function createAddress()
  {
    $data['title']="Add Address";
    $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|callback_alpha_dash_space');
    $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|numeric');
    $this->form_validation->set_rules('flat', 'Address', 'trim|required');
    if ($this->form_validation->run() == TRUE) 
    {
      $mydata = array(
        'name' => $this->input->post('name'),
        'address' => $this->input->post('flat'),
        'mobile' => $this->input->post('mobile'),
        'landmark' => $this->input->post('landmark'),
        'user_id' => $this->session->userdata('id'),
      );

      $msg=$this->Commonmodel->insert("address_books", $mydata);
      if($msg)
      {
        $this->session->set_flashdata('success', 'Added successfully');
      }else{
        $this->session->set_flashdata('error', 'Something went Wrong');
      }
      redirect('dashboard/addAddress','refresh');
    }else {

      $this->session->set_flashdata("error", "Something went wrong");
      $this->load->view('home/header', $data);
      $this->load->view("home/add_address", $data);
      $this->load->view('home/footer');
    }
  }
     
   
    public function favourite()
    {  

    	$data['title']="My Wishlist";
      $userId=$this->session->userdata('id');

        $this->db->select('wishlists.*,products.*, products.name as product_name,wishlists.id as wishlist_id');
        $this->db->from('wishlists');
        $this->db->join('products', 'products.id = wishlists.product_id');       
        $this->db->where(['wishlists.user_id'=> $userId,'wishlists.product_type'=>'1']);
        $data1=$this->db->get()->result(); 
        
        $this->db->select('wishlists.*,promotional.*,promotional.name as product_name,wishlists.id as wishlist_id');
        $this->db->from('wishlists');
        $this->db->join('promotional', 'promotional.id = wishlists.product_id');        
        $this->db->where(['wishlists.user_id'=> $userId,'wishlists.product_type'=>'3']);
        $data2=$this->db->get()->result(); 
        
        $this->db->select('wishlists.*,offers.*,offers.name as product_name,wishlists.id as wishlist_id');
        $this->db->from('wishlists');
        $this->db->join('offers', 'offers.id = wishlists.product_id');        
        $this->db->where(['wishlists.user_id'=> $userId,'wishlists.product_type'=>'2']);
        
        $data3= $this->db->get()->result();
        $data['myfav']=array_merge($data1, $data2, $data3);
     
    	$this->load->view('home/header', $data);
    	$this->load->view("home/favourite", $data); 
    	$this->load->view('home/footer');   
    }

    public function deletewishlist()
    {
      $id = $this->input->get('id', TRUE);
      $result = $this->Commonmodel->delete_single_con('wishlists', "id='$id'");
      if ($result == TRUE) {
        $this->session->set_flashdata('success_msg', 'Product Deleted Successfully');
      } else {
        $this->session->set_flashdata('success_msg', 'Invalid Operation');
      }
    }

    public function addRemoveFav()
    {

      $userId=$this->session->userdata('id');

      if($this->input->post('pid')) 
      {
        $pid = $this->input->post('pid');
        $ptype = $this->input->post('ptype');

        $favCount= $this->Commonmodel->count('wishlists', "user_id=$userId AND product_id=$pid AND product_type=$ptype");

        if($favCount>0)
        {

          if($this->Commonmodel->delete_single_con('wishlists', "user_id=$userId AND product_id=$pid AND product_type=$ptype"))
          {
            echo 'Removed successfully';
          }else{
            echo 'Some error occured, Please try again!';
          }

        }else{

          $followdata = array(
            'product_id' => $pid,
            'product_type' => $ptype,
            'user_id' => $userId,          
          );

          if ($this->Commonmodel->insert('wishlists', $followdata)) 
          {
            echo 'Added successfully!';
          } else {
            echo 'Some error occured, Please try again!';
          }
        }
      }

    }
    
    public function password()
    {
    	$data['title']="Change Password";
    	$this->load->view('home/header', $data);
    	$this->load->view("home/password", $data);
    	$this->load->view('home/footer');  
    }

    public function upadtepass()
    {
      $this->form_validation->set_rules('oldpassword', 'Old Password', 'required|trim');
      $this->form_validation->set_rules('newpassword', 'New Password', 'required|trim|min_length[6]');
      $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim|required|min_length[6]|matches[newpassword]');
      $userId=$this->session->userdata('id');

      if ($this->form_validation->run() == TRUE ) 
      {
        $oldpass=$this->input->post('oldpassword');
        $user = $this->Commonmodel->fetch_row('users', "id=$userId");

        if (!$this->password->validate_password($oldpass, $user->password)) 
        {
          $this->session->set_flashdata("error", "Old Password was wrong");
          redirect('dashboard/password','refresh');
        }else {
          $mydata = array(
            'password' => $this->password->create_hash($this->input->post('newpassword')),
          );

          $update=$this->Commonmodel->eidt_single_row('users', $mydata,"id=$userId");          
          $this->session->set_flashdata('success', 'Password Updated Successfully!');        
          redirect('dashboard/password','refresh');
        }
      } else{
        $this->session->set_flashdata("error", "Something went wrong");
        $data['title']="Change Password";
        $this->load->view('home/header', $data);
        $this->load->view("home/password", $data);
        $this->load->view('home/footer'); 
      }
    }
    
    public function profile()
    {
    	$data['title']="My Profile";
      $userId=$this->session->userdata('id');
      $data['profile'] = $this->Commonmodel->fetch_row('users', "id=$userId");
    	$this->load->view('home/header', $data);
    	$this->load->view("home/profile"); 
    	$this->load->view('home/footer'); 
    }

    public function updateProfile()
    {
      $userId=$this->session->userdata('id');
      $this->form_validation->set_rules('name', 'name', 'required|trim|xss_clean|callback_alpha_dash_space');
      $this->form_validation->set_rules('mobile', 'mobile', 'required|trim|numeric');

      if ($this->form_validation->run() == TRUE ) 
      {
        $mydata = array(
          'name' => $this->input->post('name'),
          'mobile' => $this->input->post('mobile'),
        );

         $update = $this->Commonmodel->eidt_single_row('users', $mydata, "id=$userId");

          $this->session->set_flashdata('success', 'Profile updated successfully!');
           redirect('dashboard/profile','refresh');

      }else{
        $this->session->set_flashdata("error", "Something went wrong");
        $data['title']="My Profile";
        $userId=$this->session->userdata('id');
        $data['profile'] = $this->Commonmodel->fetch_row('users', "id=$userId");
        $this->load->view('home/header', $data);
        $this->load->view("home/profile"); 
        $this->load->view('home/footer'); 

      }

    }    
   
    
    public function cart()
     {  

        $data['title']="My Cart";         
        // $IPAddress=$this->input->ip_address();
        $user_id=$this->session->userdata('id');
       
        $this->db->select('carts.*,carts.id as cart_id, carts.user_id as cart_user_id, carts.quantity as cart_product_quantity, products.*,products.id as product_id, products.quantity as productsQuantity');
        $this->db->from('carts');
        $this->db->join('products', 'products.id = carts.product_id');
        $this->db->where(['carts.user_id'=>$user_id,'carts.product_type'=>1]);
        $Cart1=$this->db->get()->result();

        $this->db->select('carts.*,carts.id as cart_id,carts.user_id as cart_user_id,carts.quantity as cart_product_quantity, offers.*,offers.id as product_id,offers.quantity as productsQuantity');
        $this->db->from('carts');
        $this->db->join('offers', 'offers.id = carts.product_id');
        $this->db->where(['carts.user_id'=>$user_id,'carts.product_type'=>2]);
        $Cart2=$this->db->get()->result();

        $this->db->select('carts.*,carts.id as cart_id,carts.user_id as cart_user_id,carts.quantity as cart_product_quantity, promotional.*,promotional.id as product_id,promotional.quantity as productsQuantity');
        $this->db->from('carts');
        $this->db->join('promotional', 'promotional.id = carts.product_id');
        $this->db->where(['carts.user_id'=>$user_id,'carts.product_type'=>3]);
        $Cart3=$this->db->get()->result();

        $data['collection']= array_merge($Cart1,$Cart2,$Cart3);

        $availableCoupon=array();
        $coupons=$this->Commonmodel->fetch_all_rows('coupons', array('status'=>1,'applied'=>0));
        if(count($coupons) > 0){
            foreach($coupons as $coupon)
            {
            if(strtotime($coupon->valid_upto) >= strtotime(date('d-m-Y')))
            {
               $availableCoupon[]=$coupon; 
            }
        }
        }    

        
       $data['availableCoupon']=  $availableCoupon;    

      $this->load->view('home/header', $data);
      $this->load->view("home/cart", $data);
      $this->load->view('home/footer');  
    } 

    public function addCart()
    {
      $data['title']="Add Cart"; 
      $userId=$this->session->userdata('id');
      $pid=$this->input->post('id', TRUE);
      $type=$this->input->post('type', TRUE);
      $where="product_id=$pid AND product_type=$type AND user_id=$userId";     

      $result = $this->Commonmodel->fetch_row('carts', $where);

      if($result) 
      {
        $old_quantity=$result->quantity;
        $new_quantity=$old_quantity+1;
        $dataupdate = array(
         'quantity'=> $new_quantity,
        );
        $status = $this->Commonmodel->eidt_single_row('carts', $dataupdate, "id='".$result->id."'");
        $msg ='Cart updated successfully';       
      }else{
        $quantity=1;

        $userdata = array(
          'product_id' => $pid,
          'quantity' => $quantity,
          'product_type'=> $type,
          'user_id' => $userId
        );

       
       $status=$this->Commonmodel->insert("carts", $userdata);
       $msg ='Successfully added to cart list';
      }
      if ($status == TRUE) 
      {
        echo $msg;

      } else {
        $msg ='Invalid Operation';
         echo $msg;
      }
    }

  public function deleteProduct()
  {
    $id = $this->input->post('cid', TRUE);
    $result = $this->Commonmodel->delete_single_con('carts', "id='$id'");
    if($result == TRUE) 
    {
      echo 'Product removed from carts successfully';
      
    } else {
      echo 'Invalid Operation';
    }
  }
  
  public function updateCart()
  {
      $id = $this->input->post('cid', TRUE);
      $flag = $this->input->post('flag', TRUE);      
      $result = $this->Commonmodel->fetch_row('carts', "id=$id");      
      if($flag =="minus")
      {
        if($result->quantity>1)
        {
          $old_quantity=$result->quantity;
          $new_quantity=$old_quantity-1;
          $dataupdate = array(
            'quantity'=> $new_quantity,
          );
          $status = $this->Commonmodel->eidt_single_row('carts', $dataupdate, "id='".$result->id."'");
          echo "Quantity updated successfully";
        }else{
          echo "Quantity must be greater than 1"; 
        }

      }elseif ($flag =="plus") {
        $old_quantity=$result->quantity;
        $new_quantity=$old_quantity+1;
        $dataupdate = array(
          'quantity'=> $new_quantity,
        );
        $status = $this->Commonmodel->eidt_single_row('carts', $dataupdate, "id='".$result->id."'");

      echo "Quantity updated successfully";
       
      }else{
        echo "Somwthing went wrong!";
      }      

  }

  public function checkout()
  {  

    $data['title']="Checkout";
    $user_id=$this->session->userdata('id');
       
    $this->db->select('carts.*,carts.id as cart_id, carts.user_id as cart_user_id, carts.quantity as cart_product_quantity, products.*,products.id as product_id, products.quantity as productsQuantity');
    $this->db->from('carts');
    $this->db->join('products', 'products.id = carts.product_id');
    $this->db->where(['carts.user_id'=>$user_id,'carts.product_type'=>1]);
    $Cart1=$this->db->get()->result();

    $this->db->select('carts.*,carts.id as cart_id,carts.user_id as cart_user_id,carts.quantity as cart_product_quantity, offers.*,offers.id as product_id,offers.quantity as productsQuantity');
    $this->db->from('carts');
    $this->db->join('offers', 'offers.id = carts.product_id');
    $this->db->where(['carts.user_id'=>$user_id,'carts.product_type'=>2]);
    $Cart2=$this->db->get()->result();

    $this->db->select('carts.*,carts.id as cart_id,carts.user_id as cart_user_id,carts.quantity as cart_product_quantity, promotional.*,promotional.id as product_id,promotional.quantity as productsQuantity');
    $this->db->from('carts');
    $this->db->join('promotional', 'promotional.id = carts.product_id');
    $this->db->where(['carts.user_id'=>$user_id,'carts.product_type'=>3]);
    $Cart3=$this->db->get()->result();

    $data['collection']= array_merge($Cart1,$Cart2,$Cart3);

    $availableCoupon=array();
    $coupons=$this->Commonmodel->fetch_all_rows('coupons', array('status'=>1,'applied'=>0));
    if(count($coupons) > 0)
    {
      foreach($coupons as $coupon)
      {
        if(strtotime($coupon->valid_upto) >= strtotime(date('d-m-Y')))
        {
          $availableCoupon[]=$coupon; 
        }
      }
    }

    $def = $this->Commonmodel->fetch_row('address_books', array('address_books.user_id'=>$user_id,'address_books.default_address'=>'1'));
    if($def){
      $data['address'] = $def;
    }else{
       $data['address'] = $this->Commonmodel->fetch_row('address_books', array('address_books.user_id'=>$user_id));
    }
    $data['availableCoupon']=  $availableCoupon; 

    $data['addresslist'] = $this->Commonmodel->fetch_all_rows('address_books', array('address_books.user_id'=>$user_id));

    $this->load->view('home/header', $data); 
    $this->load->view("home/checkout"); 
    $this->load->view('home/footer');   
  } 

   public function verifyCoupons()
    {
        $user_id=$this->session->userdata('id');
        $coupon_id=$this->input->post('cid');
        $amount=$this->input->post('total');
        $coupons=$this->basic_operation->uniqueSelect('coupons',array('status'=>1,'applied'=>0,'coupon_id'=>$coupon_id));
        if(!empty($coupons)){
        $couponData=$coupons[0];
        if($amount > $couponData->max_order_price){
           $collection=array(
             'error'=>true,
             'message'=>'maximum amount should be less than '.$couponData->max_order_price,
             );  
        }else{
            if($amount < $couponData->min_order_price){
            $collection=array(
             'error'=>true,
             'message'=>'Minimum amount should be greater than '.$couponData->min_order_price,
             ); 
            }else{
                $collection=array(
                 'error'=>false,
                 'message'=>'Promo code applied successfully',
                 'data'=>$coupons
                );  
            }
        }
    }else{
       $collection=array(
         'error'=>true,
         'message'=>'Coupon is not valid',
        ); 
    }
    echo json_encode($collection);
    }

  public function changeAddress()
  {
    $user_id=$this->session->userdata('id');
    $aid=$this->input->post('aid');

    $address = $this->Commonmodel->fetch_row('address_books', "id=$aid AND user_id=$user_id");   

    if($address)
    {  

      $mydata = array(
        'default_address' =>1,
      );

      $update=$this->Commonmodel->eidt_single_row(
        'address_books', $mydata,"id=$address->id");     

      if($update)
      {
        $collection=array(
          'error'=>false,
          'message'=>'Address updated successfully',
        ); 
        $this->Commonmodel->eidt_single_row('address_books', 
          array('default_address' =>0,), "user_id=$user_id AND id!=$aid");
      }else{
        $collection=array(
          'error'=>true,
          'message'=>'Invalid operation',
        );  
      }

    }else{
      $collection=array(
        'error'=>true,
        'message'=>'Address not found',
      ); 
    }
    echo json_encode($collection);
  } 

  public function detailcart()
  {
    $pid=$this->input->post('pid', TRUE);
    $qty=$this->input->post('qty', TRUE);
    $type=$this->input->post('type', TRUE);

    $userId=$this->session->userdata('id');
    $pid=$this->input->post('pid', TRUE);
    $where="product_id=$pid AND user_id =$userId";
    $result = $this->Commonmodel->count('carts', $where);
    if ($result > 0) {
      $cart = $this->Commonmodel->fetch_row('carts', $where);
      $dataupdate = array(
        'quantity'=> $qty,
      );
      $update = $this->Commonmodel->eidt_single_row('carts', $dataupdate, "id='".$cart->id."'");
    }else{
      $userdata = array(
        'product_id' => $pid,
        'quantity' => $qty,
        'user_id' => $userId,
        'product_type' =>$type
      );
      $update=$this->Commonmodel->insert("carts", $userdata);
    }
    if ($update == TRUE) {
      $msg = 'Cart updated successfully!';
      echo '["'.$msg.'"]';

    } else {
      echo '["Some error occured, Please try again!"]';
    }

  }

  public function placeOrder()
  {
     
      $this->form_validation->set_rules('address', 'Address', 'required|trim');
      $this->form_validation->set_rules('payment_method','Payment Method','required|trim');
      $this->form_validation->set_rules('delivery_type','Delivery Type','required|trim');
      $user_id=$this->session->userdata('id');
      $user = $this->Commonmodel->fetch_row('users', "id=$user_id");
      $aid= $this->input->post('address');
      $myadd= $this->Commonmodel->fetch_row('address_books', "id=$aid");      
            
        if($this->form_validation->run() == TRUE)
        {
          $email= $user->email !=''? $user->email :'munnakumar1810@gmail.com';
          $user_name=$user->name !=''? $user->name:'Rajesh kumar';
          $subTotal=0;
          $taxPrice=0;
          $totalTax=0;
          $Subtotaltax=0;

          $order_id=strtoupper(uniqid());
          $delivery= $this->input->post('delivery_type');
          if($delivery=='10')
          {
            $delType='Same day delivery';
          }else{
            $delType='Delivery within 48 hours';
          }

          $payment= $this->input->post('payment_type');
          if($payment=='0')
          {
            $payType='Cash On Delivery';
          }else{
            $payType='Card On Delivery';

          }

          if($delivery=='10'){
            $delicery_date=date('d-m-Y H:i:s');
            $deliveryCharge= 10;
          }else{
            $Date=date('d-m-Y H:i:s');
            $delicery_date=date('d-m-Y H:i:s', strtotime($Date. ' + 2 days')); 
            $deliveryCharge= 0; 
          }

          $this->db->select('carts.*,carts.id as cart_id,carts.user_id as cart_user_id,carts.quantity as cart_product_quantity, products.*,products.id as product_id,products.quantity as productsQuantity');
            $this->db->from('carts');
            $this->db->join('products', 'products.id = carts.product_id');
            $this->db->where(['carts.user_id'=>$user_id,'carts.product_type'=>1]);
            $Cart1=$this->db->get()->result();

          $this->db->select('carts.*,carts.id as cart_id,carts.user_id as cart_user_id,carts.quantity as cart_product_quantity, offers.*,offers.id as product_id,offers.quantity as productsQuantity');
            $this->db->from('carts');
            $this->db->join('offers', 'offers.id = carts.product_id');
            $this->db->where(['carts.user_id'=>$user_id,'carts.product_type'=>2]);
            $Cart2=$this->db->get()->result();
            
          $this->db->select('carts.*,carts.id as cart_id,carts.user_id as cart_user_id,carts.quantity as cart_product_quantity, promotional.*,promotional.id as product_id,promotional.quantity as productsQuantity');
            $this->db->from('carts');
            $this->db->join('promotional', 'promotional.id = carts.product_id');
            $this->db->where(['carts.user_id'=>$user_id,'carts.product_type'=>3]);
            $Cart3=$this->db->get()->result();
            
            $data=array_merge($Cart1, $Cart2, $Cart3);

            $totalPrices=0;
            
            foreach($data as $row)
            { 
               $totalPrices+=($row->offer_price*$row->cart_product_quantity); 
            }
            if($totalPrices < 80){
                $totalTax=10;
            }

            $vat = $this->input->post('vat');
          
            $grandTotal=  $totalPrices + $totalTax + $vat +$deliveryCharge;

            $form_data=array(
               'user_id'=>$user_id,
               'referal_applied'=>$this->input->post('referal_applied')?$this->input->post('referal_applied'):'',
               'transection_id'=>$this->input->post('transection_id')?$this->input->post('transection_id'):'',
               'transection_amount'=>@$grandTotal,
               'transection_message'=>$this->input->post('transection_message')?$this->input->post('transection_message'):'',
               'payment_type'=>$payType,
               'delivery_type'=>$delType,
               'transection_status'=>$this->input->post('transection_status')?$this->input->post('transection_status'):'',
               'order_id'=>$order_id,
               'delivery_date'=>$delicery_date,
               'coupon_id'=>$this->input->post('coupon_id')?$this->input->post('coupon_id'):0,
               'address_id'=>$aid,
               'address'=>@$myadd->address,
               'latitude'=>@$myadd->ip_address,
               'longitude'=>@$myadd->ip_address,
               'note'=>$this->input->post('note')?$this->input->post('note'):''
          );
            
          $coupon_id=$this->input->post('coupon_id')?$this->input->post('coupon_id'):0;

            if(!empty($this->input->post('coupon_id')))
            {

              $coupon=$this->db->get_where('coupons', array('coupon_id' => $this->input->post('coupon_id')))->row();
               $form_data['coupon_code']=$coupon->coupon_code;
               $form_data['valid_from']=$coupon->valid_from;
               $form_data['valid_upto']=$coupon->valid_upto;
               $form_data['tax']=$totalTax;
               $form_data['discount_percentage']=$coupon->discount_percentage;
               $form_data['min_order_price']=$coupon->min_order_price;
               $form_data['max_order_price']=$coupon->max_order_price;
               
            }

            if(!empty($this->input->post('address')))
            {
              $address=$this->db->get_where('address_books', array('id' => $this->input->post('address')))->row();
              
               if(!empty($address))
               {
               $form_data['address']=$address->address;
               $form_data['name']=$address->name;
               $form_data['landmark']=$address->landmark;
               $form_data['pincode']=$address->pincode;
               $form_data['mobile']=$address->mobile;
               }
            }
            
            # Checking for user have 1st order or not
            $OrderCount=$this->basic_operation->matchedRowCount('bookings', array('user_id'=>$user_id));

            $form_data['first_order_discount']=($OrderCount > 0)? 0 : 1;
            
            foreach($data as $row)
            { 
               $subTotalss=($row->offer_price*$row->cart_product_quantity); 
               $form_data['product_id']=$row->product_id;
               $form_data['product_type']=$row->product_type;
               $form_data['product_name']=$row->name;
               $form_data['offer_price']=$row->offer_price;
               $form_data['weight']=$row->weight;
               $form_data['country']=$row->country;
               $form_data['image']=$row->image;
               $form_data['offer_percentage']=$row->offer_percentage;
               $form_data['quantity']=$row->cart_product_quantity;
               $form_data['price']=$subTotalss;

               $this->basic_operation->insertData('bookings', $form_data);
               
               $this->basic_operation->updateDetails('coupons',array('user_id '=>$user_id,'applied'=>1),array('coupon_id'=>$coupon_id));
            
            }

            $this->db->where('coupon_id', $coupon_id)->update('coupons',array('applied'=>1));
                
            if($this->input->post('referal_applied') > 0)
            {
             $this->basic_operation->updateDetails('users',array('referal_applied'=>1),array('id'=>$user_id));
            }
               $this->load->library('email');
               $this->load->library('sendmail');
               
               $message = '';
               $message .= 'Hi, ' .$user_name.'<br>';
               $message .= '<br>';
               $message .= 'Welcome! you have Order  with our website with the following information:<br>';
               $message .= '<br>';
               $message .='<table>';
               $message .='<tr>
                    <td>Product Name</td>
                    <td>Price</td>
                    <td>Qty</td>
                    <td>Subtotal</td>
               </tr>';
               $subTotal=0;

               foreach($data as $row)
               {

               $subTotal+=($row->offer_price*$row->cart_product_quantity);  
               $message .='<tr><td><h3>'.$row->name.'</h3></td><td>'.'₹ '.$row->offer_price.'</td><td>'.$row->cart_product_quantity.'</td><td>'.'₹ '.($row->offer_price*$row->cart_product_quantity).'</td></tr>';
                   } 

              $deliveryCharge=$subTotal > 80 ? 0 : 10;   
               $message .='</table>';
               $message .= '<br>';
               $message .= '<br>';
               $message .= 'Total Price : ₹ '.$subTotal;
               $message .= '<br>';
               $message .= 'Total Tax : ₹ '.$vat;
               $message .= '<br>';
               $message .= 'Delivery Charges: ₹ '.$deliveryCharge;
               $message .= '<br>';               
               $message .= 'Grand Total : ₹ '.($subTotal+$vat+$deliveryCharge);
               $message .= 'Sincerely yours,<br>';
               $message .= 'Ashamart Team';
               $to_email = $email;

               $this->email->initialize($this->sendmail->config());
               $this->email->from($this->config->item('register'), 'Order Details ' . $user_name);
               $this->email->to($to_email);
               $this->email->subject('Order Details');
               $this->email->message($message);
               $this->email->set_mailtype("html");

               //Sending mail & empty cart Item 
               $this->basic_operation->deleteData('carts', array('user_id'=>$form_data['user_id']));
               
               $form_data['booking_date']=date('Y-m-d H:i:s');
               if($this->email->send())
               {

                $this->session->set_flashdata("success", "Order placed successfully , please check your email.");
               $collection=array(
                'error'=>false,
                'message'=>'Order placed successfully , Please check your email.',
                'order_data' => array($form_data) 
                );
                   
               }else{

                 $this->session->set_flashdata("info", "Order placed successfully , please check your email.");
               $collection=array(
                'error'=>true,
                'message'=>'There is problem to send mail , Please check in your order history',
                'order_data' => array($form_data) 
                );
               }
               
               $collection['title']="Order Success"; 
               $this->load->view('home/header', $collection);
               $this->load->view("home/thankyou", $collection); 
               $this->load->view('home/footer'); 
        }
        else{
          $this->session->set_flashdata("error", "Something went wrong");
          $data['title']="Checkout";
          $user_id=$this->session->userdata('id');

          $this->db->select('carts.*,carts.id as cart_id, carts.user_id as cart_user_id, carts.quantity as cart_product_quantity, products.*,products.id as product_id, products.quantity as productsQuantity');
          $this->db->from('carts');
          $this->db->join('products', 'products.id = carts.product_id');
          $this->db->where(['carts.user_id'=>$user_id,'carts.product_type'=>1]);
          $Cart1=$this->db->get()->result();

          $this->db->select('carts.*,carts.id as cart_id,carts.user_id as cart_user_id,carts.quantity as cart_product_quantity, offers.*,offers.id as product_id,offers.quantity as productsQuantity');
          $this->db->from('carts');
          $this->db->join('offers', 'offers.id = carts.product_id');
          $this->db->where(['carts.user_id'=>$user_id,'carts.product_type'=>2]);
          $Cart2=$this->db->get()->result();

          $this->db->select('carts.*,carts.id as cart_id,carts.user_id as cart_user_id,carts.quantity as cart_product_quantity, promotional.*,promotional.id as product_id,promotional.quantity as productsQuantity');
          $this->db->from('carts');
          $this->db->join('promotional', 'promotional.id = carts.product_id');
          $this->db->where(['carts.user_id'=>$user_id,'carts.product_type'=>3]);
          $Cart3=$this->db->get()->result();

          $data['collection']= array_merge($Cart1,$Cart2,$Cart3);

          $availableCoupon=array();
          $coupons=$this->Commonmodel->fetch_all_rows('coupons', array('status'=>1,'applied'=>0));
          if(count($coupons) > 0)
          {
            foreach($coupons as $coupon)
            {
              if(strtotime($coupon->valid_upto) >= strtotime(date('d-m-Y')))
              {
                $availableCoupon[]=$coupon; 
              }
            }
          }

          $def = $this->Commonmodel->fetch_row('address_books', array('address_books.user_id'=>$user_id,'address_books.default_address'=>'1'));
          if($def){
            $data['address'] = $def;
          }else{
            $data['address'] = $this->Commonmodel->fetch_row('address_books', array('address_books.user_id'=>$user_id));
          }
          $data['availableCoupon']=  $availableCoupon; 

          $data['addresslist'] = $this->Commonmodel->fetch_all_rows('address_books', array('address_books.user_id'=>$user_id));

          $this->load->view('home/header', $data); 
          $this->load->view("home/checkout"); 
          $this->load->view('home/footer');
        }
      
  }  

   public function orderDetails($booking_id)
     {
          $data = $this->session->userdata;
          $orderData=array();
          $user_id=$this->session->userdata('id');
         
          $this->db->select('bookings.*,products.*,products.image, address_books.*, bookings.quantity as cart_product_quantity, products.name as product_name, customer.name as  customer_name,customer.dob, customer.mobile, customer.email,coupons.*');
          $this->db->from('bookings');
          $this->db->join('products', 'products.id = bookings.product_id');
          $this->db->join('users as customer', 'customer.id = bookings.user_id');
          $this->db->join('coupons', 'coupons.coupon_id = bookings.coupon_id','left');
          $this->db->join('address_books', 'address_books.id = bookings.address_id');
          $this->db->where(array('bookings.user_id'=>$user_id,'bookings.order_id'=>$booking_id,'bookings.product_type'=>'1'));
          
          $data= $this->db->get()->result();
     
          $this->db->select('bookings.*,offers.*,offers.image,address_books.*,bookings.quantity as cart_product_quantity,offers.name as product_name,customer.name as  customer_name,customer.dob, customer.mobile,customer.email,coupons.*');
          $this->db->from('bookings');
          $this->db->join('offers', 'offers.id = bookings.product_id');
          $this->db->join('users as customer', 'customer.id = bookings.user_id');
          $this->db->join('coupons', 'coupons.coupon_id = bookings.coupon_id','left');
          $this->db->join('address_books', 'address_books.id = bookings.address_id');
          $this->db->where(array('bookings.user_id'=>$user_id,'bookings.order_id'=>$booking_id,'bookings.product_type'=>'2'));
          
          $data2= $this->db->get()->result();
     
          $this->db->select('bookings.status as order_status,bookings.*,promotional.*,promotional.image,address_books.*,bookings.quantity as cart_product_quantity, promotional.name as product_name, customer.name as  customer_name,customer.dob, customer.mobile, customer.email, coupons.*');
          $this->db->from('bookings'); 
          $this->db->join('promotional', 'promotional.id = bookings.product_id');
          $this->db->join('coupons', 'coupons.coupon_id = bookings.coupon_id','left');
          $this->db->join('users as customer', 'customer.id = bookings.user_id');
          $this->db->join('address_books', 'address_books.id = bookings.address_id');
          $this->db->where(array('bookings.user_id'=>$user_id,'bookings.order_id'=>$booking_id,'bookings.product_type'=>'3'));
          
          $data3= $this->db->get()->result();
          $this->db->select('*');
          $this->db->from('cancel_msgs');
          $data4= $this->db->get()->result();
          $orderData['cancel_message']=$data4;     
          $orderData['fetch_data']=array_merge($data, $data2, $data3);
          
          foreach($orderData['fetch_data'] as $item)
          {
            if($item->coupon_id==null)
            {
              $item->coupon_id=0;
              $item->coupon_code='';
              $item->coupon_title='';
              $item->discount_percentage=0;
            }
            if($item->address_id==0)
              {
              $item->address=$item->web_address;
              $item->landmark=$item->web_landmark;
              $item->mobile=$item->web_mobile;
              $item->name=$item->web_name;
            }
          } 

      $this->load->view('home/booking_details', $orderData);
          
    }
    
}
