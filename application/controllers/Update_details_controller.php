<?php

    /* 
    *Project name : API for Android and IOS guys
    *Date : 12/08/2019
    *Auther : SASIDHARAN
    *Project omner : KUMARESAN
    */

    require APPPATH . 'libraries/REST_Controller.php';

	class Update_details_controller extends REST_Controller
	{
		
		public function __construct()
		{
	        parent::__construct();

	        $this->load->helper(array("function"));

	        $this->load->model(array("Registration_model","Api_model"));

	        $this->load->model("Update_model");

	        $this->validate = $this->config->item('update_details');
		}

        // user update controller.......name:sasi date:19/08/2019

		public function index_post()

		{
                $input = file_get_contents("php://input");
                $json = decoder($input);
                $name = $json->name;
                $email = $json->email;
                $id=$json->id;
                $phone_number=$json->phone_number;
                $country_code=$json->country_code;
                $isNumNotExits=false;
                $isEmailNotExits=false;
                $isimage=false;

                if(!empty($json->image))
                {
                    $isimage=true;
                }

            // To check if the ID is empty or the length is less then 24...name:sasi,date:13/08/2019
                
                if(empty($id)||strlen($id)<24)
                {
                  $res = array(
                        "status" => 0,
                        "message" =>"Illegal Access"
                    );
                    $encoded = encoder($res);
                    $this->response($encoded);                }
                else
                {
//-------------------------------------------------------------------------------------------------------------
                // Image Upload........ name:sasi , date:12/08/2019

                if($isimage)
                {
                if (!empty($input)) 
                {
                // $object = json_decode($input);
                    if ($json->image != "") 
                    {
                        $path = "./uploads/images/";
                        $img = $json->image;
                        $img = str_replace('data:image/*;base64,', '', $img);
                        $img = str_replace(' ', '+', $img);
                        $data = base64_decode($img);
                        $image_name = $json->id;
                        $filename =  $image_name . '.png';
                        $get_image_names = scandir("./uploads/images/", 1);
                         $check_image = array_map(function ($e) {
                            return pathinfo($e, PATHINFO_FILENAME);
                    }, $get_image_names);

                if (in_array($image_name, $check_image)) {
                    $file_pattern = "./uploads/images/$image_name.*";
                    array_map("unlink", glob($file_pattern));
                    file_put_contents($path . $filename, $data);
                    $message = "profile image updated";
                } else {
                    file_put_contents($path . $filename, $data);
                    $message = "profile image uploaded";
                }
                $data = array(
                    'id' => $json->id,
                    'image_path' => $filename
                );
                $this->Update_model->image_path($data);
            }
        }
    }
//-------------------------------------------------------------------------------------------------------------


                //TO make a data as a array format for easy handling.. name:sasi, date :12/8/2019

                $data = array("name" => $name,"email" => $email, "phone_number" => $phone_number, 
                			  "country_code" => $country_code);

                $this->form_validation->set_data($data);
                $this->form_validation->set_rules($this->validate);


                //Form validation... name:sasi, date :12/8/2019
                
                if ($this->form_validation->run() == false) 
                {
                	$error = $this->form_validation->error_array();
                    $res = array(
                    "status" => 0,
                    "message" => $error
                );
                $encoded = encoder($res);
                $this->response($encoded);
                }
                else
                {

                //To Check if the mail and number are unique....name:sasi,date:12/08/2019

                    $oldData=$this->Update_model->userDetails($id);


                    if($oldData[0]->email==$email)
                    {
                        $isEmailNotExits=true;
                    }
                    else
                    {
                        $emailExits = $this->Registration_model->emailExits($data);

                        // to check if the Email is already exists

                        if(!empty($emailExits[0]->email)&&$emailExits[0]->email==$email)
                        {
                            $res = array(
                            "status" => 3,
                            "message" => "The Email is Already Exits Use Anathor Email"
                        );
                        $encoded = encoder($res);
                        $this->response($encoded);
                        return false;
                        }
                        else
                        {
                            $isEmailNotExits=true;
                        }
                    }

                    if($oldData[0]->phone_number==$phone_number)
                    {
                        $isNumNotExits=true;
                    }
                    else
                    {
                        $numberExits = $this->Update_model->numberExits($data);

                        // to check if the phone number is already exists

                        if($numberExits)
                        {
                            $res = array(
                            "status" => 4,
                            "message" => "The Phone Number is Already Exists Please Use Anathor Number"
                        );
                        $encoded = encoder($res);
                        $this->response($encoded);
                        return false;
                        }
                        else
                        {
                            $isNumNotExits=true;
                        }
                    }

                    //update user details...name:sasi date:12/8/2019

                    if($isNumNotExits&&$isEmailNotExits)
                    {
                        $update=$this->Update_model->user_update($id,$data);
                        if($update)
                        {
                            $responceData = $this->Update_model->userDetails($id);
                            $responceData=image_url($responceData);

                            //if phone number change...name:sasi date:12/8/2019

                            if($responceData[0]->phone_number!=$phone_number)
                            {
                                $otp = generateNumericOTP();
                                $this->Api_model->newPhoneVerify($id,$otp);
                                $detail = $this->Api_model->getDetails($id);
                                $res = array(
                                "status" => 5,
                                "details"=> $detail[0],
                                "message" => "Your Phone Number is Changed So You Have Verify Your OTP"
                            );
                            $encoded = encoder($res);
                            $this->response($encoded);
                            }
                            else
                            {
                            $res = array(
                            "status" => 1,
                            "details" =>$responceData[0],
                            "message" => "successfully updated"
                            );
                           $encoded = encoder($res);
                           $this->response($encoded);
                            } 
                        }
                    }
                    else
                    {
                        $res = array(
                        "status" => 0,
                        "message" => "user details cannot be update"
                    );
                    $encoded = encoder($res);
                    $this->response($encoded); 
                    }
              	}
            }
	    }
    }
 ?>