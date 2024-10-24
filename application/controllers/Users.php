<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller 
{

    public $status;
    public $roles;

    function __construct(){
        Parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
        die();
        }
        
        $this->load->model('auth', 'auth', TRUE);
        $this->load->model('User_model', 'user_model', TRUE);
        $this->load->model('Basic_operation', 'basic_operation', TRUE);
        $this->load->library('form_validation');
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
        $this->load->library('userlevel');
        $this->load->library('session');
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
	
	public function checkLoginUser()
    {
	    
	$data = $this->session->userdata;
	    
	    
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
            $this->email->initialize($this->sendmail->config());
            $this->email->from($this->config->item('register'), 'New sign-in! from '.$browser.'');
            $this->email->to($to_email);
            $this->email->subject('New sign-in! from '.$browser.'');
            $this->email->message($message);
            $this->email->set_mailtype("html");
            $this->email->send();
            
            $this->input->set_cookie($setLogin, TRUE);
            $array = array(
                'error'    => false,
                'message' => 'Login Successfully ! ',
            );
        }else{
            $this->input->set_cookie($setLogin, TRUE);
            $array = array(
                'error'    => false,
                'message' => 'Login Successfully ! ',
            );
        }
        /*-------------------------------------- Updating cart ------------------------------------------------------*/
        $this->basic_operation->updateDetails('carts',array('user_id'=>$data['id']),array('ip_address'=>$getip,'user_id'=>0));
        $this->basic_operation->updateDetails('carts',array('ip_address'=>$getip),array('ip_address'=>'','user_id'=>$data['id']));
                    
    
       
        echo json_encode($array);
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
        $pathToStore='./uploads/';
        $this->load->library('curl');
        $this->load->library('password');
        $this->load->library('recaptcha');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('dob', 'DOB', 'required');
        
        $result = $this->user_model->getAllSettings();
        $sTl = $result->site_title;
        $data['recaptcha'] = $result->recaptcha;

        if ($this->form_validation->run() == FALSE) {
            //validation error response
            $array = array(
                'error'    => true,
                'name' => form_error('name'),
                'mobile' => form_error('mobile'),
                'email' => form_error('email'),
                'password' => form_error('password'),
                'dob' => form_error('dob'),
              );
        }else{
        
            if($this->auth->isDuplicate($this->input->post('email'))){
                // email duplicate response
                $array = array(
                    'error'    => true,
                    'email_error' => 'User email already exists'
                   );
            }else{
                if(isset($_FILES['passport']['name'])){
                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = 'jpeg|jpg|png|pdf';
                    $config['encrypt_name'] = TRUE;
                    $config['max_size'] = '1024';
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('passport')) { 
                        $error = array('error' => $this->upload->display_errors()); 
                        $array = array(
                            'error'    => true,
                            'file' =>$error
                           );  
                    }else{
                        $d = $this->upload->data();
                        $form_data = array(
                            'name' => $this->input->post('name'),
                            'email'   => $this->input->post('email'),
                            'password'   => $this->password->create_hash($this->input->post('password')),
                            'mobile'  => $this->input->post('mobile'),
                            'dob' => $this->input->post('dob'),
                            'passport' => $d['file_name'],
                        );
                            
                            //insert to database
                            $id = $this->auth->insertUser($form_data);
                            $token = $this->auth->insertToken($id);
            
                            //generate token
                            $qstring = $this->base64url_encode($token);
                            $url = site_url() . 'app/complete/token/' . $qstring;
                            $link = '<a href="' . $url . '">' . $url . '</a>';
            
                            $this->load->library('email');
                            $this->load->library('sendmail');
                            
                            $message = $this->sendmail->sendRegister($this->input->post('name'),$this->input->post('email'),$link,$sTl);
                            $to_email = 'support@cheersonlinesales.com';
                            $this->email->initialize($this->sendmail->config());
                            $this->email->from($this->config->item('register'), 'Account Activation ' . $this->input->post('name')); //from sender, title email
                            $this->email->to($to_email);
                            $this->email->subject('Account Activation');
                            $this->email->message($message);
                            $this->email->attach($d['full_path']);
                            $this->email->set_mailtype("html");
            
                            //Sending mail
                            if($this->email->send()){
                                // success response
                                $array = array(
                                    'error'    => false,
                                    'message' => 'Registerd Successfully ,Please wait for Admin Verification'
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

    protected function _islocal(){
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
        $this->auth->updateUserInfo($data);
        echo 'Account Activated Now you can Login...';
    }
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
               
                $userInfo = $this->user_model->checkLogin($form_data);
                
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
                    elseif($userInfo->status != "approved")
                    {
                        $array = array(
                            'error'    => true,
                            'message' => 'Please wait To Verify Your Email from Admin Then Login.'
                        );  
                    }
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
                        
                        foreach($userInfo as $key=>$val){
                        $this->session->set_userdata($key, $val);
                        }
                        redirect(site_url().'users/checkLoginUser/');
                         
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
                            'message' => 'Please wait To Verify Your Email from Admin Then, can Login.'
                        );  
                    }
                    elseif($userInfo->banned_users == "ban")
                    {
                        $array = array(
                            'error'    => true,
                            'message' => 'You are temporarily Deactivated By Admin!.'
                        );  
                    }
                    elseif($userInfo && $userInfo->banned_users == "unban") 
                    {
                        
                        foreach($userInfo as $key=>$val){
                        $this->session->set_userdata($key, $val);
                        }
                        redirect(site_url().'users/checkLoginUser/');
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
         $this->db->where('token', $this->input->post('token'));
           if($this->db->update('users', array('fcm_token'=>'','token'=>''))){
            $array = array(
                'error'    => false,
                'message' => 'Logged Out Successfully...! '
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
                    'message'  => 'We can not find your email address',
                );
            }else{
             if($userInfo->status != $this->status[1]){ 
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
                    $this->email->initialize($this->sendmail->config());
                    $this->email->from($this->config->item('forgot'), 'Reset Password! ' . $this->input->post('name')); 
                    $this->email->to($to_email);
                    $this->email->subject('Reset Password');
                    $this->email->message($message);
                    $this->email->set_mailtype("html");
    
                    if($this->email->send()){
                        $form_data = array(
                            'error'    => false,
                            'message'  => 'Email Sent Successfully,Please check your inbox',
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
                $this->email->initialize($this->sendmail->config());
                $this->email->from($this->config->item('forgot'), 'Reset Password! ' . $this->input->post('name')); //from sender, title email
                $this->email->to($to_email);
                $this->email->subject('Reset Password');
                $this->email->message($message);
                $this->email->set_mailtype("html");

                if($this->email->send()){
                    $form_data = array(
                        'error'    => false,
                        'message'  => 'Email Sent Successfully,Please check your inbox',
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
}
