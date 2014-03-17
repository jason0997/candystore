<?php
class OrderItem_model extends CI_Model {
     function __construct() 
     {
           parent::__construct(); 
			$this->load->model('OrderItem');
           $this->load->database();
     }

	function getAll()
	{  
		$query = $this->db->get('order_item');
		return $query->result('OrderItem');
	}  
	
	function get($id)
	{
		$query = $this->db->get_where('order_item',array('id' => $id));
		
		return $query->row(0,'OrderItem');
	}
	
	function delete($id) {
		return $this->db->delete("order_item",array('id' => $id ));
	}
	
	function insert($OrderItem) {
		return $this->db->insert("order_item", array('order_id' => $OrderItem->order_id,
				                                  'product_id' => $OrderItem->product_id,
											      'quantity' => $OrderItem->quantity));
	}
	 
	function update($OrderItem) {
		$this->db->where('id', $OrderItem->id);
		return $this->db->update("order_item", array('order_id' => $OrderItem->order_id,
				                                  'product_id' => $OrderItem->product_id,
											      'quantity' => $OrderItem->quantity));
	}
	
	
}
?>