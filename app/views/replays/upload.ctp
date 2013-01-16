
<p>Complete the following information and select the replay you would like to upload.</p>
<form id="ReplayUploadForm" enctype="multipart/form-data" method="post" action="/replays/upload" accept-charset="utf-8" class="form">
    <?php
        echo $form->input('Replay.title', array('class'=>'text', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));   //text
        echo $form->input('Replay.game_type_id', array('label'=>'Game Type','type'=>'select', 'class'=>'select', 'options'=>$game_types, 'empty' => 'Select a Game Type', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));
        echo $form->input('Replay.map_id', array('label'=>'Map','type'=>'select', 'class'=>'select', 'options'=>$maps, 'empty' => 'Select a Map', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));
    ?>
    <?php /*<div class="form-row form-row-submit">		
		<label >&nbsp;</label>		
   		<div><p style='margin-top:0px'><a href="http://www.shacknews.com/onearticle.x/64920" target="_blank" >Map Reference</a></p></div>
   	</div>*/
	?>
    <?php
        echo $form->input('Replay.description', array('class'=>'textarea mceEditor', 'type'=>'textarea', 'div'=>'form-row', 'after'=>''));   //text
        echo $form->input('Replay.replay_file', array('type'=>'file', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));
    ?>

	<div class="form-row form-row-submit">		
		<label >&nbsp;</label>		
		<div class="submit-button"><input type="submit" value="Upload" /><br style='clear:both'/></div>
		<br style='clear:both'/>
	</div>
	<div class="form-row form-row-submit">		
		<label >&nbsp;</label>		
		<div><p>or <a href='/replays' >Cancel</a></p></div>		
	</div>
</form>	
