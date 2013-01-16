<div class='avatar-frame'>
	<div class='avatar-portrait' 
		<?php 
		
			$a = $_SESSION["User"]["Avatar"];
		
			echo "style='background:url(/img/avatars/portraits-{$a["img_num"]}-75.jpg) no-repeat -{$a["x_value"]}px -{$a["y_value"]}px'";
		?>
	>		
	</div>
</div>
<a href="/avatars/changeAvatar" >Change Avatar</a>
<br style='clear:left'/>
<div  class='account-info'>
	<h5>Account Information</h5>
	<table>
		<tr><th>Username:</th><td><?php echo $_SESSION["User"]["username"] ?></td></tr>
		<tr><th>Email:</th><td><?php echo $_SESSION["User"]["email"] ?></td></tr>
		<tr><th>Rank:</th><td><?php echo $_SESSION["User"]["rank"] ?></td></tr>
		<tr><th>Role:</th><td><?php echo $_SESSION["User"]["role"] ?></td></tr>
	</table>	
</div>
<br style='clear:both'/>
<p><a href="/users/edit" >Edit Account</a></p>
<p><a href="/users/changePassword" >Change Password</a></p>