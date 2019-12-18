<?php

	 /* 

    *Project name : API for Android and IOS guys
    *Date : 12/08/2019
    *Auther : SASIDHARAN
    *Project owner : KUMARESAN
    */

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_controller extends CI_Controller {

	  	public function __construct()
		{
		parent::__construct();
				
		$this->load->library('form_validation'); //For Form Validation

		$this->load->helper(array("url","form")); //For URL Redirection

		$this->load->library('session');// Session library

		$this->load->model(array("Dashboard_model","Map_data_model","Api_model"));
		
		}

	// admin login name:sasi date:19/08/2019


	  public function login()
	  {
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[2]|max_length[50]|regex_match[/^[a-zA-Z ]*$/]',
			array('required'=>"Username is Required"),
			array('regex_match'=>"Only Letters and Spaces Are Allowed")
			);

		$this->form_validation->set_message("min_length","The length of your name is too short atleast 2 letters required");
		$this->form_validation->set_message("max_length","The length of your name is too long");


		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[16]',
			array('required'=>"Password is Required")
			);
		$this->form_validation->set_message("min_length","The length of your password is too short atleast 4 charecters are  required");
		$this->form_validation->set_message("max_length","The length of your password is too long");


		if ($this->form_validation->run() === FALSE) 
		{
			if(isset($_SESSION["username"]))
			{
				redirect('all_users');
			}
		    $this->load->view('login');
        } 
        else 
        {
        	$username=$this->input->post("username");
        	$password=$this->input->post("password");
        	$password=md5($password);
        	$data=array("username"=>$username,"password"=>$password);
        	$userData=$this->Dashboard_model->login_verification($data);
     		if(count($userData)==0)
     		{
     			echo "Invalid Username And Password";
     			$this->load->view("login");
     		}
     		else
     		{
     			$this->session->set_userdata('username', $this->input->post("username"));
				redirect('all_users');
     		}
        }
	}

	// list all users name:sasi date:19/08/2019

	public function all_users()
	{
		if($_SESSION["username"]=="")
		{
			redirect('login');
		}
		$allUsers=$this->Dashboard_model->getAllUsers();
		$alldata["data"]=$allUsers;
		$this->load->view("allusers",$alldata);
	}

	// viewlocations name:sasi date:19/08/2019

	public function viewlocations()
	{
		if($_SESSION["username"]=="")
		{
			redirect('login');
		}

		$current_id=$this->input->get("id");
		if($current_id=="")
		{
			redirect('login');
		}
		$current_user=$this->Api_model->getDetails($current_id);
		$location=$this->Map_data_model->findIdExits($current_id);
		$loc['location']=$location;
		$loc['user']=$current_user;
		$this->session->set_userdata('id', $current_id);
		$this->load->view("viewlocations",$loc);
	}

	// ajax name:sasi date:19/08/2019

	public function ajax()
    {
        if ($_SESSION["username"] == "") {
            redirect('login');
        }
        $id = $this->input->get("user_id");
        $lastData = $this->Map_data_model->findIdExits($id);
        if (!empty($lastData)) {
            $previousData = $lastData[0]->loc->cor;
            $arr = end($previousData);
            echo json_encode($arr);
        }
    }

    public function pagination()
    {
    	$limit=$this->input->get('limit');
    	$skip=$this->input->get('skip');
        $current_user=$this->Dashboard_model->getAllUsers2($skip,$limit);
        echo json_encode($current_user);
    }

	// logout name:sasi date:19/08/2019

	public function logout()
	{
		session_destroy();
		redirect('login');
	}
}