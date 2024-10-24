<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class PromotionalCategory extends CI_Controller { 
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
          
          $data["fetch_data"] = $this->basic_operation->selectData('promotional_category');
          $this->load->view("admin/promotional_category", $data);  
      }  
      public function form_validation()  
      {        
            
            if(!empty($_FILES['image_file']['name']) && !empty($_FILES['image_file']['tmp_name'])){
               $config['upload_path'] = './uploads/categories/';
               $config['allowed_types'] = 'jpeg|jpg|png';
               $config['encrypt_name'] = TRUE;
               $this->load->library('upload', $config);
               if (!$this->upload->do_upload('image_file')) {
                    $error = array('error' => $this->upload->display_errors());
                    $data["fetch_data"] = $this->basic_operation->selectData('galleries');   
                    $data['error']=$error; 
                    $this->load->view("admin/promotional_category", $data);
                    
                    } else {
                    $d = $this->upload->data();
                    $data=array(
                         'category'=>$this->input->post('category'),
                         'status'=>$this->input->post('status'),
                         'image'=>$d['file_name'],
                    ); 
                 }
               }else{
                    $data=array(
                         'category'=>$this->input->post('category'),
                         'status'=>$this->input->post('status'),
                    ); 
               }
                
                
               if($this->input->post("updatecategory"))  
               {  
                    $this->basic_operation->updateDetails('promotional_category',$data, array('id'=>$this->input->post("hidden_id")));  
                    $this->session->set_flashdata('success','Category Updated Successfully.');
                    redirect(base_url() . "PromotionalCategory/index");  
               } 
               if($this->input->post("insertcategory"))  
               {  
                    $this->basic_operation->insertData('promotional_category',$data); 
                    $this->session->set_flashdata('success','Category Added Successfully.');
                    redirect(base_url() . "PromotionalCategory/index");  
               }else{
                    $data["fetch_category"] = $this->db->where(array('status'=>1))->get('promotional_category')->result();
                    $this->load->view("admin/promotional_category_insert",$data); 
               }           
      }  
     
      public function delete(){  
          $id = $this->uri->segment(3);  
          $image = $this->uri->segment(4);  
           $this->basic_operation->deleteData('promotional_category',array('id'=>$id));
           $this->basic_operation->deleteData('promotional',array('category_id'=>$id));
           $img_path=base_url().'uploads/categories/'.$image;
           @unlink($img_path);
           $this->session->set_flashdata('success','Category Deleted Successfully.');
           redirect(base_url() . "PromotionalCategory/index");  
      }  
       
      public function update(){ 
          $category_id = $this->uri->segment(3); 
          $data["user_data"] = $this->basic_operation->UniqueSelect('promotional_category',array('id'=>$category_id));  
          $this->load->view("admin/promotional_category_insert", $data);  
     }
      
 } 