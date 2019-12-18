
<?php
     /* 

    *Project name : API for Android and IOS guys
    *Date : 12/08/2019
    *Auther : SASIDHARAN
    *Project omner : KUMARESAN
    */

require APPPATH . 'libraries/REST_Controller.php';
     
class Signin extends REST_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array("function"));

        $this->load->model("Api_model");

        $this->validate = $this->config->item('forms');
    }

    // customer login...name:sasi date:19/08/2019

    public function index_post()
    {

                $input = file_get_contents("php://input");
                $json =decoder($input);
                $phone_number = $json->phone_number;
                $country_code = $json->country_code;
                $data=array(
                    'country_code'=>$country_code,
                    'phone_number'=>$phone_number
                    );
                $errors=array();
                $validate=$this->Api_model->numberValidator($data);

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
                    $otp = generateNumericOTP();

                    $newData=array(
                    'country_code'=>$country_code,
                    'phone_number'=>$phone_number,
                    'otp'=>$otp,
                    'status'=>"B"
                    );

                    if(count($validate)==0)
                    {
                        $this->Api_model->otpInsert($newData);

                        $details = $this->Api_model->userDetails($newData);

                        $res = array(
                        "status" => 1,
                        "details"=> $details[0],
                        "message" => "New User is Successfully Created"
                    );
                    $encoded = encoder($res);
                    $this->response($encoded);
                    }
                    else
                    {

                        $details = $this->Api_model->userDetails($newData);

                        $id = $details[0]->_id;

                        $this->Api_model->otpUpdater($id,$otp);

                        $detail = $this->Api_model->userDetails($newData);

                        $res = array(
                            "status" => 1,
                            "details"=> $detail[0],
                            "message" => "New OTP"
                        );
                    $encoded = encoder($res);
                    $this->response($encoded);

                        // This is used to if the user is already exits or not if you uncommand it it will show a different responces for the single sign up....name:sasi date :12/08/2019

                        // $registered=$this->Api_model->getOtp($details[0]->_id);

                        // $isset =empty($registered[0]->email);

                        // if(!$isset)
                        // {
                        //     $res = array(
                        //     "status" => 3,
                        //     "details"=> $detail,
                        //     "message" => "User Exits"
                        // );
                        // }
                        // else
                        // {
                        //     $res = array(
                        //     "status" => 4,
                        //     "details"=> $detail,
                        //     "message" => "User Exits But Not Registered"
                        // );
                        // }
                        // $this->response($res);
                    }

                }

            }

        }
    