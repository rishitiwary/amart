<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
class Product extends CI_Controller
{
     public function __construct()
     {
          parent::__construct();
          $this->load->model("Basic_operation", "basic_operation", true);
          $this->load->model('AdminDetails');
          $this->load->library('form_validation');
          $this->load->library("pagination");
          $auth = $this->session->userdata;
          if (empty($auth)) {
               redirect(site_url() . 'main/login/');
          }


          if (empty($auth['role'])) {
               redirect(site_url() . 'main/login/');
          }
     }

     public function index()
     {
          $auth = $this->session->userdata;
          if ($auth['role'] == 1) {
               $this->db->select('products.*,categories.*,products.id as id,products.status as status,categories.id as category_id');
               $this->db->from('products');
               $this->db->join('categories', 'categories.id=products.category_id');
               $data["fetch_data"] = $this->db->get()->result();
          }

          $this->load->view("admin/product", $data);
     }

     public function store()
     {
          $auth = $this->session->userdata;
          if (!empty($_FILES['image_file']['name']) && !empty($_FILES['image_file']['tmp_name'])) {
               $config['upload_path'] = './uploads/products/';
               $config['allowed_types'] = 'jpeg|jpg|png';
               $config['encrypt_name'] = TRUE;
               $this->load->library('upload', $config);
               if (!$this->upload->do_upload('image_file')) {
                    $error = array('error' => $this->upload->display_errors());
                    $data["fetch_data"] = $this->basic_operation->selectData('products');
                    $data['error'] = $error;
                    $this->load->view("admin/product", $data);
               } else {
                    $d = $this->upload->data();
                    $data = array(
                         // 'image' => $d['file_name'],
                         'country' => ($this->input->post('country')) ? $this->input->post('country') : '',
                         'user_id' => $auth['id'],
                         'brand'=>$this->input->post('brand'),
                         'status' => $this->input->post('status'),
                         'name' => $this->input->post('name'),
                         'product_code' => $this->input->post('product_code'),
                         'category_id' => $this->input->post('category_id'),
                         'description' => $this->input->post('description'),
                    );
               }
          } else {
               $data = array(
                    'user_id' => $auth['id'],
                    'country' => ($this->input->post('country')) ? $this->input->post('country') : '',
                    'status' => $this->input->post('status'),
                    'name' => $this->input->post('name'),
                    'brand'=>$this->input->post('brand'),
                    'product_code' => $this->input->post('product_code'),
                    'category_id' => $this->input->post('category_id'),
                    'description' => $this->input->post('description'),
               );
          }
          if ($this->input->post("updateproduct")) {
               $this->basic_operation->updateDetails('products', $data, array('id' => $this->input->post("hidden_id")));
               $this->session->set_flashdata('success', 'Product Updated Successfully.');
               redirect(base_url() . "product/index");
          } elseif ($this->input->post("insertproduct")) {
               $inserted_id = $this->basic_operation->insertData('products', $data);
               $this->session->set_flashdata('success', 'Product Added Successfully.');
               redirect(base_url() . "product/index");
          } else {
               $data["fetch_category"] = $this->basic_operation->UniqueSelect('categories', array('parent_category =' => 0, 'status =' => '1'));
               $data["brand"]=$this->AdminDetails->fetchCols("brand_tb","id,bname","status=1");
               $this->load->view("admin/product_insert", $data);
          }
     }
     public function delete($id, $img)
     {
          $this->basic_operation->deleteData('products', array('id' => $id));
          $path = './uploads/products/' . $img;
          @unlink($path);
          $this->session->set_flashdata('success', 'Product Deleted Successfully.');
          redirect(base_url() . "product/index");
     }

     public function update()
     {
          $auth = $this->session->userdata;
          $product_id = $this->uri->segment(3);
          $data["fetch_subcategory"] = $this->basic_operation->UniqueSelect('categories', array('parent_category !=' => 0, 'status =' => '1'));
          $data["fetch_category"] = $this->basic_operation->UniqueSelect('categories', array('parent_category =' => 0, 'status =' => '1', 'categories.id !=' => '95'));
          $data["user_data"] = $this->basic_operation->Uniqueselect('products', array('id' => $product_id));
         $data['brand']=$this->AdminDetails->fetchCols("brand_tb","id,bname","status=1");
          $this->load->view("admin/product_insert", $data);
     }

