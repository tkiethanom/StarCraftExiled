<?php
class Article extends AppModel{
	var $name = 'Article';
	
	var $validate = array(
    	'date' => array('required' => array ('rule'=>'notEmpty', 
    												'message' => 'Username cannot be left blank') ),
        'body' => array('required' => array ('rule'=>'notEmpty', 
    												'message' => 'Email cannot be left blank') ),		
    );
            
}
?>