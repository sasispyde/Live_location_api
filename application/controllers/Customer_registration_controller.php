<?php 

	 /* 

    *Project name : API for Android and IOS guys
    *Date : 12/08/2019
    *Auther : SASIDHARAN
    *Project owner : KUMARESAN
    */

	require APPPATH . 'libraries/REST_Controller.php';

	class Customer_registration_controller extends REST_Controller
	{
		
		public function __construct()
		{
	        parent::__construct();

	        $this->load->helper(array("function"));

	        $this->load->model(array("Api_model","Registration_model"));

	        // $this->load->model("Registration_model");   

	        $this->validate = $this->config->item('registration');
		}

		public function index_post()
		{
                $input = file_get_contents("php://input");
                $json = decoder($input);
                $name = $json->name;
                $email = $json->email;
                $id=$json->id;

        // To check if the ID is EMPTY or NOT...name:sasi date:12/08/2019  

                if(empty($id)||strlen($id)<24)
                {
	              $res = array(
		                "status" => 0,
		                "message" => "Illegal Access"
		            );
                    $encoded = encoder($res);
                    $this->response($encoded);                }
                else
                {

        // Form Validation...name:sasi date:12/08/2019

                $data=array("name" => $name,"email"=> $email,"id" => $id);

                $this->form_validation->set_data($data);
                $this->form_validation->set_rules($this->validate);

                if ($this->form_validation->run() == false) 
                {
                    $error = $this->form_validation->error_array();
                    $err=array_values($error);
                    $res = array(
                    "status" => 0,
                    "message" => $error
                );
                    $encoded = encoder($res);
                    $this->response($encoded);                }
                else
                {
                	$emailCheck = $this->Registration_model->emailExits($data);

                	if(isset($emailCheck[0]->email))
                	{
                		$res = array(
		                "status" => 3,
		                "message" => "The Email Id is Already Exits"
		              );
                    $encoded = encoder($res);
                    $this->response($encoded);
                    return false;
                	}
                	else
                	{
                		$findUserExits = $this->Api_model->getOtp($data["id"]);

                		if(empty($findUserExits[0]->email))
                		{
	                	$result = $this->Registration_model->user_registration($data);	
	    	            if($result)
	                	{
	                		$resData=$this->Api_model->getDetails($id);
	                		$res = array(
		                    "status" => 1,
		                    "details" => $resData[0],
		                    "message" => "User Successfully Registered"
		                );
                    $encoded = encoder($res);
                    $this->response($encoded);	                	}
                		}
                		else
                		{
                            $resData=$this->Api_model->getDetails($id);
	                		$res = array(
		                    "status" => 2,
                            "details" => $resData[0],
		                    "message" => "The User is Already Registered Connot Update Your details"
			                );
                    $encoded = encoder($res);
                    $this->response($encoded);                		}
                	}
                }
            }
		}
	}
?>