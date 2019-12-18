
 <?php 

    /* 
    *Project name : API for Android and IOS guys
    *Date : 12/08/2019
    *Auther : SASIDHARAN
    *Project omner : KUMARESAN
    */

    require APPPATH . 'libraries/REST_Controller.php';

	class Map_data_controller extends REST_Controller
	{
		
		public function __construct()
		{
	        parent::__construct();

	        $this->load->helper(array("function"));

	        $this->load->model("Map_data_model");
		}

		// it stores the Map data to the database

		public function index_post()
		{
			$input = file_get_contents("php://input");
			$json = decoder($input);
			$long=$json->long;
			$lat=$json->lat;
			$id=$json->id;
			$data=array($long,$lat,$id);
			$idExits=$this->Map_data_model->findIdExits($id);
			$bool=empty($idExits[0]->_id);
			$validLong=false;
			$validLat=false;

			// check the id is empty or not
			
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

				if (isValidLatitude($lat)) {
				    $validLat=true;
				}
				else
				{
					$validLat=false;
				}

				if (isValidLongitude($long)) {
				    $validLong=true;
				}
				else
				{
					$validLong=false;
				}

				if($bool&&$validLong&&$validLat)
				{
					$newRecord=$this->Map_data_model->newMapData($data);
					$res = array(
                    "status" => 1,
                    "message" => "Success"
                );
                    $encoded = encoder($res);
                    $this->response($encoded);
				}
				else
				{
					if($validLong&&$validLat)
					{
						$previousData=$this->Map_data_model->findIdExits($id);
						$previousData=$previousData[0]->loc->cor;
						$arr   = end($previousData);
						if($arr[0]!=$long || $arr[1]!=$lat)
						{	
							$oldRecord=$this->Map_data_model->oldMapData($data);
							$res = array(
		                    "status" => 1,
		                    "message" => "Success"
		                );
		                    $encoded = encoder($res);
		                    $this->response($encoded);
						}
					}
					else
					{
						$res = array(
	                    "status" => 0,
	                    "message" => "Invalid Longitude and Latitude"
	                	);
	                    $encoded = encoder($res);
	                    $this->response($encoded);
					}
				}
			}
		}
	}

 ?>