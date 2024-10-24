<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Content extends CI_Controller 
 { 
      public function __construct()
      {
          parent::__construct();
          $this->load->model("Basic_operation","basic_operation",true);  
          $this->load->library('form_validation'); 
          $this->load->library('session');
          $auth = $this->session->userdata;
          if(empty($auth)){
               redirect(site_url().'main/login/');
          }

          
          if(empty($auth['role']) || $auth['role']==3){
               redirect(site_url().'main/login/');
          } 
      } 
 
      public function index()
      {  
          $auth = $this->session->userdata;
          if($auth['role']==1){
             $data["fetch_data"] = $this->basic_operation->selectData('galleries'); 
          }  
          $this->load->view("admin/gallery", $data);  
      }  
      public function form_validation()  
      {        
               $auth = $this->session->userdata;
               
               if(!empty($_FILES['image_file']['name']) && !empty($_FILES['image_file']['tmp_name'])){
               $config['upload_path'] = './uploads/banners/';
               $config['allowed_types'] = 'jpeg|jpg|png';
               $config['encrypt_name'] = TRUE;
               $this->load->library('upload', $config);
               if (!$this->upload->do_upload('image_file')) {
                    $error = array('error' => $this->upload->display_errors());
                    $data["fetch_data"] = $this->basic_operation->selectData('galleries');   
                    $data['error']=$error; 
                    $this->load->view("admin/gallery", $data);
                    
                    } else {
                    $d = $this->upload->data();
                    $data=array(
                         'image'=>$d['file_name'],
                         'status'=>$this->input->post('status'),
                         'type'=>$this->input->post('type'),
                    );     
                 }
               }else{
                    $data=array(
                         'status'=>$this->input->post('status'),
                         'type'=>$this->input->post('type'),
                    ); 
               }
               if($this->input->post("update"))  
               {    
                    $this->basic_operation->updateDetails('galleries',$data, array('id'=>$this->input->post("hidden_id")));  
                    $this->session->set_flashdata('success','Banner Updated Successfully.');
                    redirect(base_url() . "content/index");  
               } 
               if($this->input->post("insert"))  
               {   
                
                   $rowsCount=$this->basic_operation->matchedRowCount('galleries',array('status'=>1));
                   
                    $this->basic_operation->insertData('galleries',$data); 
                    $this->session->set_flashdata('success','Banner Added Successfully.');
               }           
      }  
     
      public function delete(){  
           $id = $this->uri->segment(3);  
           $this->basic_operation->deleteData('galleries',array('id'=>$id));  
            $this->session->set_flashdata('success','Banner Deleted Successfully.');
           redirect(base_url() . "content/index");  
      }  
       
      public function update(){  
           $auth = $this->session->userdata;
           $user_id = $this->uri->segment(3);  
            $data["user_data"] = $this->basic_operation->Uniqueselect('galleries',array('id'=>$user_id));  
           $data["fetch_data"] = $this->basic_operation->selectData('galleries'); 
           $this->load->view("admin/gallery", $data);  
      }
     
      
 } 