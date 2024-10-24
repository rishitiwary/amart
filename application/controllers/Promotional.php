<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Promotional extends CI_Controller 
 { 
      public function __construct()
      {
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
          $auth = $this->session->userdata;
          if($auth['role']==1){
              $this->db->select('promotional.*,promotional_category.*,promotional.image as image,promotional.id as id,promotional.status as status,promotional_category.id as category_id');
              $this->db->from('promotional');
              $this->db->join('promotional_category','promotional_category.id=promotional.category_id');
              $data["fetch_data"] = $this->db->get()->result();
          }
               
           $this->load->view("admin/promotional_view", $data);            
     } 
     
     public function store(){ 
          $auth = $this->session->userdata; 
          if(!empty($_FILES['image_file']['name']) && !empty($_FILES['image_file']['tmp_name'])){
               $config['upload_path'] = './uploads/products/';
               $config['allowed_types'] = 'jpeg|jpg|png';
               $config['encrypt_name'] = TRUE;
               $this->load->library('upload', $config);
               if (!$this->upload->do_upload('image_file')) {
                    $error = array('error' => $this->upload->display_errors());
                    $data["fetch_data"] = $this->basic_operation->selectData('promotional');   
                    $data['error']=$error; 
                    $this->load->view("admin/promotional_view", $data);
                    
                    } else {
                    $d = $this->upload->data();
                    $data=array(
                         'image'=>$d['file_name'],
                         'user_id'=>$auth['id'],
                         'status'=>$this->input->post('status'),
                         'name' =>$this->input->post('name'),
                         'product_code' =>$this->input->post('product_code'),
                         'country'=>($this->input->post('country'))?$this->input->post('country'):'',
                         'price' =>$this->input->post('price'),
                         'offer_price' =>$this->input->post('offer_price'),
                         'offer_percentage' =>$this->input->post('offer_percentage'),
                         'quantity' =>$this->input->post('quantity'),
                         'category_id' =>$this->input->post('category_id'),
                         'weight' =>$this->input->post('measure'),
                         'description' =>$this->input->post('description'),
                    );     
                 }
               }else{
                    $data=array(
                         'user_id'=>$auth['id'],
                         'status'=>$this->input->post('status'),
                         'name' =>$this->input->post('name'),
                         'product_code' =>$this->input->post('product_code'),
                         'price' =>$this->input->post('price'),
                         'country'=>($this->input->post('country'))?$this->input->post('country'):'',
                         'offer_price' =>$this->input->post('offer_price'),
                         'offer_percentage' =>$this->input->post('offer_percentage'),
                         'category_id' =>$this->input->post('category_id'),
                         'quantity' =>$this->input->post('quantity'),
                         'weight' =>$this->input->post('measure'),
                         'description' =>$this->input->post('description'),
                    ); 
               }
               if($this->input->post("updateproduct"))  
               {  
               $this->basic_operation->updateDetails('promotional',$data, array('id'=>$this->input->post("hidden_id"))); 
               $this->session->set_flashdata('success','Product Updated Successfully.');
               redirect(base_url() . "promotional/index");  
               } 
               elseif($this->input->post("insertproduct"))  
               {  
               $inserted_id= $this->basic_operation->insertData('promotional',$data);
               $this->session->set_flashdata('success','Product Added Successfully.');
               redirect(base_url() . "promotional/index");  
               }else{
               $data["fetch_category"] = $this->basic_operation->UniqueSelect('promotional_category',array('status ='=>'1'));
               $this->load->view("admin/promotional_insert",$data); 
               }
     }
     public function delete($id,$img){  
          $this->basic_operation->deleteData('promotional',array('id'=>$id)); 
          $path='./uploads/products/'.$img;
          @unlink($path);
          $this->session->set_flashdata('success','Product Deleted Successfully.');
          redirect(base_url() . "promotional/index");  
     }  
      
     public function update(){  
         $auth = $this->session->userdata;
          $product_id = $this->uri->segment(3);  
          $data["fetch_category"] = $this->basic_operation->UniqueSelect('promotional_category',array('status ='=>'1'));
          $data["user_data"] = $this->basic_operation->Uniqueselect('promotional',array('id'=>$product_id));  
          $this->load->view("admin/promotional_insert", $data);  
     }
         
 } 