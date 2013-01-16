<p>Enter your login information to proceed.</p>
<form id="UserLoginForm" method="post" action="/users/login" accept-charset="utf-8" class="form">
    <?php
        echo $form->input('User.username', array('class'=>'text', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));   //text
        echo $form->input('User.password',  array('class'=>'text', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));   //password       
    ?>

	<div class="form-row form-row-submit">		
		<label >&nbsp;</label>		
		<div class="submit-button"><input type="submit" value="Submit" /><br style='clear:both'/></div>
		<br style='clear:both'/>
	</div>
	<p><a href='/users/forgotPassword' >Forgot Password?</a></p>
	<p>If you do not have an account please <a href='/users/register' >Register</a>.</p>
</form>	
