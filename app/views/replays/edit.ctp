<?php if(!empty($this->data)): ?>
<p>Update your replay information below.</p>
<form id="ReplayEditForm" method="post" action="/replays/edit/<?php echo $id ?>" accept-charset="utf-8" class="form">
    <?php
        echo $form->input('Replay.title', array('class'=>'text', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));   //text
        echo $form->input('Replay.game_type_id', array('label'=>'Game Type','type'=>'select', 'class'=>'select', 'options'=>$game_types, 'empty' => 'Select a Game Type', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));
        echo $form->input('Replay.map_id', array('label'=>'Map','type'=>'select', 'class'=>'select', 'options'=>$maps, 'empty' => 'Select a Map', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));
    ?>
    <?php
    	/*<div class="form-row form-row-submit">		
		<label >&nbsp;</label>		
   		<div><p style='margin-top:0px'><a href="http://www.shacknews.com/onearticle.x/64920" target="_blank" >Map Reference</a></p></div>
   	</div>
   	*/
    ?>
    <?php
        echo $form->input('Replay.description', array('class'=>'textarea mceEditor', 'type'=>'textarea', 'div'=>'form-row', 'after'=>''));   //text        
    ?>

	<div class="form-row form-row-submit">		
		<label >&nbsp;</label>		
		<div class="submit-button"><input type="submit" value="Update" /><br style='clear:both'/></div>
		<br style='clear:both'/>
	</div>
	<div class="form-row form-row-submit">		
		<label >&nbsp;</label>		
		<div><p>or <a href='/replays/view/<?php echo $id ?>' >Cancel</a></p></div>		
	</div>
</form>	
<?php endif; ?>
