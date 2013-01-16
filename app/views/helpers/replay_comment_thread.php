<?php
class ReplayCommentThreadHelper extends AppHelper {
    
	function generateThread($comments) {
		$output = "";
		
		
		
		if(!empty($comments) ){
			foreach($comments as $comment){
				$a = $comment["Avatar"];
				$avatar = "
				<div class='avatar-frame'>
				<a href='/profile/{$comment["User"]["id"]}' >
				<span class='avatar-portrait' 
					style='background:url(/img/avatars/portraits-{$a["img_num"]}-75.jpg) no-repeat -{$a["x_value"]}px -{$a["y_value"]}px' >		
				</span></a>
				</div>";	
			
				$output .= "<div class='comment'>
								<div class='comment-top'>
									$avatar
									<div class='comment-username'>
										<a href='/profile/{$comment["User"]["id"]}' >
											{$comment["User"]["username"]}
										</a>
									</div>
									<div class='comment-date'>".date("m/d/Y", strtotime($comment["ReplayComment"]["created"]) )."</div>
									<br style='clear:left'/>
								</div>
								<div class='comment-content' >
									<div class='comment-id'>{$comment["ReplayComment"]["id"]}</div>
									<div class='comment-body'>{$comment["ReplayComment"]["comment"]}</div>
									<div class='comment-controls'>
										<a href='' class='comment-replay-link'>Reply</a>";
				if($_SESSION["User"]["id"] == $comment["ReplayComment"]["user_id"] ||
					in_array("replay_comment_admin", $_SESSION["User"]["permissions"])){
					$output .= "<a onclick='return confirm(\"Are you sure you would like to delete this comment?\");' href='/replayComments/deleteComment/{$comment["ReplayComment"]["id"]}'>Delete</a>";						
				}
				$output .= "</div>
							<br style='clear:both'/>
							</div>";
				if(!empty($comment["ReplayComment"]["children"])){
					$output .= $this->generateThread($comment["ReplayComment"]["children"]);
				}
				$output .= "</div>";
			}
		}
		
		return $output;
    }   
}

?>
