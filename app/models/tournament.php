<?php
class Tournament extends AppModel{
	var $name = 'Tournament';
	
	var $hasMany = array(
					'TournamentMatch' => array(
							'className' => 'TournamentMatch',
							'foreignKey' => 'tournament_id',
						),
					);
}
?>