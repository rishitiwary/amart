<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
     	$this->load->helper('form');
     	$this->load->model('Basic_operation', 'basic_operation');
     	$this->load->model('User_model', 'user_model', TRUE);
     	$this->load->model('Auth', 'auth', TRUE);
     	$this->load->library('password');
     	$this->load->model('Commonmodel');
	}

	public function index()
	{
		
		$data['title']="Register";
		$this->form_validation->set_rules('firstName', 'first Name', 'trim|required');
		$this->form_validation->set_rules('lastName', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email ID', 'trim|valid_email|required|is_unique[users.email]');
		$this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('conpassword', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');

		if ($this->form_validation->run() == TRUE) {
			 $referral='REF_'.time();

			$mydata = array(
				'name' => $this->input->post('firstName').' '.$this->input->post('lastName'),
				'email' => $this->input->post('email'),
				'mobile' => $this->input->post('phone'),
				'gender' => $this->input->post('gender'),
				'nationality' => $this->input->post('nationality'),
				'referal_code' =>$referral,
                'referal_id' =>$this->input->post('referal_id')?$this->input->post('referal_id'):'',
				'password' => $this->password->create_hash($this->input->post('password')),
				'role' => 3,
				'status' => 'pending'
			);

			$result = $this->user_model->getAllSettings();
        	$sTl = $result->site_title;

			$msg=$this->basic_operation->insertData("users", $mydata);
			$id = $this->db->insert_id();

			$this->basic_operation->insertData('notifications',array('pending'=>'1','processing'=>'1','delivered'=>'1','cancelled'=>'1','user_id'=>$id));
			if(!empty($this->input->post('referal_id'))){
				$this->basic_operation->updateDetails('users',array('referal_id'=>$this->input->post('referal_id')),array('referal_code'=>$this->input->post('referal_id')));
			}
			$token = $this->auth->insertToken($id);

			$qstring = $this->base64url_encode($token);
			$url = site_url() . 'app/complete/token/' . $qstring;
			$link = '<a href="' . $url . '">' . $url . '</a>';

			$this->load->library('email');
			$this->load->library('sendmail');

			$message = $this->sendmail->sendRegister($this->input->post('firstName'), $this->input->post('email'),$link, $sTl);
			$to_email = $this->input->post('email');
			$this->email->initialize($this->sendmail->config());
			$this->email->from($this->config->item('register'), 'Account Activation ' . $this->input->post('firstName')); //from sender, title email
			$this->email->to($to_email);
			$this->email->subject('Account Activation');
			$this->email->message($message);

			$this->email->set_mailtype("html");
			if($this->email->send())
			{
				$this->session->set_flashdata('success', 'Registered successfully ,Please Verify Your Account');

			}else{
				$this->session->set_flashdata('info', 'There was a problem sending an email.');
			}			
			redirect('signup','refresh');			

		} else {

				$this->session->set_flashdata("error", "Something went wrong");
				$this->load->view('home/header');
				$this->load->view('home/register', $data);
				$this->load->view('home/footer');
		}


	}
	public function base64url_encode($data) {
      return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
	public function reset()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required');

		if ($this->form_validation->run() == TRUE) 
		{
			$email = $this->input->post('email');
			$where = "email = '".$email."'";

			if ($this->count('users', $where) != 1) {
				$msg = "User not registerd";
			} else {
				$user = $this->get_by('users', true, $where);
				if($user->status != $this->status[1]){ 
                $form_data = array(
                    'error'    => true,
                    'message'  => 'Your account is not in approved status',
                );                
            }
			}
			
			$this->session->set_flashdata('error', ''.$msg);

		} else {

			$msg = 'Please Fill the Register Email';
			
			$this->session->set_flashdata('error', ''.$msg);

			redirect('home/forget', 'refresh');
		}

	}

	public function forget()
     {  
        $data['title']="Forget Password"; 
        $this->load->view('home/header', $data);
        $this->load->view("home/forget_password", $data);
        $this->load->view('home/footer'); 
     }

	public function recoverPass()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required');

		if ($this->form_validation->run() == TRUE) 
		{	
			$checkMail=$this->input->post('email');

			$userInfo = $this->Commonmodel->fetch_row('users', "email='$checkMail'");
			if ($userInfo) 
			{
				if($userInfo->status== 'pending'){

				$this->session->set_flashdata("info", "Your account is not in approved status");
				redirect('register/forget','refresh');

				}

				$result = $this->user_model->getAllSettings();
        		$sTl = $result->site_title;

				$token = $this->user_model->insertToken($userInfo->id);
                $qstring = $this->base64url_encode($token);
                $url = site_url() . 'app/reset_password/token/' . $qstring;
                $link = '<a href="' . $url . '">' . $url . '</a>';

                $this->load->library('email');
                $this->load->library('sendmail');
                
                $message = $this->sendmail->sendForgot(@$userInfo->name, @$userInfo->email, $link, $sTl);
                $to_email = $this->input->post('email');
                $this->email->from($this->config->item('forgot'), 'Reset Password! ' . $this->input->post('name')); //from sender, title email
                $this->email->to($to_email);
                $this->email->subject('Reset Password');
                $this->email->message($message);
                $this->email->set_mailtype("html");

                if($this->email->send()){
                	$this->session->set_flashdata('success', 'Email sent successfully, please check your inbox');
                    
                }else{
                	$this->session->set_flashdata('info', 'There was a problem sending an email.');                   
                }
                redirect('register/forget','refresh');
				
			}else{
				$this->session->set_flashdata("warning", "User not registered");
				redirect('register/forget','refresh');
			}

		}else{

			$this->session->set_flashdata("error", "Something went wrong");
			
			$data['title']="Forget Password"; 
			$this->load->view('home/header', $data);
			$this->load->view("home/forget_password", $data);
			$this->load->view('home/footer'); 

		}


	}

}