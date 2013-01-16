<?php

class ReplaysController extends AppController{
	var $name = 'Replays';
	var $uses = array('Replay', 'User', 'GameType', 'Map', 'ReplayComment', 'Avatar');
	var $helpers = array('ReplayCommentThread');
	
	
	function index(){		
		$rows_per_page = 10;
		
		$curr_page = $this->Replay->_getCurrPage($_GET);
		$limits = $this->Replay->_getLimits($curr_page, $rows_per_page);
		
		$replay_count = $this->Replay->getReplayListCount($_GET);
		$paging = $this->Replay->_getPagingLinks($replay_count, $curr_page, $rows_per_page, $_GET);
		
		$replays = $this->Replay->getReplayList($_GET, $limits);
		
		$this->set("paging", $paging);
		$this->set("replays", $replays);
		$this->set("game_types", $this->GameType->find('list'));
		$this->set("maps", $this->Map->getMapsAsOptions() );	
		
		if(empty($_GET["s"])){
			$_GET["s"] = "DESC";
		}
		if(empty($_GET["o"])){
			$_GET["o"] = "created";
		}
		
		if(!empty($_GET["s"]) && $_GET["s"] == 'ASC'){
			$_GET["s"] = "DESC"; 
		}
		elseif(!empty($_GET["s"]) && $_GET["s"] == 'DESC'){
			$_GET["s"] = "ASC"; 
		}
				
		$sorting_links = array("created"=>array("link"=>"Latest"), 
								"downloaded"=>array("link"=>"Downloaded"), 
								"comments"=>array("link"=>"Comments"),
								"ratings"=>array("link"=>"Ratings") );
		
		foreach($sorting_links as $key => $value){
			$get_values = $_GET;
			if($_GET['o'] != $key){
				$get_values['s'] = "DESC";
			}
			$get_values['o'] = $key;
			unset($get_values['p']); 
			$sorting_links[$key]["url"] = $this->Replay->encode_query_string($get_values);
		}
		
		$this->set("sorting_links", $sorting_links);
	}
	
	function upload(){
		$this->set("title_for_layout", "Upload a Replay");
		$this->set("game_types", $this->GameType->find('list'));
		$this->set("maps", $this->Map->getMapsAsOptions() );
		
		if(!empty($this->data) ){
			$this->Replay->set($this->data);
			
			$this->Replay->validates();
			
			if($this->data["Replay"]["replay_file"]["error"] == 4 ){
				$this->Replay->validationErrors["replay_file"] = "Replay File cannot be left blank.";
			}
			
			if(empty($this->Replay->validationErrors) ){
				$path = $this->Replay->uploadReplayFile($this->data);
				if(!is_null($path)){
					if($this->Replay->saveReplay($this->data, $path) ){
						$this->Session->setFlash("Upload Successful! Click <a href='/replays/view/{$this->Replay->id}'>here</a> to view your replay.", "default", array('class'=>'flash-success'));
						$this->data = array();
					}
					else{
						$this->Session->setFlash("There was an error while trying to save your replay information.", "default", array('class'=>'flash-error'));
					}
				}
				else{
					$this->Session->setFlash("There was an error while trying to upload your replay.", "default", array('class'=>'flash-error'));
				}
			}
		}
	}
	
	function edit($id = null){
		$this->set("title_for_layout", "Replay Edit");
		
		if(!empty($id)){
			$id = mysql_real_escape_string($id);
			
			$this->set("game_types", $this->GameType->find('list'));
			$this->set("maps", $this->Map->getMapsAsOptions() );
					
			//Check to see if user has replay_admin permissions
			if(in_array("replay_admin",$_SESSION["User"]["permissions"])){
				$replay = $this->Replay->find("first", array("conditions"=>array("id"=>$id ) ) );
			}
			else{
				$replay = $this->Replay->find("first", array("conditions"=>array("id"=>$id, "user_id"=>$_SESSION["User"]["id"]) ) );
			}
			
			if(empty($replay)){
				 $this->Session->setFlash("The replay you are looking for does not exist.", "default", array('class'=>'flash-error'));
				 $this->set("back_link", array("url"=>"/replays", "text"=>"&laquo; Back to Replays"));
			}
			else{
				if(empty($this->data) ){
					$this->data["Replay"]["title"] = $replay["Replay"]["title"];
					$this->data["Replay"]["description"] = $replay["Replay"]["description"];
					$this->data["Replay"]["game_type_id"] = $replay["Replay"]["game_type_id"];
					$this->data["Replay"]["map_id"] = $replay["Replay"]["map_id"];
				}
				else{
					$this->Replay->set($this->data);
				
					$this->Replay->validates();
					
					if(empty($this->Replay->validationErrors) ){
						$this->data["Replay"]["id"] = $id;
						if($this->Replay->save($this->data) ){
							$this->Session->setFlash("Replay Updated Successfully!", "default", array('class'=>'flash-success'));
							$this->redirect("/replays/view/$id");
						}
					}
				}
				$this->set("id", $id);
				$this->set("back_link", array("url"=>"/replays/view/$id", "text"=>"&laquo; Back to Replay"));
			}
		}
		else{
			$this->Session->setFlash("The replay you are looking for does not exist.", "default", array('class'=>'flash-error'));
			$this->set("back_link", array("url"=>"/replays", "text"=>"&laquo; Back to Replays"));
		}
	}
	
