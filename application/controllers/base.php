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
		$this->load->view('admin_page');
	}
	
	
	public function product_management(){			//1. display all products
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
		$this->load->view('display_order_page');		
	}
	
	public function delete_info(){
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']) || $userInfo['loginName']!="admin")
			redirect('login');	
		$this->load->view('delete_success');
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
		foreach ($shopping_cart as $exist_item){
			if($id == $exist_item['product_id'])
				$exist = true;
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
		$this->form_validation->set_rules('orderNumber','Order Number','required|numeric|greater_than[0]');
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
		foreach ($shopping_cart as $shopping_cart_item){
			$product = $this->product_model->get($shopping_cart_item['product_id']);
			$item = array();
			array_push($item, $product);			
			array_push($item, $shopping_cart_item['number']);
			array_push($products,$item);
		}
		$data['products'] = $products;
		$this->load->view('shopping_cart_main_page', $data);
	}
	function remove_item_shopping_cart(){
		$userInfo = $this->session->userdata('userInfo');
		if(empty($userInfo['loginName']))
			redirect('login');	
		
			
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */