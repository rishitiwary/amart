<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Item extends CI_Controller
  { 
      public function __construct()
      {
          parent::__construct();
          $this->load->model("Basic_operation","basic_operation",true);  
          $this->load->library('form_validation'); 
          $this->load->library("pagination");
          $auth = $this->session->userdata;
      } 
 
      public function SearchResult()
      {  
                  $string=$this->input->get('_search');
                  $limit=10;
                  $start=$this->input->get('page')?$this->input->get('page'):0;
                  $start*=$limit;
                  $this->db->select('products.*,categories.*,products.image as image,categories.id as category_id,products.id as id');
                  $this->db->from('products');
                  $this->db->join('categories','categories.id=products.category_id','inner');
                  $this->db->like('products.name',$string,'both');
                  $this->db->or_like('categories.category',$string,'both');
                  $this->db->or_like('products.country',$string,'both');
                  $this->db->order_by('products.id','RANDOM');
                  $this->db->order_by('products.name','asc');
                  $this->db->where(['products.status'=>1,'products.quantity >'=>0,'products.category_id !='=>0]);
                  $this->db->limit($limit, $start);
        
                  $getProduct=$this->db->get()->result();
                  
                  $this->db->select('offers.*,categories.*,offers.image as image,categories.id as category_id,offers.id as id');
                  $this->db->from('offers');
                  $this->db->join('categories','categories.id=offers.category_id','inner');
                  $this->db->like('offers.name',$string,'both');
                  $this->db->or_like('categories.category',$string,'both');
                  $this->db->or_like('offers.country',$string,'both');
                  $this->db->order_by('offers.id','RANDOM');
                  $this->db->order_by('offers.name','asc');
                  $this->db->where(['offers.status'=>1,'offers.quantity >'=>0,'offers.category_id !='=>0]);
                  $this->db->limit($limit, $start);
        
                  $getOffers=$this->db->get()->result();
                  
                  $this->db->select('promotional.*,promotional_category.*,promotional.image as image,promotional_category.id as category_id,promotional.id as id');
                  $this->db->from('promotional');
                  $this->db->join('promotional_category','promotional_category.id=promotional.category_id','inner');
                  $this->db->like('promotional.name',$string,'both');
                  $this->db->or_like('promotional_category.category',$string,'both');
                  $this->db->or_like('promotional.country',$string,'both');
                  $this->db->order_by('promotional.id','RANDOM');
                  $this->db->order_by('promotional.name','asc');
                  $this->db->where(['promotional.status'=>1,'promotional.quantity >'=>0,'promotional.category_id !='=>0]);
                  $this->db->limit($limit, $start);
        
                  $getPromo=$this->db->get()->result();
                  $Data['fetch_data']=array_merge($getProduct,$getOffers,$getPromo);
                  
                  $this->db->select('products.*,categories.*,products.image as image,categories.id as category_id,products.id as id');
                  $this->db->from('products');
                  $this->db->limit(10);
                  $this->db->join('categories','categories.id=products.category_id','left');
                  $this->db->where(['products.status'=>1,'products.quantity >'=>0]);
                  $Data["recommended_data"] = $this->db->get()->result();
               
                  $this->load->view("home/search",$Data);  
      }  
      
      
 } 