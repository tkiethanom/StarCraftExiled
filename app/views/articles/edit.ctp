<form id="ArticleEditForm" method="post" action="/articles/edit/<?php echo $article_id ?>" accept-charset="utf-8" class="form">
    <?php
    echo $form->input('Article.date', array('class'=>'date','dateFormat'=>'YMD', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));   //text
    echo $form->input('Article.body', array('class'=>'textarea mceEditor', 'type'=>'textarea', 'div'=>'form-row', 'after'=>''));
     ?>

	<div class="form-row form-row-submit">		
		<label >&nbsp;</label>		
		<div class="submit-button"><input type="submit" value="Update" /><br style='clear:both'/></div>
		<br style='clear:both'/>
	</div>
	<div class="form-row form-row-submit">		
		<label >&nbsp;</label>		
		<div><p>or <a href='/home' >Cancel</a></p></div>		
	</div>
</form>	
