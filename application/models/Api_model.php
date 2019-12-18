<?php 

	 /* 

    *Project name : API for Android and IOS guys
    *Date : 12/08/2019
    *Auther : SASIDHARAN
    *Project omner : KUMARESAN
    */

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Api_model extends CI_Model {

	protected $mng;
	protected $bulk;

		public function __construct()
		{
			parent::__construct();

			$this->load->helper(array("function"));

	        parent::__construct();

	        $this->mng = new MongoDB\Driver\Manager("mongodb://root:ndot@192.168.2.25:27017/");

	        $this->bulk = new MongoDB\Driver\BulkWrite;

		}

		// To Check IF The Mobile Number is Exits Or Not  Name:Sasi Date:13/08/2019

		public function numberValidator($data)
		{
			$number=$data["phone_number"];
			$country_code=$data["country_code"];
			$filter = [ 'phone_number' => $number,'country_code'=>$country_code];
			$query = new MongoDB\Driver\Query($filter); 
	        $rows = $this->mng->executeQuery("sasi_ci.api_ci", $query)->toArray();
	        return $rows;
		}

		// public function numberValidator($data)
		// {
		// 	$number=$data["phone_number"];
		// 	$filter = [ 'phone_number' => $number];
		// 	$query = new MongoDB\Driver\Query($filter); 
	 //        $rows = $this->mng->executeQuery("sasi_ci.api_ci", $query);
	 //        foreach ($rows as $row) {
	 //            if($row->phone_number==$number)
	 //            {
	 //            	return true;
	 //            }
	 //            else
	 //            {
	 //            	return false;
	 //            }
	 //        }
		// }

		//Update the exiting OTP to new OTP.... nams:sasi date:13/08/2019

		public function otpUpdater($id,$otp)
		{
		    $this->bulk->update([ '_id'=> new MongoDB\BSON\ObjectId("$id")], ['$set' => ['otp' => $otp]]);
		    
		    $this->mng->executeBulkWrite('sasi_ci.api_ci', $this->bulk);

		    return true;
		}

		// function to insert number (if the mobile number is changed)

		public function newPhoneVerify($id,$otp)
		{
		    $this->bulk->update([ '_id'=> new MongoDB\BSON\ObjectId("$id")], ['$set' => ['otp' => $otp,'status'=>'B']]);
		    
		    $this->mng->executeBulkWrite('sasi_ci.api_ci', $this->bulk);

		    return true;
		}

		// insert new login data

		public function otpInsert($data)
		{
			$this->bulk->insert($data);

			$this->mng->executeBulkWrite('sasi_ci.api_ci', $this->bulk);
		}

		// Get the Current user Details Login only.... nams:sasi date:13/08/2019

		public function userDetails($data)
		{
			$phone_number=$data["phone_number"];
			$filter = [ 'phone_number'=> $phone_number];
			$query = new MongoDB\Driver\Query($filter,[]);
			$rows = $this->mng->executeQuery("sasi_ci.api_ci", $query)->toArray();
			return $rows; 
		}

		// Get the Current user Details After Login.... nams:sasi date:13/08/2019

		public function getOtp($id)
		{
			$id = $id;
			$filter = ['_id'=> new MongoDB\BSON\ObjectId("$id")];
			$options=[];
			$query = new MongoDB\Driver\Query($filter,[]);
			$rows = $this->mng->executeQuery("sasi_ci.api_ci", $query)->toArray();
			return $rows;
		}

		// Get the Current user Details After login.... nams:sasi date:13/08/2019

		public function getDetails($id)
		{
			$id = $id;
			$filter = ['_id'=> new MongoDB\BSON\ObjectId("$id")];
			$options=[];
			$query = new MongoDB\Driver\Query($filter,[]);
			$rows = $this->mng->executeQuery("sasi_ci.api_ci", $query)->toArray();
			return $rows;
		}

		// Update the status after the OTP is verified.... nams:sasi date:13/08/2019

		public function statusUpdater($data,$status)
		{
			$id=$data["id"];
			$phone_number=$data["phone_number"];
			$this->bulk->update( ['_id'=> new MongoDB\BSON\ObjectId("$id")], ['$set' => ['status' => $status,
				"phone_number"=>$phone_number]]);
		    $this->mng->executeBulkWrite('sasi_ci.api_ci', $this->bulk);
		}

	}


?>