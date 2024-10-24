<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

   public function __construct()
   {
        Parent::__construct();
        $this->load->database();
        $this->load->model('Basic_operation', 'basic_operation', TRUE);
        
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") 
        {
        die();
        }
    }

    
    public function CancelledOrder(){
        $user_id=$this->input->post('user_id');
        $order_id=$this->input->post('order_id');
        $this->load->library('email');
        $this->load->library('sendmail');
        $this->load->library('notifications');
        $this->load->library('notifications');
        $this->email->initialize($this->sendmail->config());
        $this->email->from('support@yaldafresh.ae', 'no-reply'); 
        $data["user_data"] = $this->basic_operation->Uniqueselect('users',array('id'=>$user_id)); 

        $device_key=$data['user_data'][0]->fcm_token;
        $data["user_data"] = $this->basic_operation->Uniqueselect('users',array('id'=>$user_id)); 
        $data["notification"] = $this->basic_operation->Uniqueselect('notifications',array('user_id'=>$user_id)); 
        
         $dataorderget=$this->get_booking_details($order_id,$user_id);
      
        $message='';
        $message='';
        $message.='<!doctype html><html><head><meta charset="utf-8"><title>Yalda </title><link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,700;1,600&display=swap" rel="stylesheet"></head>';
        $message.='<body style="margin: 0; padding: 0;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  style="background:#efefef">';
		$message.='<tr><td><table width="800" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family: "Poppins", sans-serif; background: #fff">';
        $message.='<tbody><tr><td><table width="100%" align="center"><tr><td align="center" style="border-bottom: 8px solid  #e60000; padding: 10px 0"><img src="'.base_url().'images/common/logo.png" width="161" height="62" alt=""/></td></tr>';
		$message.='</table><table width="100%" align="center" style="background: #F5F5F5 "><tr><td height="100" align="center" valign="bottom"><img src="'.base_url().'images/common/close.png" width="59" height="59" alt=""/></td></tr>';
		$message.='<tr><td height="30" align="center" style="font-size: 15px">'.  $data["user_data"][0]->name .'</td></tr>';
		$message.='<tr><td height="70" align="center" valign="top" style="font-size: 20px; font-weight: bold">Your order has been cancelled</td></tr>';
		$message.='</table>';
		$message.='<table width="100%" align="center" style="background: #E3E3E3; padding: 30px 30px; font-size: 14px"><tr><td width="50%" align="left" valign="top">';
		$message.='<table><tr><td><strong>Order No -</strong></td></tr><tr><td>'.$order_id.'</td></tr><tr><td height="10"></td></tr>';
		$message.='<tr><td><strong>Delivery Date</strong></td></tr><tr><td>'.date("F j, Y",strtotime($dataorderget['fetch_data'][0]->delivery_date)).'</td></tr></table></td><td width="50%" align="left" valign="top">';
		$message.='<table><tr><td><strong>Delivery Address</strong></td></tr><tr><td height="10"></td></tr><tr><td><strong>'.$data["user_data"][0]->name.'</strong></td></tr>';
		$message.='<tr><td>'.$dataorderget['fetch_data'][0]->address.','.$dataorderget['fetch_data'][0]->landmark .'</td></tr>';
		$message.='<tr><td></td></tr><tr><td><strong>Mobile - '.$dataorderget['fetch_data'][0]->mobile.'</strong></td></tr></table></td></tr></table>';
		$message.='<table width="100%" cellpadding="0" cellspacing="0" style="background: #fff;  font-size: 14px"><tr style="background: #F5F5F5; font-weight: bold">';
		$message.='<td style="padding-left:30px" height="40" valign="middle">Sr. No</td><td style="padding-left:30px" height="40" valign="middle">Item Details</td>';
		$message.='<td style="padding-left:30px" height="40" valign="middle">Qty</td>';
		$message.='<td style="padding-left:30px" height="40" valign="middle">Unite Price</td>';
		$message.='<td style="padding-left:30px" height="40" valign="middle">Sub Total</td></tr>';
		$fetch_data=$dataorderget['fetch_data'];
		if(count($fetch_data) > 0)  
        {  
            $counter=1;
            $subTotal=0;
            foreach($fetch_data as $row)  
            { 
                $subTotal= $subTotal+ $row->cart_product_quantity * $row->offer_price;  
                $message.=' <tr><td style="padding-left:30px; border-bottom: 1px solid #F5F5F5 " height="40">'.$counter.'</td><td style="padding-left:30px; border-bottom: 1px solid #F5F5F5" height="40">'.$row->product_name.'</td>';
                $message.='<td style="padding-left:30px; border-bottom: 1px solid #F5F5F5" height="40">'.$row->cart_product_quantity.'</td><td style="padding-left:30px; border-bottom: 1px solid #F5F5F5" height="40">₹ '.$row->offer_price.'</td>';
                $message.='<td style="padding-left:30px; border-bottom: 1px solid #F5F5F5" height="40">₹ '.$row->cart_product_quantity*$row->offer_price.'</td></tr>';
                //$message.='</tr>';
                $counter++;
           } 
            $deliveryCharge=$subTotal > 80 ? 0 : 10;
            $sameDay= 0;
            $type=$fetch_data[0]->delivery_type;
            if($type=="Same day delivery")
            {
                $sameDay= 10;
            }
		$message.='<tr><td height="40" colspan="4" align="right" style="padding-right:30px; border-bottom: 1px solid #F5F5F5"><strong>Sub Total</strong></td><td style="padding-left:30px" height="40"><strong>₹ '.$subTotal.'</strong></td></tr>';
	    $message.='<tr><td height="40" colspan="4" align="right" style="padding-right:30px; border-bottom: 1px solid #F5F5F5"><strong>VAT 5% </strong></td><td style="padding-left:30px" height="40"><strong>₹ '.$vat = (5 / 100) * $subTotal.'</strong></td></tr>';
		$message.='<tr><td height="40" colspan="4" align="right" style="padding-right:30px; border-bottom: 1px solid #F5F5F5"><strong>Delivery Charges</strong></td><td style="padding-left:30px" height="40"><strong>₹ '.$deliveryCharge.'</strong></td></tr>';
		$message.='<tr><td height="40" colspan="4" align="right" style="padding-right:30px; border-bottom: 1px solid #F5F5F5"><strong>Same Day Delivery Charges</strong></td><td style="padding-left:30px" height="40"><strong>₹ '.$sameDay.'</strong></td></tr>';
        if($fetch_data[0]->discount_percentage != ""){
          $message.='<tr><td height="40" colspan="4" align="right" style="padding-right:30px; border-bottom: 1px solid #F5F5F5"><strong>Discount Percentage</strong></td><td style="padding-left:30px" height="40"><strong>₹ '. $fetch_data[0]->discount_percentage.' % Discount(Coupon Applied)'.'</strong></td></tr>';
        }        
        $vat=(5 / 100) * $subTotal;      
        $deliveryCharge = number_format($deliveryCharge +$vat +$sameDay);
        if($fetch_data[0]->coupon_id <= 0){
            $grandtotal=$deliveryCharge+$subTotal;
            $message.='<tr style="background: #383838 ; color: #fff"><td height="40" colspan="4" align="right" style="padding-right:30px"><strong>Grand Total </strong>	</td><td style="padding-left:30px" height="40"><strong> ₹ '.$grandtotal.'</strong></td></tr>';

            
        }else{
                if($fetch_data[0]->referal_applied == 1){
                    $amount=50/100*$subTotal;
                    $amount=$subTotal-$amount;
                     $grandtotal=$deliveryCharge+$amount;
                    $message.='<tr style="background: #383838 ; color: #fff"><td height="40" colspan="4" align="right" style="padding-right:30px"><strong>Grand Total </strong>	</td><td style="padding-left:30px" height="40"><strong> ₹ '.$grandtotal.'</strong></td></tr>';

                }
                else{
                    $amount=$fetch_data[0]->discount_percentage/100*$subTotal;
                    $amount=$subTotal-$amount;
                    $grandtotal=$deliveryCharge+$amount;
                    $message.='<tr style="background: #383838 ; color: #fff"><td height="40" colspan="4" align="right" style="padding-right:30px"><strong>Grand Total </strong>	</td><td style="padding-left:30px" height="40"><strong> ₹ '.$grandtotal.'</strong></td></tr>';

                }
            }
        }
		$message.='</table><table width="100%"><tr align="center"><td height="50" align="center" valign="bottom">Happy Shopping</td></tr><tr><td height="50" align="center" valign="top" style="font-size: 20px; font-weight: bold">Team Yalda</td></tr></table>';
		$message.='<table width="100%" style="background: #F5F5F5; padding: 20px 0 "><tr align="center"><td height="50" colspan="2" align="center" style="font-size: 20px; font-weight: bold" valign="middle">DOWNLOAD OUR APP</td></tr><tr><td align="right" valign="middle" style="padding-right: 5px"><a href="#"><img src="'.base_url().'images/common/google.png" width="140" height="40" alt=""/></a></td><td align="left" valign="middle" style="padding-left: 5px"><a href="#"><img src="'.base_url().'images/common/ios.png" width="140" height="40" alt=""/></a></td></tr></table>';
		$message.=' <table width="100%" style="background:#B60008; color: #fff; padding: 30px"><tr><td><strong>Have questions?</strong></td></tr><tr><td>We are here to help, learn more about us here  <a href="#" style="color: #fff; text-decoration: none">Contact us</a></td></tr></table>';
		$message.='</td></tr></tbody></table></td></tr></table></body></html>';
       
        //echo $message;exit;
        $this->email->to($data['user_data'][0]->email);
        $this->email->subject('Order Cancellation');
        $this->email->message($message);
        $this->email->set_mailtype("html");
        if($this->email->send()){
             $api_url = site_url()."app/updateStatus";
            if($this->input->post('message')==null){
                $message=$this->input->post('option_message');
            }
            else{
                $message=$this->input->post('message').' '.$this->input->post('option_message');
            }
            $form_data = array(
             'user_id'  => $this->input->post('user_id'),
             'message'  => $message,
             'order_id'  => $this->input->post('order_id'),
             'status'  => $this->input->post('status'),
            );
            $client = curl_init($api_url);
        
            curl_setopt($client, CURLOPT_POST, true);
        
            curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
        
            curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        
            $response = curl_exec($client);
            curl_close($client);
        }
        // //echo $response;
        $this->session->set_flashdata("success", "Order Canceled Successfully");
        redirect('dashboard');
    }
    public function get_booking_details($booking_id,$user_id){
          $data = $this->session->userdata;
          //if($data['role']==1){
                $this->db->select('bookings.*,products.*,products.image,address_books.*,bookings.quantity as cart_product_quantity,products.name as product_name,customer.name as  customer_name,customer.dob,customer.mobile,customer.email,coupons.*');
                $this->db->from('bookings');
                $this->db->join('products', 'products.id = bookings.product_id');
                $this->db->join('users as customer', 'customer.id = bookings.user_id');
                $this->db->join('address_books', 'address_books.id = bookings.address_id','left');
                $this->db->join('coupons', 'coupons.coupon_id = bookings.coupon_id','left');
                $this->db->where(array('bookings.user_id'=>$user_id,'bookings.order_id'=>$booking_id,'bookings.product_type'=>'1'));
                $data= $this->db->get()->result();
           
                $this->db->select('bookings.*,offers.*,offers.image,address_books.*,bookings.quantity as cart_product_quantity,offers.name as product_name,customer.name as  customer_name,customer.dob,customer.mobile,customer.email,coupons.*');
                $this->db->from('bookings');
                $this->db->join('offers', 'offers.id = bookings.product_id');
                $this->db->join('users as customer', 'customer.id = bookings.user_id');
                $this->db->join('address_books', 'address_books.id = bookings.address_id','left');
                $this->db->join('coupons', 'coupons.coupon_id = bookings.coupon_id','left');
                $this->db->where(array('bookings.user_id'=>$user_id,'bookings.order_id'=>$booking_id,'bookings.product_type'=>'2'));
                $data2= $this->db->get()->result();
           
                $this->db->select('bookings.*,promotional.*,promotional.image,address_books.*,bookings.quantity as cart_product_quantity,promotional.name as product_name,customer.name as  customer_name,customer.dob,customer.mobile,customer.email,coupons.*');
                $this->db->from('bookings');
                $this->db->join('promotional', 'promotional.id = bookings.product_id');
                $this->db->join('users as customer', 'customer.id = bookings.user_id');
                $this->db->join('address_books', 'address_books.id = bookings.address_id','left');
                $this->db->join('coupons', 'coupons.coupon_id = bookings.coupon_id','left');
                $this->db->where(array('bookings.user_id'=>$user_id,'bookings.order_id'=>$booking_id,'bookings.product_type'=>'3'));
                $data3= $this->db->get()->result();
                $Data['fetch_data']=array_merge($data,$data2,$data3);
                foreach($Data['fetch_data'] as $item){
                if($item->coupon_id==null){
                    $item->coupon_id=0;
                    $item->coupon_code='';
                    $item->coupon_title='';
                    $item->discount_percentage=0;
                }
                if($item->address_id==0){
                    $item->address=$item->address;
                    $item->landmark=$item->landmark;
                    $item->mobile=$item->mobile;
                    $item->name=$item->customer_name;
                }
                
           // }
           return $Data;
          
      }
    }
    
    public function login(){

        $api_url = site_url()."app/login";
        $form_data = array(
            'email'  => $this->input->post('email'),
            'password'   => $this->input->post('password'),
            'fcm_token' =>$this->input->post('fcm_token'),
            'device_id' =>$this->input->post('device_id')
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    }

    public function sendOTP(){
        $otp=$this->generateNumericOTP(6);
        $param = array(
            'username' => 'yaldafresh',
            'password' => '3eLsEw1v8x',
            'senderid' => 'YALDAFRESH',
            'text' => $otp.' is your one time password(OTP) for phone verification',
            'type' => 'text',
        );
        $mobile=$this->input->post('mobile');
        $recipients = array($mobile);
        $post = 'to=' . implode(';', $recipients);
        foreach ($param as $key => $val) {
            $post .= '&' . $key . '=' . rawurlencode($val);
        }
        $url = "https://smartsmsgateway.com/api/api_json.php";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
        $result = curl_exec($ch);
        if(curl_errno($ch)) {
            $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
        } else {
            $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            switch($returnCode) {
                case 200 :
                    break;
                default :
                    $result = "HTTP ERROR: " . $returnCode;
            }
        }
        curl_close($ch);
        $this->basic_operation->updateDetails('users',array('verify_otp'=>$otp,'mobile_verified'=>'0'),array('mobile'=>$mobile));
        echo json_encode(array(
                    'error'    => false,
                    'message' => 'OTP Send Successfully'
               )); 
    }
    
    public function verifyOTP(){
        
        
         $api_url = site_url()."app/verifyOTP";
        $form_data = array(
         'mobile'  => $this->input->post('mobile'),
         'otp' => $this->input->post('otp')
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
         
     
    }
    
    // Function to generate OTP 
    public function generateNumericOTP($n) 
    { 
        $generator = "1357902468"; 
        $otp = ""; 
        for ($i = 1; $i <= $n; $i++) { 
            $otp .= substr($generator, (rand()%(strlen($generator))), 1); 
        } 
      
        $chkOTP = $this->basic_operation->matchedRowCount('users',array('verify_otp ='=>$otp));
        if($chkOTP > 0){
           $this->generateNumericOTP(6); 
        }else{
            return $otp;
        }
        
    }
    public function logout()
    {
    
        $api_url = site_url()."app/logout";
        $form_data = array(
         'user_id'  => $this->input->post('user_id'),
         'device_id' => $this->input->post('device_id')
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    }
    
    public function forgot()
    {
    
        $api_url = site_url()."app/forgot";
        $form_data = array(
         'email'  => $this->input->post('email'),
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    }


/* *****************************************  Users APIs ****************************************** */

public function UserLogin()
{

    $api_url = site_url()."users/login";
    $form_data = array(
        'email'  => $this->input->post('email'),
        'password'   => $this->input->post('password'),
        'fcm_token' =>$this->input->post('fcm_token')
    );
    $client = curl_init($api_url);

    curl_setopt($client, CURLOPT_POST, true);

    curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($client);

    curl_close($client);

    echo $response;
}
public function UserLogout(){

$api_url = site_url()."users/logout";
$form_data = array(
 'token'  => $this->input->post('token'),
);
$client = curl_init($api_url);

curl_setopt($client, CURLOPT_POST, true);

curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($client);

curl_close($client);

echo $response;
}

public function UserForgot(){

$api_url = site_url()."users/forgot";
$form_data = array(
 'email'  => $this->input->post('email'),
);
$client = curl_init($api_url);

curl_setopt($client, CURLOPT_POST, true);

curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($client);

curl_close($client);

echo $response;
}

public function checkEmailAvailibility(){

$api_url = site_url()."data/checkEmailAvailibility";
$form_data = array(
 'email'  => $this->input->post('email'),
);
$client = curl_init($api_url);

curl_setopt($client, CURLOPT_POST, true);

curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($client);

curl_close($client);

echo $response;
}


/* ***************************************** Home Pages APIs *******************************************/
    
    public function getHomeData(){
        $api_url = site_url()."app/getHomeData";

        $client = curl_init($api_url);
        $form_data=array(
            'user_id'=>$this->input->post('user_id'),
            'device_id' => $this->input->post('device_id')
            );
        curl_setopt($client, CURLOPT_POST, true);
        
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
        
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($client);
        
        curl_close($client);
        
        echo $response; 
    }
    public function getAllCategory(){
        
        $api_url = site_url()."app/getAllCategory";

        $client = curl_init($api_url);
        
        curl_setopt($client, CURLOPT_POST, true);
        
        curl_setopt($client, CURLOPT_POSTFIELDS, false);
        
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($client);
        
        curl_close($client);
        
        echo $response;
    } 
    
    
    public function getAllProduct(){

    $api_url = site_url()."app/getAllProduct";

    $client = curl_init($api_url);
    
    curl_setopt($client, CURLOPT_POST, true);
    
    curl_setopt($client, CURLOPT_POSTFIELDS, false);
    
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($client);
    
    curl_close($client);
    
    echo $response;
    }
    
    public function getAllCategoryProduct(){

    $api_url = site_url()."app/getAllCategoryProduct";
    $client = curl_init($api_url);
    $form_data=array(
        'category_id'=>$this->input->post('category_id'),
        'user_id'=>$this->input->post('user_id'),
        'page'=>$this->input->post('page'),
        'device_id' => $this->input->post('device_id')
        );
    $client = curl_init($api_url);
    
    curl_setopt($client, CURLOPT_POST, true);
    
    curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($client);
    
    curl_close($client);
    
    echo $response;
    }
    
    
    public function getPromotionalCategoryProduct()
    {

    $api_url = site_url()."app/getPromotionalCategoryProduct";
    $client = curl_init($api_url);
    $form_data=array(
        'category_id'=>$this->input->post('category_id'),
        'user_id'=>$this->input->post('user_id'),
        'page'=>$this->input->post('page'),
        'device_id' => $this->input->post('device_id')
        );
    $client = curl_init($api_url);
    
    curl_setopt($client, CURLOPT_POST, true);
    
    curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($client);
    
    curl_close($client);
    
    echo $response;
    }
    
    public function getAllSubCategory($id){

    $api_url = site_url()."app/getAllSubCategory/$id";

    $client = curl_init($api_url);
    
    curl_setopt($client, CURLOPT_POST, true);
    
    curl_setopt($client, CURLOPT_POSTFIELDS, false);
    
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($client);
    
    curl_close($client);
    
    echo $response;
    }
    

    public function verifyMycart()
    {   $api_url = site_url()."app/verifyMycart";
        $requiredFields = array("user_id");
        $form_data = array(
           'user_id'   => $_REQUEST['user_id']
        );
            $fields = array_diff_key(array_flip($requiredFields), $_REQUEST);
            if(!empty($fields))
            {
                $response["error"] = false;
                $missing_fields = implode(",", array_keys($fields));
                $response["missing_fields"] = $missing_fields;
                $response["message"] = "Some Fields are missing";
            }
            else
            {
               $client = curl_init($api_url);    
                curl_setopt($client, CURLOPT_POST, true);            
                curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);            
                curl_setopt($client, CURLOPT_RETURNTRANSFER, true);            
                $response = curl_exec($client);            
                curl_close($client);            
                echo $response;
            }            
        
    }

    
    public function getAllOffer()
    {

    $api_url = site_url()."app/getAllOffer";
    $form_data=array(
        'user_id'=>$this->input->post('user_id'),
        'page'=>$this->input->post('page'),
        'device_id' => $this->input->post('device_id')
        );
    $client = curl_init($api_url);
    
    curl_setopt($client, CURLOPT_POST, true);
    
    curl_setopt($client, CURLOPT_POSTFIELDS,$form_data);
    
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($client);
    
    curl_close($client);
    
    echo $response;
    }

    
    public function myBooking()
    {
        $api_url = site_url()."app/myBooking";
        $form_data = array(
           'user_id'   => $this->input->post('user_id'),
           'flag'  => $this->input->post('flag'),
           'device_id' => $this->input->post('device_id'),
           'page' => $this->input->post('page')
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    }
    
    
    public function getBookingDetails()
    {
        $api_url = site_url()."app/getBookingDetails";
        $form_data = array(
           'user_id'   => $this->input->post('user_id'),
           'order_id'   => $this->input->post('order_id'),
           'device_id' => $this->input->post('device_id')
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    }
    

    
    public function addMyWishList()
    {
        $api_url = site_url()."app/addMyWishList";
        $form_data = array(
            'user_id'   => $this->input->post('user_id'),
            'product_type'   => $this->input->post('product_type'),
            'product_id'  => $this->input->post('product_id'),
            'wishlist_id'=>$this->input->post('wishlist_id'),
            'device_id' => $this->input->post('device_id')
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    }
    
    public function myWishList(){
        $api_url = site_url()."app/myWishList";
        $form_data = array(
            'user_id'   => $this->input->post('user_id'),
            'page'   => $this->input->post('page'),
            'device_id' => $this->input->post('device_id')
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    }

    public function deleteWishList(){
        $api_url = site_url()."app/deleteWishList";
        $form_data = array(
            'user_id'   => $this->input->post('user_id'),
            'product_id'   => $this->input->post('product_id'),
            'product_type' => $this->input->post('product_type'),
            'device_id' => $this->input->post('device_id')
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    }


    public function getProductById($id){

        $api_url = site_url()."app/getProductById/$id";
    
        $client = curl_init($api_url);
        
        curl_setopt($client, CURLOPT_POST, true);
        
        curl_setopt($client, CURLOPT_POSTFIELDS, false);
        
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($client);
        
        curl_close($client);
        
        echo $response;
    }
          
    public function AddToCart(){  
        $api_url = site_url()."app/AddToCart";
    
        $client = curl_init($api_url);
        $form_data = array(
            'product_id'   => $this->input->post('product_id'),
            'product_type'   => $this->input->post('product_type'),
            'flag'   => $this->input->post('flag'),
            'product_quantity'   => $this->input->post('product_quantity'),
            'user_id'   => $this->input->post('user_id'),
            'device_id'  => $this->input->post('device_id'),

        );
        curl_setopt($client, CURLOPT_POST, true);
        
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
        
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($client);
        
        curl_close($client);
        
        echo $response;     
            
    } 
    
    public function myCart(){  
        $api_url = site_url()."app/myCart";
    
        $client = curl_init($api_url);
        $form_data = array(
            'user_id'   => $this->input->post('user_id'),
            'device_id' => $this->input->post('device_id')
        );
        curl_setopt($client, CURLOPT_POST, true);
        
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
        
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($client);
        
        curl_close($client);
        
        echo $response;     
            
    } 
    public function getCartQty(){  
        $api_url = site_url()."app/getCartQty";
    
        $client = curl_init($api_url);
        $form_data = array(
            'user_id'   => $this->input->post('user_id'),
            'device_id' => $this->input->post('device_id')
        );
        curl_setopt($client, CURLOPT_POST, true);
        
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
        
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($client);
        
        curl_close($client);
        
        echo $response;     
            
    } 

    public function ManageAddToCart(){  
        $api_url = site_url()."app/ManageAddToCart";
    
        $client = curl_init($api_url);
        $form_data = array(
            'product_id'   => $this->input->post('product_id'),
            'product_quantity'   => $this->input->post('product_quantity'),
            'user_id'   => $this->input->post('user_id'),
            'device_id' => $this->input->post('device_id')

        );
        curl_setopt($client, CURLOPT_POST, true);
        
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
        
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($client);
        
        curl_close($client);
        
        echo $response;     
            
    } 

    public function AddToWishList(){  
        $api_url = site_url()."app/AddToWishList";
    
        $client = curl_init($api_url);
        $form_data = array(
            'product_id'   => $this->input->post('product_id'),
            'user_id'   => $this->input->post('user_id'),
            'device_id' => $this->input->post('device_id')

        );
        curl_setopt($client, CURLOPT_POST, true);
        
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
        
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($client);
        
        curl_close($client);
        
        echo $response;     
            
    } 

    public function DeleteCartProduct(){  
        $api_url = site_url()."app/DeleteCartProduct";
    
        $client = curl_init($api_url);
        $form_data = array(
            'cart_id'   => $this->input->post('cart_id'),
            'user_id'   => $this->input->post('user_id'),
            'device_id' => $this->input->post('device_id')
        );
        curl_setopt($client, CURLOPT_POST, true);
        
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
        
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($client);
        
        curl_close($client);
        
        echo $response;     
            
    }
    
    public function addressBook(){
        $api_url = site_url()."app/addressBook";
    
        $client = curl_init($api_url);
        $form_data = array(
            'name'   => $this->input->post('name'),
            'address'   => $this->input->post('address'),
            'pincode'   => $this->input->post('pincode'),
            'mobile'   => $this->input->post('mobile'),
            'user_id'   => $this->input->post('user_id'),
            'device_id' => $this->input->post('device_id'),
            'address_id'   => $this->input->post('address_id'),
            'landmark'   => $this->input->post('landmark')
        );
        curl_setopt($client, CURLOPT_POST, true);
        
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
        
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($client);
        
        curl_close($client);
        
        echo $response;     
           
    }
    
    public function getAddressBook(){
        $api_url = site_url()."app/getAddressBook";
    
        $client = curl_init($api_url);
        $form_data = array(
           'user_id'   => $this->input->post('user_id'),
           'device_id' => $this->input->post('device_id')
        );
        curl_setopt($client, CURLOPT_POST, true);
        
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
        
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($client);
        
        curl_close($client);
        
        echo $response;     
           
    }
    public function deleteAddressBook(){
        $api_url = site_url()."app/deleteAddressBook";
    
        $client = curl_init($api_url);
        $form_data = array(
           'user_id'   => $this->input->post('user_id'),
           'address_id'   => $this->input->post('address_id'),
           'device_id' => $this->input->post('device_id')
        );
        curl_setopt($client, CURLOPT_POST, true);
        
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
        
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($client);
        
        curl_close($client);
        
        echo $response; 
    }
    
    public function getDefaultAddress(){
        $api_url = site_url()."app/getDefaultAddress";
        $form_data = array(
           'user_id'   => $this->input->post('user_id'),
           'device_id' => $this->input->post('device_id')
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    }
    
    public function getCountry(){
        $api_url = site_url()."app/getCountry";
       
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, false);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    }
    
     public function getMessages(){
        $api_url = site_url()."app/getMessages";
       
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, false);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    }
    
    public function getBanners()
    {
        $api_url = site_url()."app/getBanners";       
        $client = curl_init($api_url);    
        curl_setopt($client, CURLOPT_POST, true);    
        curl_setopt($client, CURLOPT_POSTFIELDS, false);    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);    
        $response = curl_exec($client);    
        curl_close($client);    
        echo $response;        
    }

     
    public function setDefaultAddress()
    {
        $api_url = site_url()."app/setDefaultAddress";
        $form_data = array(
           'user_id'   => $this->input->post('user_id'),
           'address_id'   => $this->input->post('address_id'),
           'device_id' => $this->input->post('device_id')
        );
        $client = curl_init($api_url);    
        curl_setopt($client, CURLOPT_POST, true);    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);    
        $response = curl_exec($client);    
        curl_close($client);    
        echo $response;
    }
    
    
     public function PlaceOrder(){
        $api_url = site_url()."app/PlaceOrder";
        $form_data = array(
           'user_id'   => $this->input->post('user_id'),
           'device_id' => $this->input->post('device_id'),
           'delivery_type' => $this->input->post('delivery_type'),
           'transection_id'=>$this->input->post('transection_id'),
           'payment_type'=>$this->input->post('payment_type'),
           'transection_amount'=>$this->input->post('transection_amount'),
           'transection_message'=>$this->input->post('transection_message'),
           'transection_status'=>$this->input->post('transection_status'),
           'address_id'   => $this->input->post('address_id'),
           'address'=>$this->input->post('address'),
           'name'=>$this->input->post('name'),
           'email'=>$this->input->post('email'),
           'latitude'=>$this->input->post('latitude'),
           'longitude'=>$this->input->post('longitude'),
           'note'=>$this->input->post('note'),
           'coupon_id'=>$this->input->post('coupon_id'),
           'referal_applied'=>$this->input->post('referal_applied'),
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    }
    
    public function updateProfile(){
        $api_url = site_url()."app/updateProfile";
        $form_data = array(
           'user_id'   => $this->input->post('user_id'),
           'name'=>$this->input->post('name'),
           'mobile'=>$this->input->post('mobile'),
           'nationality'=>$this->input->post('nationality'),
           'device_id' => $this->input->post('device_id')
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    }
    
    public function changePassword(){
        $api_url = site_url()."app/changePassword";
        $form_data = array(
           'user_id'   => $this->input->post('user_id'),
           'current_password'=>$this->input->post('current_password'),
           'new_password'=>$this->input->post('new_password'),
           'confirm_password'=>$this->input->post('confirm_password'),
           'device_id' => $this->input->post('device_id')
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    
    }
    
   public function search(){
       $api_url = site_url()."app/search";
        $form_data = array(
           'user_id'   => $this->input->post('user_id'),
           'page'   => $this->input->post('page'),
           'keywords'=>$this->input->post('keywords'),
           'device_id' => $this->input->post('device_id')
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
   }
   
   public function getCoupons(){
        $api_url = site_url()."app/getCoupons";
        
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, false);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
   }
   
   public function verifyCoupons(){
        $api_url = site_url()."app/verifyCoupons";
         $form_data = array(
           'user_id'   => $this->input->post('user_id'),
           'coupon_id'=>$this->input->post('coupon_id'),
           'amount'=>$this->input->post('amount'),
           'device_id' => $this->input->post('device_id')
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
   }
   
       public function SetNotificationKeys()
       {
        $api_url = site_url()."app/SetNotificationKeys";
        $form_data = array(
           'user_id'   => $this->input->post('user_id'),
           'pending'   => $this->input->post('pending'),
           'processing'=>$this->input->post('processing'),
           'delivered'=>$this->input->post('delivered'),
           'cancelled'=>$this->input->post('cancelled'),
           'device_id' => $this->input->post('device_id')
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    }
    
    public function GetNotificationKeys()
    {
        $api_url = site_url()."app/GetNotificationKeys";
        $form_data = array(
           'user_id'   => $this->input->post('user_id'),
           'device_id' => $this->input->post('device_id')
        );
        
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    }
    
    public function getSimilarProducts()
    {
        $api_url = site_url()."app/getSimilarProducts";
        $form_data = array(
           'user_id'   => $this->input->post('user_id'),
           'product_id'   => $this->input->post('product_id'),
           'category_id'   => $this->input->post('category_id'),
           'device_id' => $this->input->post('device_id')
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    }
    
    public function SetFcmToken()
    {
        $api_url = site_url()."app/SetFcmToken";
        $form_data = array(
           'user_id'   => $this->input->post('user_id'),
           'fcm_token'   => $this->input->post('fcm_token'),
           'device_id' => $this->input->post('device_id')
        );
        $client = curl_init($api_url);
    
        curl_setopt($client, CURLOPT_POST, true);
    
        curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($client);
    
        curl_close($client);
    
        echo $response;
    }
}

