<?php 

    /* 
    *Project name : API for Android and IOS guys
    *Date : 12/08/2019
    *Auther : SASIDHARAN
    *Project omner : KUMARESAN
    */

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Registration_model extends CI_Model {

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

		// To inser user Details name:sasi date:13/08/2019

		public function user_registration($data)
		{
			$id= $data["id"];
			$name = $data["name"];
			$email= $data["email"];
			$this->bulk->update(['_id'=> new MongoDB\BSON\ObjectId("$id")], ['$set' => ['name' => $name , "email" => $email]]);
		    $this->mng->executeBulkWrite('sasi_ci.api_ci', $this->bulk);
		    return true;
		}

		// To Ckeck if the email is exits or not name:sasi date:13/08/2019

		public function emailExits($data)
		{
			$email = $data["email"];
			$filter = [ 'email' => $email];
			$query = new MongoDB\Driver\Query($filter,[]);
			$rows = $this->mng->executeQuery("sasi_ci.api_ci", $query)->toArray();
			return $rows;
		}

	}


?>