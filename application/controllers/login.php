<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
	    	$this->load->helper(array('form', 'url'));
			$this->load->library('session');			    	
    }
	public function index()
	{
		$error = array('error' => " ");
		$userInfo = $this->session->userdata('userInfo');
 		if(empty($userInfo['loginName']))
			$this->load->view('login_page', $error);
		else{
			redirect('base');		
		}
	}
	public function loginCheck(){
		$this->load->model('customer_model');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('loginName','Login Name','required');
		$this->form_validation->set_rules('password','Password','required');
		$password = $this->input->post('password');	
		$loginName = $this->input->post('loginName');

		$customer = $this->customer_model->get($loginName);
		if(count($customer) == 0 || $loginName != $customer->login || $password != $customer->password){
			$error = array('error' => "Your password or login name is incorrect!");
			$this->load->view('login_page', $error);	
		}else if($password == $customer->password && $loginName == "admin"){
			$userInfo = array('loginName' => $loginName, 'password' => $password, 'first' => $customer->first, 'last' => $customer->last);
			$this->session->set_userdata('userInfo',$userInfo);
			redirect('base/admin_main');
		}else if($loginName == $customer->login && $password == $customer->password){
			$userInfo = array('loginName' => $loginName, 'password' => $password, 'first' => $customer->first, 'last' => $customer->last);
			$this->session->set_userdata('userInfo',$userInfo);
			$this->session->set_userdata('shopping_cart', array());
			redirect('base');
		}
		
	}
	public function registerForm(){
		redirect('register');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */