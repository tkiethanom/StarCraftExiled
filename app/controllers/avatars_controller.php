<?php
class AvatarsController extends AppController{
	var $name = "Avatars";
	var $uses = array('User', 'Avatar');
	
	
	function changeAvatar(){
		$this->set("title_for_layout", "Change Avatar");
		
		$avatars = $this->Avatar->find("all");
		
		$this->set("avatars", $avatars);
	}
	
	function submitChange($avatar_id){
		if(!empty($avatar_id)){
			if(is_numeric($avatar_id) ){
				
				//Get Avatar values
    			$avatar = $this->Avatar->getAvatarValues($avatar_id);
    			
    			if(!empty($avatar)){
    				$this->User->id = $_SESSION["User"]["id"];
					$data["User"]["avatar_id"] = $avatar_id; 
					$this->User->save($data);
				
					$_SESSION["User"]["Avatar"] = $avatar["Avatar"];		
					$this->Session->setFlash("Avatar Updated Successfully!", "default", array("class"=>"flash-success"));					
    			}    				
			}
		}
		$this->redirect("/users/account");
		exit;
	}
	
	/*
	 * $count = 1;
		
		for($p = 0; $p < 3; $p++){
			for($i = 0; $i < 6; $i++){
				for($j = 0; $j < 6; $j++){				
					if($count > 98){
						break;	
					}
					$img_num = 0;
					if($count > 36){
						$img_num = 1;
					}
					if($count > 72){
						$img_num = 2;
					}
					$y = $i * 75;
					$x = $j * 75;
					
					$data["Avatar"]["img_num"] = $img_num;
					$data["Avatar"]["x_value"] = $x;
					$data["Avatar"]["y_value"] = $y;
					
					$this->Avatar = new Avatar();
					$this->Avatar->save($data);
					$count++;
				}
			}
		}
	 */
}
?>