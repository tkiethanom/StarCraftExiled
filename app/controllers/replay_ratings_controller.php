<?php
class ReplayRatingsController extends AppController{
	var $name = 'ReplayRatings';
	var $uses = array('ReplayRating', 'Replay');
	
	function submitRating(){
		$this->layout = "blank";
		$output = "false";
		
		if(isset($_POST["x"]) && isset($_POST["v"]) ){
			//Check if Replay exists;
			$replay = $this->Replay->find("first", array("conditions"=>array("id"=>$_POST["x"]) ) );
			if(!empty($replay)){
				if($_POST["v"] == 1 || $_POST["v"] == 0){
					if($_POST["v"] == 0){
						$v = -1;
					}
					else{
						$v = 1;
					}
					//Check if ReplayRating exists
					$duplicate = $this->ReplayRating->find("first", array("conditions"=>array("user_id"=>$_SESSION["User"]["id"],
																				"replay_id"=>$replay["Replay"]["id"]) ) );
					$data = array();
					if(!empty($duplicate)){
						if($duplicate["ReplayRating"]["value"] != $v){
							$data["ReplayRating"]["id"] = $duplicate["ReplayRating"]["id"];
							$data["ReplayRating"]["value"] = $v;
							$data["ReplayRating"]["modified"] = date("Y-m-d H:i:s");
							$this->ReplayRating->save($data);
							$output = $this->ReplayRating->getRating($replay["Replay"]["id"]);
						}
					}
					else{
						$data["ReplayRating"]["user_id"] = $_SESSION["User"]["id"];
						$data["ReplayRating"]["replay_id"] = $replay["Replay"]["id"];
						$data["ReplayRating"]["value"] = $v;
						$data["ReplayRating"]["created"] = date("Y-m-d H:i:s");
						$data["ReplayRating"]["modified"] = date("Y-m-d H:i:s");
						$this->ReplayRating->save($data);
						$output = $this->ReplayRating->getRating($replay["Replay"]["id"]);
					}
 				}
			}
		}
		if(is_numeric($output) && $output > 0){
			$output = "+".$output;
		}
		$this->set("output", $output);
	}
	
}
?>