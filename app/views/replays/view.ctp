<?php if(!empty($replay)): ?>
<div class='sub-content replay-container replay-view'>
	<div class='replay-id'><?php echo $replay["Replay"]["id"]?></div>
	<?php if($replay["Replay"]["user_id"] == $_SESSION["User"]["id"] ||
			in_array("replay_admin", $_SESSION["User"]["permissions"])): ?>
		<div id='replay-owner-controls'>
			<h5>Owner Controls</h5>
			<p><a href='/replays/edit/<?php echo $replay["Replay"]["id"] ?>' >Edit Replay Information</a></p>
			<p><a href='/replays/delete/<?php echo $replay["Replay"]["id"] ?>' >Delete Replay</a></p>
		</div>
	<?php endif; ?>

	<h5>Uploaded By:</h5>
	<div class='avatar-frame'>
		<a href='/profile/<?php echo $replay["Replay"]["user_id"] ?>' >
		<span class='avatar-portrait' 
			<?php 
				$a = $replay["User"]["avatar"]["Avatar"];
			
				echo "style='background:url(/img/avatars/portraits-{$a["img_num"]}-75.jpg) no-repeat -{$a["x_value"]}px -{$a["y_value"]}px'";
			?>
		>		
		</span></a>
	</div>
	<a href='/profile/<?php echo $replay["Replay"]["user_id"] ?>' ><?php echo $replay["User"]["username"] ?></a>
	<br/>
	<br/>

	<h5>Upload Date:</h5>
	<p><?php echo date("m/d/Y", strtotime($replay["Replay"]["created"]) ) ?></p>
	<h5>Description:</h5>
	<div>
		<?php echo $replay["Replay"]["description"]?>
	</div>
	
	<h5>GameType:</h5>
	<p><?php echo $replay["GameType"]["name"] ?></p>
	
	<h5>Map:</h5>
	<p><?php echo $replay["Map"]["name"] ?></p>
	
	<h5>Downloaded:</h5>
	<p><?php echo $replay["Replay"]["downloaded"] ?> times</p>
	
	<h5>Replay File:</h5>
	<p><a class="download-replay-link" href='/replays/download/<?php echo $replay["Replay"]["id"] ?>' >Download Replay</a><br style='clear:both'/></p>
	
	<h5>Rating:</h5>
	<?php
		$replay["ReplayRating"]["total"] = $replay[0]["IFNULL(ReplayRating.total, 0)"];
		
		if($replay["ReplayRating"]["total"] > 0){
			$replay["ReplayRating"]["total"] = "+".$replay["ReplayRating"]["total"];
		}
	?>
	<p><span class='rating-value' style='float:left'><?php echo $replay["ReplayRating"]["total"] ?></span><span class='ajax-loader' style='float:left'></span><br style='clear:left'/></p>
	
	<h5>Rate It:</h5>
	
	<p><a class="rate-up-link" href='/replayRatings/submitRatings/' >Rate Up</a> <a class="rate-down-link" href='/replayRatings/submitRatings/' >Rate Down</a><br style='clear:left'/></p>
	
	<?php if(!empty($comments)): ?>
	<div id="comments" >
		<h5>Comments</h5>
		<?php echo $this->ReplayCommentThread->generateThread($comments)?>						
	</div>
	<?php endif; ?>	
</div>
<form id="ReplayCommentForm" method="post" action="/replayComments/submitComment" accept-charset="utf-8" class="form">
    <?php
        echo $form->input('ReplayComment.comment', array('class'=>'textarea mceEditor', 'type'=>'textarea', 'div'=>'form-row', 'after'=>''));
    ?>
    <input type='hidden' name='data[ReplayComment][parent_id]' id='ReplayCommentParentId' value='0' />
    <input type='hidden' name='data[ReplayComment][replay_id]' value='<?php echo $replay["Replay"]["id"] ?>' />
	<div class="form-row form-row-submit">		
		<label >&nbsp;</label>		
		<div class="submit-button"><input type="submit" value="Submit" /><br style='clear:both'/></div>
		<br style='clear:both'/>
	</div>
	<div class="form-row form-row-submit" id='form-row-cancel-reply'>		
		<label >&nbsp;</label>		
		<div><p>or <a href='' >Cancel Reply</a></p></div>		
	</div>				
</form>	
<?php endif; ?>