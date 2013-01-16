<?php
class TournamentMatch extends AppModel{
	var $name = 'TournamentMatch';		
	
	var $hasMany = array(
					'TournamentMatchPlayer' => array(
							'className' => 'TournamentMatchPlayer',
							'foreignKey' => 'tournament_match_id',
						)
					);
					
}
?>