<?php if(!empty($user)): ?>

<div  class='account-info'>

	<h5>Profile Information</h5>
	<div class='avatar-frame'>
		<div class='avatar-portrait' 
			<?php 
				$a = $user["Avatar"];
			
				echo "style='background:url(/img/avatars/portraits-{$a["img_num"]}-75.jpg) no-repeat -{$a["x_value"]}px -{$a["y_value"]}px'";
			?>
		>		
		</div>
	</div>
	<table>
	
		<tr><th>Username:</th><td><?php echo $user["User"]["username"] ?></td></tr>
		<tr><th>Rank:</th><td><?php echo $user["User"]["rank"] ?></td></tr>
		<tr><th>Role:</th><td><?php echo $user["User"]["role"] ?></td></tr>
	</table>	
</div>
<br style='clear:left'/>
<div class='sub-content profile-replay-list'>
	<h5>Replay List</h5>
	<?php if(!empty($replays) ): ?>
	<ul>
		<?php 
		foreach($replays as $replay){
			echo "<li><a href='/replays/view/{$replay["Replay"]["id"]}'>{$replay["Replay"]["title"]}</a></li>";	 
		}
		?>
	</ul>
	<?php endif; ?>
</div>
<?php endif; ?>