<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webview extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('form');      
    $this->load->model('Commonmodel');
  }

  
  public function policy()
  {  
    $data['title']="Privacy Policy";   
    $this->load->view("webview/policy", $data); 
  }

  public function terms()
  {
    $data['title']="Term & Condition";  
    $this->load->view("webview/terms", $data);
 
  }

  public function refund()
  {
    $data['title']="Return Policy";
    $this->load->view("webview/refund", $data); 

  }
 
}
