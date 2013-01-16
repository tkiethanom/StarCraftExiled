<?php

class TournamentsController extends AppController{
	var $name = 'Tournaments';
	var $uses = array('Tournament', 'TournamentMatch');
	
	function index(){
		$tournament = $this->Tournament->find('first', array('order'=>array('Tournament.created DESC') ) );		
		
		//Calculate number of rounds
		$rounds = ($tournament['Tournament']['num_players']/2)-1;

		//For each round get the matches
		$tournament_matches = array(); 
		for($i=1; $i <= $rounds; $i++){
			$tournament_matches[$i] = $this->TournamentMatch->find('all', array('conditions'=>array('TournamentMatch.tournament_id'=>$tournament['Tournament']['id'],
																			'TournamentMatch.round'=>$i),
												'order'=>array('TournamentMatch.created ASC'),
												'recursive'=>2, 
											) 
										);
		}
		
		
		$this->set('tournament_matches', $tournament_matches);
		$this->set('tournament', $tournament);
		$this->set('rounds', $rounds);
	}
}
?>