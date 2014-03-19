<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends CI_Controller {

    function __construct() {
		parent::__construct();
		$config['upload_path'] = './images/product/';
		$config['allowed_types'] = 'gif|jpg|png';
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');			
		$this->load->library('upload',$config);
		$this->load->model("product_model");
		$this->load->model("Product");
    }
	public function index(){
		$userInfo = $this->session->userdata('userInfo');
		$errmsg = $this->session->userdata('errmsg');
		if(isset($errmsg)){
			$data['exists'] = $errmsg;
			$this->session->set_userdata('errmsg', '');
		}
		if(empty($userInfo['loginName']))
			redirect('login');
		else{
			$products = $this->product_model->getAll();
			$data['products']=$products;
			$data['userInfo']=$userInfo;
			$this->load->view('main_page',$data);
		}
	}
	
	
	public function logout(){
		$this->session->set_userdata('userInfo',array('loginName' => '', 'password' => '', 'first' => '', 'last' => ''));
		redirect('login');
	}

	public function admin_main(){
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']) || $userInfo['loginName']!="admin")
			redirect('login');
		if($this->input->post('Delete') == true){
			redirect('base/delete_all_info');
		}
		$this->load->view('admin_page');
	}
	
	
	public function product_management(){			
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']) || $userInfo['loginName']!="admin")
			redirect('login');
		$this->load->model('product_model');
		$this->load->model('Product');
		$products = $this->product_model->getAll();
		$data['products']=$products;
		$this->load->view('product_manage_page',$data);
	}
	
	
	public function display_order(){
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']) || $userInfo['loginName']!="admin")
			redirect('login');	
		$this->load->model('order_model');
		$orders = $this->order_model->getAll();
		$orders_view_array = array();
		$orders_view_item = array();
		foreach ($orders as $order){
			$orders_view_item['order_id'] = $order->id;
			$orders_view_item['order_date'] = $order->order_date;
			$orders_view_item['order_time'] = $order->order_time;
			$orders_view_item['total'] = $order->total;
					
			array_push($orders_view_array, $orders_view_item);
		}		
		$data['orders_view_array'] = $orders_view_array;
		$this->load->view('display_order_page', $data);		
	}
	function admin_vieworder($id){
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']) || $userInfo['loginName']!="admin")
			redirect('login');	
		$this->load->model('orderitem_model');
		$this->load->model('orderitem');
		$orderitems = $this->orderitem_model->get_order($id);
		$products = array();
		foreach ($orderitems as $orderitem){
			$product['product_id'] = $orderitem->product_id;
			$temp_product = $this->product_model->get($product['product_id']);
			$product['name'] = $temp_product->name;
			$product['number'] = $orderitem->quantity;
 			
			array_push($products, $product);
		}
		$data['id'] = $id;
		$data['products'] = $products;
		$this->load->view('order_detail_page',$data);
	}
	function delete_all_info(){
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']) || $userInfo['loginName']!="admin")
			redirect('login');	
			
		$this->load->model('orderitem_model');
		$this->load->model('order_model');
		$this->load->model('customer_model');
		$this->customer_model->delete_all();
		$this->order_model->delete_all();
		$this->orderitem_model->delete_all();
		$this->load->view('delete_all_info_success');		
	}
    
	public function newForm() {
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']) || $userInfo['loginName']!="admin")
			redirect('login');	
    	$this->load->view('product/newForm.php');
    }
	
	public function create() {
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']) || $userInfo['loginName']!="admin")
			redirect('login');	
		$this->load->model('product_model');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required|is_unique[product.name]');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required|numeric');
		$this->form_validation->set_message('is_unique', "Prouct already exists");
		$fileUploadSuccess = $this->upload->do_upload();
		
		if ($this->form_validation->run() == true && $fileUploadSuccess) {
			$this->load->model('product_model');
			$this->load->model('Product');
			$product = new Product();
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$data = $this->upload->data();
			$product->photo_url = $data['file_name'];
			
			$this->product_model->insert($product);

			redirect('base/product_management', 'refresh');
		}
		else {
			if ( !$fileUploadSuccess) {
				$data['fileerror'] = $this->upload->display_errors();
				$this->load->view('product/newForm.php',$data);
				return;
			}
			
			$this->load->view('product/newForm.php');
		}	
	}
	
	function editForm($id) {
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']) || $userInfo['loginName']!="admin")
			redirect('login');	
		$this->load->model('Product');
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('product/editForm.php',$data);
	}
	
	function update($id) {
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']) || $userInfo['loginName']!="admin")
			redirect('login');	
		$this->load->model('product_model');
		$this->load->model('Product');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required|numeric');
				
		if ($this->form_validation->run() == true) {
			$product = new Product();
			$product->id = $id;
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$this->load->model('product_model');
			$result = $this->product_model->update($product);
				
			if($result == false){
				$data['existerror'] = true;
			}else{
				redirect('base/product_management', 'refresh');
			}
		}
		if($this->form_validation->run() == false || $result == false){
			$product = new Product();
			$product->id = $id;
			$product->name = set_value('name');
			$product->description = set_value('description');
			$product->price = set_value('price');
			$data['product']=$product;
			$this->load->view('product/editForm.php',$data);
		}
	}
	
	
	function delete($id) {
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']))
			redirect('login');		
		
		$this->load->model('product_model');
		$this->load->model('Product');
		$product = $this->product_model->get($id);
		chown("./images/product/" . $product->photo_url,465);
		unlink("./images/product/" . $product->photo_url);		
		if (isset($id)) 
			$this->product_model->delete($id);

		//Then we redirect to the index page again
		redirect('base/product_management', 'refresh');
	}
	
	function add_shopping_cart($id){
	   
		$this->load->model("product_model");
		$this->load->model("Product");
		$userInfo = $this->session->userdata('userInfo');
		$shopping_cart = $this->session->userdata('shopping_cart');
		$exist = false;
 		if(empty($userInfo['loginName']))
			redirect('login');		
		if(!empty($shopping_cart)){	
			foreach ($shopping_cart as $exist_item){
				if($id == $exist_item['product_id'])
					$exist = true;
			}
		}
		if(!$exist){
			$data['product'] = $this->product_model->get($id);
			$this->load->view('product/add_shopping_cart_page.php',$data);
		}else{
			$this->session->set_userdata('errmsg',"This item is in the shopping cart!");
			redirect('base');
		}			
	}
	
	function confirm_adding($id){
		$this->load->model("product_model");
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']))
			redirect('login');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('orderNumber','Order Number','required|integer|greater_than[0]');
		$product = $this->product_model->get($id);
		if ($this->form_validation->run() == true){
			$shopping_cart_item = array('product_id'=>$id, 'number'=>$this->input->post('orderNumber'));
			$shopping_cart = $this->session->userdata('shopping_cart');
			array_push($shopping_cart, $shopping_cart_item);
			$this->session->set_userdata('shopping_cart', $shopping_cart);
			$this->load->view('adding_success');
		}else{
			$data['product'] = $product;
			$this->load->view('product/add_shopping_cart_page.php',$data);
		}	
	}
	
	function shopping_cart_main(){
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']))
			redirect('login');	
		$shopping_cart = $this->session->userdata('shopping_cart');		
		$products = array();
		$totalCost = 0;
		if(!empty($shopping_cart)){
			foreach ($shopping_cart as $shopping_cart_item){
				$product = $this->product_model->get($shopping_cart_item['product_id']);
				$item = array();
				array_push($item, $product);			
				array_push($item, $shopping_cart_item['number']);
				array_push($products,$item);
				$totalCost = $totalCost + $item[0]->price * $item[1];
			}		
		}
		$data['products'] = $products;
		$data['totalCost'] = $totalCost;
		$this->load->view('shopping_cart_main_page', $data);
	}
	function remove_item_shopping_cart($id){
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']))
			redirect('login');	
		$shopping_cart = $this->session->userdata('shopping_cart');		
		$result_shopping_cart = array();
		foreach ($shopping_cart as $shopping_cart_item){
			if($shopping_cart_item['product_id'] != $id){
				array_push($result_shopping_cart, $shopping_cart_item);
			}
		}			
		$this->session->set_userdata('shopping_cart', $result_shopping_cart);
		$this->load->view('remove_success');
	}

	function confirm_checkout($status){

		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']))
			redirect('login');		
		$shopping_cart = $this->session->userdata('shopping_cart');		
		if($status == "checkout"){
			$products = array();
			$totalCost = 0;
			foreach ($shopping_cart as $shopping_cart_item){
				$product = $this->product_model->get($shopping_cart_item['product_id']);
				$item = array();
				array_push($item, $product);			
				array_push($item, $shopping_cart_item['number']);
				array_push($products,$item);
				$totalCost = $totalCost + $item[0]->price * $item[1];
			}
			$data['products'] = $products;
			$data['totalCost'] = $totalCost;
			$this->session->set_userdata('totalCost', $totalCost);
			$this->load->view("confirm_checkout_page",$data);
		}else if($status == "confirm"){
			$this->load->view("credit_card_info_page");
		}
	}
	function checkout(){
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']))
			redirect('login');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('ccnumber','Credit Card Number','required|numeric|exact_length[16]');
		$this->form_validation->set_rules('expiredate','Expire Date','required');
		$shopping_cart = $this->session->userdata('shopping_cart');
		$string_date = $this->input->post('expiredate');		
		$pattern = "/^\d{2}\/\d{2}$/";
		$data = array();	
		$current_year = date('y');
		$current_month = date('m');
		$ccnumber =$this->input->post("ccnumber");
		if ($this->form_validation->run() == true){
			$totalCost =  $this->session->userdata('totalCost');
			if(preg_match($pattern, $string_date) && !empty($totalCost)){
				$date = explode('/',$string_date);
				$month = $date[0];
				$year = $date[1];
				if((int)$month > 12 || (int)$month < 1)
					$data['error'] = "Invalid Date(MM/YY).";
				else if((int)$year < $current_year || ((int)$year == $current_year && (int)$month <= $current_month))
					$data['error'] = "Your Credit Card has expired.";									
				else{					
					$this->load->model('order_model');
					$this->load->model('Order');
					$order= new Order();
					$order->customer_id = $userInfo["id"];
					$order->order_date = date("Y-m-d");
					$order->order_time = date("H:i:s");
					$order->total = $totalCost;
					$order->creditcard_number = $ccnumber;
					$order->creditcard_month = $month;
					$order->creditcard_year = $year;
					$order_id= $this->order_model->insert($order);
					foreach ($shopping_cart as $shopping_cart_item){
						$this->load->model('orderitem_model');
						$this->load->model('OrderItem');
						$orderitem= new OrderItem();						
						$orderitem->order_id = $order_id;
						$orderitem->product_id = $shopping_cart_item['product_id'];
						$orderitem->quantity =$shopping_cart_item['number'];
						$this->orderitem_model->insert($orderitem);												
					}
					$this->session->set_userdata('totalCost', '');
					$this->session->set_userdata('shopping_cart', array());
					$data['userInfo']=$userInfo;
					$first_ccnumber =substr($ccnumber, 0,6);
					$second_ccnumber = substr($ccnumber, 12);
					$encryptCCNumber = $first_ccnumber . "******" . $second_ccnumber; 
					$data['encryptCCNumber'] = $encryptCCNumber;
					$data['totalCost'] = $totalCost;
					$data['orderID'] = $order_id;
					$config['protocol'] = 'sendmail';
					$config['mailpath'] = '/usr/sbin/sendmail';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					$config = Array(
						'protocol' => 'smtp',
						'smtp_host' => 'ssl://smtp.googlemail.com',
						'smtp_port' => 465,
						'smtp_user' => 'jasonlu1993@gmail.com',
						'smtp_pass' => 'ca1234567',
						'mailtype'  => 'html', 
						'charset'   => 'iso-8859-1'
					);
					$this->load->view('pay_success', $data);
					$view = $this->load->view('pay_success',NULL,TRUE);
					$this->load->library('email', $config);
					$this->email->set_newline("\r\n");
					$this->email->from('jasonlu1993@gmail.com', 'Candy Store');
					$this->email->to($userInfo['email']); 
					
					$this->email->subject('Candy Store Receipt');
					$this->email->message($view);	
					
					$this->email->send();
				}
			}else if(empty($totalCost)){	
				$data['error'] = "Error! Please go back to the shopping cart page";									
			}else{
				$data['error'] = "The Expire Date should follow the format (MM/YY).";		
			}
			if(isset($data['error']) && !empty($data['error'])){
				$this->load->view('credit_card_info_page',$data);
			}
		}else{
			$this->load->view('credit_card_info_page');
		}
	}
	
	function edit_item_shopping_cart($id){
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']))
			redirect('login');	
		$shopping_cart = $this->session->userdata('shopping_cart');		
		$result_shopping_cart = array();
		foreach ($shopping_cart as $shopping_cart_item){
			if($shopping_cart_item['product_id'] == $id){
				$data['product'] = $this->product_model->get($id);
				$data['number'] = $shopping_cart_item['number'];
			}
		}
		$this->load->view('edit_shopping_cart_item',$data);			
	}

	function update_item_shopping_cart($id){
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']))
			redirect('login');	
		$this->load->library('form_validation');		
		$this->form_validation->set_rules('number','Order Amount','required|integer|greater_than[0]');
		if ($this->form_validation->run() == true){
			$shopping_cart = $this->session->userdata('shopping_cart');		
			$result_shopping_cart = array();
			$newAmount = $this->input->post('number');
			foreach ($shopping_cart as $shopping_cart_item){
				if($shopping_cart_item['product_id'] == $id){
					$shopping_cart_item['number'] = $newAmount;
				}			
				array_push($result_shopping_cart, $shopping_cart_item);			
			}	
			$this->session->set_userdata('shopping_cart',$result_shopping_cart);
			$this->load->view('edit_success');		
		}else{
			$shopping_cart = $this->session->userdata('shopping_cart');		
			$result_shopping_cart = array();
			foreach ($shopping_cart as $shopping_cart_item){
				if($shopping_cart_item['product_id'] == $id){
					$data['product'] = $this->product_model->get($id);
					$data['number'] = $shopping_cart_item['number'];
				}
			}
			$this->load->view('edit_shopping_cart_item', $data);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */