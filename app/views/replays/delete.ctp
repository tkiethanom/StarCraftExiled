<?php if(!empty($replay)): ?>
	<form id="ReplayDeleteForm" method="post" action="/replays/delete/<?php echo $replay["Replay"]["id"] ?>" accept-charset="utf-8" class="form">
	<p>Are you sure you would like to delete <b><?php echo $replay["Replay"]["title"] ?></b>?</p>
	<div class="form-row form-row-submit">		
		<label >&nbsp;</label>		
		<div class="submit-button"><input type="submit" value="Delete"/><br style='clear:both'/></div>
		<br style='clear:both'/>
	</div>
	<div class="form-row form-row-submit">		
		<label >&nbsp;</label>		
		<div><p>or <a href='/replays/view/<?php echo $replay["Replay"]["id"] ?>' >Cancel</a></p></div>		
	</div>
	<input type='hidden'  name="data[Replay][delete]" value='1' />
</form>	
<?php endif; ?>