	function delete($id = null){
		$this->set("title_for_layout", "Replay Delete");
		
		if(!empty($id)){
			$id = mysql_real_escape_string($id);
		
			//Check to see if user has replay_admin permissions
			if(in_array("replay_admin",$_SESSION["User"]["permissions"])){
				$replay = $this->Replay->find("first", array("conditions"=>array("id"=>$id ) ) );
			}
			else{
				$replay = $this->Replay->find("first", array("conditions"=>array("id"=>$id, "user_id"=>$_SESSION["User"]["id"]) ) );
			}
			
			if(empty($replay)){
				 $this->Session->setFlash("The replay you are looking for does not exist.", "default", array('class'=>'flash-error'));
				 $this->set("back_link", array("url"=>"/replays", "text"=>"&laquo; Back to Replays"));
			}
			else{
				if(!empty($this->data) && $this->data["Replay"]["delete"] == 1){
					if($this->Replay->delete($id) ){
						$this->Replay->deleteReplayFile($replay);
						$this->Session->setFlash("Replay Deleted Successfully!", "default", array('class'=>'flash-success'));
						$this->redirect("/replays/index");
					}
					else{
						$this->Session->setFlash("Replay could not be removed. Please try again.", "default", array('class'=>'flash-error'));
					}
				}
				$this->set("replay", $replay);
				$this->set("back_link", array("url"=>"/replays/view/$id", "text"=>"&laquo; Back to Replay"));
			}
		}
		else{
			$this->Session->setFlash("The replay you are looking for does not exist.", "default", array('class'=>'flash-error'));
			$this->set("back_link", array("url"=>"/replays", "text"=>"&laquo; Back to Replays"));
		}
	}
	
	function view($id = null){
		$this->set("title_for_layout", "Replay View");
		
		if(!empty($id)){
			$id = mysql_real_escape_string($id);
		
			$replay = $this->Replay->getReplay($id);
			if(empty($replay)){
				 $this->Session->setFlash("The replay you are looking for does not exist.", "default", array('class'=>'flash-error'));
				 $this->set("back_link", array("url"=>"/replays", "text"=>"&laquo; Back to Replays"));
			}
			else{
				$this->set("title_for_layout", $replay[0]["Replay"]["title"]);
				$replay[0]["User"]["avatar"] = $this->Avatar->getAvatarValues($replay[0]["User"]["avatar_id"]);
								
				$this->set("replay", $replay[0]);
				$this->set("comments", $this->ReplayComment->getReplayComments($id) );
			}
			$this->set("back_link", array("url"=>"/replays", "text"=>"&laquo; Back to Replays"));
		}
		else{
			$this->Session->setFlash("The replay you are looking for does not exist.", "default", array('class'=>'flash-error'));
			$this->set("back_link", array("url"=>"/replays", "text"=>"&laquo; Back to Replays"));
		}
	}
	
	function download($id = null){
		$this->layout = "blank";
		
		if(!empty($id)){
			$id = mysql_real_escape_string($id);
		
			$replay = $this->Replay->find("first", array("conditions"=>array("id"=>$id) ) );
			if(empty($replay)){
				 echo "The replay you are looking for does not exist.";
				 exit;
			}
			else{
				//Set downloaded plus one
				$downloaded = $replay["Replay"]["downloaded"];
				$downloaded += 1;
				
				$this->Replay = new Replay();
				$data["Replay"]["id"] = $id;
				$data["Replay"]["downloaded"] = $downloaded;
				$this->Replay->save($data);
				
				$filename = basename($replay["Replay"]["path"]);
	       		 
				$path = $_SERVER['DOCUMENT_ROOT']."/app/webroot".$replay["Replay"]["path"]; 
				 
				if ($handle = fopen ($path, "r")) {
				    $fsize = filesize($path);
				   
				    header("Content-type: application/octet-stream");
				    header("Content-Disposition: filename=\"".$filename."\"");
				    
				    header("Content-length: $fsize");
				    header("Cache-control: private"); //use this to open files directly
				    while(!feof($handle)) {
				        $buffer = fread($handle, 2048);
				        echo $buffer;
				    }
				}
				fclose ($handle);
				exit;
			}
		}
		else{
			echo "The replay you are looking for does not exist.";
			exit;
		}
	}
}
?>