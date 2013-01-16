<?php
class Replay extends AppModel{
	var $name = 'Replay';
	
	var $validate = array(
    	'title' => array('required' => array ('rule'=>'notEmpty', 
    												'message' => 'Title cannot be left blank') ),
        'description' => array('required' => array ('rule'=>'notEmpty', 
    												'message' => 'Description cannot be left blank.') ),
		'game_type_id' => array('required' => array ('rule'=>'notEmpty', 
    												'message' => 'Game Type cannot be left blank.') ),		
		'map_id' => array('required' => array ('rule'=>'notEmpty', 
    												'message' => 'Map cannot be left blank.') ),
    );
    
    function getReplay($id){
    	$replay = $this->query("SELECT Replay.*, User.username, User.avatar_id, GameType.name, Map.name, CommentCount.total, IFNULL(ReplayRating.total, 0)
									FROM users User, game_types GameType, maps Map, replays Replay LEFT JOIN 
										(SELECT COUNT(id) AS total, replay_id FROM replay_comments GROUP BY replay_id) AS CommentCount
										ON CommentCount.replay_id = Replay.id
										LEFT JOIN (SELECT SUM(value) AS total, replay_id FROM replay_ratings GROUP BY replay_id) AS ReplayRating
										ON ReplayRating.replay_id = Replay.id
									WHERE Replay.user_id = User.id
										AND Replay.game_type_id = GameType.id
										AND Replay.map_id = Map.id	
										AND Replay.id = '$id';
									");
		return $replay;
    }
    
    function getReplayList($params, $limits){
    	$filter = $this->getFilterQuery($params);
		$order = $this->getOrder($params);
		$replays = $this->query("SELECT Replay.*, User.username, GameType.short_code, Map.name, CommentCount.total, IFNULL(ReplayRating.total, 0)
									FROM users User, game_types GameType, maps Map, replays Replay LEFT JOIN 
										(SELECT COUNT(id) AS total, replay_id FROM replay_comments GROUP BY replay_id) AS CommentCount
										ON CommentCount.replay_id = Replay.id
										LEFT JOIN (SELECT SUM(value) AS total, replay_id FROM replay_ratings GROUP BY replay_id) AS ReplayRating
										ON ReplayRating.replay_id = Replay.id
									WHERE Replay.user_id = User.id
										AND Replay.game_type_id = GameType.id
										AND Replay.map_id = Map.id	
										$filter									
									ORDER BY $order, Replay.created DESC
									$limits ");
		return $replays;		
    }
    
 	function getReplayListCount($params){
 		$filter = $this->getFilterQuery($params);
		$replays = $this->query("SELECT COUNT(*) AS total 
									FROM replays Replay, users User, game_types GameType, maps Map
									WHERE Replay.user_id = User.id
										AND Replay.game_type_id = GameType.id
										AND Replay.map_id = Map.id
										$filter
									");
		return $replays[0][0]["total"];		
    }
    
    function getFilterQuery($params){
    	$output = "";
    	if(!empty($params['g']) ){
    		$g = mysql_real_escape_string($params['g']);
    		$output .= " AND Replay.game_type_id = '$g' ";
    	}
    	if(!empty($params['m']) ){
    		$m = mysql_real_escape_string($params['m']);
    		$output .= " AND Replay.map_id = '$m' ";
    	}
    	return $output;
    }
    
    function getOrder($params){
    	$order = "Replay.created DESC";
		if(!empty($params['o']) && !empty($params['s']) ){
			switch($params['o']){
				case "created":
					$order = "Replay.created";
					break;
				case "downloaded":
					$order = "Replay.downloaded";
					break;
				case "comments":
					$order = "CommentCount.total";
					break;
				case "ratings":
					$order = "IFNULL(ReplayRating.total, 0)";
					break;
			}
			switch($params['s']){
				case "ASC":
					$order .= " ASC";
					break;
				case "DESC":
					$order .= " DESC";
					break;
			}
		}
		return $order;
    }
    
    function uploadReplayFile($data){
    	$output = null;
    	
    	if($data["Replay"]["replay_file"]["error"] == 0){
    		$month = date("m");
    		$year = date("Y");
			$target_path = "../webroot/uploads/replays/$year/$month/";

    		if(!file_exists("../webroot/uploads/replays/$year")){
				mkdir("../webroot/uploads/replays/$year");
			}
			
    		if(!file_exists("../webroot/uploads/replays/$year/$month")){
				mkdir("../webroot/uploads/replays/$year/$month");
			}
			
			$target_path = $target_path .date("YmdHis")."_". basename( $data["Replay"]["replay_file"]["name"]); 
			
			if(move_uploaded_file( $data["Replay"]["replay_file"]['tmp_name'], $target_path)) {
			    $output = "/uploads/replays/$year/$month/".date("YmdHis")."_".basename( $data["Replay"]["replay_file"]["name"]);
			}
		}
		else{
			$err = "";
			switch ($data["Replay"]["replay_file"]["error"]) {
		        case 1:
		            $err =  'The uploaded file exceeds the upload_max_filesize directive in php.ini';
		        case 2:
		            $err =  'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
		        case 3:
		            $err =  'The uploaded file was only partially uploaded';
		        case 4:
		            $err =  'No file was uploaded';
		        case 5:
		            $err =  'Missing a temporary folder';
		        case 6:
		            $err =  'Failed to write file to disk';
		        case 7:
		            $err =  'File upload stopped by extension';
		        default:
		            $err =  'Unknown upload error';
		    }     		
		}
		
		return $output;
    }
    
    function deleteReplayFile($replay){
    	unlink("../webroot".$replay["Replay"]["path"]);
    }
    
    function saveReplay($data, $path){
    	$output = false;
    	
    	$data["Replay"]["user_id"] = $_SESSION["User"]["id"];
    	$data["Replay"]["path"] = $path;
    	$data["Replay"]["created"] = date("Y-m-d H:i:s");
		$data["Replay"]["modified"] = date("Y-m-d H:i:s");
		
    	if($this->save($data)){
    		$output = true;
    	}
    	
    	return $output;
    }

	//Gets the current page using the $_GET["page"] variable
	//Returns 1 otherwise
	function _getCurrPage($params){
		$output = 1;
		if(!empty($params["p"])){
			$curr_page = $params["p"];
			if(is_numeric($curr_page) && $curr_page > 0){
				$output = $curr_page;
			}
		}
		
		return $output;
	}
	
	//Creates the limits query string using the current page passed in,
	// and the number of rows per page
	function _getLimits($curr_page, $row_per_page){
		$output = " LIMIT $row_per_page ";
		
		if($curr_page > 1){
			$offset = ($curr_page-1) * $row_per_page;
			$output = " LIMIT $offset, $row_per_page" ;
		}
		
		return $output;
	}
	
	//Creates the Prev Numbers and Next links using the total number of rows
	//the current page and the number of rows per page
	function _getPagingLinks($total_rows, $curr_page, $rows_per_page, $params){
		$output = "";	
		$total_pages = ceil($total_rows/$rows_per_page);	
				
		$url = "/replays/index";
			
		if($total_pages > 1){
			$output .= "<div class='paging'>";		
			
			$tens = ceil($total_pages/10);
			$lowPage = $curr_page - 5;
			if($lowPage <= 0 ){
				$lowPage = 0;
			}
			$highPage = $lowPage + 10;
			
			if($highPage >= $total_pages){
				$highPage = $total_pages;
				$lowPage = $highPage - 10;
			}			
			
			if($lowPage > 0){
				$params['p'] = $lowPage;
				$output .= "<div class='paging-link'><a href='$url/".$this->encode_query_string($params)."' >...</a></div>";
			}
			if($curr_page > 1){
				$prev = $curr_page-1;			
				$params['p'] = $prev;
				$output .= "<div class='paging-link'><a href='$url/".$this->encode_query_string($params)."'>&laquo; Prev</a></div> ";			
			}
			
			for($i = $lowPage+1; $i < $highPage+1 ; $i++){
				if($i > 0){
					$current = "";
					if($curr_page == $i){
						$current = "current";
					}
					$params['p'] = $i;
					$output .= "<div class='paging-link $current'><a href='$url/".$this->encode_query_string($params)."'>$i</a></div>";
				}
			}
			if($curr_page < $total_pages){
				$next = $curr_page+1;
				$params['p'] = $next;
				$output .= "<div class='paging-link'><a href='$url/".$this->encode_query_string($params)."'>Next &raquo;</a></div> ";
			}				
			if($i <= $total_pages){
				$params['p'] = $i;
				$output .= "<div class='paging-link'><a href='$url/".$this->encode_query_string($params)."' >...</a></div>";
			}
			
			$output .= "<br style='clear:left;'/></div>";
		}
		
		return $output;
	}
	
	function encode_query_string($params, $first = true){
		$count = 0;
		$q_string = "";
		if(!empty($params)){
			foreach($params as $key => $value){
				if($key != 'url'){
					if($count == 0 && $first){
						$q_string .= "?";
					}
					else{
						$q_string .= "&";
					}
					$q_string .= $key."=".$value;
					$count++;
				}
			}
		}
		
		return $q_string;
	}
}
?>