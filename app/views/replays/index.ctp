<?php 

?>
<div id='replay-list-sidebar'>
	<div id='replay-list-sorting'>
		<h5>Sorting</h5>
		<?php 
			foreach($sorting_links as $key => $link){
				$current = "";
				if(empty($_GET['o']) && $key == 'created' ){
					$current = "class='current'";
				}
				elseif(!empty($_GET['o']) && $key == $_GET['o']){ 
					$current = "class='current'";
				}
				echo "<p><a $current href='/replays/index/{$link["url"]}' >{$link["link"]}</a></p>";
			}
		?>		
	</div>
	<div id='replay-list-filters'>
		<h5>Filters</h5>
		<form action='' method='get'>
		<?php 
			$g = "";
			if(!empty($_GET['g']) ){
				$g = $_GET['g'];
			}
			$m = "";
			if(!empty($_GET['m']) ){
				$m = $_GET['m'];
			}
			echo $form->input('Replay.game_type_id', array('selected'=>$g, 'name'=>'g', 'label'=>'Game Type','type'=>'select', 'class'=>'select', 'options'=>$game_types, 'empty' => 'Select a Game Type', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));
	        echo $form->input('Replay.map_id', array('selected'=>$m,'name'=>'m', 'label'=>'Map','type'=>'select', 'class'=>'select', 'options'=>$maps, 'empty' => 'Select a Map', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));
	        ?>
	    <div class="form-row form-row-submit">		
			<label >&nbsp;</label>		
			<div class="submit-button"><input type="submit" value="Filter" /><br style='clear:both'/></div>
			<br style='clear:right'/>
		</div>
		</form>
	</div>
</div>

<div id='replay-list-controls'>
	<div id='replay-list-upload-link'><a href='/replays/upload' >Upload a Replay</a><br style='clear:left;'/></div>
	<br/>
	<?php echo $paging ?>
	
</div>
<?php if(!empty($replays) ):
		foreach($replays as $replay): 
			$replay["ReplayRating"]["total"] = $replay[0]["IFNULL(ReplayRating.total, 0)"];

			if($replay["ReplayRating"]["total"] > 0){
				$replay["ReplayRating"]["total"] = "+".$replay["ReplayRating"]["total"];
			}
		?>
			<div class='sub-content replay-container left-container'>
				<div class='replay-id'><?php echo $replay["Replay"]["id"]?></div>
				<h5 class='replay-list-title'><a href='/replays/view/<?php echo $replay["Replay"]["id"] ?>' >
					<?php echo $replay["Replay"]["title"]?></a>
				</h5>
				<div class='replay-list-title-info'>
					<a href='/profile/<?php echo $replay["Replay"]["user_id"] ?>' ><?php echo $replay["User"]["username"] ?></a> - 
					<?php echo date("m.d.Y", strtotime($replay["Replay"]["created"]) ) ?>
				</div>
				<br style='clear:left'/>
				<div class='replay-list-description'><?php echo $replay["Replay"]["description"]?></div>
				
				<div class='replay-list-info'><p>Downloaded (<?php echo $replay["Replay"]["downloaded"] ?>)</p></div>				
				<div class='replay-list-info'><p>Game Type (<?php echo $replay["GameType"]["short_code"] ?>)</p></div>
				<div class='replay-list-info'><p>Map (<?php echo $replay["Map"]["name"] ?>)</p></div>
				<div class='replay-list-info'><p>Rating (<span class='rating-value'><?php echo $replay["ReplayRating"]["total"] ?></span>)<span class='ajax-loader'></span></p></div>
				<br style='clear:left'/>
				<div class='replay-list-info'>
					<a class="download-replay-link" href='/replays/download/<?php echo $replay["Replay"]["id"] ?>' >Download Replay</a>
				</div>
				<div class='replay-list-info'>
					<a class="comment-replay-link" href='/replays/view/<?php echo $replay["Replay"]["id"] ?>/#comments' >Comments (<?php echo empty($replay["CommentCount"]["total"])? 0 : $replay["CommentCount"]["total"]; ?>)</a>
				</div>
				<div class='replay-list-info'>
					<a class="rate-up-link" href='/replayRatings/submitRatings/' >Rate Up</a>
				</div>
				<div class='replay-list-info'>
					<a class="rate-down-link" href='/replayRatings/submitRatings/' >Rate Down</a>
				</div>
				<br style='clear:left'/>
			</div>
<?php	endforeach;
endif; ?>
<?php if(count($replays) >= 5): ?>
	<br style='clear:left'/>
	<br/>
	<?php echo $paging ?>
<?php endif; ?>
