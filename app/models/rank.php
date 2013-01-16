<?php
class Rank extends AppModel{
	var $name = 'Rank';
	
	function getRankName($rank_id){
		$rank = $this->find("first", array("conditions"=>array("id"=>$rank_id) ) );
		return $rank["Rank"]["name"];	        
	}
}
?>