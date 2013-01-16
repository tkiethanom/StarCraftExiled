<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * This is a placeholder class.
 * Create the same file in app/app_controller.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @link http://book.cakephp.org/view/957/The-App-Controller
 */
class AppController extends Controller {
	
	var $no_login_required = array(array("controller"=>"users", "action"=>"login"), 
									array("controller"=>"users", "action"=>"register"),
									array("controller"=>"users", "action"=>"forgotPassword"),
								);
	
	function beforeFilter(){
		$this->_loginRequired();						
	}
	
	function _loginRequired(){
		$user = $this->Session->read("User");
		
		if(empty($user) ){
			$login_required = false;
			foreach($this->no_login_required as $page ){
				if($this->params["controller"] != $page["controller"] || 
					$this->params["action"] != $page["action"]){
						$login_required = true;
				}
				else{
					$login_required = false;
					break;
				}
			}
			if($login_required){
				$this->redirect("/users/login");
				exit;
			}
		}
	}
	
	function _cleanValues($data){			
		
		if(!empty($data)){
			foreach($data as $key => $value){
				if(is_array($value)){
					$data[$key] = $this->_cleanValues($value);
				}
				else{
					$data[$key] = mysql_real_escape_string($value);
				}					
			}															
		}
		
		return $data;
	}

	function _hasPermission($permission){
		$output = false;
		if(!empty($_SESSION["User"]["permissions"]) ){
			if(in_array($permission, $_SESSION["User"]["permissions"])){
				$output = true;
			}
		}
		return $output;
	}
}