     public function orders()
     {
          $data = $this->session->userdata;
          if ($data['role'] == 1) {
               $this->db->select('bookings.*,SUM(bookings.price) as TotalBookingPrice,SUM(bookings.quantity) as TotalProductQty,customer.name as  customer_name,bookings.address as delivery_address,products.name as product_name');
               $this->db->from('bookings');
               $this->db->join('products', 'products.id = bookings.product_id');
               $this->db->join('users as customer', 'customer.id = bookings.user_id');
               $this->db->group_by(['bookings.order_id', 'bookings.user_id', 'bookings.booking_date']);
               if (!empty($this->uri->segment(3))) {
                    $this->db->where(array('bookings.status' => $filterBy));
               }
               $data['fetch_data'] = $this->db->get()->result();
               foreach ($data['fetch_data'] as $item) {
                    if ($item->coupon_id == null) {
                         $item->coupon_id = 0;
                         $item->coupon_code = '';
                         $item->coupon_title = '';
                         $item->discount_percentage = 0;
                    }
                    if ($item->address_id == 0) {
                         @$item->address = $item->web_address;
                         @$item->landmark = $item->web_landmark;
                         @$item->mobile = $item->web_mobile;
                         @$item->name = $item->web_name;
                    }
               }
          }
          //echo "<pre>";print_r($data);exit;
          $this->load->view("admin/orders", $data);
     }

     public function OrdersDetail()
     {

          $this->load->view("admin/orders");
     }
     public function fetchCategory($category_id)
     {
          $data = $this->basic_operation->UniqueSelect('categories', array('parent_category =' => $category_id, 'status =' => '1'));
          echo json_encode($data);
     }
     public function brand()
     {

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
               $config['upload_path'] = 'uploads/products/';
               $config['allowed_types'] = 'jpeg|jpg|png';
               $config['encrypt_name'] = TRUE;
               $this->load->library('upload', $config);
               if (!$this->upload->do_upload('brandimage')) {
                    $error = $data['error'] = array('error' => $this->upload->display_errors());
               } else {
                    $d = $this->upload->data();
                    $brand = $this->input->post('brand');
                    $data = array(
                         'image' => $d['file_name'],
                         'bname' => trim($this->input->post('brand')),
                         'description' => trim($this->input->post('description')),

                    );

                    $que = $this->db->query("select * from brand_tb where bname='$brand'");
                    $row = $que->num_rows();
                    if ($row) {
                         $this->session->set_flashdata('msg', 'Brand already exists');
                         redirect(base_url() . 'Product/brand');
                    }
                    $insert = $this->AdminDetails->InsertData('brand_tb', $data);
                    if ($insert) {

                         $this->session->set_flashdata('msg', 'Brand added succesfully');
                         redirect(base_url() . 'Product/brand');
                    } else {
                         $this->session->set_flashdata('msg', 'Sorry some error occured');
                         redirect(base_url() . 'Product/brand');
                    }
               }
          }

