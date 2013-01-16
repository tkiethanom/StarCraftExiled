<?php
class Role extends AppModel{
	var $name = 'Role';
	
	function getRoleName($role_id){
		$role = $this->find("first", array("conditions"=>array("id"=>$role_id) ) );
		return $role["Role"]["name"];	        
	}
}
?>