<?php
class ReplayCommentsController extends AppController{
	var $name = "ReplayComments";
	var $uses = array('Replay', 'ReplayComment');
		
	function submitComment(){
		if(!empty($this->data["ReplayComment"]["replay_id"]) &&
			!empty($this->data["ReplayComment"]["comment"]) ){

			//Check if replay_id exists
			$replay = $this->Replay->find("first", array("conditions"=>array("id"=>$this->data["ReplayComment"]["replay_id"]) ) );
			if(!empty($replay)){
				if(!empty($this->data["ReplayComment"]["comment"])){
					//Check if parent_id exists
					if(!empty($this->data["ReplayComment"]["parent_id"])){
						$parent = $this->ReplayComment->find("first", array("conditions"=>array("id"=>$this->data["ReplayComment"]["parent_id"]) ) );
						if(empty($parent)){
							$this->redirect("/replays/view/{$this->data["ReplayComment"]["replay_id"]}");
							exit;
						}						
					}
					
					$this->data["ReplayComment"]["user_id"] = $_SESSION["User"]["id"];
					$this->data["ReplayComment"]["created"] = $_SESSION["User"]["id"];
					$this->data["ReplayComment"]["created"] = date("Y-m-d H:i:s");
					$this->data["ReplayComment"]["modified"] = date("Y-m-d H:i:s");
					
					if($this->ReplayComment->save($this->data)){
						$this->Session->setFlash("Comment Added Successfully!", "default", array("class"=>"flash-success"));
						$this->redirect("/replays/view/{$this->data["ReplayComment"]["replay_id"]}");
						exit;					
					}
				}
				else{
					$this->redirect("/replays/view/{$this->data["ReplayComment"]["replay_id"]}");
					exit;				
				}
			}				
		}	
		$this->redirect("/replays");
		exit;	
	}
	
	function deleteComment($id = null){
		$this->set("title_for_layout", "Replay Comment Delete");
		
		if(!empty($id)){
			$id = mysql_real_escape_string($id);
		
			//Check to see if user has replay_admin permissions
			if(in_array("replay_comment_admin",$_SESSION["User"]["permissions"])){
				$replay = $this->ReplayComment->find("first", array("conditions"=>array("id"=>$id ) ) );
			}
			else{
				$replay = $this->ReplayComment->find("first", array("conditions"=>array("id"=>$id, "user_id"=>$_SESSION["User"]["id"]) ) );
			}
			
			if(!empty($replay)){										
				if($this->ReplayComment->delete($id) ){
					//Delete children comments
					$this->ReplayComment->deleteChildren($id);
					$this->Session->setFlash("Replay Comment Deleted Successfully!", "default", array('class'=>'flash-success'));
					$this->redirect("/replays/view/{$replay["ReplayComment"]["replay_id"]}");
					exit;
				}		
			}							
		}
		$this->redirect("/replays");
		exit;
	}
}
?>