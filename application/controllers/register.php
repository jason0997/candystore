<?php

class Register extends CI_Controller {
    function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url')); 
		$this->load->library('session');			
    }
	
    function index() {
			$this->load->view('register_page.php');
    }
	
	function registerCheck(){
		$this->load->model('customer_model');
	//	$customers = $this->customer_model->getAll();
		$registerSuccess = true;
		$data = array();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first','First Name','required');
		$this->form_validation->set_rules('last','Last Name','required');
		$this->form_validation->set_rules('loginName','Login Name','required|is_unique[customer.login]');
		$this->form_validation->set_rules('password','Password','required|min_length[6]|matches[confPwd]');
		$this->form_validation->set_rules('confPwd','Confirm Password','required|min_length[6]');
		$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[customer.email]');	
		$this->form_validation->set_message('is_unique','Account has already existed');
		
		$password = $this->input->post('password');	
		$confPwd = $this->input->post('confPwd');		
		$loginName = $this->input->post('loginName');
		$first = $this->input->post('first');	
		$last = $this->input->post('last');
		$email = $this->input->post('email');	
		$data = array('first' => $first);
		if ($this->form_validation->run() == false) {
			$registerSuccess = false;
		}
		if($registerSuccess){
			$userInfo = array('loginName' => $loginName, 'password' => $password, 'first' => $first, 'last' => $last);
		    $this->load->model('Customer');
    		$this->load->model('customer_model');

			$customer = new Customer();
			$customer->password = $this->input->post('password');	
			$customer->login = $this->input->post('loginName');
			$customer->first = $this->input->post('first');	
			$customer->last = $this->input->post('last');
			$customer->email = $this->input->post('email');
	
			$this->customer_model->insert($customer);
			$this->session->set_userdata('userInfo',$userInfo);
			$this->load->view('register_success');
		}
		else{
			$this->load->view('register_page', $data);
		}
		
	}

}
