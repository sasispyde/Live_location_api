<?php 

     /* 

    *Project name : API for Android and IOS guys
    *Date : 12/08/2019
    *Auther : SASIDHARAN
    *Project omner : KUMARESAN
    */

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Map_data_model extends CI_Model {

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

		// To find if the user is already exits

		public function findIdExits($id)
		{
			$id = $id;
			$filter = ['_id'=> $id];
			$options=[];
			$query = new MongoDB\Driver\Query($filter,[]);
			$rows = $this->mng->executeQuery("sasi_ci.map_data", $query)->toArray();
			return $rows;

		}

		// To insert new user Data in the map_data collection...

		public function newMapData($data)
		{
			$long=$data[0];
			$lat=$data[1];
			$id=$data[2];
			$bulk = new MongoDB\Driver\BulkWrite;
			$doc = ['_id' => $id, "loc"=>["type"=>"multipoint","cor"=>[[$long,$lat]]]];
	    	$bulk->insert($doc);
	    	$rows=$this->mng->executeBulkWrite('sasi_ci.map_data', $bulk);
		}

		// To update the user Data in the map_data collection...

		public function oldMapData($data)
		{
			$long=$data[0];
			$lat=$data[1];
			$id=$data[2];
			$bulk = new MongoDB\Driver\BulkWrite;
	    	$bulk->update(['_id' => $id], ['$pushAll' => ["loc.cor" => [[$long,$lat]]]]);
	    	$rows=$this->mng->executeBulkWrite('sasi_ci.map_data', $bulk);
		}

	}
 ?>