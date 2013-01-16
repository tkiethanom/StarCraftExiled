<?php
class UsersController extends AppController{
	var $name = 'Users';
	var $uses = array('User', 'Role', 'Rank', 'Replay', 'Avatar');
	var $helpers = array('Cache');
	
	var $cacheAction = array(
							'users/login' => '24 hours',
							'users/logout' => '24 hours',
							'users/register' => '24 hours',
							'users/forgotPassword' => '24 hours',
							'users/changePassword' => '24 hours',
							'users/changeAvatar' => '24 hours',	
						);
	
	function login(){
		if(!empty($_SESSION["User"])){
			$this->redirect("/home");
			exit;
		}
		
		$this->set("title_for_layout", "Login");	
		
		if(!empty($this->data) ){
			$this->User->set($this->data);
			
			if ($this->User->validates()){
				
				$user = $this->User->find("first", array("conditions"=>array("username" => $this->data["User"]["username"],
    																 "status_id" => 1 ) ) );					
    			if(!empty($user)){
    				if($user["User"]["password"] == md5($this->data["User"]["password"])){
    					//Set session variables
    					$_SESSION["User"]["id"] = $user["User"]["id"];
    					$_SESSION["User"]["username"] = $user["User"]["username"];
    					$_SESSION["User"]["email"] = $user["User"]["email"];    					
    					
    					//Get permissions and set in the session
    					$permissions = $this->User->getPermissions($user["User"]["id"]);    					
    					$_SESSION["User"]["permissions"] = $permissions;
    					
    					$_SESSION["User"]["role"] = $this->Role->getRoleName($user["User"]["role_id"]);
    					$_SESSION["User"]["rank"] = $this->Rank->getRankName($user["User"]["rank_id"]);
    					
    					//Get Avatar values
    					//$avatar = $this->Avatar->getAvatarValues($user["User"]["avatar_id"]);
    					$_SESSION["User"]["Avatar"] = $user['Avatar'];
    					
    					
    					//Set login date
    					$this->User = new User();
    					$this->User->id = $user["User"]["id"];
    					$this->User->set(array("last_login"=>date("Y-m-d H:i:s") ) );
    					$this->User->save();
    					
    					$this->Session->setFlash("Login Successful!", "default", array("class"=>"flash-success"));					
						$this->redirect("/home");
						exit;
    				}
    				else{
    					$this->Session->setFlash("Login Error, Username and Password combination does not exist", "default", array("class"=>"flash-error"));
    				}
    			}
    			else{
    				$this->Session->setFlash("Login Error, Username and Password combination does not exist", "default", array("class"=>"flash-error"));	
    			}
			}
		}
	}
	
	function register(){
		if(!empty($_SESSION["User"])){
			$this->redirect("/home");
			exit;
		}
		
		$this->set("title_for_layout", "Registration");
		
		if(!empty($this->data) ){
			$this->User->saveAll($this->data, array('validate' => 'only'));
			
			//Check uniqueness of username
			$username = $this->User->find("first", array("conditions"=>array("username" => $this->data["User"]["username"] ) ) );
			if(!empty($username)){
				$this->User->validationErrors["username"] = "Username has already been taken.";			
			}	

			//Check uniqueness of email
			$email = $this->User->find("first", array("conditions"=>array("email" => $this->data["User"]["email"] ) ) );
			if(!empty($email)){
				$this->User->validationErrors["email"] = "Email has already been taken.";			
			}
			
			if(empty($this->User->validationErrors) ){
				$this->data["User"]["password"] = md5($this->data["User"]["password"]);
				$this->data["User"]["password_confirm"] = md5($this->data["User"]["password_confirm"]);
				$this->data["User"]["created"] = date("Y-m-d H:i:s");
				$this->data["User"]["modified"] = date("Y-m-d H:i:s");
								
				if($this->User->save($this->data) ){
					$this->Session->setFlash("Registration Successful!", "default", array("class"=>"flash-success"));					
					$this->redirect("/users/login");
					exit;
				}
			}
		}
	}
	
	function forgotPassword(){
		if(!empty($_SESSION["User"])){
			$this->redirect("/home");
			exit;
		}
		
		$this->set("title_for_layout", "Forgot Password");
		
		if(!empty($this->data) ){
			$this->User->set($this->data);
			
			if($this->User->validates()){
				//Check if email exists
				$user = $this->User->find("first", array("conditions"=>array("email" => $this->data["User"]["email"],
    																 "status_id" => 1 ) ) );
				if(!empty($user)){
					$length = 10;
					
					//Generate a password
					$validchars = "0123456789abcdfghjkmnpqrstvwxyz";
					$password  = "";
					$counter = 0;
					
					while ($counter < $length) {
						$actChar = substr($validchars, rand(0, strlen($validchars)-1), 1);
					    $password .= $actChar;
					    $counter++;
					}

					$this->User = new User();
					$this->User->id = $user["User"]["id"];
					$this->User->set(array("password"=>md5($password),
											"modified"=>date("Y-m-d H:i:s") ) );
   					if($this->User->save()){
   						$message = "Here is your generated password:
   						
$password

Use this new password to login to change your password. If you have not requested a new password please contact the system administrator. Thank you.";
   						mail($this->data["User"]["email"], "StarCraft Exiled Password",$message, "From: webmaster@scexiled.com \r\n Reply-To: webmaster@scexiled.com \r\n" );
   						$this->Session->setFlash("Your Password Request was Successful!", "default", array("class"=>"flash-success"));   											
						$this->redirect("/users/login");
						exit;
   					}
				}
				else{
					$this->User->validationErrors["email"] = "Email does not exist.";
				}
			}
		}
	}
	
