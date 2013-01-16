<p>Enter your personal information to below.</p>
<form id="UserRegisterForm" method="post" action="/users/register" accept-charset="utf-8" class="form">
    <?php
        echo $form->input('User.username', array('class'=>'text', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));   //text
        echo $form->input('User.email', array('class'=>'text', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));   //text
        echo $form->input('User.password',  array('class'=>'password', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));   //password
        echo $form->input('User.password_confirm',  array('class'=>'password', 'type'=>'password', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));   //password       
    ?>

	<div class="form-row form-row-submit">		
		<label >&nbsp;</label>		
		<div class="submit-button"><input type="submit" value="Submit" /><br style='clear:both'/></div>
		<br style='clear:both'/>
	</div>
	<div class="form-row form-row-submit">		
		<label >&nbsp;</label>		
		<div><p>or <a href='/users/login' >Cancel</a></p></div>		
	</div>
</form>	
