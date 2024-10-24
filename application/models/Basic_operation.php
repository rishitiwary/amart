<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Basic_operation extends CI_Model
{


    function insertData($table,$data)
    {
        if($this->db->insert($table,$data)){
        return $this->db->insert_id();
        }
    }
    
    public function get_count($table) 
	{
        return $this->db->count_all($table);
    }
    
    public function matchedRowCount($table,$conditions){
        
        $this->db->where($conditions);
        $this->db->from($table);
        return $this->db->count_all_results();
    }
    
    function selectData($table,$limit=null)
    {   
        $this->db->limit($limit);
        $this->db->order_by("id", "desc");
        return $this->db->get($table)->result();
    }
    function Uniqueselect($table,$conditions,$limit=null,$flag=false)
    {
        if($flag===true){
        $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit);
        return $this->db->where($conditions)->get($table)->result();
    }
    
    

    function selectDataPagination($table,$limit,$start)
    {   
        $this->db->order_by("id", "desc");
        $this->db->limit($limit, $start);
        return $this->db->get($table)->result();
    }
    function UniqueselectPagination($table,$conditions,$limit,$start)
    {
        $this->db->order_by("id", "desc");
        $this->db->limit($limit, $start);
        return $this->db->where($conditions)->get($table)->result();
    }
    
    
    
    function updateDetails($table,$data,$where)
    {         
         return $this->db->update($table, $data,$where);
    }
   
    function deleteData($table,$where)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
    function validateUser($table,$email,$password)
    {
        $array = array('email' => $email, 'password' => $password);
        $data=$this->db->where($array)->get($table);
        if($data->num_rows()==1)
        {
            return true;
        }else
        {
            return false;
        }
         
    }
    function validateEntry($table,$email)
    {
        $array = array('email' => $email);
        $data=$this->db->where($array)->get($table);
        if($data->num_rows()==1)
        {
            return false;
        }else
        {
            return true;
        }
         
    }
    function validateRowExist($table,$conditions)
    {
        $data=$this->db->where($conditions)->get($table);
        if($data->num_rows() > 0)
        {
            return false;
        }else
        {
            return true;
        }
         
    }

} 
?>