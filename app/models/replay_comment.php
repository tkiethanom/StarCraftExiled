<?php
class ReplayComment extends AppModel{
	var $name = "ReplayComment";
	
	
	function getReplayComments($replay_id){
		$result = $this->query("SELECT ReplayComment.*, User.id,  User.username, 
										Avatar.img_num, Avatar.x_value, Avatar.y_value
									FROM replay_comments ReplayComment, users User, avatars Avatar
									WHERE ReplayComment.replay_id = '$replay_id'
										AND User.id = ReplayComment.user_id
										AND User.avatar_id = Avatar.id
										");
		
		$output = $this->getTree($result);
		
		return $output;
	}
	
	function getTree($result){
		$parents = array();
		$children = array();
		
		$output = array();
		
		foreach($result as $comment){
			$parent_id = $comment["ReplayComment"]["parent_id"];
			
			if(empty($parent_id) ){
				$parents[$comment["ReplayComment"]["id"]] = $comment;				
			}
			else{
				$children[$parent_id][] = $comment;
			}
		}
		
		foreach($parents as $id => $parent){
			$childTree = $this->getChildren($id, $children);
			if(!empty($childTree)){
				$parent["ReplayComment"]["children"] = $childTree;
			}
			
			$output[$id] = $parent;
		}
		
		return $output;
	}
	
	function getChildren($parent_id, $children){
		$output = array();
		
		if(!empty($children[$parent_id]) ){
			foreach($children[$parent_id] as $comment){
				$id = $comment["ReplayComment"]["id"]; 
				
				$childTree = $this->getChildren($id, $children);
				if(!empty($childTree)){
					$comment["ReplayComment"]["children"] = $childTree;
				}
				
				$output[$id] = $comment;
			}
		}
		
		return $output;
	}
	
	function deleteChildren($parent_id){
		$children = $this->find("all", array("conditions"=>array("parent_id"=>$parent_id)) );
		if(!empty($children)){
			foreach($children as $child){
				$this->delete($child["ReplayComment"]["id"]);
				$this->deleteChildren($child["ReplayComment"]["id"]);
			}	
		}
	}
	
}
?>