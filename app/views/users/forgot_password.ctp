<p>Enter your email address and a generated password will be sent to you.</p>
<form id="UserForgotPasswordForm" method="post" action="/users/forgotPassword" accept-charset="utf-8" class="form">
    <?php
        echo $form->input('User.email', array('class'=>'text', 'div'=>'form-row', 'after'=>'<br style="clear:both"/>'));   //text               
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
