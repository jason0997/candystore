<?php
class Customer_model extends CI_Model {
     function __construct() 
     {
           parent::__construct(); 
		    		$this->load->model('Customer');
           $this->load->database();
     }
	function getAll()
	{
		$query = $this->db->get('customer');
		return $query->result('Customer');
	}  
	
	function get($login)
	{
		$query = $this->db->get_where('customer',array('login' => $login));
		
		return $query->row(0,'Customer');
	}
	
	function delete($id) {
		return $this->db->delete("customer",array('id' => $id ));
	}

	function insert($customer) {
		return $this->db->insert("customer", array('first' => $customer->first,
				                                  'last' => $customer->last,
											      'login' => $customer->login,
											      'password' => $customer->password,
											      'email' => $customer->email));
	}
	 
	function update($customer) {
		$this->db->where('id', $product->id);
		return $this->db->update("product", array('name' => $customer->name,
				                                  'description' => $customer->description,
											      'price' => $customer->price));
	}
	
	
}
?>