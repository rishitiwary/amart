<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Category extends CI_Controller { 
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
           $this->db->select('*');
           $this->db->from('categories');
           $this->db->where('parent_category','0');
           $this->db->order_by('id','desc');
          $data["fetch_data"] = $this->db->get()->result();
          $this->load->view("admin/category", $data);  
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
                    $this->load->view("admin/category_insert", $data);
                    
                    } else {
                    $d = $this->upload->data();
                    $data=array(
                         'category'=>$this->input->post('category'),
                        'image'=>$d['file_name'],
                        'parent_category'=>$this->input->post('parent_category'),
                        'enable_as_category'=>$this->input->post('enable_as_category'),
                        'status'=>$this->input->post('status'),
                    ); 
                 }
               }else{
                    $data=array(
                        'category'=>$this->input->post('category'),
                         'parent_category'=>$this->input->post('parent_category'),
                         'enable_as_category'=>$this->input->post('enable_as_category'),
                         'status'=>$this->input->post('status'),
                    ); 
               }
                
                
               if($this->input->post("updatecategory"))  
               {  
                    $this->basic_operation->updateDetails('categories',$data, array('id'=>$this->input->post("hidden_id")));  
                    $this->session->set_flashdata('success','Category Updated Successfully.');
                    redirect(base_url() . "category/index");  
               } 
               if($this->input->post("insertcategory"))  
               {  
                    $this->basic_operation->insertData('categories',$data); 
                    $this->session->set_flashdata('success','Category Added Successfully.');
                    redirect(base_url() . "category/index");  
               }else{
                    $data["fetch_category"] = $this->db->where(array('enable_as_category'=>1,'status'=>1))->get('categories')->result();
                    $this->load->view("admin/category_insert",$data); 
               }           
      }  
     
      public function delete(){  
          $id = $this->uri->segment(3);  
          $image = $this->uri->segment(4);  
           $this->basic_operation->deleteData('categories',array('id'=>$id));
           $this->basic_operation->deleteData('categories',array('parent_category'=>$id));
           $this->basic_operation->deleteData('products',array('category_id'=>$id));
           $img_path=base_url().'uploads/categories/'.$image;
           @unlink($img_path);
           $this->session->set_flashdata('success','Category Deleted Successfully.');
           redirect(base_url() . "category/index");  
      }  
       
      public function update(){ 
          $category_id = $this->uri->segment(3); 
          $data["fetch_category"] = $this->db->where(array('parent_category'=>0,'status'=>1))->get('categories')->result();
          $data["user_data"] = $this->basic_operation->UniqueSelect('categories',array('id'=>$category_id));  
          $this->load->view("admin/category_insert", $data);  
     }

     public function view(){ 
          $category_id = $this->uri->segment(3);  
          $data["fetch_data"] = $this->basic_operation->Uniqueselect('categories',array('parent_category'=>$category_id));
          $this->load->view("admin/subcategory", $data);  
     }
      
 } 