<?php 

     /* 

    *Project name : API for Android and IOS guys
    *Date : 12/08/2019
    *Auther : SASIDHARAN
    *Project omner : KUMARESAN
    */
	
	require APPPATH . 'libraries/REST_Controller.php';
	     
	class Otp_verify_controller extends REST_Controller {

    	public function __construct()
    	{
    		parent::__construct();

    		$this->load->helper(array("function"));

            $this->load->model("Api_model");

            $this->validate = $this->config->item('otp');
    	}

        // to check if the OTP is valid or not...

    	public function index_post()
    	{
    		$input = file_get_contents("php://input");    
            $json = decoder($input);
            $id = $json->id;
            $otp = $json->otp;
            $phone_number =$json->phone_number;

    		$data=array('otp' =>$otp,
    					'id' =>$id,
                        'phone_number'=>$phone_number
    				   );

            // To check if the ID is empty or the length is less then 24...name:sasi,date:13/08/2019

            if(empty($id)||strlen($id)<24)
            {
                $res = array(
                    "status" => 0,
                    "message" => "Illegal Access"
                );
                    $encoded = encoder($res);
                    $this->response($encoded);
            }
            else
            {

            $this->form_validation->set_data($data);
            $this->form_validation->set_rules($this->validate);

            if ($this->form_validation->run() == false) 
            {
                $error = $this->form_validation->error_array();
                $err=array_values($error);
                $res = array(
                "status" => 0,
                "message" => $err
            );
                    $encoded = encoder($res);
                    $this->response($encoded);
            }
            else
            {
                $storedOtp = $this->Api_model->getOtp($data["id"]);
                // To Cheak If the OTP is matching or not

            	if($storedOtp[0]->otp==$otp)
            	{
                    if($storedOtp[0]->status=="B")
                    {
                        $status="A";
                        $this->Api_model->statusUpdater($data,$status);
                    }

                    // To check if the user is exits or not

                    if(isset($storedOtp[0]->email))
                    {
                        $storedOtp = $this->Api_model->getOtp($data["id"]);

                        $res = array(
                        "status" => 2,
                        "details"=>$storedOtp[0],   
                        "message" => "Otp Verified"
                    );
                    $encoded = encoder($res);
                    $this->response($encoded);
                    }
                    else
                    {
                        $storedOtp = $this->Api_model->getOtp($data["id"]);

                        $res = array(
                        "status" => 1,
                        "details"=>$storedOtp[0],   
                        "message" => "Otp Verified"
                    );    
                    $encoded = encoder($res);
                    $this->response($encoded);
                    }
            	}

            	else
            	{
     	       		$res = array(
    	            "status" => 0,
    	            "message" => "The OTP Is Not Matching"
    	        );
                    $encoded = encoder($res);
                    $this->response($encoded);
            	}
            }
    	}
    }
}

?>