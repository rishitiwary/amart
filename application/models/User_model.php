<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public $status; 
    public $roles;
    
    function __construct(){
        // Call the Model constructor
        parent::__construct();        
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
        $this->banned_users = $this->config->item('banned_users');
    }    
    
    //insert user into database
    public function insertUser($d)
    {  
            $string = array(
                'name'=>$d['name'],
                'mobile'=>$d['mobile'],
                'email'=>$d['email'],
                'password'=>$d['password'],
                'role'=>$d['role'], 
                'status'=>$this->status[0],
                'banned_users'=>$this->banned_users[1]
            );
            $q = $this->db->insert_string('users',$string);             
            $this->db->query($q);
            return $this->db->insert_id();
    }
    
    //check is duplicate
    public function isDuplicate($email)
    {     
        $this->db->get_where('users', array('email' => $email), 1);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;         
    }
    
    //insert the token
    public function insertToken($user_id)
    {   
        $token = substr(sha1(rand()), 0, 30); 
        $date = date('Y-m-d');
        
        $string = array(
                'token'=> $token,
                'user_id'=>$user_id,
                'created'=>$date
            );
        $query = $this->db->insert_string('tokens',$string);
        $this->db->query($query);
        return $token . $user_id;
        
    }
    
    //check if token is valid
    public function isTokenValid($token)
    {
       $tkn = substr($token,0,30);
       $uid = substr($token,30);      
       
        $q = $this->db->get_where('tokens', array(
            'tokens.token' => $tkn, 
            'tokens.user_id' => $uid), 1);                         
               
        if($this->db->affected_rows() > 0){
            $row = $q->row();             
            
            $created = $row->created;
            $createdTS = strtotime($created);
            $today = date('Y-m-d'); 
            $todayTS = strtotime($today);
            
            if($createdTS != $todayTS){
                return false;
            }
            
            $user_info = $this->getUserInfo($row->user_id);
            return $user_info;
            
        }else{
            return false;
        }
        
    }    
    
    //get user info
    public function getUserInfo($id)
    {
        $q = $this->db->get_where('users', array('id' => $id), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$id.')');
            return false;
        }
    }
    
    //getUserName
    public function getUserAllData($email)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email );
        $query = $this->db->get();

        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            return $row;
        }
        else
        {
            error_log('no user found getUserAllData('.$email.')');
            return false;
        }
    }
    
    //update data user
    public function updateUserInfo($post)
    {
        $data = array(
               'last_login' => date('Y-m-d h:i:s A'), 
               'status' => $this->status[1]
            );
        $this->db->where('id', $post['user_id']);
        $this->db->update('users', $data); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            error_log('Unable to updateUserInfo('.$post['user_id'].')');
            return false;
        }
        
        $user_info = $this->getUserInfo($post['user_id']); 
        return $user_info; 
    }
    
    //check login
    public function checkLogin($post)
    {
        $this->load->library('password');       
        $this->db->select('*');
        $this->db->where('email', $post['email']);
        $this->db->where('role', 1);
        $query = $this->db->get('users');
        $userInfo = $query->row();
        $count = $query->num_rows();
        
        if($count == 1){
            if(!$this->password->validate_password($post['password'], $userInfo->password))
            {
                error_log('Unsuccessful login attempt('.$post['email'].')');
                return false;
            }else{
                $my_token=$this->updateLoginTime($userInfo->id,$userInfo->email,$post['fcm_token']);
            }
        }else{
            error_log('Unsuccessful login attempt('.$post['email'].')');
            return false;
        }
        
        $this->db->where('email', $post['email']);
        $query = $this->db->get('users');
        $userInfo = $query->row();
        return $userInfo; 
    }
     public function checkLogin_appuser($post)
    {
        $this->load->library('password');       
        $this->db->select('*');
        $this->db->where('email', $post['email']);
        $query = $this->db->get('users');
        $userInfo = $query->row();
        $count = $query->num_rows();
        
        if($count == 1){
            if(!$this->password->validate_password($post['password'], $userInfo->password))
            {
                error_log('Unsuccessful login attempt('.$post['email'].')');
                return false;
            }else{
                $my_token=$this->updateLoginTime($userInfo->id,$userInfo->email,$post['fcm_token']);
            }
        }else{
            error_log('Unsuccessful login attempt('.$post['email'].')');
            return false;
        }
        
        $this->db->where('email', $post['email']);
        $query = $this->db->get('users');
        $userInfo = $query->row();
        return $userInfo; 
    }
    //update time login
    public function updateLoginTime($id,$email,$fcm)
    {   
        $token=md5(uniqid().$this->base64url_encode($email));
        $token = hash ("sha256", $token);
        $this->db->where('id', $id);
        $this->db->update('users', array('last_login' => date('Y-m-d h:i:s A'),
                                         'token'=>$token,
                                         'fcm_token'=>$fcm,
                                    ));
        return $token;
    }

    // encription token 
    public function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    //get user from email
    public function getUserInfoByEmail($email)
    {
        $q = $this->db->get_where('users', array('email' => $email), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$email.')');
            return false;
        }
    }
    
    //update password
    public function updatePassword($post)
    {   
        $this->db->where('id', $post['user_id']);
        $this->db->update('users', array('password' => $post['password'])); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            error_log('Unable to updatePassword('.$post['user_id'].')');
            return false;
        }        
        return true;
    } 
    
    //add user login
    public function addUser($d)
    {  
            $string = array(
                'first_name'=>$d['firstname'],
                'last_name'=>$d['lastname'],
                'email'=>$d['email'],
                'password'=>$d['password'], 
                'role'=>$d['role'], 
                'status'=>$this->status[1]
            );
            $q = $this->db->insert_string('users',$string);             
            $this->db->query($q);
            return $this->db->insert_id();
    }
    
    //update profile user
    public function updateProfile($post)
    {   
        $this->db->where('id', $post['user_id']);
        $this->db->update('users', array('password' => $post['password'], 'email' => $post['email'], 'name' => $post['name'])); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            error_log('Unable to updatePassword('.$post['user_id'].')');
            return false;
        }        
        return true;
    }
    
    //update user level
    public function updateUserLevel($post)
    {   
        $this->db->where('email', $post['email']);
        $this->db->update('users', array('role' => $post['level'])); 
        $success = $this->db->affected_rows();
        
        if(!$success){
            return false;
        }        
        return true;
    }
    
    //update user ban
    public function updateUserban($post)
    {   
        $this->db->where('email', $post['email']);
        $this->db->update('users', array('banned_users' => $post['banuser'])); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            return false;
        }        
        return true;
    }
    
    //get email user
    public function getUserData()
    {   
        $query = $this->db->get('users');
        return $query->result();
    }
    
    //delete user
    public function deleteUser($id)
    {   
        $this->db->where('id', $id);
        $this->db->delete('users');
        
        if ($this->db->affected_rows() == '1') {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
    
    //get settings
    public function getAllSettings()
    {
        $this->db->select('*');
        $this->db->from('settings');
        return $this->db->get()->row();

    }
    
    //do change settings
    public function settings($post)
    {   
        $this->db->where('id', $post['id']);
        $this->db->update('settings', 
            array(
                'site_title' => $post['site_title'], 
                'timezone' => $post['timezone'],
                'recaptcha' => $post['recaptcha'],
                'theme' => $post['theme']
            )
        ); 
        $success = $this->db->affected_rows(); 
        if(!$success){
            return false;
        }        
        return true;
    }
}
