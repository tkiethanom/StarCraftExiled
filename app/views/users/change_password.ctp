<p>Change your password using the fields below.</p>
<form id="UserRegisterForm" method="post" action="/users/changePassword" accept-charset="utf-8" class="form">
    <?php
        echo $form->input('User.old_password',  array('class'=>'password', 'type'=>'password','div'=>'form-row', 'after'=>'<br style="clear:both"/>'));   //password
        echo $form->input('User.password',  array('class'=>'password', 'label'=>'New Password', 'type'=>'password','div'=>'form-row', 'after'=>'<br style="clear:both"/>'));   //password
        echo $form->input('User.password_confirm',  array('class'=>'password', 'type'=>'password', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));   //password       
    ?>

	<div class="form-row form-row-submit">		
		<label >&nbsp;</label>		
		<div class="submit-button"><input type="submit" value="Submit" /><br style='clear:both'/></div>
		<br style='clear:both'/>
	</div>
	<div class="form-row form-row-submit">		
		<label >&nbsp;</label>		
		<div><p>or <a href='/users/account' >Cancel</a></p></div>		
	</div>
</form>	
