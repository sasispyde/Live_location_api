<?php 

    /* 
    *Project name : API for Android and IOS guys
    *Date : 12/08/2019
    *Auther : SASIDHARAN
    *Project omner : KUMARESAN
    */

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Update_model extends CI_Model {

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

		//  To update the user details in database... name:sasi date:13/08/2019

		public function user_update($id,$data)
		{
			$name=$data["name"];
			$email=$data["email"];
			$country_code=$data["country_code"];

			$this->bulk->update( ['_id'=> new MongoDB\BSON\ObjectId("$id")], ['$set' => 
				[
				'name' => $name,
				'email'=>$email,
				'country_code'=>$country_code
				]
			]);
		    
		    $this->mng->executeBulkWrite('sasi_ci.api_ci', $this->bulk);

			return true;
		}

		public function userDetails($id)
		{
			$filter = ['_id'=> new MongoDB\BSON\ObjectId("$id")];
			$query = new MongoDB\Driver\Query($filter,[]);
			$rows = $this->mng->executeQuery("sasi_ci.api_ci", $query)->toArray();
			return $rows; 
		}

		//  To check if the mobile number is already exits or not... name:sasi date:13/08/2019

		public function numberExits($data)
		{
			$number=$data["phone_number"];
			$filter = [ 'phone_number' => $number];
			$query = new MongoDB\Driver\Query($filter); 
	        $rows = $this->mng->executeQuery("sasi_ci.api_ci", $query);   
	        foreach ($rows as $row) {
	            if($row->phone_number==$number)
	            {
	            	return true;
	            }
	            else
	            {
	            	return false;
	            }
	        }
		}

		//  To store image as a path in a database... name:sasi date:13/08/2019

		public function image_path($data)
		{
			$id = $data['id'];
			$path = $data['image_path'];
			$filter = ['_id' => new MongoDB\BSON\ObjectId("$id")];
			$query = new MongoDB\Driver\Query($filter); 
			$this->bulk->update($filter, ['$set' => ['image_path' => $path]]);
			$this->mng->executeQuery("sasi_ci.api_ci", $query);
		}



	}
