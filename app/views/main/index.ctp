<?php 
	if(in_array("article_admin", $_SESSION["User"]["permissions"])){
		echo "<p><a href='/articles/add' >Add Article</a></p>";
	}
?>
<div class="sub-content left-container">
	
	<h5>News</h5>
	<?php
		
		foreach($articles as $article){
			$edit_link = "";
			if(in_array("article_admin", $_SESSION["User"]["permissions"] ) ){
				$edit_link="<p style='text-align:right'><a href='/articles/edit/{$article["Article"]["id"]}' >Edit Article</a></p>";
			}
			
			$date = date("m.d.Y", strtotime($article["Article"]["date"]) );
			
			echo "<div class='news'>
					<div class='news-date'><p>$date - </p></div>
					<div class='news-body'>{$article["Article"]["body"]}</div>					
					<br style='clear:left'/>
					$edit_link					
					</div>
					";
		}
	?>
	
	<br style='clear:both'/>
</div>	
<div class="sidebar-top"></div>
<div class="sidebar">
	<div class="sidebar-title latest-title">Latest Replays</div>
	<?php 
	foreach($latest_replays as $latest_replay){
		echo "<div class='link-list'><a href='/replays/view/{$latest_replay["Replay"]["id"]}'>{$latest_replay["Replay"]["title"]}</a></div>";
	}
	?>
	<div class="sidebar-title rated-title">Highest Rated Replays</div>
	<?php 
	foreach($rated_replays as $rated_replays){
		echo "<div class='link-list'><a href='/replays/view/{$rated_replays["Replay"]["id"]}'>{$rated_replays["Replay"]["title"]}</a></div>";
	}	
	?>
</div>
<div class="sidebar-bottom"></div>