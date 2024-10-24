<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Commonmodel extends CI_Model 
{
	function __construct() { 
		parent::__construct(); 


	}
	public function login($username, $password) 
	{
		$this->load->library('password');
		$where = "email = '".$username."'";

		if ($this->count('users', $where) != 1) {

			$msg = "Invalid Email.";
		} else {
			$user = $this->get_by('users', true, $where);
			if (!$this->password->validate_password($password, $user->password)){
				$msg = "Invalid Password";
			
			}elseif (@$user->status != "approved") {

				$msg = "Please Verify Your Email Then Login.";

			}elseif (@$user->banned_users == "ban") {

				$msg = "Your account has been deactivated. Please contact master admin for details.";

			}

			else {

				$msg = "Login";

				$value = array(
					'id'=>$user->id,
					'email'=>$user->email,
					'role' => $user->role,
				);

				$this->session->set_userdata($value);
			}
		}
		return $msg;
	}

	public function get_by($table, $single = False, $where = NULL, $order_by = NULL, $limit = NULL, $offset = NULL)
	{
		if ($where != NULL) {
			$this->db->where($where);
		}

		$this->db->from($table);

		if ($single == FALSE) {
			$method = 'result';
		} else {
			$method = 'row';
		}

		if ($limit != NULL) {
			$this->db->limit($limit);
		}

		if ($offset != NULL) {
			$this->db->offset($offset);
		}

		if ($order_by != NULL) {
			$this->db->order_by($order_by);
		}

		$query = $this->db->get();

		$result = $query->$method();

		return $result;
	}
	
	public function insert($table, $data)
	{
		if($this->db->insert($table, $data))
		{
			return true;
		} else {
			return false;
		}
	}

	public function count($table, $where = NULL)
	{
		if ($where != NULL) {
			$this->db->where($where);
		}
		$this->db->from($table);
		return $this->db->count_all_results();
	}

	public function fetch_all_join_count($query)
	{
		$this->db->query($query);
		return $this->db->count_all_results();  

	}
	public function get_list_pagination($query, $limit=1, $offset=1) 
	{
		$query=$this->db->query($query);
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		return $query->result();   
    }

	public function fetch_all_join($query)
	{
		$query = $this->db->query($query);
		return $query->result();   

	}

	public function fetch_single_join($query)
	{
		$query = $this->db->query($query);
		return $query->row();        
	}

	public function fetch_row($tbl, $where)
	{

		$this->db->select('*');
		$this->db->where($where);
		$query=$this->db->get($tbl);
		return $query->row();

	} 

	public function fetch_all_rows($tbl, $where)
	{
		$this->db->select('*');
		$this->db->where($where);
		$query=$this->db->get($tbl);
		return $query->result();

	}
	public function fetch_all_rows_limit($tbl, $where, $limit= NULL)
	{
		$this->db->select('*');
		$this->db->where($where);
		if ($limit != NULL) {
			$this->db->limit($limit);
		}
		$query=$this->db->get($tbl);
		return $query->result();
	}

	public function delete_single_con($tbl, $where)
	{
		$this->db->where($where);
		$delete = $this->db->delete($tbl); 
		return $delete;

	}

	public function eidt_single_row($tbl,$data, $where)
	{
		$this->db->where($where);
		$this->db->update($tbl,$data);
		return true;

	}

	public function fetch_by_limit_offset($tbl, $where, $limit=null, $offset=NULL)
	{
		$this->db->select('*');
		$this->db->where($where);
		$query=$this->db->from($tbl);
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		return $query->result();
	}

	public function fectch_all_by_cat($cat)
	{
		$this->db->select('products.*,categories.category,products.quantity as stock_quantity,products.id as product_id,categories.id as category_id, categories.parent_category as parent_category_id');
        $this->db->from('products','products.status=1');
        $this->db->join('categories','categories.id=products.category_id');
        //$this->db->where('categories.parent_category !=', 0);
        $this->db->where('products.category_id',$cat);
        $this->db->or_where('categories.parent_category',$cat);
        $query = $this->db->get();
		return $query->result();
	}
	
	public function fectch_all_by_new()
	{
		$this->db->select('products.*,categories.category,products.quantity as stock_quantity,products.id as product_id,categories.id as category_id, categories.parent_category as parent_category_id');
        $this->db->from('products','products.status=1');
        $this->db->join('categories','categories.id=products.category_id');
        $this->db->order_by('products.id',"desc")->limit(12);
        // $this->db->limit('12');
        //$this->db->where('categories.parent_category !=', 0);
        // $this->db->where('products.category_id',$cat);
        // $this->db->or_where('categories.parent_category',$cat);
        $query = $this->db->get();
		return $query->result();
	}
	

}
