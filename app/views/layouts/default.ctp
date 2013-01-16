<?php
$user_logged_in = false;

if(!empty($_SESSION["User"]) ){
	$user_logged_in = true;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		SC Exiled<?php if(!empty($title_for_layout)){ echo " - ".$title_for_layout; }?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array('reset','style','tournament','form','comment',) );
		echo $this->Html->script('jquery');
		echo $this->Html->script('tiny_mce/tiny_mce');
		echo $this->Html->script('tiny_mce/my_tiny_mce');
		echo $this->Html->script('tiny_mce/my_tiny_mce');
		echo $this->Html->script('comment_reply');
		echo $this->Html->script('ajax_rating');
		
		echo $scripts_for_layout;
	?>
	<meta name="description" content="Exiled is a StarCraft Replay site for friends who are a part of StarCraft Exiled. Exiled was created in 2000 and still exists today" />	
	
	<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-398472-15']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
	</script>	
</head>
<body>
	<div id="container">
		<?php if($user_logged_in): ?>
			<div id="user-bar-wrapper">
				<div id="user-bar">
					<div id="logo-section"><a href='/home'></a></div>
					<div id="user-section">Welcome, <?php echo $_SESSION["User"]["username"] ?> | <a href='/logout' >log out</a></div>
					<div id="account-section"><a href='/users/account' >Account</a></div>
				</div>
			</div>
		<?php endif; ?>
		<div id="header">		
			<h1 onclick="window.location = '/home'">StarCraft Exiled</h1>
		</div>
		<?php if(!$user_logged_in): ?>
			<div id="content-top">
				<h3 id="page-title"><?php echo $title_for_layout ?></h3>
				<?php echo $this->Session->flash(); ?>
			</div>
		<?php else: ?>
			<div id="content-top-nav">
				<div id="navigation">
					<ul>
						<li <?php if($this->params["controller"] == "main" && $this->params["action"] == "index"){ echo "class='active'";} ?> >
							<a href='/home' ><span id="home-button">Home</span></a>
						</li>
						<li <?php if($this->params["url"]["url"] == "replays"){ echo "class='active'";} ?> >
							<a href='/replays' ><span id="replay-button">Replays</span></a>
						</li>
						<li <?php if($this->params["url"]["url"] == "tournaments"){ echo "class='active'";} ?> >
							<a href='/tournaments' ><span id="tournament-button">Tournament</span></a>
						</li>
					</ul>
				</div>
				<h3 id="page-title"><?php echo $title_for_layout ?></h3>
				<?php echo $this->Session->flash(); ?>
			</div>
		<?php endif; ?>
		<div id="content">
			<div id="content-inner" >
			<?php if(!empty($back_link)){ echo "<p><a id='back-link' href='{$back_link["url"]}' >{$back_link["text"]}</a></p>"; } ?>
			<?php echo $content_for_layout; ?>
			<br style='clear:both'/>
			</div>
		</div>
		<div id="content-bottom"></div>
		<div id="footer">
			Created by thawtful.com. Original Images &copy;2010 Blizzard Entertainment, Inc. All rights reserved			
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>