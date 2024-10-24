<?php

defined('BASEPATH') or exit('No direct script access allowed');

class AdminDetails extends CI_model
{

	function __Construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
		$this->load->helper('url');
	}

	function fetch_all()
	{

		$query = $this->db->query("select * from vendor_type_tb order by id");
		return $query->result();
	}
	function fetchAll($table)
	{

		$query = $this->db->query("select * from $table order by id desc");
		return $query->result();
	}
	function viewvendor()
	{

		$query = $this->db->query("SELECT vendor_type_tb.name,
vendor_tb.vendorid,vendor_tb.vname,vendor_tb.email,
vendor_tb.phone,vendor_tb.cdate,vendor_tb.id,vendor_tb.status
FROM vendor_type_tb
INNER JOIN vendor_tb ON vendor_type_tb.id=vendor_tb.type");
		return $query->result();
	}
	function viewsinglevendor()
	{
		$id = $_GET['id'];

		$query = $this->db->query("select * from vendor_tb where id='$id'");
		return $query->result();
	}

	public function insertData($table, $data)
	{

		$this->db->insert($table, $data);
		//   echo $this->db->last_query();
		return true;
	}
	public function add_vendor_type($table, $data)
	{

		//$this->load->database();
		$this->db->insert($table, $data);

		//if ($query) {
		return true;
	}
	function Updatevendortype($user_id, $data)
	{

		$this->db->where("id", $user_id);
		$query = $this->db->update("vendor_type_tb", $data);
		if ($query) {
			$response["message"] = "Updated Successfully";
			$this->session->set_flashdata('msg', 'Vendor type updated successfully');
		} else {
			$response["status"] = "0";
			$response["message"] = "Failed. Try again later";
			$this->session->set_flashdata('msg', 'Error occured');
		}
		return $response;
	}
	function delete($id)
	{
		$query = $this->db->query("delete  from vendor_type_tb where id='" . $id . "'");
		if ($query) {

			$response["message"] = "Deleted Successfully";
		} else {

			$response["status"] = "0";
			$response["message"] = "Failed. Try again later";
		}
		return $response;
		exit;
	}

	function deleteval($table, $id)
	{
		$query = $this->db->query("delete  from $table where id='" . $id . "'");
		if ($query) {

			$response["message"] = "Deleted Successfully";
		} else {

			$response["status"] = "0";
			$response["message"] = "Failed. Try again later";
		}
		return $response;
		exit;
	}
	function UpdateData($uid, $data, $table)
	{

		$this->db->where("id", $uid);
		$query = $this->db->update($table, $data);
		// echo $this->db->last_query();
		if ($query) {

			$this->session->set_flashdata('msg', 'Updated successfully');
		} else {
			$this->session->set_flashdata('msg', 'Error occured');
		}
	}

	function upodatevendor($table, $data, $uid)
	{

		$this->db->where("id", $uid);
		$query = $this->db->update($table, $data);
		if ($query) {
			$response["message"] = "Updated Successfully";
			$this->session->set_flashdata('msg', 'Vendor type updated successfully');
		} else {
			$response["status"] = "0";
			$response["message"] = "Failed. Try again later";
			$this->session->set_flashdata('msg', 'Error occured');
		}
		return $response;
	}
	function selectData($table, $limit = null)
	{
		$this->db->limit($limit);
		$this->db->order_by("id", "desc");
		return $this->db->get($table)->result();
	}
	function updateDetails($table, $data, $where)
	{
		return $this->db->update($table, $data, $where);
	}
	public function updateBannerstatus($id, $status)
	{
		$data = array(
			'status' => $status,
		);
		$this->db->where('id', $id);
		$this->db->update('galleries', $data);
		return true;
	}
	function deleteData($table, $where)
	{
		$this->db->where($where);
		$this->db->delete($table);
	}
	function Uniqueselect($table, $conditions, $limit = null, $flag = false)
	{
		if ($flag === true) {
			$this->db->order_by('id', 'desc');
		}
		$this->db->limit($limit);
		return $this->db->where($conditions)->get($table)->result();
	}

	function fetchSecondCat()
	{

		$query = $this->db->query("SELECT second_categories_tb.categoriessecond,
second_categories_tb.catid,second_categories_tb.status,second_categories_tb.id,categories_tb.categories 
FROM second_categories_tb
INNER JOIN categories_tb ON categories_tb.id=second_categories_tb.catid");
		return $query->result();
	}
	function fetchthirdcat()
	{

		$query = $this->db->query("SELECT second_categories_tb.categoriessecond,
	third_categories_tb.catid,third_categories_tb.status,third_categories_tb.id,third_categories_tb.thirdcategories,third_categories_tb.second_catid,categories_tb.categories 
	FROM ((third_categories_tb
	INNER JOIN second_categories_tb ON second_categories_tb.id=third_categories_tb.second_catid)
	INNER JOIN categories_tb ON third_categories_tb.catid=categories_tb.id)
	");
		return $query->result();
	}
	function fetchfourthcat()
	{

		$query = $this->db->query("SELECT second_categories_tb.categoriessecond,
	fourth_categories_tb.catid,fourth_categories_tb.status,fourth_categories_tb.id,fourth_categories_tb.third_catid,
	fourth_categories_tb.second_catid,categories_tb.categories,
	third_categories_tb.thirdcategories,fourth_categories_tb.fourthcategories 
	FROM (((fourth_categories_tb
	INNER JOIN second_categories_tb ON second_categories_tb.id=fourth_categories_tb.second_catid)
	INNER JOIN categories_tb ON fourth_categories_tb.catid=categories_tb.id)
	INNER JOIN third_categories_tb ON third_categories_tb.id=fourth_categories_tb.third_catid)
	");
		return $query->result();
	}
	function fetchfifthcat()
	{

		$query = $this->db->query("SELECT second_categories_tb.categoriessecond,
	fifth_categories_tb.catid,fifth_categories_tb.status,fifth_categories_tb.id,
	fifth_categories_tb.third_catid,fifth_categories_tb.fourth_catid,
	fifth_categories_tb.second_catid,fifth_categories_tb.fifthcat,categories_tb.categories,
	third_categories_tb.thirdcategories,fourth_categories_tb.fourthcategories 
	FROM ((((fifth_categories_tb
	INNER JOIN second_categories_tb ON second_categories_tb.id=fifth_categories_tb.second_catid)
	INNER JOIN categories_tb ON fifth_categories_tb.catid=categories_tb.id)
	INNER JOIN third_categories_tb ON third_categories_tb.id=fifth_categories_tb.third_catid)
	INNER JOIN fourth_categories_tb ON fourth_categories_tb.id=fifth_categories_tb.fourth_catid)
	");
		return $query->result();
	}

	function fetchlimit($table, $limit)
	{

		$query = $this->db->query("select * from $table order by id desc limit '$limit'");
		return $query->result();
	}
	function fetchSinglesecond($table, $id)
	{

		$query = $this->db->query("select * from $table where second_catid='$id'");
		return $query->result();
	}
	function fetchSingle($table, $id)
	{

		$query = $this->db->query("select * from $table where id='$id'");
		return $query->result();
	}

	function fetchFourth($table, $id)
	{

		$query = $this->db->query("select * from $table where third_catid='$id'");
		return $query->result();
	}
	function fetchSingleById($table, $id, $col)
	{

		$query = $this->db->query("select * from $table where $col='$id'");
		return $query->result();
	}
	function fetchCols($table, $cols, $con)
	{

		$query = $this->db->query("select $cols from $table where $con");
		return $query->result();
	}
}
