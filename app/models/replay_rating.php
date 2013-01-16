<?php
class ReplayRating extends AppModel{
	var $name = "ReplayRating";
	
	function getRating($replay_id){
		$replayRating = $this->query("SELECT SUM(value) AS total FROM replay_ratings ReplayRating WHERE replay_id = '$replay_id' ");
		
		return $replayRating[0][0]["total"];
	}
}
?>