          $this->load->view('admin/brand');
     }
     public function viewbrand()
     {
          $data['brand'] = $this->AdminDetails->fetchAll('brand_tb');

          $this->load->view('admin/viewbrand', $data);
     }

     public function updatebrand($id)
     {
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {

               $gt = $data['brand'] = $this->AdminDetails->fetchSingleById('brand_tb', $this->input->post('uid'), 'id');

               $config['upload_path'] = 'uploads/products/';
               $config['allowed_types'] = 'jpeg|jpg|png';
               $config['encrypt_name'] = TRUE;

               $this->load->library('upload', $config);
               $this->upload->do_upload('brandimage');
               $this->upload->do_upload('image');
               $d = $this->upload->data();
               $image = $d['file_name'];
               $brand = $this->input->post('brand');
               $gt = $data['brand'] = $this->AdminDetails->fetchSingleById('brand_tb', $this->input->post('uid'), 'id');

               if (empty($image)) {
                    foreach ($gt as $rn) {
                         $image = $rn->image;
                    }
               }
               $data = array(
                    'image' => $image,
                    'bname' => trim($this->input->post('brand')),
                    'description' => trim($this->input->post('description')),
                    'status' => trim($this->input->post('status')),

               );

               $this->AdminDetails->UpdateData($this->input->post('uid'), $data, 'brand_tb');
               $this->session->set_flashdata('msg', 'Brand updated succesfully');
               redirect(base_url() . 'Product/viewbrand');
               //exit; 
          }
          $data['brand'] = $this->AdminDetails->fetchSingleById('brand_tb', $id, 'id');

          $this->load->view('admin/updatebrand', $data);
     }

     public function addVariants()
     {
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {

               $data = array(
                    'product_id' => $this->input->post('product_id'),
                    'cost_price' => $this->input->post('cost_price'),
                    'price' => $this->input->post('price'),
                    'offer_price' => $this->input->post('offer_price'),
                    'product_code' => $this->input->post('product_code'),
                    'unit' => $this->input->post('unit'),
                    'value' => $this->input->post('value'),
                    'packing_type' => $this->input->post('packing_type'),
                    'quantity' => $this->input->post('quantity'),
                    'min_order_qty' => $this->input->post('min_order_qty'),
                    'expiry_date' => $this->input->post('expiry_date'),
               );

               if ($this->input->post('vid') != '') {
                    $inserted_id =  $this->basic_operation->updateDetails('product_variants', $data, array('id' => $this->input->post("vid")));
               } else {
                    $inserted_id = $this->basic_operation->insertData('product_variants', $data);
               }



               if ($inserted_id > 0) {
                    $config['upload_path'] = './uploads/products/';
                    $config['allowed_types'] = 'jpeg|jpg|png';
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                    $cpt = count($_FILES['image_file']['name']);
                    for ($i = 0; $i < $cpt; $i++) {
                         // Check if the file is uploaded
                         if (!empty($_FILES['image_file']['name'][$i]) && !empty($_FILES['image_file']['tmp_name'][$i])) {

                              // Set up $_FILES for the current file
                              $_FILES['current_file']['name'] = $_FILES['image_file']['name'][$i];
                              $_FILES['current_file']['type'] = $_FILES['image_file']['type'][$i];
                              $_FILES['current_file']['tmp_name'] = $_FILES['image_file']['tmp_name'][$i];
                              $_FILES['current_file']['error'] = $_FILES['image_file']['error'][$i];
                              $_FILES['current_file']['size'] = $_FILES['image_file']['size'][$i];

                              // Initialize upload with the current file
                              $this->upload->initialize($config);

                              // Perform the upload
                              if (!$this->upload->do_upload('current_file')) {
                                   $error = array('error' => $this->upload->display_errors());
                                   echo $data['error'] = $error;
                              } else {
                                   // Get the uploaded data
                                   $d = $this->upload->data();
                                   $data = array(
                                        'images' => $d['file_name'],
                                        'product_id' => $this->input->post('product_id'),
                                   );
                                   $inserted_id = $this->basic_operation->insertData('product_images', $data);
                              }
                         }
                    }
               }

               if ($this->input->post('vid') != '') {
                    $this->session->set_flashdata('success', 'Variant updated succesfully');
                    redirect(base_url() . 'product/viewVariants/' . $this->input->post('product_id'));
               } else {
                    $this->session->set_flashdata('success', 'Variant Added succesfully');
                    redirect($_SERVER['HTTP_REFERER']);
               }
          }

          $data['productId'] = $this->uri->segment('3');

          $this->load->view('products/addVariants', $data);
     }

     public function viewVariants($id)
     {
          $data['product_id'] = $id;
          $data["fetch_data"] = $this->AdminDetails->fetchCols('product_variants', "*", "product_id=$id");
          $data['images'] = $this->AdminDetails->fetchCols('product_images', "id,images", "product_id=$id");
          $this->load->view('products/viewVariants', $data);
     }
     public function variantDelete($id, $product_id)
     {

          $this->basic_operation->deleteData('product_variants', array('id' => $id));

          $rs = $this->AdminDetails->fetchCols('product_images', "images", "product_id=$product_id");
          foreach ($rs as $run) {
               $path = './uploads/products/' . $run->images;
               @unlink($path);
          }


          $this->session->set_flashdata('success', 'Variant Deleted Successfully.');
          redirect($_SERVER['HTTP_REFERER']);
     }

     public function deleteVariantImage($id, $img)
     {
          $this->basic_operation->deleteData('product_images', array('id' => $id));
          $path = './uploads/products/' . $img;
          @unlink($path);
          $this->session->set_flashdata('success', 'Deleted Successfully.');
          redirect($_SERVER['HTTP_REFERER']);
     }

     public function VariantUpdate($id, $product_id)
     {
          $data['productId'] = $product_id;
          $data['res'] = $this->AdminDetails->fetchCols("product_variants", "*", "id=$id");
          $this->load->view('products/addVariants', $data);
     }

     public function deletebrand($id, $img)
     {
          $this->basic_operation->deleteData('brand_tb', array('id' => $id));
          $path = './uploads/products/' . $img;
          @unlink($path);
          $this->session->set_flashdata('success', 'Brand Deleted Successfully.');
          redirect(base_url() . "product/viewbrand");
     }
}
