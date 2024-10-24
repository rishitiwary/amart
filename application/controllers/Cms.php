<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->helper('form');      
    $this->load->model('Commonmodel');
    $this->load->model('Basic_operation', 'basic_operation');
  }

  public function about()
  {
    $data['title']="About Us";
    $this->load->view('home/header', $data);
    $this->load->view('home/about',$data);
    $this->load->view('home/footer');
  }

  public function contact()
  {  
    $data['title']="Contact Us";
    $this->load->view('home/header', $data);
    $this->load->view("home/contact", $data);
    $this->load->view('home/footer');  
  }
  public function faq()
  {  
    $data['title']="FAQ";
    $this->load->view('home/header', $data);
    $this->load->view("home/faq", $data);
    $this->load->view('home/footer');  
  }

  public function privacyPolicy()
  {  
    $data['title']="Privacy Policy";
    $this->load->view('home/header', $data);
    $this->load->view("home/privacy_policy"); 
    $this->load->view('home/footer');   
  }

  public function termsConditions()
  {
    $data['title']="Term & Condition";
    $this->load->view('home/header', $data);
    $this->load->view("home/terms_conditions");
    $this->load->view('home/footer');  
  }

  public function refundReturn()
  {
    $data['title']="Return Policy";
    $this->load->view('home/header', $data);
    $this->load->view("home/refund_return"); 
    $this->load->view('home/footer'); 
  }
  public function delivery()
  {
    $data['title']="Delivery Information";
    $this->load->view('home/header', $data);
    $this->load->view("home/deliveryinfo"); 
    $this->load->view('home/footer'); 
  }
}
