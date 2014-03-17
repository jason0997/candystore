<?php
class Order_model extends CI_Model {
     function __construct() 
     {
           parent::__construct(); 
		    		$this->load->model('Order');
           $this->load->database();
     }

	function getAll()
	{  
		$query = $this->db->get('order');
		return $query->result('Order');
	}  
	
	function get($id)
	{
		$query = $this->db->get_where('order',array('id' => $id));
		
		return $query->row(0,'Order');
	}
	
	function delete($id) {
		return $this->db->delete("order",array('id' => $id ));
	}
	
	function insert($order) {
		 $this->db->insert("order", array('customer_id' => $order->customer_id,
				                                  'order_date' => $order->order_date,
											      'order_time' => $order->order_time,
											      'total' => $order->total,
											      'creditcard_number' => $order->creditcard_number,
											      'creditcard_month' => $order->creditcard_month,
												  'creditcard_year' => $order->creditcard_year));
		return mysql_insert_id();
	}
	 
	function update($order) {
		$this->db->where('id', $order->id);
		return $this->db->update("order", array('customer_id' => $order->customer_id,
				                                  'order_date' => $order->order_date,
											      'order_time' => $order->order_time,
											      'total' => $order->total,
											      'creditcard_number' => $order->creditcard_number,
											      'creditcard_month' => $order->creditcard_month,
												  'creditcard_year' => $order->creditcard_year));
	}
	
	
}
?>