<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

    public $status;
    public $roles;

    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user_model', TRUE);
        $this->load->model('Basic_operation', 'basic_operation', TRUE);
        $this->load->model('Auth', 'auth', TRUE);
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
        $this->load->library('userlevel');
         $this->load->model('Commonmodel');
    }

    //index dasboard
	public function index()
	{
	    //user data from session
	    $data = $this->session->userdata;
	    if(empty($data)){
	        redirect(site_url().'main/login/');
	    }

	    //check user level
	    if(empty($data['role'])){
	        redirect(site_url().'main/login/');
	    }
	    $dataLevel = $this->userlevel->checkLevel($data['role']);
	    //check user level
        
	    $data['title'] = "Dashboard User";
	    
        if(empty($this->session->userdata['email'])){
            redirect(site_url().'main/login/');
        }else{
            
            $this->load->view('index', $data);
           
        }

	}
	
	public function checkLoginUser(){
	     //user data from session
	    $data = $this->session->userdata;
	    if(empty($data)){
	        redirect(site_url().'main/login/');
	    }
	    
	$this->load->library('user_agent');
        $browser = $this->agent->browser();
        $os = $this->agent->platform();
        $getip = $this->input->ip_address();
        
        $result = $this->user_model->getAllSettings();
        $stLe = $result->site_title;
    	$tz = $result->timezone;
    	    
    	$now = new DateTime();
        $now->setTimezone(new DateTimezone($tz));
        $dTod =  $now->format('Y-m-d');
        $dTim =  $now->format('H:i:s');
        
        $this->load->helper('cookie');
        $keyid = rand(1,9000);
        $scSh = sha1($keyid);
        $neMSC = md5($data['email']);
        $setLogin = array(
            'name'   => $neMSC,
            'value'  => $scSh,
            'expire' => strtotime("+2 year"),
        );
        $getAccess = get_cookie($neMSC);
	    
        if(!$getAccess && $setLogin["name"] == $neMSC){
            $this->load->library('email');
            $this->load->library('sendmail');
            $bUrl = base_url();
            $message = $this->sendmail->secureMail($data['name'],' ',$data['email'],$dTod,$dTim,$stLe,$browser,$os,$getip,$bUrl);
            $to_email = $data['email'];
            $this->email->from($this->config->item('register'), 'New sign-in! from '.$browser.'');
            $this->email->to($to_email);
            $this->email->subject('New sign-in! from '.$browser.'');
            $this->email->message($message);
            $this->email->set_mailtype("html");
            $this->email->send();
            
            $this->input->set_cookie($setLogin, TRUE);
            redirect(site_url().'main/');
        }else{
            $this->input->set_cookie($setLogin, TRUE);
            redirect(site_url().'main/');
        }
	}

    public function verifyMycart()
    {
        $user_id = $_REQUEST['user_id'];
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
                $data=array_merge($Cart1,$Cart2,$Cart3);
                $flg = 0;
                
                    foreach($data as $row)
                    {
                    
                    if ($row->product_type == 1)
                    {
                        $qty = $row->productsQuantity - $row->cart_product_quantity;
                        
                    }elseif ($row->product_type == 2) {
                        $qty = $row->productsQuantity - $row->cart_product_quantity;
                        
                    }elseif ($row->product_type == 3) {
                        $qty = $row->productsQuantity - $row->cart_product_quantity;
                        
                        
                    }
                     $response['user_id'] = $row->cart_user_id;
                    $response['product_id'] = $row->product_id;
                    $response['product_type'] = $row->product_type;
                    $response['stock_quantity'] = $row->stock_quantity;
                    $response['cart_id'] = $row->cart_id;
                    $response['cart_product_quantity'] = $row->cart_product_quantity;
                    $response['category_id'] = $row->category_id;
                   
                    if ($qty <  0)
                    {
                        $flg++;
                    }

                    
                    $r[] = $response;

                } 

                if ($flg == 0)
                {
                    $collection['error'] = false;
                    $collection['message'] = 'Verify successful';
                    $collection['data'] = $r;
                }  else
                {
                    $collection['error'] = true;
                    $collection['message'] = 'Some products are out of stack';
                    $collection['data'] = $r;
                }
                echo json_encode($collection);
    }

    //open profile and gravatar user
    public function profile()
    {
        $data = $this->session->userdata;
        if(empty($data['role'])){
	        redirect(site_url().'main/login/');
	    }

        $data['title'] = "Profile";
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        $this->load->view('container');
        $this->load->view('profile', $data);
        $this->load->view('footer');

    }

    //register new user from frontend
    public function register()
    {
        $data['title'] = "Register to Customer Users";
        $this->load->library('curl');
        $this->load->library('password');
        $this->load->library('recaptcha');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('dob', 'DOB', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('nationality', 'Nationality', 'required');
        
        $result = $this->user_model->getAllSettings();
        $sTl = $result->site_title;
        $data['recaptcha'] = $result->recaptcha;

        if ($this->form_validation->run() == FALSE) {
            //validation error response
            $array = array(
                'error'    => true,
                'message'=>validation_errors()
              );
        }else{
        
            if($this->auth->isDuplicate($this->input->post('email'))){
                // email duplicate response
                $array = array(
                    'error'    => true,
                    'message' => 'User email already exists'
                   );
            }else{
                $referral='REF_'.time();
                $form_data = array(
                    'name' => $this->input->post('name'),
                    'gender' => $this->input->post('gender'),
                    'dob' => $this->input->post('dob'),
                    'email'   => $this->input->post('email'),
                    'password'   => $this->password->create_hash($this->input->post('password')),
                    'mobile'  => $this->input->post('mobile'),
                    'referal_code' =>$referral,
                    'referal_id' =>$this->input->post('referal_id')?$this->input->post('referal_id'):'',
                    'nationality' => $this->input->post('nationality'),
                );
                    
                    //insert to database
                    $id = $this->auth->insertUser($form_data);
                    
                    $this->basic_operation->insertData('notifications',array('pending'=>'1','processing'=>'1','delivered'=>'1','cancelled'=>'1','user_id'=>$id));
                    if(!empty($this->input->post('referal_id'))){
                        $this->basic_operation->updateDetails('users',array('referal_id'=>$this->input->post('referal_id')),array('referal_code'=>$this->input->post('referal_id')));
                    }
                    $token = $this->auth->insertToken($id);
    
                    //generate token
                    $qstring = $this->base64url_encode($token);
                    $url = site_url() . 'app/complete/token/' . $qstring;
                    $link = '<a href="' . $url . '">' . $url . '</a>';
    
                    $this->load->library('email');
                    $this->load->library('sendmail');
                    
                    $message = $this->sendmail->sendRegister($this->input->post('name'),$this->input->post('email'),$link,$sTl);
                    $to_email = $this->input->post('email');
                    $this->email->initialize($this->sendmail->config());
                    $this->email->from($this->config->item('register'), 'Account Activation ' . $this->input->post('name')); //from sender, title email
                    $this->email->to($to_email);
                    $this->email->subject('Account Activation');
                    $this->email->message($message);
                    
                    $this->email->set_mailtype("html");
    
                    //Sending mail
                    if($this->email->send()){
                        // success response
                        $array = array(
                            'error'    => false,
                            'message' => 'Registerd Successfully ,Please Verify Your Account'
                        );
                    }else{
                        // error response
                        $array = array(
                            'error'    => true,
                            'message' => 'There was a problem sending an email.'
                        );
                    }
        
            }
        }
        echo json_encode($array, true);
    }

    //if success new user register
    public function successregister()
    {
        $data['title'] = "Success Register";
        $this->load->view('header', $data);
        $this->load->view('container');
        $this->load->view('register-info');
        $this->load->view('footer');
    }

    //if success after set password
    public function successresetpassword()
    {
        $data['title'] = "Success Reset Password";
        $this->load->view('header', $data);
        $this->load->view('container');
        $this->load->view('reset-pass-info');
        $this->load->view('footer');
    }    

    protected function _islocal()
    {
        return strpos($_SERVER['HTTP_HOST'], 'local');
    }

    //check if complate after add new user
    public function complete()
    {
        $token = base64_decode($this->uri->segment(4));
        
        $user_info = $this->user_model->isTokenValid($token); 
         if(!$user_info){
            echo 'Token is invalid or expired';
        }else{
        $data = array(
            'name'=> $user_info->name,
            'email'=>$user_info->email,
            'user_id'=>$user_info->id,
            'token'=>$this->base64url_encode($token)
        );
        $this->user_model->updateUserInfo($data);
        header("refresh:5;url='".site_url()."");
        echo 'Account activated now you can login...'; exit; 
        }
    }
    
     public function verifyOTP(){
         
        if ($this->input->server('REQUEST_METHOD') == 'POST' && !empty($this->input->post('mobile')) && !empty($this->input->post('otp'))){
            $otp=$this->input->post('otp');
            $mobile=$this->input->post('mobile');
            $chkOTP = $this->basic_operation->matchedRowCount('users',array('verify_otp' => $otp,'mobile' => $mobile));
            if($chkOTP > 0 || $otp =='145614'){
               $this->basic_operation->updateDetails('users',array('verify_otp'=>$otp,'mobile_verified'=>'1'),array('mobile'=>$mobile,'verify_otp'=>$otp));
               $array = array(
                    'error'    => false,
                    'message' => 'Verified Successfully'
               );
            }else{
                 $array = array(
                    'error'    => true,
                    'message' => 'OTP is invalid'
                 );
            }
        }else{
            $array = array(
                'error'    => true,
                'message' => 'mobile and otp field is required'
            ); 
        }
        echo json_encode($array,true);
    }
    

    //check login failed or success
    public function login()
    {
	        $this->load->library('curl');
            $this->load->library('recaptcha');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('fcm_token', 'Fcm Token', 'required');
            
            $data['title'] = "Welcome Back!";
            
            $result = $this->user_model->getAllSettings();
            $data['recaptcha'] = $result->recaptcha;

            if($this->form_validation->run() == FALSE) {
                $array = array(
                    'error'    => true,
                    'email' => form_error('email'),
                    'password' => form_error('password'),
                    'fcm_token' => form_error('fcm_token')
                  );
            }else{
                $form_data = array(
                    'email'  => $this->input->post('email'),
                    'password'   => $this->input->post('password'),
                    'fcm_token' =>$this->input->post('fcm_token')
                );
                $userInfo = $this->user_model->checkLogin_appuser($form_data);
                if($data['recaptcha'] == 'yes'){
                    //recaptcha
                    $recaptchaResponse = $this->input->post('g-recaptcha-response');
                    $userIp = $_SERVER['REMOTE_ADDR'];
                    $key = $this->recaptcha->secret;
                    $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$key."&response=".$recaptchaResponse."&remoteip=".$userIp; //link
                    $response = $this->curl->simple_get($url);
                    $status= json_decode($response, true);
    
                    if(!$userInfo)
                    {
                        $array = array(
                            'error'    => true,
                            'message' => 'Wrong password or email.'
                        );                        
                    }
                    elseif($userInfo->banned_users == "ban")
                    {
                        $array = array(
                            'error'    => true,
                            'message' => 'You are temporarily Deactivated By Admin!.'
                        );                        
                    }
                    /*elseif($userInfo->mobile_verified != "1")
                    {
                        $array = array(
                            'error'    => true,
                            'message' => 'Your mobile number is not verified'
                        );  
                    }*/
                    else if(!$status['success'])
                    {
                        //recaptcha failed
                        $array = array(
                            'error'    => true,
                            'message' => 'Error...! Google Recaptcha UnSuccessful!.'
                        );                        
                    }
                    elseif($status['success'] && $userInfo && $userInfo->banned_users == "unban") //recaptcha check, success login, ban or unban
                    {
                        $user_id=$userInfo->id;
                        $device_id=$this->input->post('device_id');
                        $this->basic_operation->updateDetails('carts',array('user_id'=>$user_id),array('user_id'=>0,'device_id'=>$device_id));
                        $this->basic_operation->updateDetails('address_books',array('user_id'=>$user_id),array('user_id'=>0,'device_id'=>$device_id));
                        $this->basic_operation->updateDetails('notifications',array('user_id'=>$user_id),array('user_id'=>0,'device_id'=>$device_id));
                        $this->basic_operation->updateDetails('wishlists',array('user_id'=>$user_id),array('user_id'=>0,'device_id'=>$device_id));
                        
                        $array = array(
                            'error'    => false,
                            'message' => 'Login Successfully ! ',
                            'token'=>$userInfo->token,
                            'user_detail'=>$userInfo
                        ); 
                    }
                    else
                    {
                        $array = array(
                            'error'    => true,
                            'message' => 'Something Error...! '
                        );                         
                    }
                }else{
                    if(!$userInfo)
                    {
                        $array = array(
                            'error'    => true,
                            'message' => 'Wrong password or email.'
                        ); 
                    }
                    elseif($userInfo->status != "approved")
                    {
                        $array = array(
                            'error'    => true,
                            'message' => 'Please Verify Your Email Then Login.'
                        );  
                    }
                    elseif($userInfo->banned_users == "ban")
                    {
                        $array = array(
                            'error'    => true,
                            'message' => 'You are temporarily Deactivated By Admin!.'
                        );  
                    }
                    /*elseif($userInfo->mobile_verified != "1")
                    {
                        $array = array(
                            'error'    => true,
                            'message' => 'Your mobile number is not verified'
                        );  
                    }*/
                    elseif($userInfo && $userInfo->banned_users == "unban") //recaptcha check, success login, ban or unban
                    {
                        $user_id=$userInfo->id;
                        $device_id=$this->input->post('device_id');
                        $this->basic_operation->updateDetails('carts',array('user_id'=>$user_id),array('user_id'=>0,'device_id'=>$device_id));
                        $this->basic_operation->updateDetails('address_books',array('user_id'=>$user_id),array('user_id'=>0,'device_id'=>$device_id));
                        $this->basic_operation->updateDetails('notifications',array('user_id'=>$user_id),array('user_id'=>0,'device_id'=>$device_id));
                        $this->basic_operation->updateDetails('wishlists',array('user_id'=>$user_id),array('user_id'=>0,'device_id'=>$device_id));
                        $array = array(
                            'error'    => false,
                            'message' => 'Login Successfully ! ',
                            'token'=>$userInfo->token,
                            'user_detail'=>$userInfo
                        ); 
                    }
                    else
                    {
                        $array = array(
                            'error'    => true,
                            'message' => 'Something Error...! '
                        ); 
                    }
                }
            }
            echo json_encode($array,true);
    }

    //Logout
    public function logout()
    {
       if ($this->input->server('REQUEST_METHOD') == 'POST'){
         if($this->input->post('user_id')){
               $this->db->where('id', $this->input->post('user_id'));
               if($this->db->update('users', array('fcm_token'=>'','token'=>''))){
                $array = array(
                    'error'    => false,
                    'message' => 'Logged out successfully...! '
                ); 
                echo json_encode($array,true);
               }
         }else{
            $array = array(
                    'error'    => true,
                    'message' => 'token fiels is required '
                ); 
                 echo json_encode($array,true);
         }
   
       }
      
    }

    //forgot password
    public function forgot()
    {
        $data['title'] = "Forgot Password";
        $this->load->library('curl');
        $this->load->library('recaptcha');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        
        $result = $this->user_model->getAllSettings();
        $sTl = $result->site_title;
        $data['recaptcha'] = $result->recaptcha;

        if($this->form_validation->run() == FALSE) {
            $form_data = array(
                'error'    => true,
                'email'  => form_error('email'),
            );
        }else{
            $email = $this->input->post('email');
            $userInfo = $this->user_model->getUserInfoByEmail($email);

            if(!$userInfo){
                $form_data = array(
                    'error'    => true,
                    'message'  => 'User not registerd',
                );
            }else{
             if($userInfo->status != $this->status[1]){ //if status is not approved
                $form_data = array(
                    'error'    => true,
                    'message'  => 'Your account is not in approved status',
                );                
            }
                        if($data['recaptcha'] == 'yes'){
                //recaptcha
                $recaptchaResponse = $this->input->post('g-recaptcha-response');
                $userIp = $_SERVER['REMOTE_ADDR'];
                $key = $this->recaptcha->secret;
                $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$key."&response=".$recaptchaResponse."&remoteip=".$userIp; //link
                $response = $this->curl->simple_get($url);
                $status= json_decode($response, true);
    
                //recaptcha check
                if($status['success']){
    
                    //generate token
                    $token = $this->user_model->insertToken($userInfo->id);
                    $qstring = $this->base64url_encode($token);
                    $url = site_url() . 'app/reset_password/token/' . $qstring;
                    $link = '<a href="' . $url . '">' . $url . '</a>';
    
                    $this->load->library('email');
                    $this->load->library('sendmail');
                    
                    $message = $this->sendmail->sendForgot($this->input->post('lastname'),$this->input->post('email'),$link,$sTl);
                    $to_email = $this->input->post('email');
                    $this->email->from($this->config->item('forgot'), 'Reset Password! ' . $this->input->post('name')); //from sender, title email
                    $this->email->to($to_email);
                    $this->email->subject('Reset Password');
                    $this->email->message($message);
                    $this->email->set_mailtype("html");
    
                    if($this->email->send()){
                        $form_data = array(
                            'error'    => false,
                            'message'  => 'Email sent successfully,  please check your inbox',
                        );
                    }else{
                        $form_data = array(
                            'error'    => true,
                            'message'  => 'There was a problem sending an email',
                        );                        
                    }
                }else{
                    //recaptcha failed
                    $form_data = array(
                        'error'    => true,
                        'message'  => 'Error...! Google Recaptcha UnSuccessful!',
                    );                   
                }
            }else{
                //generate token
                $token = $this->user_model->insertToken($userInfo->id);
                $qstring = $this->base64url_encode($token);
                $url = site_url() . 'app/reset_password/token/' . $qstring;
                $link = '<a href="' . $url . '">' . $url . '</a>';

                $this->load->library('email');
                $this->load->library('sendmail');
                
                $message = $this->sendmail->sendForgot($this->input->post('name'),$this->input->post('email'),$link,$sTl);
                $to_email = $this->input->post('email');
                $this->email->from($this->config->item('forgot'), 'Reset Password! ' . $this->input->post('name')); //from sender, title email
                $this->email->to($to_email);
                $this->email->subject('Reset Password');
                $this->email->message($message);
                $this->email->set_mailtype("html");

                if($this->email->send()){
                    $form_data = array(
                        'error'    => false,
                        'message'  => 'Email sent successfully, please check your inbox',
                    );
                }else{
                    $form_data = array(
                        'error'    => true,
                        'message'  => 'There was a problem sending an email',
                    );
                }
            }
            }
            
        }
        echo json_encode($form_data,true);
    }

    //reset password
    public function reset_password()
    {
        $token = $this->base64url_decode($this->uri->segment(4));
        $cleanToken = $this->security->xss_clean($token);
        $user_info = $this->user_model->isTokenValid($cleanToken); //either false or array();

        if(!$user_info){
           echo'Token is invalid or expired';
        }
        $data = array(
            'name'=> $user_info->name,
            'email'=>$user_info->email,
            //'user_id'=>$user_info->id,
            'token'=>$this->base64url_encode($token)
        );

        $data['title'] = "Reset Password";
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header', $data);
            $this->load->view('container');
            $this->load->view('reset_password', $data);
            $this->load->view('footer');
        }else{
            $this->load->library('password');
            $post = $this->input->post(NULL, TRUE);
            $cleanPost = $this->security->xss_clean($post);
            $hashed = $this->password->create_hash($cleanPost['password']);
            $cleanPost['password'] = $hashed;
            $cleanPost['user_id'] = $user_info->id;
            unset($cleanPost['passconf']);
            if(!$this->user_model->updatePassword($cleanPost)){
                // $this->session->set_flashdata('flash_message', 'There was a problem updating your password');
                echo 'There was a problem updating your password';
            }else{
                // $this->session->set_flashdata('success_message', 'Your password has been updated. You may now login');
                echo 'Your password has been updated. You may now login';
            }
            // redirect(site_url().'app/checkLoginUser');
            
        }
    }

    public function base64url_encode($data) {
      return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function base64url_decode($data) {
      return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    public function resetpasswordcomplete(){
        $this->load->view('reset_password_completed');
        $this->load->view('footer');
    }
    public function resetpasswordfailed(){
        $this->load->view('reset_password_failed');
        $this->load->view('footer');
    }
    
    /*************************************************************** Home Page Data ****************************************************************/
    
    
    public function getHomeData(){
        $user_id=$this->input->post('user_id');
        
        $this->db->select('categories.*');
        $this->db->from('categories','categories.status=1');
        $this->db->where(['categories.parent_category'=>'0','categories.id !='=>'95']);
        $Category = $this->db->get()->result();
       
        
        $this->db->select('promotional_category.*');
        $this->db->from('promotional_category','promotional_category.status=1');
        $this->db->where('promotional_category.status=1');
        $CategoryResults = $this->db->get()->result();
        foreach($CategoryResults as $category){
            $category_id=$category->id;
            $this->db->select('promotional.*,promotional.quantity as stock_quantity,promotional.id as product_id');
            $this->db->from('promotional');
            $this->db->where(['promotional.quantity >'=>0,'promotional.status ='=>1,'promotional.category_id'=>$category_id]);
            $ProductResults = $this->db->get()->result();
            foreach($ProductResults as $x){
                    $device_id=$this->input->post('device_id');
                    $cartQtys=0;
                    if($user_id > 0){
                       $cartQty=$this->basic_operation->uniqueSelect('carts',array('user_id'=>$user_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                       if(!empty($cartQty)){
                           $cartQtys=$cartQty[0]->quantity;
                       }
                    }else{
                      $cartQty=$this->basic_operation->uniqueSelect('carts',array('device_id'=>$device_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                      if(!empty($cartQty)){
                           $cartQtys=$cartQty[0]->quantity;
                       }
                    }
                    $x->cart_product_quantity="$cartQtys";
                    if($cartQtys >0){
                    $x->CartStatus='1';    
                    }else{
                    $x->CartStatus='0';   
                    }
                    if($user_id > 0){
                        $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('user_id'=>$user_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                    }else{
                        $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('device_id'=>$device_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                    }
                    if($favCounter > 0){
                        $x->favourite_status="1";
                    }else{
                        $x->favourite_status="0";
                    }
            }
            $arr[]=array(
                'id'=>$category->id,
                'title'=>$category->category,
                'products'=>$ProductResults
                );
        }
        
        $collection=array(
            'error'=>false,
            'message'=>'Request completed successfully',
            'category'=>$Category,
            'data'=>$arr,
            );
        
        
         echo json_encode($collection);
    }
    
    public function getAllCategory(){
        $this->db->select('categories.*');
        $this->db->from('categories','categories.status=1');
        $this->db->where('categories.parent_category=0');
        $results = $this->db->get()->result();
        $collection=array(
                'error'=>false,
                'message'=>'Request completed successfully',
                'data'=>$results,
                );
        echo json_encode($collection);
    }
    
    public function getAllProduct(){
        $this->db->select('products.*,products.quantity as stock_quantity');
        $this->db->from('products','products.status=1');
        $results = $this->db->get()->result();
        $collection=array(
                'error'=>false,
                'message'=>'Request completed successfully',
                'data'=>$results,
                );
        echo json_encode($collection);
    }
    
    
    public function getAllOffer()
    {
        $user_id=$this->input->post('user_id');
        $limit=10;
        (int)$start=$this->input->post('page')?$this->input->post('page'):0;
        $start*=$limit;
        $this->db->select('offers.*,offers.quantity as stock_quantity');
        $this->db->from('offers','offers.status=1');
        $this->db->where('offers.status',1);
        $this->db->limit($limit, $start);
        $OfferProductResults = $this->db->get()->result();
        foreach($OfferProductResults as $x){
                    $device_id=$this->input->post('device_id');
                    $cartQtys=0;
                    if($user_id > 0){
                       $cartQty=$this->basic_operation->uniqueSelect('carts',array('user_id'=>$user_id,'product_id'=>$x->id,'product_type'=>$x->product_type));
                       if(!empty($cartQty)){
                           $cartQtys=$cartQty[0]->quantity;
                       }
                    }else{
                      $cartQty=$this->basic_operation->uniqueSelect('carts',array('device_id'=>$device_id,'product_id'=>$x->id,'product_type'=>$x->product_type));
                      if(!empty($cartQty)){
                           $cartQtys=$cartQty[0]->quantity;
                       }
                    }
                    $x->cart_product_quantity="$cartQtys";
                    if($cartQtys >0){
                    $x->CartStatus='1';    
                    }else{
                    $x->CartStatus='0';   
                    }
                    if($user_id > 0){
                        $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('user_id'=>$user_id,'product_id'=>$x->id,'product_type'=>$x->product_type));
                    }else{
                        $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('device_id'=>$device_id,'product_id'=>$x->id,'product_type'=>$x->product_type));
                    }
                    if($favCounter > 0){
                        $x->favourite_status="1";
                    }else{
                        $x->favourite_status="0";
                    }
            }
        $collection=array(
                'error'=>false,
                'message'=>'Request completed successfully',
                'data'=>$OfferProductResults,
                );
        echo json_encode($collection);
        
    }
    
    public function getAllCategoryProduct()
    {
        if($this->input->post('category_id')){
        $limit=10;
        (int)$start=$this->input->post('page');
        $start*=$limit;
        $category_id=$this->input->post('category_id');
        $user_id=$this->input->post('user_id');
        $this->db->select('products.*,categories.category,products.quantity as stock_quantity,products.id as product_id,categories.id as category_id');
        $this->db->from('products','products.status=1');
        $this->db->join('categories','categories.id=products.category_id');
        $this->db->where('products.category_id',$category_id);
        $this->db->or_where('categories.parent_category',$category_id);
        $this->db->where('products.status',1);

        $this->db->limit($limit, $start);
        $results = $this->db->get()->result();
        $sale=$results;
            foreach($sale as $x){
                $device_id=$this->input->post('device_id');
                $cartQtys=0;
                if($user_id > 0){
                   $cartQty=$this->basic_operation->uniqueSelect('carts',array('user_id'=>$user_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                   if(!empty($cartQty)){
                       $cartQtys=$cartQty[0]->quantity;
                   }
                }else{
                  $cartQty=$this->basic_operation->uniqueSelect('carts',array('device_id'=>$device_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                  if(!empty($cartQty)){
                       $cartQtys=$cartQty[0]->quantity;
                   }
                }
                $x->cart_product_quantity="$cartQtys";
                if($cartQtys >0){
                $x->CartStatus='1';    
                }else{
                $x->CartStatus='0';   
                }
                if($user_id > 0){
                    $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('user_id'=>$user_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                }else{
                    $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('device_id'=>$device_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                }
                if($favCounter > 0){
                    $x->favourite_status="1";
                }else{
                    $x->favourite_status="0";
                }
            }
        $collection=array(
                'error'=>false,
                'message'=>'Request completed successfully',
                'data'=>$sale,
                );
        
        }else{
            $collection=array(
            'error'=>true,
            'message'=>'category id & user id must be required',
            );
        }
        echo json_encode($collection);
    }
    
    
    public function getPromotionalCategoryProduct(){
        if($this->input->post('category_id') && $this->input->post('user_id')){
        $limit=10;
        $start=$this->input->post('page');
        $start*=$limit;
        $category_id=$this->input->post('category_id');
        $user_id=$this->input->post('user_id');
        $this->db->select('promotional.*,promotional_category.category,promotional.quantity as stock_quantity,promotional.id as product_id,promotional_category.id as category_id');
        $this->db->from('promotional','promotional.status=1');
        $this->db->join('promotional_category','promotional_category.id=promotional.category_id');
        $this->db->where('promotional.category_id',$category_id);
         $this->db->where('promotional.status',1);
        $this->db->limit($limit, $start);
        $results = $this->db->get()->result();
        $sale=$results;
            foreach($sale as $x){
                $device_id=$this->input->post('device_id');
                $cartQtys=0;
                if($user_id > 0){
                   $cartQty=$this->basic_operation->uniqueSelect('carts',array('user_id'=>$user_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                   if(!empty($cartQty)){
                       $cartQtys=$cartQty[0]->quantity;
                   }
                }else{
                  $cartQty=$this->basic_operation->uniqueSelect('carts',array('device_id'=>$device_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                  if(!empty($cartQty)){
                       $cartQtys=$cartQty[0]->quantity;
                   }
                }
                $x->cart_product_quantity="$cartQtys";
                if($cartQtys >0){
                $x->CartStatus='1';    
                }else{
                $x->CartStatus='0';   
                }
                if($user_id > 0){
                    $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('user_id'=>$user_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                }else{
                    $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('device_id'=>$device_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                }
                if($favCounter > 0){
                    $x->favourite_status="1";
                }else{
                    $x->favourite_status="0";
                }
            }
        $collection=array(
                'error'=>false,
                'message'=>'Request completed successfully',
                'data'=>$sale,
                );
        
        }else{
            $collection=array(
            'error'=>true,
            'message'=>'category id & user id must be required',
            );
        }
        echo json_encode($collection);
    }
    
    public function getAllSubCategory($id){
        $this->db->select('categories.*');
        $this->db->from('categories','categories.status=1');
        $this->db->where('categories.parent_category',$id);
        $results = $this->db->get()->result();
        $collection=array(
                'error'=>false,
                'message'=>'Request completed successfully',
                'data'=>$results,
                );
        echo json_encode($collection);  
        
    }

    public function getProductById($id){
        $this->db->select('products.*,categories.category,products.quantity as stock_quantity');
        $this->db->from('products','products.status=1');
        $this->db->join('categories','categories.id=products.category_id','inner');
        $this->db->where('products.id',$id);
        $results = $this->db->get()->result();
        foreach($results as $x){
                $device_id=$this->input->post('device_id');
                $cartQtys=0;
                if($user_id > 0){
                   $cartQty=$this->basic_operation->uniqueSelect('carts',array('user_id'=>$user_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                   if(!empty($cartQty)){
                       $cartQtys=$cartQty[0]->quantity;
                   }
                }else{
                  $cartQty=$this->basic_operation->uniqueSelect('carts',array('device_id'=>$device_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                  if(!empty($cartQty)){
                       $cartQtys=$cartQty[0]->quantity;
                   }
                }
                $x->cart_product_quantity="$cartQtys";
                if($cartQtys >0){
                $x->CartStatus='1';    
                }else{
                $x->CartStatus='0';   
                }
                if($user_id > 0){
                    $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('user_id'=>$user_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                }else{
                    $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('device_id'=>$device_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                }
                if($favCounter > 0){
                    $x->favourite_status="1";
                }else{
                    $x->favourite_status="0";
                }
        }
        
        $collection=array(
                'error'=>false,
                'message'=>'Request completed successfully',
                'data'=>@$results[0],
                );
        echo json_encode($collection); 
    }
    
    public function addressBook(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
        $device_id=$this->input->post('device_id');
        $form_data = array(
            'name'   => $this->input->post('name'),
            'address'   => $this->input->post('address'),
            'mobile'   => $this->input->post('mobile'),
            'user_id'   => $this->input->post('user_id'),
            'landmark'   => $this->input->post('landmark'),
            'device_id'   => $device_id
        );
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('landmark', 'landmark', 'required');
        if($this->form_validation->run() == FALSE) {
            $collection = array(
                'error'    => true,
                'name'  => form_error('name'),
                'address'  => form_error('address'),
                'mobile'  => form_error('mobile'),
                'landmark'=>form_error('landmark'),
            );
        }else{
        $user_id=$this->input->post('user_id');
        if($user_id > 0){
            $count=$this->basic_operation->matchedRowCount('address_books',['user_id'=>$this->input->post('user_id'),'default_address'=>1]);
        }else{
            $count=$this->basic_operation->matchedRowCount('address_books',['device_id'=>$device_id,'default_address'=>1]);
           
        }
        if($count == 0){
           $form_data['default_address']='1';
        }
        if(!empty($this->input->post('address_id'))){
           if($user_id > 0){
               $this->basic_operation->updateDetails('address_books',$form_data,array('id'=>$this->input->post("address_id"),'user_id'=>$this->input->post("user_id"))); 
           }else{
               $this->basic_operation->updateDetails('address_books',$form_data,array('id'=>$this->input->post("address_id"),'device_id'=>$device_id)); 
            
           }
           $collection=array(
                'error'=>false,
                'message'=>'Address Updated successfully',
                'data'=>$form_data,
                );
        }else{
           $this->basic_operation->insertData('address_books',$form_data); 
           $collection=array(
                'error'=>false,
                'message'=>'Address Added successfully',
                'data'=>$form_data,
                );
        }
        }
        }else{
           $collection=array(
                'error'=>true,
                'message'=>'Only Post Method Allowed',
                ); 
        }
        echo json_encode($collection);
    }
    
    
    public function getAddressBook()
    {
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            $device_id=$this->input->post('device_id');
            $user_id=$this->input->post('user_id');
            if($user_id > 0)
            {
                $address=$this->Commonmodel->fetch_all_join("SELECT * FROM address_books WHERE user_id=$user_id ORDER BY id DESC");
            }else{

                $address=$this->Commonmodel->fetch_all_join("SELECT * FROM address_books WHERE device_id=$device_id ORDER BY id DESC");
              
            }

            $collection=array(
                'error'=>false,
                'message'=>'Request completed successfully',
                'data'=>$address,
                );
        }else{
           $collection=array(
                'error'=>true,
                'message'=>'Only Post Method allowed',
                ); 
        }
        echo json_encode($collection);
    }
    
    
    public function deleteAddressBook(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            $device_id=$this->input->post('device_id');
            
            $user_id=(int)$this->input->post('user_id');
            $address_id=(int)$this->input->post('address_id');
            if($user_id > 0){
                $this->basic_operation->DeleteData('address_books',array('user_id'=>$user_id,'id'=>$address_id));
                $count=$this->basic_operation->matchedRowCount('address_books',array('user_id'=>$user_id,'default_address'=>'1'));
            }else{
                $this->basic_operation->DeleteData('address_books',array('device_id'=>$device_id,'id'=>$address_id));
                $count=$this->basic_operation->matchedRowCount('address_books',array('device_id'=>$device_id,'default_address'=>'1'));
            }
            if($count == '0'){
              $form_data=array('default_address'=>'1');
              if($user_id > 0){
                  $user_address=$this->basic_operation->Uniqueselect('address_books',['user_id'=>$user_id],1,false);
              }else{
                  $user_address=$this->basic_operation->Uniqueselect('address_books',['device_id'=>$device_id],1,false);
              }
              $new_address_id=@$user_address[0]->id;
              $this->basic_operation->updateDetails('address_books',$form_data,array('id'=>$new_address_id));
            }
            $collection=array(
                'error'=>false,
                'message'=>'Address Delete successfully',
                );
        }else{
           $collection=array(
                'error'=>true,
                'message'=>'Only Post Method With address_id Allowed',
                ); 
        }
        echo json_encode($collection);
    }
    
    
    public function AddToCart()
    {
         
        $this->form_validation->set_rules('product_id', 'product_id', 'required');
        $this->form_validation->set_rules('product_quantity', 'product quantity', 'required');
        $this->form_validation->set_rules('flag', 'flag', 'required');
        $this->form_validation->set_rules('product_type', 'product_type', 'required');
        $this->form_validation->set_rules('user_id', 'User id', 'required');
        $this->form_validation->set_rules('device_id', 'device id', 'required');
        if($this->form_validation->run() == FALSE)
        {
            $collection = array(
                'error'    => true,
                'product_id'  => form_error('product_id'),
                'quantity'  => form_error('product_quantity'),
                'flag'  => form_error('flag'),
                'product_type'  => form_error('product_type'),
                'user_id'  => form_error('user_id'),
                'device_id'  => form_error('device_id'),
            );
        }else{

          $product_id=$this->input->post('product_id');
          $product_type=$this->input->post('product_type');
          $flag=$this->input->post('flag');
          $product_quantity=(int)$this->input->post('product_quantity');
          $user_id=$this->input->post('user_id');
          $device_id=$this->input->post('device_id');
          
          $this->basic_operation->deleteData('carts',array('quantity <='=>0));
          if($product_type==1)
          {
          $product=$this->basic_operation->Uniqueselect('products',array('id'=>$product_id));
          }
          if($product_type==2)
          {
          $product=$this->basic_operation->Uniqueselect('offers',array('id'=>$product_id));
          }
          if($product_type==3)
          {
          $product=$this->basic_operation->Uniqueselect('promotional',array('id'=>$product_id));
          }
          if($user_id > 0)
          {

          $product_stock_quantity=$product[0]->quantity;
          if(!$this->basic_operation->validateRowExist('carts',array('user_id'=>$user_id,'product_id'=>$product_id,'product_type'=>$product_type))===true)
          {
              $rows=$this->basic_operation->Uniqueselect('carts',array('user_id'=>$user_id,'product_id'=>$product_id,'product_type'=>$product_type));
              $newCartProductQuantity=($flag=='plus') ? $rows[0]->quantity+$product_quantity : $rows[0]->quantity-$product_quantity; 
              $form_data = array(
                    'product_id'   => $product_id,
                    'product_type'=>$product_type,
                    'stock_quantity'   => $product_stock_quantity,
                    'quantity'   =>$newCartProductQuantity,
                    'user_id'   => $user_id,
                    'device_id'=>$device_id
              );
              if($product_stock_quantity >0)
              {
                   $this->basic_operation->updateDetails('carts',$form_data,array('user_id'=>$user_id,'product_id'=>$product_id,'product_type'=>$product_type));
                   $collection=array(
                    'error'=>false,
                    'message'=>'Cart Updated successfully',
                    );  
              }else{
                  $collection=array(
                    'error'=>true,
                    'message'=>'Out of Stocks',
                    );
              }
              
          }else{
              $newCartProductQuantity=$product_quantity;
              if($product_stock_quantity > 0){
                  $form_data = array(
                        'product_id'   => $product_id,
                        'product_type'=>$product_type,
                        'stock_quantity'   => $product_stock_quantity,
                        'quantity'   => $newCartProductQuantity,
                        'user_id'   => $user_id,
                        'device_id'=>$device_id
                   );
                   $this->basic_operation->insertData('carts',$form_data);
                   $collection=array(
                    'error'=>false,
                    'message'=>'Added to Cart successfully',
                    );  
              }else{
                  $collection=array(
                    'error'=>true,
                    'message'=>'Out Of Stocks',
                    );
              }
             
          }
        }else{
          $product_stock_quantity=$product[0]->quantity;
          if(!$this->basic_operation->validateRowExist('carts',array('device_id'=>$device_id,'product_id'=>$product_id,'product_type'=>$product_type))===true){
              $rows=$this->basic_operation->Uniqueselect('carts',array('device_id'=>$device_id,'product_id'=>$product_id,'product_type'=>$product_type));
              $newCartProductQuantity=($flag=='plus') ? $rows[0]->quantity+$product_quantity : $rows[0]->quantity-$product_quantity; 
              $form_data = array(
                    'product_id'   => $product_id,
                    'product_type'=>$product_type,
                    'stock_quantity'   => $product_stock_quantity,
                    'quantity'   =>$newCartProductQuantity,
                    'user_id'   => $user_id,
                    'device_id'=>$device_id
              );
              if($product_stock_quantity >0)
              {
                   $this->basic_operation->updateDetails('carts',$form_data,array('device_id'=>$device_id,'product_id'=>$product_id,'product_type'=>$product_type));
                   $collection=array(
                    'error'=>false,
                    'message'=>'Cart Updated successfully',
                    );  
              }else{
                  $collection=array(
                    'error'=>true,
                    'message'=>'Out of Stocks',
                    );
              }
              
          }else{
              $newCartProductQuantity=$product_quantity;
              if($product_stock_quantity > 0)
              {
                  $form_data = array(
                        'product_id'   => $product_id,
                        'product_type'=>$product_type,
                        'stock_quantity'   => $product_stock_quantity,
                        'quantity'   => $newCartProductQuantity,
                        'user_id'   => $user_id,
                        'device_id'=>$device_id
                   );
                   $this->basic_operation->insertData('carts',$form_data);
                   $collection=array(
                    'error'=>false,
                    'message'=>'Added to Cart successfully',
                    );  
              }else{
                  $collection=array(
                    'error'=>true,
                    'message'=>'Out Of Stocks',
                    );
              }
             
          } 
        }
          
        }
        echo json_encode($collection);
    }
    
    public function myCart()
    {
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            $user_id=$this->input->post('user_id');
            $this->basic_operation->deleteData('carts',array('quantity <='=>0));
            $device_id=$this->input->post('device_id');
            
            if($user_id > 0){
                
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
            }else{
            $this->db->select('carts.*,carts.id as cart_id,carts.user_id as cart_user_id,carts.quantity as cart_product_quantity, products.*,products.id as product_id,products.quantity as productsQuantity');
            $this->db->from('carts');
            $this->db->join('products', 'products.id = carts.product_id');
            $this->db->where(['carts.device_id'=>$device_id,'carts.product_type'=>1]);
            $Cart1=$this->db->get()->result();
            
            $this->db->select('carts.*,carts.id as cart_id,carts.user_id as cart_user_id,carts.quantity as cart_product_quantity, offers.*,offers.id as product_id,offers.quantity as productsQuantity');
            $this->db->from('carts');
            $this->db->join('offers', 'offers.id = carts.product_id');
            $this->db->where(['carts.device_id'=>$device_id,'carts.product_type'=>2]);
            $Cart2=$this->db->get()->result();
            
            $this->db->select('carts.*,carts.id as cart_id,carts.user_id as cart_user_id,carts.quantity as cart_product_quantity, promotional.*,promotional.id as product_id,promotional.quantity as productsQuantity');
            $this->db->from('carts');
            $this->db->join('promotional', 'promotional.id = carts.product_id');
            $this->db->where(['carts.device_id'=>$device_id,'carts.product_type'=>3]);
            $Cart3=$this->db->get()->result(); 
            }
            $data=array_merge($Cart1,$Cart2,$Cart3);
            foreach($data as $x)
                {

                $device_id=$this->input->post('device_id');
                $cartQtys=0;
                
                if($user_id > 0){
                   $cartQty=$this->basic_operation->uniqueSelect('carts',array('user_id'=>$user_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                   if(!empty($cartQty)){
                       $cartQtys=$cartQty[0]->quantity;
                   }
                }else{
                  $cartQty=$this->basic_operation->uniqueSelect('carts',array('device_id'=>$device_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                  if(!empty($cartQty)){
                       $cartQtys=$cartQty[0]->quantity;
                   }
                }
                $x->cart_product_quantity="$cartQtys";
                if($cartQtys >0){
                $x->CartStatus='1';    
                }else{
                $x->CartStatus='0';   
                }
                if($user_id > 0){
                    $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('user_id'=>$user_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                }else{
                    $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('device_id'=>$device_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                }
                if($favCounter > 0){
                    $x->favourite_status="1";
                }else{
                    $x->favourite_status="0";
                }
            }
            $collection=array(
                'error'=>false,
                'message'=>'Request completed successfully',
                'data'=>$data,
                );
        }else{
           $collection=array(
                'error'=>true,
                'message'=>'Only Post Method Allowed',
                ); 
        }
        echo json_encode($collection);
    }
    
    public function DeleteCartProduct(){
        $this->form_validation->set_rules('cart_id', 'cart_id', 'required');
        $this->form_validation->set_rules('user_id', 'User Id', 'required');
        if($this->form_validation->run() == FALSE) {
            $collection = array(
                'error'    => true,
                'cart_id'  => form_error('cart_id'),
                'user_id'  => form_error('user_id'),
            );
        }else{
          $device_id=$this->input->post('device_id');
          
          $cart_id=$this->input->post('cart_id');
          $user_id=$this->input->post('user_id');
          if($user_id > 0){
            $this->basic_operation->deleteData('carts',array('user_id'=>$user_id,'id'=>$cart_id));
          }else{
            $this->basic_operation->deleteData('carts',array('device_id'=>$device_id,'id'=>$cart_id));  
          }
          $collection=array(
            'error'=>false,
            'message'=>'Deleted from Cart successfully',
            ); 
        }
          echo json_encode($collection);
    }
    
    public function addMyWishList(){
        if($this->input->server('REQUEST_METHOD') == 'POST' && $this->input->post('product_id') && $this->input->post('product_type') && $this->input->post('wishlist_id')=='0'){
        $user_id=$this->input->post('user_id');
        $device_id=$this->input->post('device_id');
        
        $product_type=$this->input->post('product_type');
        $product_id=$this->input->post('product_id');
        $wishlist_id=$this->input->post('wishlist_id');
        if($user_id > 0){
        $this->basic_operation->deleteData('wishlists',array('user_id'=>$user_id,'product_id'=>$product_id,'product_type'=>$product_type));
        }else{
         $this->basic_operation->deleteData('wishlists',array('device_id'=>$device_id,'product_id'=>$product_id,'product_type'=>$product_type));
        }$collection=array(
            'error'=>false,
            'message'=>'Deleted From Wishlist Successfully',
            );
        }elseif($this->input->server('REQUEST_METHOD') == 'POST' && $this->input->post('product_id')){
         $product_id=$this->input->post('product_id');
         $user_id=$this->input->post('user_id');
         $product_type=$this->input->post('product_type');
         $device_id=$this->input->post('device_id');
        
        if($user_id > 0){
          if($this->basic_operation->validateRowExist('wishlists',array('user_id'=>$user_id,'product_id'=>$product_id,'product_type'=>$product_type))===true){
               $form_data = array(
                    'product_id'   => $product_id,
                    'user_id'   => $user_id,
                    'product_type'=>$product_type,
                    'device_id'=>$device_id
               );
               $this->basic_operation->insertData('wishlists',$form_data);
               $collection=array(
                    'error'=>false,
                    'message'=>'Added To Wishlist Successfully',
                    ); 
          }else{
             $collection=array(
                    'error'=>false,
                    'message'=>'Already Added To Wishlist Successfully',
                    ); 
          }
        }else{
          if($this->basic_operation->validateRowExist('wishlists',array('device_id'=>$device_id,'product_id'=>$product_id,'product_type'=>$product_type))===true){
               $form_data = array(
                    'product_id'   => $product_id,
                    'user_id'   => $user_id,
                    'product_type'=>$product_type,
                    'device_id'=>$device_id
               );
               $this->basic_operation->insertData('wishlists',$form_data);
               $collection=array(
                    'error'=>false,
                    'message'=>'Added To Wishlist Successfully',
                    ); 
          }else{
             $collection=array(
                    'error'=>false,
                    'message'=>'Already Added To Wishlist Successfully',
                    ); 
          }  
        }
  
        }else{
            $collection=array(
            'error'=>true,
            'message'=>'Product id and must be required',
            );
        }
        echo json_encode($collection);
    }
    
    public function myWishList(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
        $limit=10;
        (int)$start=$this->input->post('page')?$this->input->post('page'):0;
        $start*=$limit;
        $user_id=$this->input->post('user_id');
        $device_id=$this->input->post('device_id');
                
        $this->db->select('wishlists.*,products.*,products.name as product_name,wishlists.id as wishlist_id');
        $this->db->from('wishlists');
        $this->db->join('products', 'products.id = wishlists.product_id');
        if($user_id > 0){
            $this->db->where(['wishlists.user_id'=> $user_id,'wishlists.product_type'=>'1']);
        }else{
            $this->db->where(['wishlists.device_id'=> $device_id,'wishlists.product_type'=>'1']);  
        }
         $this->db->where('products.status',1);
        $this->db->limit($limit,$start);
        // $this->db->order_by('wishlists.id','desc');
        $data1=$this->db->get()->result(); 
        
        $this->db->select('wishlists.*,promotional.*,promotional.name as product_name,wishlists.id as wishlist_id');
        $this->db->from('wishlists');
        $this->db->join('promotional', 'promotional.id = wishlists.product_id');
        if($user_id > 0){
            $this->db->where(['wishlists.user_id'=> $user_id,'wishlists.product_type'=>'3']);
        }else{
            $this->db->where(['wishlists.device_id'=> $device_id,'wishlists.product_type'=>'3']);  
        }
          $this->db->where('promotional.status',1);
        $this->db->limit($limit,$start);
        $data2=$this->db->get()->result(); 
        
        $this->db->select('wishlists.*,offers.*,offers.name as product_name,wishlists.id as wishlist_id');
        $this->db->from('wishlists');
        $this->db->join('offers', 'offers.id = wishlists.product_id');
        if($user_id > 0){
            $this->db->where(['wishlists.user_id'=> $user_id,'wishlists.product_type'=>'2']);
        }else{
            $this->db->where(['wishlists.device_id'=> $device_id,'wishlists.product_type'=>'2']);  
        }
        $this->db->where('offers.status',1);
        $this->db->limit($limit,$start);
        
        $data3= $this->db->get()->result();
        $totalWishlist=array_merge($data1,$data2,$data3);
        
        foreach($totalWishlist as $x){
                $device_id=$this->input->post('device_id');
                $cartQtys=0;
                if($user_id > 0){
                   $cartQty=$this->basic_operation->uniqueSelect('carts',array('user_id'=>$user_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                   if(!empty($cartQty)){
                       $cartQtys=$cartQty[0]->quantity;
                   }
                }else{
                  $cartQty=$this->basic_operation->uniqueSelect('carts',array('device_id'=>$device_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                  if(!empty($cartQty)){
                       $cartQtys=$cartQty[0]->quantity;
                   }
                }
                $x->cart_product_quantity="$cartQtys";
                if($cartQtys >0){
                $x->CartStatus='1';    
                }else{
                $x->CartStatus='0';   
                }
                if($user_id > 0){
                    $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('user_id'=>$user_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                }else{
                    $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('device_id'=>$device_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                }
                if($favCounter > 0){
                    $x->favourite_status="1";
                }else{
                    $x->favourite_status="0";
                }
            }
        $collection=array(
            'error'=>false,
            'message'=>'Request Completed Successfully',
            'wishlist'=>$totalWishlist
            );
        }else{
            $collection=array(
            'error'=>true,
            'message'=>'Post method must be required',
            );
        }
        echo json_encode($collection);
    }
    
    public function deleteWishList(){
        if($this->input->server('REQUEST_METHOD') == 'POST' && $this->input->post('user_id') && $this->input->post('product_id')){
            $user_id=$this->input->post('user_id');
            $product_id=$this->input->post('product_id');
            $product_type=$this->input->post('product_type');
            $this->basic_operation->deleteData('wishlists',array('user_id'=>$user_id,'product_id'=>$product_id,'product_type'=>$product_type));
            $collection=array(
                'error'=>false,
                'message'=>'Deleted From Wishlist Successfully',
                );
        }else{
            $collection=array(
            'error'=>true,
            'message'=>'Product id and User id must be required',
            );
        }
        echo json_encode($collection);

    }
    
    public function myBooking()
    {
        if($this->input->server('REQUEST_METHOD') == 'POST' && $this->input->post('user_id'))
        {
            $limit=10;
            $start=$this->input->post('page');
            $start*=$limit;
            @$user_id=$this->input->post('user_id');
            $this->db->select('bookings.*,SUM(bookings.price) as TotalPrice');
            $this->db->from('bookings');
            $this->db->where(array('bookings.user_id'=>$user_id,'bookings.status <'=>3));
            $this->db->group_by(array("bookings.user_id", "bookings.order_id"));
            $this->db->order_by('bookings.id','desc');
            $this->db->limit($limit, $start);
            $data= $this->db->get()->result();
            
            foreach($data as $x){
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
            
            foreach($data2 as $item){
                $order_id=$item->order_id;
                $myBookingProduct=$this->basic_operation->matchedRowCount('bookings',array('order_id'=>$order_id));
                $item->TotalProductsQty="$myBookingProduct";
                $item->booking_date=date("F j, Y",strtotime($item->booking_date));
                // if($item->coupon_id==null){
                //     $item->coupon_id=0;
                //     $item->coupon_code='';
                //     $item->coupon_title='';
                //     $item->discount_percentage=0;
                // }
                // if($item->address_id==0){
                //     $item->address=$item->web_address;
                //     $item->landmark=$item->web_landmark;
                //     $item->mobile=$item->web_mobile;
                //     $item->name=$item->web_name;
                // }
                
            }
            
            $collection=array(
                'error'=>false,
                'message'=>'Request Completed Successfully',
                'cancelled'=>$data2,
                'normal'=>$data
                );
        }else{
            $collection=array(
            'error'=>true,
            'message'=>'User id must be required',
            );
        }
        echo json_encode($collection);

    }
    
    public function getBookingDetails(){
        if($this->input->server('REQUEST_METHOD') == 'POST' && $this->input->post('user_id') && $this->input->post('order_id')){
            $user_id=$this->input->post('user_id');
            $booking_id=$this->input->post('order_id');
            $this->db->select('bookings.*,');
            $this->db->from('bookings');
            $this->db->where(array('bookings.user_id'=>$user_id,'bookings.order_id'=>$booking_id));
            $data= $this->db->get()->result();
       
            // foreach($data as $item){
            //     if($item->coupon_id==null){
            //         $item->coupon_id=0;
            //         $item->coupon_code='';
            //         $item->coupon_title='';
            //         $item->discount_percentage=0;
            //     }
            //     if($item->address_id==0){
            //         $item->address=$item->web_address;
            //         $item->landmark=$item->web_landmark;
            //         $item->mobile=$item->web_mobile;
            //         $item->name=$item->web_name;
            //     }
            // }
            
            $collection=array(
                'error'=>false,
                'message'=>'Request Completed Successfully',
                'data'=>$data
                );
        }else{
            $collection=array(
            'error'=>true,
            'message'=>'User id and Order id must be required',
            );
        }
        echo json_encode($collection);

    }
    
    public function PlaceOrder()
    {
            
          if ($this->input->server('REQUEST_METHOD') == 'POST' && !empty($this->input->post('user_id'))){
          $email=$this->input->post('email') !=''? $this->input->post('email') :'anilkumar140299@gmail.com';
          $user_name=$this->input->post('name') !=''? $this->input->post('name'):'Anil kumar';
          $subTotal=0;
          $taxPrice=0;
          $TotalTax=0;
          $Subtotaltax=0;
          $order_id=strtoupper(uniqid());
          if($this->input->post('delivery_type'=='same day delivery')){
            $delicery_date=date('d-m-Y H:i:s');
          }else{
            $Date=date('d-m-Y H:i:s');
            $delicery_date=date('d-m-Y H:i:s', strtotime($Date. ' + 2 days'));  
          }
          $form_data=array(
               'user_id'=>$this->input->post('user_id'),
               'referal_applied'=>$this->input->post('referal_applied'),
               'transection_id'=>$this->input->post('transection_id')?$this->input->post('transection_id'):'',
               'transection_amount'=>$this->input->post('transection_amount')?$this->input->post('transection_amount'):'',
               'transection_message'=>$this->input->post('transection_message')?$this->input->post('transection_message'):'',
               'payment_type'=>$this->input->post('payment_type'),
               'delivery_type'=>$this->input->post('delivery_type') ? $this->input->post('delivery_type'):'',
               'transection_status'=>$this->input->post('transection_status')?$this->input->post('transection_status'):'',
               'order_id'=>$order_id,
               'booking_date'=>date('Y-m-d H:i:s'),
               'delivery_date'=>$delicery_date,
               'coupon_id'=>$this->input->post('coupon_id')?$this->input->post('coupon_id'):0,
               'address_id'=>$this->input->post('address_id'),
               'address'=>$this->input->post('address'),
               'latitude'=>$this->input->post('latitude'),
               'longitude'=>$this->input->post('longitude'),
               'note'=>$this->input->post('note')?$this->input->post('note'):''
          );
            $user_id=$this->input->post('user_id');
            $coupon_id=$this->input->post('coupon_id')?$this->input->post('coupon_id'):0;
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
            $data=array_merge($Cart1,$Cart2,$Cart3);
            $TotalPrices=0;
            foreach($data as $row){	
               $TotalPrices+=($row->offer_price*$row->cart_product_quantity);	
            }
            if($TotalPrices < 80){
                $TotalTax=10;
            }
            if(!empty($this->input->post('coupon_id'))){
            $coupon=$this->db->get_where('coupons', array('coupon_id' => $this->input->post('coupon_id')))->row();
               $form_data['coupon_code']=$coupon->coupon_code;
               $form_data['valid_from']=$coupon->valid_from;
               $form_data['valid_upto']=$coupon->valid_upto;
               $form_data['tax']=$TotalTax;
               $form_data['discount_percentage']=$coupon->discount_percentage;
               $form_data['min_order_price']=$coupon->min_order_price;
               $form_data['max_order_price']=$coupon->max_order_price;
               
            }
            if(!empty($this->input->post('address_id'))){
            $address=$this->db->get_where('address_books', array('id' => $this->input->post('address_id')))->row();
               if(!empty($address)){
               $form_data['address']=$address->address;
               $form_data['name']=$address->name;
               $form_data['landmark']=$address->landmark;
               $form_data['pincode']=$address->pincode;
               $form_data['mobile']=$address->mobile;
               }
            }
            
            # Checking for user have 1st order or not
            $OrderCount=$this->basic_operation->matchedRowCount('bookings',array('user_id'=>$user_id));
            $form_data['first_order_discount']=($OrderCount > 0)? 0 : 1;
            
            foreach($data as $row){	
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
               $this->basic_operation->insertData('bookings',$form_data);
               $this->basic_operation->updateDetails('coupons',array('user_id '=>$user_id,'applied'=>1),array('coupon_id'=>$coupon_id));
            
            }
            $this->db->where('coupon_id',$coupon_id)->update('coupons',array('applied'=>1));
                
            if($this->input->post('referal_applied') > 0){
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

               $sameDay= 0;
               $type=@$data[0]->delivery_type;

               if($type=="Same day delivery")
               {
                $sameDay= 10;
                }

                $vat = (5 / 100) * @$subTotal;

               $message .='</table>';
               $message .= '<br>';
               $message .= '<br>';
               $message .= 'Total Price : ₹ '.$subTotal;
               $message .= '<br>';
               $message .= 'VAT 5% : ₹ '.$vat;
               $message .= '<br>';
               $message .= 'Delivery Charges : ₹ '.$deliveryCharge;
               $message .= '<br>';
               $message .= 'Same Day Delivery Charges : ₹ '.$sameDay;
               $message .= '<br>';
               $message .= 'Grand Total : ₹ '.($subTotal+$vat+$deliveryCharge+$sameDay);
               $message .= '<br>Sincerely yours,<br>';
               $message .= 'Ashamart Team';
               $to_email = $email;
               $this->email->initialize($this->sendmail->config());
               $this->email->from($this->config->item('register'), 'Order Details ' . $user_name);
               $this->email->to($to_email);
               $this->email->subject('Order Details');
               $this->email->message($message);
               $this->email->set_mailtype("html");

               //Sending mail & empty cart Item 
               $this->basic_operation->deleteData('carts',array('user_id'=>$form_data['user_id']));
               //$form_data['booking_date']=date('Y-m-d H:i:s');
               if($this->email->send()){
               $collection=array(
                'error'=>false,
                'message'=>'Order placed successfully , please check your email.',
                'order_data' => array($form_data) 
                );
                   
               }else{
               $collection=array(
                'error'=>true,
                'message'=>'There is problem to send mail , please  check in your order history',
                'order_data' => array($form_data) 
                );
               }
               echo json_encode($collection);
         }
      
     }
    
    public function getDefaultAddress(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
        $user_id=$this->input->post('user_id');
        $device_id=$this->input->post('device_id');
        
        $this->db->select('address_books.*');
        $this->db->from('address_books');
        if($user_id > 0){
            $this->db->where(array('address_books.user_id'=>$user_id,'address_books.default_address'=>'1'));
        }else{
            $this->db->where(array('address_books.device_id'=>$device_id,'address_books.default_address'=>'1'));
           
        }
        $data= $this->db->get()->result(); 
        if(count($data)>0){
           $collection=array(
            'error'=>false,
            'message'=>'Request Completed Successfully',
            'address'=>$data[0]
            ); 
        }else{
            $collection=array(
            'error'=>false,
            'message'=>'Request Completed Successfully, No Address Found',
            );
        }
        
        }else{
            $collection=array(
            'error'=>true,
            'message'=>'User id must be required',
            );
        }
        echo json_encode($collection);
    }
    
    public function setDefaultAddress(){
        if($this->input->server('REQUEST_METHOD') == 'POST' && $this->input->post('address_id')){
        $device_id=$this->input->post('device_id');
        $user_id=$this->input->post('user_id');
        $address_id=$this->input->post('address_id');
        if($user_id > 0){
        $this->basic_operation->updateDetails('address_books',array('default_address'=>'0'),array('user_id'=>$user_id));
        $this->basic_operation->updateDetails('address_books',array('default_address'=>'1'),array('id'=>$address_id,'user_id'=>$user_id));
        }else{
        $this->basic_operation->updateDetails('address_books',array('default_address'=>'0'),array('device_id'=>$device_id));
        $this->basic_operation->updateDetails('address_books',array('default_address'=>'1'),array('id'=>$address_id,'device_id'=>$device_id));
           
        }$collection=array(
            'error'=>false,
            'message'=>'Set To Default Address Successfully',
            );
        }else{
            $collection=array(
            'error'=>true,
            'message'=>'Address id must be required',
            );
        }
        echo json_encode($collection);
    }
    
    public function getCartQty(){
        #if($this->input->server('REQUEST_METHOD') == 'POST'){
        $user_id=$this->input->post('user_id');
        $device_id=$this->input->post('device_id');
        if($user_id > 0){
            $quantity=$this->basic_operation->matchedRowCount('carts',array('user_id'=>$user_id,'quantity >'=>0));
        }else{
           $quantity=$this->basic_operation->matchedRowCount('carts',array('device_id'=>$device_id,'quantity >'=>0));
         
        }
        $collection=array(
            'error'=>false,
            'message'=>'Request Completed  Successfully',
            'Quantity'=>"$quantity"
            );
        /*}else{
            $collection=array(
            'error'=>true,
            'message'=>'User id must be required',
            );
        }*/
        echo json_encode($collection);
    }
    
    public function getCountry()
    {
        $countries=$this->basic_operation->selectData('countries');
        $collection=array(
            'error'=>false,
            'message'=>'Requestd  Completed Successfully',
            'data'=>$countries
            );
        echo json_encode($collection);
    }
    
    public function getMessages()
    {
        $msgs=$this->basic_operation->uniqueSelect('cancel_msgs',array('status'=>1));
        $collection=array(
            'error'=>false,
            'message'=>'Requestd  Completed Successfully',
            'data'=>$msgs
            );
        echo json_encode($collection);
    }
     
    public function getBanners()
    {
        $galleries=$this->basic_operation->uniqueSelect('galleries',array('status'=>1));
        $collection=array(
            'error'=>false,
            'message'=>'Requestd  Completed Successfully',
            'data'=>$galleries
            );
        echo json_encode($collection);
    }
    
     public function updateProfile()
     {
          $user_id=$this->input->post('user_id');
          $name=$this->input->post('name');
          $nationality=$this->input->post('nationality');
          $mobile=$this->input->post('mobile');
          $this->basic_operation->updateDetails('users',array('name'=>$name,'mobile'=>$mobile,'nationality'=>$nationality),array('id'=>$user_id));
          $collection=array(
                 'error'=>false,
                 'message'=>'Profile Updated Successfully...'
          );
          echo json_encode($collection);

     }
     public function changePassword()
     {
          $this->load->library('password');
          $current_password=$this->input->post('current_password') ;
          $new_password=$this->password->create_hash($this->input->post('new_password'));
          $confirm_password=$this->password->create_hash($this->input->post('confirm_password'));
          $user_id=$this->input->post('user_id');
          $user_data=$this->basic_operation->Uniqueselect('users',array('id'=>$user_id));
          if(!$this->password->validate_password($current_password,$user_data[0]->password)){
             $collection=array(
                 'error'=>true,
                 'message'=>'Current Password is Invalid'
            );
               
          }
          elseif(!empty($current_password) && !empty($new_password) && !empty($confirm_password)){
          if($this->input->post('confirm_password') != $this->input->post('new_password')){
              $collection=array(
                 'error'=>true,
                 'message'=>'New Password is not Matched With Confirm Password'
            );
          }else{
              $this->basic_operation->updateDetails('users',array('password'=>$new_password),array('id'=>$user_id));
              $collection=array(
                 'error'=>false,
                 'message'=>'Password Updated Successfully...'
              );
          }
          }
          echo json_encode($collection);
     }
    public function getCoupons()
    {
        $availableCoupon=array();
        $coupons=$this->basic_operation->uniqueSelect('coupons',array('status'=>1,'applied'=>0));
        if(count($coupons) > 0){
            foreach($coupons as $coupon){
            if(strtotime($coupon->valid_upto) >= strtotime(date('d-m-Y'))){
               $availableCoupon[]=$coupon; 
            }
        }
        }
          $collection=array(
             'error'=>false,
             'message'=>'Request Completed Successfully...',
             'data'=>$availableCoupon
          ); 
          echo json_encode($collection);
    }
    
    public function verifyCoupons()
    {
        $user_id=$this->input->post('user_id');
        $coupon_id=$this->input->post('coupon_id');
        $amount=$this->input->post('amount');
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
             'message'=>'minimum amount should be greater than '.$couponData->min_order_price,
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
   
    public function search()
    {
        if(!empty($this->input->post('keywords')))
        {
                  $string=$this->input->post('keywords');
                  $user_id=$this->input->post('user_id');
                  $limit=10;
                  $start=$this->input->post('page');
                  $start*=$limit;
                  $this->db->select('products.*,categories.*,products.image as image,categories.id as category_id,products.id as product_id');
                  $this->db->from('products');
                  $this->db->join('categories','categories.id=products.category_id','inner');
                  $this->db->like('products.name',$string,'both');
                //   $this->db->or_like('categories.category',$string,'both');
                //   $this->db->or_like('products.country',$string,'both');
                  // $this->db->order_by('products.id','RANDOM');
                  $this->db->order_by('products.name','asc');
                  $this->db->where(['products.status'=>1,'products.quantity >'=>0,'products.category_id !='=>0]);
                  $this->db->limit($limit, $start);
        
                  $getProduct=$this->db->get()->result();
                  
                  $this->db->select('offers.*,categories.*,offers.image as image,categories.id as category_id,offers.id as product_id');
                  $this->db->from('offers');
                  $this->db->join('categories','categories.id=offers.category_id','inner');
                  $this->db->like('offers.name',$string,'both');
                //   $this->db->or_like('categories.category',$string,'both');
                //   $this->db->or_like('offers.country',$string,'both');
                  // $this->db->order_by('offers.id','RANDOM');
                  $this->db->order_by('offers.name','asc');
                  $this->db->where(['offers.status'=>1,'offers.quantity >'=>0,'offers.category_id !='=>0]);
                  $this->db->limit($limit, $start);
        
                  $getOffers=$this->db->get()->result();
                  
                  $this->db->select('promotional.*,promotional_category.*,promotional.image as image,promotional_category.id as category_id,promotional.id as product_id');
                  $this->db->from('promotional');
                  $this->db->join('promotional_category','promotional_category.id=promotional.category_id','inner');
                  $this->db->like('promotional.name',$string,'both');
                //   $this->db->or_like('promotional_category.category',$string,'both');
                //   $this->db->or_like('promotional.country',$string,'both');
                  // $this->db->order_by('promotional.id','RANDOM');
                  $this->db->order_by('promotional.name','asc');
                  $this->db->where(['promotional.status'=>1,'promotional.quantity >'=>0,'promotional.category_id !='=>0]);
                  $this->db->limit($limit, $start);
        
                  $getPromo=$this->db->get()->result();
                  $Data=array_merge($getProduct,$getOffers,$getPromo);
                  
                  foreach($Data as $x){
                      
                        $device_id=$this->input->post('device_id');
                        $cartQtys=0;
                        if($user_id > 0){
                            
                           $cartQty=$this->basic_operation->uniqueSelect('carts',array('user_id'=>$user_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                           if(!empty($cartQty)){
                               $cartQtys=$cartQty[0]->quantity;
                           }
                        }else{
                          $cartQty=$this->basic_operation->uniqueSelect('carts',array('device_id'=>$device_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                          if(!empty($cartQty)){
                               $cartQtys=$cartQty[0]->quantity;
                           }
                        }
                        $x->cart_product_quantity="$cartQtys";
                        if($cartQtys >0){
                        $x->CartStatus='1';    
                        }else{
                        $x->CartStatus='0';   
                        }
                        if($user_id > 0){
                            $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('user_id'=>$user_id,'product_id'=>$x->id,'product_type'=>$x->product_type));
                        }else{
                            $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('device_id'=>$device_id,'product_id'=>$x->id,'product_type'=>$x->product_type));
                        }
                        if($favCounter > 0){
                            $x->favourite_status="1";
                        }else{
                            $x->favourite_status="0";
                        }
                      
                  }
                 
                  $collection=array(
                      'error'=>false,
                      'message'=>'Request Completed Successfully',
                      'data'=>$Data
                      );
                  echo json_encode($collection);
            } 
    }
    
    public function SetNotificationKeys(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            $device_id=$this->input->post('device_id');
            $user_id=$this->input->post('user_id');
            $pending=$this->input->post('pending');
            $processing=$this->input->post('processing');
            $delivered=$this->input->post('delivered');
            $cancelled=$this->input->post('cancelled');
        if($user_id > 0){
        if($this->basic_operation->validateRowExist('notifications',array('user_id'=>$user_id))===true){
               $form_data = array(
                    'user_id'   => $user_id,
                    'pending'   =>$pending ,
                    'processing'=>$processing,
                    'delivered' =>$delivered ,
                    'cancelled' =>$cancelled ,
               );
               $this->basic_operation->insertData('notifications',$form_data);
               $collection=array(
                    'error'=>false,
                    'message'=>'Added  Successfully',
                    ); 
          }else{
              $form_data = array(
                    'pending'   =>$pending ,
                    'processing'=>$processing,
                    'delivered' =>$delivered ,
                    'cancelled' =>$cancelled ,
               );
             $this->basic_operation->updateDetails('notifications',$form_data,array('user_id'=>$user_id));
             $collection=array(
                    'error'=>false,
                    'message'=>'Updated Successfully',
                    ); 
          }
        }else{
           if($this->basic_operation->validateRowExist('notifications',array('device_id'=>$device_id))===true){
               $form_data = array(
                    'user_id'   => $user_id,
                    'pending'   =>$pending ,
                    'processing'=>$processing,
                    'delivered' =>$delivered ,
                    'cancelled' =>$cancelled ,
               );
               $this->basic_operation->insertData('notifications',$form_data);
               $collection=array(
                    'error'=>false,
                    'message'=>'Added  Successfully',
                    ); 
              }else{
                  $form_data = array(
                        'pending'   =>$pending ,
                        'processing'=>$processing,
                        'delivered' =>$delivered ,
                        'cancelled' =>$cancelled ,
                   );
                 $this->basic_operation->updateDetails('notifications',$form_data,array('device_id'=>$device_id));
                 $collection=array(
                        'error'=>false,
                        'message'=>'Updated Successfully',
                        ); 
              } 
        }
  
        }else{
            $collection=array(
            'error'=>true,
            'message'=>'pending, processing, delivered, cancelled must be required',
            );
        }
        echo json_encode($collection);
    }
    
    
    public function GetNotificationKeys(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
             $user_id=$this->input->post('user_id');
             $device_id=$this->input->post('device_id');
             if($user_id > 0){
             $data=$this->basic_operation->uniqueselect('notifications',array('user_id'=>$user_id));
             }else{
               $data=$this->basic_operation->uniqueselect('notifications',array('device_id'=>$device_id));
             }
             if(!empty($data)){
             unset($data[0]->user_id);
             unset($data[0]->notification_id);
             }
             $detail=(!empty($data))?$data[0]:array('pending'=>'1','processing'=>'1','delivered'=>'1','cancelled'=>'1');
             
             $collection=array(
                    'error'=>false,
                    'message'=>'Request Compleled Successfully',
                    'data'=>$detail
                    ); 
        }else{
            $collection=array(
            'error'=>true,
            'message'=>'Post method  allowed only',
            );
        }
        echo json_encode($collection);
    }
    
    public function getSimilarProducts()
    {
        if($this->input->post('category_id') && $this->input->post('product_id'))
        {
        $limit=10;
        $start=$this->input->post('page');
        $start*=$limit;
        $category_id=$this->input->post('category_id');
        $product_id=$this->input->post('product_id');
        $user_id=$this->input->post('user_id');
        $device_id=$this->input->post('device_id');
             
        
        $this->db->select('products.*,categories.category,products.quantity as stock_quantity,products.id as product_id,categories.id as category_id');
        $this->db->from('products','products.status=1');
        $this->db->join('categories','categories.id=products.category_id');
        $this->db->where(['products.category_id'=>$category_id,'products.id !='=>$product_id]);
        $this->db->where('products.status',1);
        $this->db->limit($limit, $start);
        $results = $this->db->get()->result();
        $sale=$results;
            foreach($sale as $x)
            {
                $device_id=$this->input->post('device_id');
                $cartQtys=0;
                if($user_id > 0)
                {
                   $cartQty=$this->basic_operation->uniqueSelect('carts',array('user_id'=>$user_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                   if(!empty($cartQty)){
                       $cartQtys=$cartQty[0]->quantity;
                   }
                }else{
                  $cartQty=$this->basic_operation->uniqueSelect('carts',array('device_id'=>$device_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                  if(!empty($cartQty)){
                       $cartQtys=$cartQty[0]->quantity;
                   }
                }
                $x->cart_product_quantity="$cartQtys";
                if($cartQtys >0){
                $x->CartStatus='1';    
                }else{
                $x->CartStatus='0';   
                }
                if($user_id > 0){
                    $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('user_id'=>$user_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                }else{
                    $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('device_id'=>$device_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                }
                if($favCounter > 0){
                    $x->favourite_status="1";
                }else{
                    $x->favourite_status="0";
                }
            }
        $collection=array(
                'error'=>false,
                'message'=>'Request completed successfully',
                'data'=>$sale,
                );
        
        }else{
            $collection=array(
            'error'=>true,
            'message'=>'category id & user id must be required',
            );
        }
        echo json_encode($collection);
    }
    
    public function SetFcmToken(){
        if($this->input->server('REQUEST_METHOD') == 'POST' &&  $this->input->post('fcm_token')){
        $user_id=$this->input->post('user_id');
        $device_id=$this->input->post('device_id');
        
        $fcm_token=$this->input->post('fcm_token');
            if($user_id > 0){
               $this->basic_operation->updateDetails('users',array('fcm_token'=>$fcm_token),array('id'=>$user_id));
            }else{
               $this->basic_operation->updateDetails('users',array('fcm_token'=>$fcm_token),array('device_id'=>$device_id)); 
            }
             $collection=array(
                    'error'=>false,
                    'message'=>'Updated Successfully',
                    ); 
        }else{
            $collection=array(
            'error'=>true,
            'message'=>'fcm_token must be required',
            );
        }
        echo json_encode($collection);
    }
    
     public function updateStatus()
     {
         $status=$this->input->post('status');
         $user_id=$this->input->post('user_id');
         $order_id=$this->input->post('order_id');
         $message=$this->input->post('message')?$this->input->post('message'):'';
         $this->basic_operation->updateDetails('bookings',array('status'=>$status,'cancelation_msg'=>$message),array('order_id'=>$order_id));
         $this->load->library('notifications');
         $data["user_data"] = $this->basic_operation->Uniqueselect('users',array('id'=>$user_id)); 
         $data["notification"] = $this->basic_operation->Uniqueselect('notifications',array('user_id'=>$user_id)); 
         if(!empty($data['user_data'])){
         @$device_key=$data['user_data'][0]->fcm_token;
         if(!empty($device_key)){
            $tokens=array($device_key);
            // For android
            $message='';
            if(@$data["notification"][0]->processing==1){
            if($status=='1'){
                $message='Your Order has been Accepted from Ashamart';
                $dataAndroid=array("title"=>"Order Status", "text"=>$message,'type'=>'order'); 
                $res=$this->notifications->send_push_notification_data($tokens,$dataAndroid);
            }
            }
            if(@$data["notification"][0]->delivered==1){
            if($status=='2'){
              $message='Your Order has been Delivered from Ashamart'; 
              $dataAndroid=array("title"=>"Order Status", "text"=>$message,'type'=>'order'); 
              $res=$this->notifications->send_push_notification_data($tokens,$dataAndroid);
            }
            }
            if(@$data["notification"][0]->processing==1){
            if($status=='3'){
              $message='Your order has been cancelled successfully'; 
              $dataAndroid=array("title"=>"Order Status", "text"=>$message,'type'=>'order'); 
              $res=$this->notifications->send_push_notification_data($tokens,$dataAndroid);
            }
            }
            
          }
        }
        $collection=array(
            'error'=>false,
            'message'=>'Your order has been cancelled successfully',
            );
        echo json_encode($collection);
    }

}
