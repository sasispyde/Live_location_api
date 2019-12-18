<?php 

     /* 

    *Project name : API for Android and IOS guys
    *Date : 12/08/2019
    *Auther : SASIDHARAN
    *Project owner : KUMARESAN
    */

   require APPPATH . 'libraries/REST_Controller.php';

	class Get_details_controller extends REST_Controller
	{

		public function __construct()
		{
	        parent::__construct();

	        $this->load->helper(array("function"));

	        $this->load->model("Api_model");

		}

// it gives the details of current user in map-page name:sasi date:19/08/2019

		public function index_post()
		{
			$input = file_get_contents("php://input");
            $json = decoder($input);
            $id=$json->id;

            if(empty($id)||strlen($id)<24)
            {
               	$res = array(
                "status" => 0,
                "message" =>"Illegal Access"
                );
                    $encoded = encoder($res);
                    $this->response($encoded);
           	}
            else
            {
            	$data=$this->Api_model->getDetails($id);
                $data=image_url($data);
                $res = array(
                 	"status" => 1,
                 	"details" =>$data[0],
                 	"message" => "Success"
             		); 
                    $encoded = encoder($res);
                    $this->response($encoded);
            }
		}
	}




 ?>