	function account(){
		$this->set("title_for_layout", "Account");
	}
	
	function edit(){
		$this->set("title_for_layout", "Edit Account");
		
		if(empty($this->data) ){
			$this->data["User"]["username"] = $_SESSION["User"]["username"];
			$this->data["User"]["email"] = $_SESSION["User"]["email"];
		}
	
		if(!empty($_POST) ){
			$this->User->saveAll($this->data, array('validate' => 'only'));
			
			//Check uniqueness of username
			$username = $this->User->find("first", array("conditions"=>array("username" => $this->data["User"]["username"],
																			"id <>" => $_SESSION["User"]["id"]) ) );
			
			if(!empty($username) ){
				$this->User->validationErrors["username"] = "Username has already been taken.";			
			}	

			//Check uniqueness of email
			$email = $this->User->find("first", array("conditions"=>array("email" => $this->data["User"]["email"],
    															 			"id <>" => $_SESSION["User"]["id"]) ) );

			if(!empty($email)){
				$this->User->validationErrors["email"] = "Email has already been taken.";			
			}
			
			//Check that password matches
			$password = $this->User->find("first", array("conditions"=>array("id" => $_SESSION["User"]["id"],
    															 			"status_id" => 1 ) ) );

			if(!empty($password)){
				if($password["User"]["password"] != md5($this->data["User"]["password"])){
					$this->User->validationErrors["password"] = "Invalid Password. Enter your original password.";	
				}							
			}
			
			if(empty($this->User->validationErrors) ){
				$this->User = new User();
				$this->User->id = $_SESSION["User"]["id"];
				$this->User->read();
				
				unset($this->data["User"]["password"]);
				$this->data["User"]["modified"] = date("Y-m-d H:i:s");		
				
				
				if($this->User->save($this->data) ){
					$_SESSION["User"]["username"] = $this->data["User"]["username"];
   					$_SESSION["User"]["email"] = $this->data["User"]["email"];
					
					$this->Session->setFlash("Account Updated Successfully!", "default", array("class"=>"flash-success"));					
					$this->redirect("/users/account");
					exit;
				}
			}
			
		}
	}	
	
	function changePassword(){
		$this->set("title_for_layout", "Change Password");
		
		if(!empty($this->data) ){
			$this->User->saveAll($this->data, array('validate' => 'only'));
			
			//Check that password matches
			$password = $this->User->find("first", array("conditions"=>array("id" => $_SESSION["User"]["id"],
    															 			"status_id" => 1 ) ) );

			if(!empty($password)){
				if($password["User"]["password"] != md5($this->data["User"]["old_password"])){
					$this->User->validationErrors["old_password"] = "Invalid Password. Enter your original password.";	
				}							
			}
			
			if(empty($this->User->validationErrors) ){
				$this->User = new User();
				$this->User->id = $_SESSION["User"]["id"];
				$this->User->read();
				
				$this->data["User"]["password"] = md5($this->data["User"]["password"]);
				$this->data["User"]["password_confirm"] = md5($this->data["User"]["password_confirm"]);
				$this->data["User"]["modified"] = date("Y-m-d H:i:s");						
				
				if($this->User->save($this->data) ){										
					$this->Session->setFlash("Password Changed Successfully!", "default", array("class"=>"flash-success"));					
					$this->redirect("/users/account");
					exit;
				}
			}
			
		}
	}
	
	function profile($id = null){
		$this->set("title_for_layout", "Profile");
		
		if(empty($id)){
			$this->Session->setFlash("Profile does not exist", "default", array("class"=>"flash-error"));
		}
		else{
			$user = $this->User->find("first", array("conditions"=>array("User.id" => $id, "User.status_id" => 1 ) ) );
			if(!empty($user)){
				$user["User"]["role"] = $this->Role->getRoleName($user["User"]["role_id"]);
 				$user["User"]["rank"] = $this->Rank->getRankName($user["User"]["rank_id"]);
  					
 				$replays = $this->Replay->find("all", array("conditions"=>array("user_id"=>$id), "order"=>array("created DESC") ) );
 				
				$this->set("title_for_layout", "Profile - {$user["User"]["username"]}");
				$this->set("user", $user);
				$this->set("replays", $replays);
			}
			else{
				$this->Session->setFlash("Profile does not exist", "default", array("class"=>"flash-error"));
			}
		}
		
		$this->set("back_link", array("url"=>"/replays", "text"=>"&laquo; Back to Replays"));
	}
	
	function logout(){
		session_destroy();
		session_unset();
		$this->Session->setFlash("Logout Successful!", "default", array("class"=>"flash-success"));					
		$this->redirect("/users/login");
		exit;
	}			
}
?>