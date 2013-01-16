<?php
class User extends AppModel{
	var $name = 'User';

	var $belongsTo = array(
					'Avatar' => array(
							'className' => 'Avatar',
							'foreignKey' => 'avatar_id',
						),
					);
	
	var $validate = array(
    	'username' => array('required' => array ('rule'=>'notEmpty', 
    												'message' => 'Username cannot be left blank') ),
        'email' => array('email' => array ('rule'=>'email', 
    												'message' => 'Invalid email address'),
						 'required' => array ('rule'=>'notEmpty', 
    												'message' => 'Email cannot be left blank') ),
		'password' => array('required' => array ('rule'=>'notEmpty', 
    												'message' => 'Password cannot be left blank') ),
		'password_confirm' => array('required' => array ('rule'=>'notEmpty', 
    												'message' => 'Password cannot be left blank'),
									'confirm' => array ('rule'=>'confirmPassword', 
    												'message' => 'Password does not match') ),
		'old_password' => array('required' => array ('rule'=>'notEmpty', 
    												'message' => 'Password cannot be left blank') ),									
		'new_password' => array('required' => array ('rule'=>'notEmpty', 
    												'message' => 'Password cannot be left blank') ),									
    );
    
    
    
	function confirmPassword($check){
		if(!empty($this->data["User"]["password"]) && !empty($this->data["User"]["password_confirm"])){
			if($this->data["User"]["password"] == $this->data["User"]["password_confirm"]){
	        	return true;        	
	        }	
		}
        return false;
    }
    
    function getPermissions($user_id){
    	$output = array();
    	$data = $this->query("SELECT permission FROM users User, role_permissions RolePermission, permissions Permission 
    					WHERE User.role_id = RolePermission.role_id 
    						AND RolePermission.permission_id = Permission.id 
    						AND User.id = '$user_id' ");  
    	if(!empty($data)){  	
	    	foreach($data as $value){
	    		$output[] = $value["Permission"]["permission"];
	    	}		
    	}
    	return $output;
    }
    
    function getUsername($id){
    	$output = "";
    	
    	$user = $this->find("first", array("conditions"=>array("id"=>$id) ) );
    	if(!empty($user) ){
    		$output = $user["User"]["username"];
    	}
    	return $output;
    }
        
}
?>