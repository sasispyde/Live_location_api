<?php 

	/* 
    *Project name : API for Android and IOS guys
    *Date : 12/08/2019
    *Auther : SASIDHARAN
    *Project omner : KUMARESAN
    */

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Dashboard_model extends CI_Model
	{
		
		public function __construct()
		{
			parent::__construct();
			$this->load->helper(array("function"));
	        parent::__construct();
	        $this->mng = new MongoDB\Driver\Manager("mongodb://root:ndot@192.168.2.25:27017/");
	        $this->bulk = new MongoDB\Driver\BulkWrite;	
		}

		// function to check if the user is exists in the database...

		public function login_verification($data)
		{
			$username=$data['username'];
			$password=$data["password"];
			$filter = ['username'=> $username,"password"=>$password];
			$query = new MongoDB\Driver\Query($filter,[]);
			$rows = $this->mng->executeQuery("sasi_ci.users", $query)->toArray();
			return $rows;
		}

		// function to get all user and details...

		// public function getAllUsers()
		// {
		// 	$query = new MongoDB\Driver\Query([]);
		// 	$rows = $this->mng->executeQuery("sasi_ci.api_ci", $query)->toArray();
		// 	return $rows;
		// }

		public function getAllUsers()
		{
			$query = new MongoDB\Driver\Query([],['limit' => 10]);
			$rows = $this->mng->executeQuery("sasi_ci.api_ci", $query)->toArray();
			return $rows;
		}

		public function getAllUsers2($skip,$value)
		{
			$query = new MongoDB\Driver\Query([],['skip'=>$skip,'limit' => $value]);
			$rows = $this->mng->executeQuery("sasi_ci.api_ci", $query)->toArray();
			return $rows;
		}

	}

 ?>