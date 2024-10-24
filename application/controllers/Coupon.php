<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Coupon extends CI_Controller 
 { 
      public function __construct(){
          parent::__construct();
          $this->load->model("Basic_operation","basic_operation",true);  
          $this->load->library('form_validation'); 
          $this->load->library("pagination");
          $auth = $this->session->userdata;
          if(empty($auth)){
               redirect(site_url().'main/login/');
          }

          
          if(empty($auth['role'])){
               redirect(site_url().'main/login/');
          } 
      } 
 
      public function index(){  
          $this->db->order_by("coupon_id", "desc");
          $data["fetch_data"] = $this->db->get('coupons')->result();
          $this->load->view("admin/coupon", $data);  
      }  
      public function form_validation()  
      {        
            $data=array(
                 'coupon_title'=>$this->input->post('coupon_title'),
                 'coupon_code'=>$this->input->post('coupon_code'),
                 'status'=>$this->input->post('status'),
                 'min_order_price'=>$this->input->post('min_order_price'),
                 'max_order_price'=>$this->input->post('max_order_price'),
                 'discount_percentage'=>$this->input->post('discount_percentage'),
                 'valid_from'=>date("F j, Y",strtotime($this->input->post('valid_from'))),
                 'valid_upto'=>date("F j, Y",strtotime($this->input->post('valid_upto'))),
            ); 
                
                
               if($this->input->post("updatecategory"))  
               {  
                    $this->basic_operation->updateDetails('coupons',$data, array('coupon_id'=>$this->input->post("hidden_id")));  
                    $this->session->set_flashdata('success','Coupon Updated Successfully.');
                    redirect(base_url() . "coupon/index");  
               } 
               if($this->input->post("insertcategory"))  
               {  
                    $this->basic_operation->insertData('coupons',$data); 
                    $this->session->set_flashdata('success','Coupon Added Successfully.');
                    redirect(base_url() . "coupon/index");  
               }else{
                    $this->load->view("admin/coupon_insert",$data); 
               }           
      }  
     
      public function delete(){  
          $id = $this->uri->segment(3);  
          $image = $this->uri->segment(4);  
           $this->basic_operation->deleteData('coupons',array('coupon_id'=>$id));
           $this->session->set_flashdata('success','Coupon Deleted Successfully.');
           redirect(base_url() . "coupon/index");  
      }  
       
      public function update(){ 
          $category_id = $this->uri->segment(3); 
          $data["user_data"] = $this->basic_operation->UniqueSelect('coupons',array('coupon_id'=>$category_id));  
          $this->load->view("admin/coupon_insert", $data);  
     }
      
 } 