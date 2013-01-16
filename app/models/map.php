<?php
class Map extends AppModel{
	var $name = "Map";
	
	function getMapsAsOptions(){
		$results = $this->query("SELECT DISTINCT GameType.name, Map.game_type_id
									FROM maps Map, game_types GameType
									WHERE Map.game_type_id = GameType.id ");
		$output = array();
		foreach($results as $row){			
			$maps = $this->find("list", array("conditions"=>array("game_type_id"=>$row["Map"]["game_type_id"]), "order"=>array("name") ) );
			$output[$row["GameType"]["name"]] = $maps;
		}
		
		return $output;
	}
}
?>