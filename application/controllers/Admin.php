<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Admin extends CI_Controller { 
      public function __construct(){
        Parent::__construct();
        $this->load->database();
        $this->load->model("Basic_operation","basic_operation",true);  
        $this->load->model("User_model","user_model",true);  
        $this->load->model("Auth","auth",true);  
        $this->load->library('form_validation'); 
        $this->load->library('user_agent');

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
           $this->db->from('users');
           $this->db->where('role','3');
           $this->db->order_by('id','desc');
           $data["fetch_data"] = $this->db->get()->result();
           $data['user_type']='customers';
           $this->load->view("admin/index",$data);   
     
      }
      
      public function pending(){ 
          
          $array = array('role' => '3' , 'status' => 'pending' );
        $this->db->select('*');
           $this->db->from('users');
           $this->db->where($array);
           $this->db->order_by('id','desc');
           $data["fetch_data"] = $this->db->get()->result();
           $data['user_type']='customers';
           $this->load->view("admin/pending_customer",$data);   
     
      }
      
      
      public function profile(){ 
        $auth = $this->session->userdata;
        $user_id=$auth['id'];
        $this->db->where('id',$user_id);
        $data['row']=$this->db->get('users')->result_array();
        $this->load->view("admin/profile",$data); 
      }
    
    public function admins(){ 
      $this->db->where('role','1');
      $data['fetch_data']=$this->db->get('users')->result_array();
      $this->load->view("admin/viewadmin",$data); 
    
    }
    public function base64url_encode($data) {
      return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function base64url_decode($data) {
      return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
    public function addAdmins(){ 
      $this->load->view("admin/register"); 
      $result = $this->user_model->getAllSettings();
      $sTl = $result->site_title;  
      if ($this->input->server('REQUEST_METHOD') == 'POST'){
        $this->load->library('password');
        if($this->auth->isDuplicate($this->input->post('email'))){
          // email duplicate response
          $this->session->set_flashdata('error','Email already exist !...'); 
          //  redirect($_SERVER['HTTP_REFERER']);
          redirect($this->agent->referrer());
      }else{
        $form_data = array(
          'name' => $this->input->post('name'),
          'email'   => $this->input->post('email'),
          'password'   => $this->password->create_hash($this->input->post('password')),
          'mobile'  => $this->input->post('mobile'),
          'role'=>1,
          'banned_users'=>'ban'
      );
        
        //insert to database
        $id = $this->user_model->insertUser($form_data);
        $token = $this->user_model->insertToken($id);

        //generate token
        $qstring = $this->base64url_encode($token);
        $url = site_url() . 'app/complete/token/' . $qstring;
        $link = '<a href="' . $url . '">' . $url . '</a>';

        $this->load->library('email');
        $this->load->library('sendmail');
        
        $message = $this->sendmail->sendRegister($this->input->post('name'),$this->input->post('email'),$link,$sTl);
        $to_email = $this->input->post('email');
        $this->email->initialize($this->sendmail->config());
        $this->email->from($this->config->item('register'), 'Account Activation ' . $this->input->post('name')); //from sender, title email
        $this->email->to($to_email);
        $this->email->subject('Account Activation');
        $this->email->message($message);
        if(!empty($uploadFormData)){
            foreach($uploadFormData as $uploadFData){
                $this->email->attach($uploadFData['full_path']);         
            }
        }
      
        $this->email->set_mailtype("html");

        //Sending mail
        if($this->email->send()){
            // success response
            $this->session->set_flashdata('success','User created successfully...'); 
            //  redirect($_SERVER['HTTP_REFERER']);
            redirect($this->agent->referrer());
        }else{
            // error response
            $this->session->set_flashdata('error','There is problem to sending mail...'); 
              //  redirect($_SERVER['HTTP_REFERER']);
            redirect($this->agent->referrer());
        }

      }
    }
    
    }
    public function feedback(){  
      $this->load->view("admin/feedback_view");  
    }

    public function contact(){  
        $this->load->view("admin/contact_view");  
    }
    public function manage_subscriber(){  
        $data['fetch_subscriber']=$this->db->get('newsletter')->result_array();
        $this->load->view("admin/manage_subscriber",$data);  
    }
    // public function approvesubscriber($user_id,$status)
    // {
    //     $data=array(
    //       'status'=>$status
    //     );
    //     $this->basic_operation->updateDetails('newsletter',$data,array('newsletterId'=>$user_id));
    //     $this->session->set_flashdata('success','Status Updated Successfully...'); 
    //      redirect($_SERVER['HTTP_REFERER']);

    // }
    public function changePassword(){
      if ($this->input->server('REQUEST_METHOD') == 'POST')
      {
          $this->load->library('password');
          $auth = $this->session->userdata;
          $current_password=$this->input->post('current_password') ;
          $new_password=$this->password->create_hash($this->input->post('new_password'));
          $confirm_password=$this->password->create_hash($this->input->post('confirm_password'));
          $user_id=$auth['id'];
          $user_data=$this->basic_operation->Uniqueselect('users',array('id'=>$user_id));
          if(!$this->password->validate_password($current_password,$user_data[0]->password)){
               $this->session->set_flashdata('error','Current Password is Invailed'); 
              //  redirect($_SERVER['HTTP_REFERER']);
              redirect($this->agent->referrer());
               
          }
          elseif(!empty($current_password) && !empty($new_password) && !empty($confirm_password)){
          if($new_password != $confirm_password){
               $this->session->set_flashdata('error','New Password is not Matched With Confirm Password'); 
              //  redirect($_SERVER['HTTP_REFERER']);
              redirect($this->agent->referrer());    
          }else{
               $this->basic_operation->updateDetails('users',array('password'=>$new_password),array('id'=>$user_id));
               $this->session->set_flashdata('success','Profile Updated Successfully...'); 
              //  redirect($_SERVER['HTTP_REFERER']);
              redirect($this->agent->referrer()); 
          }
          }
      }
      $this->load->view('admin/changepassword');
    }
    public function updateProfileImg()
    {
      $auth = $this->session->userdata;
      $user_id=$auth['id'];      
      if(!empty($_FILES['image_file']['name']) && !empty($_FILES['image_file']['tmp_name'])){
      $config['upload_path'] = './uploads/admins/';
      $config['allowed_types'] = 'jpeg|jpg|png';
      $config['encrypt_name'] = TRUE;
      $this->load->library('upload', $config);
      if (!$this->upload->do_upload('image_file')) {
           $error = array('error' => $this->upload->display_errors());
           $data["fetch_data"] = $this->basic_operation->selectData('galleries');   
           $data['error']=$error; 
           $this->db->where('id',$user_id);
           $data['row']=$this->db->get('users')->result_array();
            
           $this->load->view("admin/profile", $data);
           
           } else{
           $d = $this->upload->data();
           $data=array(
                'user_image'=>$d['file_name'],
                'name'=>$this->input->post('name'),
                'mobile'=>$this->input->post('mobile')
           );
           $this->basic_operation->updateDetails('users',$data,array('id'=>$user_id));
           $image=$this->input->post('prev_image_file');
           if($image !='default_user.png'){
           $img_path=base_url().'uploads/admins/'.$image;
        //   unlink($img_path);
           }
           $this->session->set_flashdata('success','Profile details updated successfully...'); 
           //  redirect($_SERVER['HTTP_REFERER']);
           redirect(site_url().'admin/profile/');      
        }

      }else{
        $data=array(
          'name'=>$this->input->post('name'),
          'mobile'=>$this->input->post('mobile')
        );
        $this->basic_operation->updateDetails('users',$data,array('id'=>$user_id));
        $this->session->set_flashdata('success','Profile details updated successfully...'); 
        //  redirect($_SERVER['HTTP_REFERER']);
        redirect(site_url().'admin/profile/');      
      }

    }
    public function approveUser($user_id,$status)
    {
        $data=array(
          'banned_users'=>$status
        );
        $this->basic_operation->updateDetails('users',$data,array('id'=>$user_id));
        $this->session->set_flashdata('success','Status Updated Successfully...'); 
         redirect($_SERVER['HTTP_REFERER']);
        // redirect(site_url().'admin/admins/');

    }
    
    public function updateWebContents()
    {
        $this->db->where(['id'=>1]);
        $data['webContents']=$this->db->get('web_contents')->first_row();

        $this->load->view('admin/updateWebContents',$data);
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $form_data=array(
                'header_text_title'=>$this->input->post('header_text_title'),
                'header_text_description'=>$this->input->post('header_text_description'),
                'footer_email'=>$this->input->post('footer_email'),
                'footer_contact'=>$this->input->post('footer_contact'),
                'footer_address'=>$this->input->post('footer_address'),
                ); 
            if($this->input->post('updatecontents')){
               $this->db->where('id', 1);
               if($this->db->update('web_contents', $form_data)){
          
               $this->session->set_flashdata('success','Contents Updated Successfully'); 
               redirect($this->agent->referrer());
               }
            }
        }
    }
    
    public function customers(){  
           $this->db->select('*');
           $this->db->from('users');
           $this->db->where('role','3');
           $this->db->order_by('id','desc');
           $data["fetch_data"] = $this->db->get()->result();
           $data['user_type']='customers';
           $this->load->view("admin/index",$data);  
     } 
      public function approval($id)
      {
          $data["user_data"] = $this->basic_operation->Uniqueselect('users',array('id'=>$id)); 
          $this->basic_operation->updateDetails('users',array('status'=>'approved'),array('id'=>$id));
          $this->load->library('email');
          $this->load->library('sendmail');
          $this->load->library('notifications');
          $this->email->initialize($this->sendmail->config());
          $this->email->from('support@yaldafresh.com', 'no-reply'); 
          $device_key=$data['user_data'][0]->fcm_token;
          
          if(!empty($device_key)){
            $tokens=array($device_key);
            // For android
            $message='';
            $message.='Hi '.$data['user_data'][0]->name.' , Now Enjoy the Shopping...';
            $dataAndroid=array("title"=>"Account Approved", "text"=>"$message",'type'=>'account'); 
            $res=$this->notifications->send_push_notification_data($tokens,$dataAndroid);
          }
          
          $message='';
          $message .= 'Dear, '.$data['user_data'][0]->name.'<br>';
          $message .= '<br>';
          $message .= 'Thank you for Registrition with Ashamart!';
          $message .= 'Now you can enjoy Shopping at our website <a href="https://www.yaldafresh.com/">Ashamart</a> <br><br>';
          $message .= 'Happy Shopping and Enjoy responsibily <br><br><br>';
          $message .= 'Regards,<br>';
          $message .= 'Ashamart Team';
          $this->email->to($data['user_data'][0]->email);
          $this->email->subject('Account Approval');
          $this->email->message($message);
          $this->email->set_mailtype("html");
          if($this->email->send()){
          $this->session->set_flashdata('success','Customer Approved Successfully.');
             redirect(base_url() . "admin/customers");
          }else{
          $this->session->set_flashdata('error','There is Problem to send mail'); 
             redirect(base_url() . "admin/customers");
          }
         
     }
    public function updateStatus($status,$order_id,$user_id)
    {
         $this->basic_operation->updateDetails('bookings',array('status'=>$status),array('order_id'=>$order_id));
         $this->load->library('notifications');
         $data["user_data"] = $this->basic_operation->Uniqueselect('users',array('id'=>$user_id)); 
         $data["notification"] = $this->basic_operation->Uniqueselect('notifications',array('user_id'=>$user_id)); 
         if(!empty($data['user_data'])){
         @$device_key=$data['user_data'][0]->fcm_token;
         if(!empty($device_key)){
            $tokens=array($device_key);
            // For android
            $message='';
            if(@$data["notification"][0]->processing==1){
            if($status=='1'){
                $message='Your Order has been Accepted from Ashamart';
                $dataAndroid=array("title"=>"Order Status", "text"=>$message,'type'=>'order'); 
                $res=$this->notifications->send_push_notification_data($tokens,$dataAndroid);
            }
            }
            if(@$data["notification"][0]->delivered==1){
            if($status=='2'){
              $message='Your Order has been Delivered from Ashamart'; 
              $dataAndroid=array("title"=>"Order Status", "text"=>$message,'type'=>'order'); 
              $res=$this->notifications->send_push_notification_data($tokens,$dataAndroid);
            }
            }
            if(@$data["notification"][0]->processing==1){
            if($status=='3'){
              $message='Your Order has been Cancelled By Ashamart'; 
              $dataAndroid=array("title"=>"Order Status", "text"=>$message,'type'=>'order'); 
              $res=$this->notifications->send_push_notification_data($tokens,$dataAndroid);
            }
            }
            
          }
        }
         $this->session->set_flashdata('success','Status Updated  Successfully.');
         redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function booking_details($booking_id,$user_id){
          $data = $this->session->userdata;
          if($data['role']==1){
                $this->db->select('bookings.*,products.*,products.image,address_books.*,bookings.quantity as cart_product_quantity,products.name as product_name,customer.name as  customer_name,customer.dob,customer.mobile,customer.email,coupons.*');
                $this->db->from('bookings');
                $this->db->join('products', 'products.id = bookings.product_id');
                $this->db->join('users as customer', 'customer.id = bookings.user_id');
                $this->db->join('address_books', 'address_books.id = bookings.address_id','left');
                $this->db->join('coupons', 'coupons.coupon_id = bookings.coupon_id','left');
                $this->db->where(array('bookings.user_id'=>$user_id,'bookings.order_id'=>$booking_id,'bookings.product_type'=>'1'));
                $data= $this->db->get()->result();
           
                $this->db->select('bookings.*,offers.*,offers.image,address_books.*,bookings.quantity as cart_product_quantity,offers.name as product_name,customer.name as  customer_name,customer.dob,customer.mobile,customer.email,coupons.*');
                $this->db->from('bookings');
                $this->db->join('offers', 'offers.id = bookings.product_id');
                $this->db->join('users as customer', 'customer.id = bookings.user_id');
                $this->db->join('address_books', 'address_books.id = bookings.address_id','left');
                $this->db->join('coupons', 'coupons.coupon_id = bookings.coupon_id','left');
                $this->db->where(array('bookings.user_id'=>$user_id,'bookings.order_id'=>$booking_id,'bookings.product_type'=>'2'));
                $data2= $this->db->get()->result();
           
                $this->db->select('bookings.*,promotional.*,promotional.image,address_books.*,bookings.quantity as cart_product_quantity,promotional.name as product_name,customer.name as  customer_name,customer.dob,customer.mobile,customer.email,coupons.*');
                $this->db->from('bookings');
                $this->db->join('promotional', 'promotional.id = bookings.product_id');
                $this->db->join('users as customer', 'customer.id = bookings.user_id');
                $this->db->join('address_books', 'address_books.id = bookings.address_id','left');
                $this->db->join('coupons', 'coupons.coupon_id = bookings.coupon_id','left');
                $this->db->where(array('bookings.user_id'=>$user_id,'bookings.order_id'=>$booking_id,'bookings.product_type'=>'3'));
                $data3= $this->db->get()->result();
                $Data['fetch_data']=array_merge($data,$data2,$data3);
                foreach($Data['fetch_data'] as $item){
                if($item->coupon_id==null){
                    $item->coupon_id=0;
                    $item->coupon_code='';
                    $item->coupon_title='';
                    $item->discount_percentage=0;
                }
                if($item->address_id==0){
                    $item->address=$item->web_address;
                    $item->landmark=$item->web_landmark;
                    $item->mobile=$item->web_mobile;
                    $item->name=$item->web_name;
                }
                
            }
            $this->load->view('admin/booking_details', $Data);
          
      }
    }
      
      public function deleteUser($user_id)
      {
       $user_data=$this->basic_operation->Uniqueselect('users',array('id'=>$user_id)); 
       if(!empty($user_data)){
           $this->basic_operation->deleteData('carts',array('user_id'=>$user_id));
           $this->basic_operation->deleteData('bookings',array('user_id'=>$user_id));
           $this->basic_operation->deleteData('address_books',array('user_id'=>$user_id));
           $this->basic_operation->deleteData('wishlists',array('user_id'=>$user_id));
           $this->basic_operation->deleteData('users',array('id'=>$user_id));
       }
       $this->session->set_flashdata('success','User Data Deleted Successfully...'); 
       redirect($_SERVER['HTTP_REFERER']);
      
    }
    
    public function view($id){
        $detail = $this->session->userdata;
        if($detail['role']==1){
                $this->db->select('bookings.*,SUM(bookings.price) as TotalBookingPrice,SUM(bookings.quantity) as TotalProductQty,customer.name as  customer_name,bookings.address as delivery_address,products.name as product_name');
                $this->db->from('bookings');
                $this->db->join('products', 'products.id = bookings.product_id');
                $this->db->join('users as customer', 'customer.id = bookings.user_id');
                $this->db->group_by(['bookings.order_id','bookings.user_id','bookings.booking_date']);
                $this->db->where(array('bookings.user_id'=>$id));
                
                $data['fetch_data'] = $this->db->get()->result(); 
                foreach($data['fetch_data'] as $item){
                if($item->coupon_id==null){
                    $item->coupon_id=0;
                    $item->coupon_code='';
                    $item->coupon_title='';
                    $item->discount_percentage=0;
                }
                if($item->address_id==0){
                    $item->address=$item->web_address;
                    $item->landmark=$item->web_landmark;
                    $item->mobile=$item->web_mobile;
                    $item->name=$item->web_name;
                }
                }
                
            } 
        $data["user"] = $this->basic_operation->Uniqueselect('users',array('id'=>$id));
        $this->load->view('admin/user_details', $data);
    }


 } 