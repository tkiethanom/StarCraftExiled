<p><a href='/users/account' >&laquo; Back to Account</a></p>
<div class='avatar-list'>
<?php foreach($avatars as $avatar): ?>
	<div class='avatar-frame'>
	<a onclick='return confirm("Are you sure you would like to use this Avatar?");' href='/avatars/submitChange/<?php echo $avatar["Avatar"]["id"] ?>' ><span class='avatar-portrait' 
		<?php 
			$a = $avatar["Avatar"];		
			echo "style='background:url(/img/avatars/portraits-{$a["img_num"]}-75.jpg) no-repeat -{$a["x_value"]}px -{$a["y_value"]}px'";
		?>
	>		
	</span></a>
	</div>
<?php endforeach; ?>
</div>