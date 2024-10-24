<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Product extends CI_Controller
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
              $this->db->select('products.*,categories.*,products.image as image,products.id as id,products.status as status,categories.id as category_id');
              $this->db->from('products');
              $this->db->join('categories','categories.id=products.category_id');
              $data["fetch_data"] = $this->db->get()->result();
          }
               
           $this->load->view("admin/product", $data);            
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
                    $data["fetch_data"] = $this->basic_operation->selectData('products');   
                    $data['error']=$error; 
                    $this->load->view("admin/product", $data);
                    
                    } else {
                    $d = $this->upload->data();
                    $data=array(
                         'image'=>$d['file_name'],
                         'country'=>($this->input->post('country'))?$this->input->post('country'):'',
                         'user_id'=>$auth['id'],
                         'status'=>$this->input->post('status'),
                         'name' =>$this->input->post('name'),
                         'product_code' =>$this->input->post('product_code'),
                         'price' =>$this->input->post('price'),
                         'offer_price' =>$this->input->post('price'),
                         'offer_percentage' =>0,
                         'quantity' =>$this->input->post('quantity'),
                         'category_id' =>$this->input->post('category_id'),
                         'weight' =>$this->input->post('measure'),
                         'description' =>$this->input->post('description'),
                    );     
                 }
               }else{
                    $data=array(
                         'user_id'=>$auth['id'],
                         'country'=>($this->input->post('country'))?$this->input->post('country'):'',
                         'status'=>$this->input->post('status'),
                         'name' =>$this->input->post('name'),
                         'product_code' =>$this->input->post('product_code'),
                         'price' =>$this->input->post('price'),
                         'offer_price' =>$this->input->post('price'),
                         'offer_percentage' =>0,
                         'category_id' =>$this->input->post('category_id'),
                         'quantity' =>$this->input->post('quantity'),
                         'weight' =>$this->input->post('measure'),
                         'description' =>$this->input->post('description'),
                    ); 
               }
               if($this->input->post("updateproduct"))  
               {  
               $this->basic_operation->updateDetails('products',$data, array('id'=>$this->input->post("hidden_id"))); 
               $this->session->set_flashdata('success','Product Updated Successfully.');
               redirect(base_url() . "product/index");  
               } 
               elseif($this->input->post("insertproduct"))  
               {  
               $inserted_id= $this->basic_operation->insertData('products',$data);
               $this->session->set_flashdata('success','Product Added Successfully.');
               redirect(base_url() . "product/index");  
               }else{
               $data["fetch_category"] = $this->basic_operation->UniqueSelect('categories',array('parent_category ='=>0,'status ='=>'1'));
               $this->load->view("admin/product_insert",$data); 
               }
     }
     public function delete($id,$img){  
          $this->basic_operation->deleteData('products',array('id'=>$id)); 
          $path='./uploads/products/'.$img;
          @unlink($path);
          $this->session->set_flashdata('success','Product Deleted Successfully.');
          redirect(base_url() . "product/index");  
     }  
      
     public function update(){  
         $auth = $this->session->userdata;
          $product_id = $this->uri->segment(3);  
          $data["fetch_subcategory"] = $this->basic_operation->UniqueSelect('categories',array('parent_category !='=>0,'status ='=>'1'));
          $data["fetch_category"] = $this->basic_operation->UniqueSelect('categories',array('parent_category ='=>0,'status ='=>'1','categories.id !='=>'95'));
          $data["user_data"] = $this->basic_operation->Uniqueselect('products',array('id'=>$product_id));  
          $this->load->view("admin/product_insert", $data);  
     }
     
     public function orders(){  
            $data = $this->session->userdata;
	        if($data['role']==1){
                $this->db->select('bookings.*,SUM(bookings.price) as TotalBookingPrice,SUM(bookings.quantity) as TotalProductQty,customer.name as  customer_name,bookings.address as delivery_address,products.name as product_name');
                $this->db->from('bookings');
                $this->db->join('products', 'products.id = bookings.product_id');
                $this->db->join('users as customer', 'customer.id = bookings.user_id');
                $this->db->group_by(['bookings.order_id','bookings.user_id','bookings.booking_date']);
                if(!empty($this->uri->segment(3))){
                    $this->db->where(array('bookings.status'=>$filterBy));
                }
                $data['fetch_data'] = $this->db->get()->result(); 
                foreach($data['fetch_data'] as $item){
                if($item->coupon_id==null){
                    $item->coupon_id=0;
                    $item->coupon_code='';
                    $item->coupon_title='';
                    $item->discount_percentage=0;
                }
                if($item->address_id==0){
                    @$item->address=$item->web_address;
                    @$item->landmark=$item->web_landmark;
                    @$item->mobile=$item->web_mobile;
                    @$item->name=$item->web_name;
                }
                }
                
            }         
          $this->load->view("admin/orders",$data);  
     }

     public function OrdersDetail(){  
                    
          $this->load->view("admin/orders");      
     }
     public function fetchCategory($category_id){
          $data= $this->basic_operation->UniqueSelect('categories',array('parent_category ='=>$category_id,'status ='=>'1'));
          echo json_encode($data);
      }
         
 } 