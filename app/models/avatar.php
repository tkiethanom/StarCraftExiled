<?php
class Avatar extends AppModel{
	var $name = "Avatar";
		
	function getAvatarValues($avatar_id){
		//Get Avatar values
    	$avatar = $this->find("first", array("conditions"=>array("id" => $avatar_id),
    																"fields"=>array("id","img_num","x_value","y_value") ) );
    	return $avatar;
	}
}
?>