<?php 

	 /* 

    *Project name : API for Android and IOS guys
    *Date : 12/08/2019
    *Auther : SASIDHARAN
    *Project owner : KUMARESAN
    */

	require APPPATH . 'libraries/REST_Controller.php';

	class Resend_otp extends REST_Controller
	{

		public function __construct()
		{
	        parent::__construct();

	        $this->load->helper(array("function"));

	        $this->load->model(array("Api_model"));

		}

		// resend otp to the user name:sasi date:19/08/2019

		public function index_post()
		{
                $input = file_get_contents("php://input");
                $json = decoder($input);
                $id=$json->id;

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
                	$otp = generateNumericOTP();
                	$this->Api_model->otpUpdater($id,$otp);
                	$data=array("otp"=>$otp);
                	$res = array(
                        "status" => 1,
                        "details"=> $data,
                        "message" => "New OTP"
                    );
                    $encoded = encoder($res);
                    $this->response($encoded);
                }

        }


	}


?>