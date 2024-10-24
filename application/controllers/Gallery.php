<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Gallery extends CI_Controller { 
      public function __construct(){
        Parent::__construct();
        $this->load->database();
        $this->load->model("Basic_operation","basic_operation",true);  
        $this->load->library('form_validation'); 
        
        $auth = $this->session->userdata;
        if(empty($auth)){
            redirect(site_url().'main/login/');
        }

        
        if(empty($auth['role'])){
            redirect(site_url().'main/login/');
        } 
      } 
 
      public function index(){
        $auth = $this->session->userdata;
        if($auth['role']==1){
           $data["fetch_data"] = $this->basic_operation->selectData('galleries'); 
        }  
        $this->load->view("admin/view_gallery", $data); 
      
      }
      
    public function store(){  
      $this->load->view("admin/insert_gallery");  
    }

    public function form_validation()  
    {        
              $auth = $this->session->userdata;
              
              if(!empty($_FILES['image_file']['name']) && !empty($_FILES['image_file']['tmp_name'])){
              $config['upload_path'] = './uploads/galleries/';
              $config['allowed_types'] = 'jpeg|jpg|png';
              $config['encrypt_name'] = TRUE;
              $this->load->library('upload', $config);
              if (!$this->upload->do_upload('image_file')) {
                    $error = array('error' => $this->upload->display_errors());
                    $data["fetch_data"] = $this->basic_operation->selectData('galleries');   
                    $data['error']=$error; 
                    $this->load->view("admin/insert_gallery", $data);
                    
                    } else {
                    $d = $this->upload->data();
                    $data=array(
                        'image'=>$d['file_name'],
                        'status'=>$this->input->post('status'),
                  );     
                }
              }else{
                    $data=array(
                        'status'=>$this->input->post('status'),
                    ); 
              }
              if($this->input->post("updategallery"))  
              {    
                    $this->basic_operation->updateDetails('galleries',$data, array('id'=>$this->input->post("hidden_id")));  
                    $this->session->set_flashdata('success','Gallery Updated Successfully.');
                    redirect(base_url() . "gallery/index");  
              } 
              if($this->input->post("insertgallery"))  
              {   
                    $this->basic_operation->insertData('galleries',$data); 
                    $this->session->set_flashdata('success','Gallery Added Successfully.');
                    redirect(base_url() . "gallery/index");  
              }           
      }  
    
      public function delete($id,$img){   
          $this->basic_operation->deleteData('galleries',array('id'=>$id));  
          $path='./uploads/galleries/'.$img;
          unlink($path);
          $this->session->set_flashdata('success','Gallery Deleted Successfully.');
          redirect(base_url() . "gallery/index");  
      }  
      
      public function update(){  
          $auth = $this->session->userdata;
          $user_id = $this->uri->segment(3);  
            $data["user_data"] = $this->basic_operation->Uniqueselect('galleries',array('id'=>$user_id));  
          $data["fetch_data"] = $this->basic_operation->selectData('galleries'); 
          $this->load->view("admin/insert_gallery", $data);  
      }
    
      
 } 