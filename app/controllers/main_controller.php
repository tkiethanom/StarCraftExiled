<?php

class MainController extends AppController {
	var $name = 'Main';
	var $uses = array('Article', 'Replay');
	
	function index(){
		$this->set('title_for_layout', 'Welcome to the Void!');
		
		$articles = $this->Article->find("all", array("order"=>array("date DESC"),"limit"=>5) );
		
		$latest_replays = $this->Replay->find("all", array("order"=>array("created DESC"), "limit"=>5 ) );
		$this->set("latest_replays", $latest_replays);
		
		$rated_replays = $this->Replay->query("SELECT Replay.*, IFNULL(ReplayRating.total, 0) FROM replays Replay LEFT JOIN 
												(SELECT SUM(value) AS total, replay_id FROM replay_ratings GROUP BY replay_id)
												AS ReplayRating ON ReplayRating.replay_id = Replay.id 
												ORDER BY IFNULL(ReplayRating.total, 0) DESC, Replay.created DESC 
												LIMIT 5");

		$this->set("articles", $articles);
		$this->set("latest_replays", $latest_replays);
		$this->set("rated_replays", $rated_replays);
	}
}

?>