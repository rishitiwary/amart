<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Home extends CI_Controller 
 { 
      public function __construct()
      {
          parent::__construct();
          $this->load->helper('url');               
          $this->load->model("Basic_operation","basic_operation",true);  
          $this->load->library('form_validation'); 
          $this->load->library("pagination");
          $this->load->library('session');
          $this->load->library('user_agent');
          $this->load->model('Commonmodel');
          $this->load->helper('string'); 
        
      } 
    public function index22()
    {
       $this->load->view("home/index");

    } 
    
     public function index()
     {   
       $user_id=$this->input->post('user_id');
       $banners = $this->basic_operation->selectData('galleries');
       $latsql= "SELECT * FROM products WHERE status='1' order by id DESC";
       $latest = $this->Commonmodel->fetch_all_join($latsql);
       $offers = $this->Commonmodel->fetch_all_rows('offers', "status=1");
       $fruits = $this->Commonmodel->fectch_all_by_cat('4');
       $vegetables =  $this->Commonmodel->fectch_all_by_cat('5');
       $eggs =  $this->Commonmodel->fectch_all_by_cat('7');
       $items =  $this->Commonmodel->fectch_all_by_cat('98');
       $drinks =  $this->Commonmodel->fectch_all_by_cat('9');
       $fruitbasket =  $this->Commonmodel->fectch_all_by_cat('109');
       //echo "<pre>";print_r($fruitbasket);exit;
        $this->db->select('categories.*');
        $this->db->from('categories','categories.status=1');
        $this->db->where(['categories.parent_category'=>'0','categories.id !='=>'95']);
        $Category = $this->db->get()->result();
       
        
        $this->db->select('promotional_category.*');
        $this->db->from('promotional_category','promotional_category.status=1');
        $this->db->where('promotional_category.status=1');
        
        $CategoryResults = $this->db->get()->result();
        
        foreach($CategoryResults as $category)
        {
            $category_id=$category->id;
            $this->db->select('promotional.*,promotional.quantity as stock_quantity,promotional.id as product_id');
            $this->db->from('promotional','promotional.status=1');
            $this->db->where(['promotional.quantity >'=>0,'promotional.status ='=>1,'promotional.category_id'=>$category_id]);
            $ProductResults = $this->db->get()->result();
            foreach($ProductResults as $x){
                    $device_id=$this->input->post('device_id');
                    $cartQtys=0;
                    if($user_id > 0){
                       $cartQty=$this->basic_operation->uniqueSelect('carts',array('user_id'=>$user_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                       if(!empty($cartQty)){
                           $cartQtys=$cartQty[0]->quantity;
                       }
                    }else{
                      $cartQty=$this->basic_operation->uniqueSelect('carts',array('device_id'=>$device_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                      if(!empty($cartQty)){
                           $cartQtys=$cartQty[0]->quantity;
                       }
                    }
                    $x->cart_product_quantity="$cartQtys";
                    if($cartQtys >0){
                    $x->CartStatus='1';    
                    }else{
                    $x->CartStatus='0';   
                    }
                    if($user_id > 0){
                        $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('user_id'=>$user_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                    }else{
                        $favCounter=$this->basic_operation->matchedRowCount('wishlists',array('device_id'=>$device_id,'product_id'=>$x->product_id,'product_type'=>$x->product_type));
                    }
                    if($favCounter > 0){
                        $x->favourite_status="1";
                    }else{
                        $x->favourite_status="0";
                    }
            }
            $arr[]=array(
                'id'=>$category->id,
                'title'=>$category->category,
                'products'=>$ProductResults
                );
        }
        
        $collection=array(
            'error'=>false,
            'message'=>'Request completed successfully',
            'category'=>$Category,
            'data'=>$arr,
            'banners'=>$banners,
            'latest' =>$latest,
            'offers' => $offers,
            'fruits' => $fruits,
            'vegetables' => $vegetables,
            'eggs' =>$eggs,
            'items'=>$items,
            'drinks'=>$drinks,
            'fruitbasket'=> $fruitbasket,
            );
        
        $this->load->view('home/header');  
        $this->load->view("home/index33", $collection);
        $this->load->view('home/footer');
        
     }

     public function signup()
     {   
        $data['title']="SignUp"; 
        $this->load->view('home/header', $data);
        $this->load->view('home/register', $data);
        $this->load->view('home/footer');
     }


     public function login()
     {  
        $data['title']="Login"; 
      
      if($_POST)
      {

        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

          $email = $this->input->post('email');

          $password = $this->input->post('password');

          $msg=$this->Commonmodel->login($email, $password);

          if ($this->session->userdata('id')!="") {
            $this->session->set_flashdata('success', ''.$msg);

            $where = array('userId'=>$this->session->userdata('id'));

            if ($this->input->get('redirectto')) {
              redirect(urldecode($this->input->get('redirectto')),'refresh');
            } else {

              redirect('dashboard','refresh');
            }
          }else{
            $this->session->set_flashdata('error', ''.$msg);
            redirect('login', 'refresh');

          }

        } else {

          $msg = '';
          if (form_error('email')) {
            $msg .= strip_tags(form_error('email'))."<br/>";
          }
          if (form_error('password')) {
            $msg .= strip_tags(form_error('password'))."<br/>";
          }
          $this->session->set_flashdata('error', ''.$msg);

          redirect('login', 'refresh');
        }
      }else{

        $this->load->view('home/header', $data);
        $this->load->view("home/login");
        $this->load->view('home/footer');
      }
    }
    
    
     public function place_order()
     {
        $data['title']="Order"; 
        $this->load->view('home/header', $data);
        $this->load->view("home/thankyou", $data); 
        $this->load->view('home/footer'); 
     }

     

     public function category($cat, $type=null)
     {  

      $data['title']="All Category"; 

      $data['bestsellinglist']= $this->Commonmodel->fetch_all_rows_limit('promotional', "category_id=1", 4);

      $data['offerslist']=$this->Commonmodel->fetch_all_rows_limit('offers', "status=1", 4);

      if($type=='3')
      {
        $sql = "SELECT promotional.* from promotional JOIN promotional_category ON promotional.category_id = promotional_category.id WHERE promotional.category_id=$cat";
        $data['cat']= $this->Commonmodel->fetch_row('promotional_category', "promotional_category.id=$cat");
        $where= array('promotional_category.status'=>1 , 'promotional_category.id'=>$cat);
        $data['subcatlist']= $this->Commonmodel->fetch_all_rows('promotional_category', $where);
      }elseif ($type=='2') {
        $sql = "SELECT offers.* from offers WHERE offers.category_id in (SELECT id from categories WHERE (categories.id=$cat OR categories.parent_category=$cat) AND categories.parent_category!=0)";
        $data['cat']= $this->Commonmodel->fetch_row('categories', "categories.id=$cat");
        $where= array('categories.status'=>1 , 'categories.parent_category'=>$cat);
        $data['subcatlist']= $this->Commonmodel->fetch_all_rows('categories', $where);
      }else{
        $sql ="SELECT products.* FROM products WHERE products.category_id in (SELECT id from categories WHERE (categories.id=$cat OR categories.parent_category=$cat) AND categories.parent_category!=0)";
        $data['cat']= $this->Commonmodel->fetch_row('categories', "categories.id=$cat");
        $where= array('categories.status'=>1 , 'categories.parent_category'=>$cat);
        $data['subcatlist']= $this->Commonmodel->fetch_all_rows('categories', $where);
      } 

      $sort= $this->input->get('sort');

      $total_row =  $this->Commonmodel->fetch_all_join($sql);
      $config=array();
      $config["base_url"] = base_url() . "home/category";
      $data['total_row'] = count($total_row);
      $config["total_rows"] = count($total_row);
      $config["per_page"] = 15;
      $config['use_page_numbers'] = TRUE;
      $config['num_links'] = count($total_row);
      $config['cur_tag_open'] = '&nbsp;<a class="current">';
      $config['cur_tag_close'] = '</a>';
      $config['next_link'] = '<i class="fas fa-angle-right"></i>';
      $config['prev_link'] = '<i class="fas fa-chevron-left"></i>';

      $this->pagination->initialize($config);

      if($this->input->get('page'))
      {
        $page = $this->input->get('page') ;
        $start_from = ($page-1) * $config["per_page"];
      }
      else
      {
        $page = 1;
        $start_from = 0;
      }
      if($sort!="")
      {
        if($sort=='asc')
        {
            $sql= $sql. " ORDER BY name ASC";
        }elseif ($sort=='desc') {
          $sql= $sql." ORDER BY name DESC";
        }elseif ($sort=='low_to_high') {
          $sql= $sql." ORDER BY offer_price ASC";
        }else{
          $sql= $sql." ORDER BY offer_price DESC";
        }
      }
      $finalsql= $sql. " LIMIT ".$config['per_page']." OffSET ".$start_from."";


      $data['total_pages'] = ceil(count($total_row) / $config['per_page']);
      $data['per_page'] = $config["per_page"];
      $data['list']=$this->Commonmodel->fetch_all_join($finalsql);

      $this->load->view('home/header', $data);
      $this->load->view("home/category",$data);
      $this->load->view('home/footer');
    }

    public function subcategory($cat, $subcat, $type=null)
    {         

      $data['title']="All Products";
      $data['bestsellinglist']= $this->Commonmodel->fetch_all_rows_limit('promotional', "category_id=1", 4);
      $data['offerslist']=$this->Commonmodel->fetch_all_rows_limit('offers', "status=1", 4);

      if($type=='3'){
        $sql = "SELECT promotional.* from promotional JOIN promotional_category ON promotional.category_id = promotional_category.id WHERE promotional.category_id=$subcat";
        $data['cat']= $this->Commonmodel->fetch_row('promotional_category', "promotional_category.id=$subcat");
        $where= array('promotional_category.status'=>1 , 'promotional_category.id'=>$subcat);
        $data['subcatlist']= $this->Commonmodel->fetch_all_rows('promotional_category', $where);

      }elseif ($type=='2') {
        $sql = "SELECT offers.* from offers JOIN categories ON offers.category_id = categories.id WHERE offers.category_id=$subcat GROUP BY products.id";
        $data['cat']= $this->Commonmodel->fetch_row('categories', "categories.id=$subcat");
        $where= array('categories.status'=>1 , 'categories.parent_category'=>$cat);
        $data['subcatlist']= $this->Commonmodel->fetch_all_rows('categories', $where);
      }else{
        $sql = "SELECT products.* from products JOIN categories ON products.category_id=categories.id  WHERE products.category_id=$subcat";
        $data['cat']= $this->Commonmodel->fetch_row('categories', "categories.id=$subcat");
        $where= array('categories.status'=>1 , 'categories.parent_category'=>$cat);
        $data['subcatlist']= $this->Commonmodel->fetch_all_rows('categories', $where);
      }
      $data['category'] = $cat;

      $sort= $this->input->get('sort');
      $total_row =  $this->Commonmodel->fetch_all_join($sql);
      $config=array();
      $config["base_url"] = base_url() . "home/subcategory";
      $data['total_row'] = count($total_row);
      $config["total_rows"] = count($total_row);
      $config["per_page"] = 15;
      $config['use_page_numbers'] = TRUE;
      $config['num_links'] = count($total_row);
      $config['cur_tag_open'] = '&nbsp;<a class="current">';
      $config['cur_tag_close'] = '</a>';
      $config['next_link'] = '<i class="fas fa-angle-right"></i>';
      $config['prev_link'] = '<i class="fas fa-chevron-left"></i>';

      $this->pagination->initialize($config);

       if($this->input->get('page'))
      {
        $page = $this->input->get('page') ;
        $start_from = ($page-1) * $config["per_page"];
      }
      else
      {
        $page = 1;
        $start_from = 0;
      }
      if($sort!="")
      {
        if($sort=='asc')
        {
            $sql= $sql. " ORDER BY name ASC";
        }elseif ($sort=='desc') {
          $sql= $sql." ORDER BY name DESC";
        }elseif ($sort=='low_to_high') {
          $sql= $sql." ORDER BY offer_price ASC";
        }else{
          $sql= $sql." ORDER BY offer_price DESC";
        }
      }
      
      $finalsql= $sql. " LIMIT ".$config['per_page']." OffSET ".$start_from."";

      $data['total_pages'] = ceil(count($total_row) / $config['per_page']);
      $data['per_page'] = $config["per_page"];
      $data['list']=$this->Commonmodel->fetch_all_join($finalsql);
      //$data['list']= $this->Commonmodel->fetch_all_join($sql);
      $this->load->view('home/header', $data);
      $this->load->view("home/subcategory",$data);
      $this->load->view('home/footer');
    }

     public function offers()
     {
      $data['title']="All Offers";
      $data['bestsellinglist']= $this->Commonmodel->fetch_all_rows_limit('promotional', "category_id=1", 4);

      $sql = "SELECT offers.* from offers JOIN categories ON offers.category_id = categories.id";
            
      $data['categories'] = $this->Commonmodel->fetch_all_join("SELECT categories.* FROM offers JOIN categories On categories.id = offers.category_id GROUP BY categories.id"); 

      $sort= $this->input->get('sort');
      $total_row =  $this->Commonmodel->fetch_all_join($sql);
      $config=array();
      $config["base_url"] = base_url() . "home/offers";
      $data['total_row'] = count($total_row);
      $config["total_rows"] = count($total_row);
      $config["per_page"] = 9;
      $config['use_page_numbers'] = TRUE;
      $config['num_links'] = count($total_row);
      $config['cur_tag_open'] = '&nbsp;<a class="current">';
      $config['cur_tag_close'] = '</a>';
      $config['next_link'] = '<i class="fas fa-angle-right"></i>';
      $config['prev_link'] = '<i class="fas fa-chevron-left"></i>';

      $this->pagination->initialize($config);

      if($this->input->get('page'))
      {
        $page = $this->input->get('page') ;
        $start_from = ($page-1) * $config["per_page"];
      }
      else
      {
        $page = 1;
        $start_from = 0;
      }
      if($sort!="")
      {
        if($sort=='asc')
        {
            $sql= $sql. " ORDER BY name ASC";
        }elseif ($sort=='desc') {
          $sql= $sql." ORDER BY name DESC";
        }elseif ($sort=='low_to_high') {
          $sql= $sql." ORDER BY offer_price ASC";
        }else{
          $sql= $sql." ORDER BY offer_price DESC";
        }
      }
      
      $finalsql= $sql. " LIMIT ".$config['per_page']." OffSET ".$start_from."";


      $data['total_pages'] = ceil(count($total_row) / $config['per_page']);
      $data['per_page'] = $config["per_page"];
      $data['list']=$this->Commonmodel->fetch_all_join($finalsql);
      
      $this->load->view('home/header', $data);
      $this->load->view("home/offers",$data);
      $this->load->view('home/footer');

     }
     
    
     public function productDetail($id, $type)
     {
        $data['title']="All Category";
        $user_id=$this->session->userdata('id');
        if($type=='3')
        {  
          $data['details']=$details= $this->Commonmodel->fetch_row('promotional',"id=$id");
          $data['category']= $this->Commonmodel->fetch_row('promotional_category',"id=$details->category_id");          
          $data['subcategory']= '';

        }elseif ($type=='2') {
          $data['details']=$details= $this->Commonmodel->fetch_row('offers',"id=$id");
          $category= $this->Commonmodel->fetch_row('categories',"id=$details->category_id");
          
          if($category->parent_category=='0')
          {
            $data['category'] = $category;
          }else{
            $data['subcategory'] = $category;
            $parent = $this->Commonmodel->fetch_row('categories',"id=$category->parent_category");
            $data['category'] = $parent;
          }
        }else{
          $data['details']=$details= $this->Commonmodel->fetch_row('products',"id=$id");
          $category= $this->Commonmodel->fetch_row('categories',"id=$details->category_id");
         
          if($category->parent_category=='0')
          {
            $data['category'] = $category;
          }else{
            $data['subcategory'] = $category;
            $parent = $this->Commonmodel->fetch_row('categories',"id=$category->parent_category");
            
            $data['category'] = $parent;
          }
        }
        if($user_id)
        {
           $data['cart'] = $this->Commonmodel->fetch_row("carts", "user_id=$user_id AND product_id = $id AND product_type=$type");           
        }

        $this->db->select('products.*,categories.category,products.quantity as stock_quantity,products.id as product_id,categories.id as category_id');
        $this->db->from('products','products.status=1');
        $this->db->join('categories','categories.id=products.category_id');
        $this->db->where(['products.category_id'=> $data['category']->id,'products.id !='=>$id]);
        $this->db->limit(4);
        
        $data['latest'] = $this->db->get()->result();
       

        $this->load->view('home/header', $data);
        $this->load->view("home/product_detail", $data); 
        $this->load->view('home/footer'); 
     }
     
     

  public function subscribe()
  {
    $email = $this->input->post('email');
    $this->form_validation->set_rules('email', 'Email', 'trim|required');    
    if ($this->form_validation->run() == FALSE)
    {
      $this->session->set_flashdata('err_sub', 'Please provide an acceptable email address.');
      redirect($this->input->post('redirect'));
    }
    else
    {
      
      $fetch_row = $this->Commonmodel->fetch_row('newsletter', "email='$email'");
      
      if (!empty($fetch_row)) 
      {
        $this->session->set_flashdata('warn_sub', 'Already Subscribed');
        redirect($this->input->post('redirect'));

      } else {

        $subdata = array(
          'email' => $email,
          'status' => 1
        );

        $result = $this->Commonmodel->insert("newsletter", $subdata);
       
        if ($result) {
          $this->session->set_flashdata('succ_sub', 'Succeessful Subscribed Email');
          redirect($this->input->post('redirect'));
        } else {
          $this->session->set_flashdata('err_sub', 'Something Wrong');
          redirect($this->input->post('redirect'));
        }

      }
    }

  }

    public function search()
    {        
        $data['title']="All Search Result";

        $keyword=$this->input->get('keyword');

        $q = "SELECT product_code, name, offer_price, price, offer_percentage, country, category_id, product_type, description FROM `products` INNER JOIN `categories` ON `categories`.`id`=`products`.`category_id` AND name LIKE '%$keyword%'
        UNION
        SELECT product_code, name, offer_price, price, offer_percentage, country, category_id, product_type, description FROM `offers` INNER JOIN `categories` ON `categories`.`id`=`offers`.`category_id` AND name LIKE '%$keyword%'
        UNION
        SELECT product_code, name, offer_price, price, offer_percentage, country, category_id, product_type, description FROM `promotional` INNER JOIN `promotional_category` ON `promotional_category`.`id`=`promotional`.`category_id`
        AND name LIKE '%$keyword%'
        ";

        // if($keyword!="")
        // {
        //   $q .= " AND name LIKE '%$keyword%'";
        // }

        $sql=$q. " GROUP BY product_code";
        
      $sort= $this->input->get('sort');
      $total_row =  $this->Commonmodel->fetch_all_join($sql);
      $config=array();
      $config["base_url"] = base_url() . "home/search";
      $data['total_row'] = count($total_row);
      $config["total_rows"] = count($total_row);
      $config["per_page"] = 15;
      $config['use_page_numbers'] = TRUE;
      $config['num_links'] = count($total_row);
      $config['cur_tag_open'] = '&nbsp;<a class="current">';
      $config['cur_tag_close'] = '</a>';
      $config['next_link'] = '<i class="fas fa-angle-right"></i>';
      $config['prev_link'] = '<i class="fas fa-chevron-left"></i>';

      $this->pagination->initialize($config);

      if($this->input->get('page'))
      {
        $page = $this->input->get('page') ;
        $start_from = ($page-1) * $config["per_page"];
      }
      else
      {
        $page = 1;
        $start_from = 0;
      }
      if($sort!="")
      {
        if($sort=='asc')
        {
            $sql= $sql. " ORDER BY name ASC";
        }elseif ($sort=='desc') {
          $sql= $sql." ORDER BY name DESC";
        }elseif ($sort=='low_to_high') {
          $sql= $sql." ORDER BY offer_price ASC";
        }else{
          $sql= $sql." ORDER BY offer_price DESC";
        }
      }
      
      $finalsql= $sql. " LIMIT ".$config['per_page']." OffSET ".$start_from."";


      $data['total_pages'] = ceil(count($total_row) / $config['per_page']);
      $data['per_page'] = $config["per_page"];
      $data['list']=$this->Commonmodel->fetch_all_join($finalsql);
      $data['keyword'] = $keyword;

      $this->load->view('home/header', $data);
      $this->load->view("home/search", $data);
      $this->load->view('home/footer');
    }
 
     public function logout()
     {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('role');
        $this->session->sess_destroy();
        redirect('home');
     }

 
    public function category_list()
     {
         $data['title']="All Category"; 
         $this->load->view('home/header', $data);
         $this->load->view("home/categorypage-list");
         $this->load->view('home/footer');
     }

    
     
    
    
     public function updateProfile()
      {
        $user_id=$this->input->post('user_id');
        $name=$this->input->post('name');
        $mobile=$this->input->post('mobile');
        $this->basic_operation->updateDetails('users',array('name'=>$name,'mobile'=>$mobile),array('id'=>$user_id));
        $this->session->set_flashdata('success','Profile Updated Successfully...'); 
        redirect(base_url() . "home/account");

      }

     
     public function account()
     { 
        $data = $this->session->userdata;
        
        if(@$data['role'] != 3 ){
            $this->login();
        }else{
        
        $user_id=$data['id'];
        
        if($data['role']==3)
        {
        $this->db->select('bookings.*, SUM(bookings.price) as TotalBookingPrice,SUM(bookings.quantity) as TotalProductQty,customer.name as  customer_name,bookings.web_address as delivery_address,products.name as product_name');
        $this->db->from('bookings');
        $this->db->join('products', 'products.id = bookings.product_id');
        $this->db->join('users as customer', 'customer.id = bookings.user_id');
        $this->db->group_by(['bookings.order_id','bookings.user_id','bookings.booking_date']);
        $this->db->where(['bookings.user_id'=>$user_id]);
        $data['fetch_data'] = $this->db->get()->result(); 
        
        foreach($data['fetch_data'] as $item)
        {
            if($item->coupon_id==null)
            {
                $item->coupon_id=0;
                $item->coupon_code='';
                $item->coupon_title='';
                $item->discount_percentage=0;
            }

            if($item->address_id==0)
            {
                $item->address=$item->web_address;
                $item->landmark=$item->web_landmark;
                $item->mobile=$item->web_mobile;
                $item->name=$item->web_name;
            }
        }
        $this->load->view("home/account", $data);  
       }
      }
     }

    
    
     
}