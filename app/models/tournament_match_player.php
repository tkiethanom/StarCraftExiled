<?php
class TournamentMatchPlayer extends AppModel{
	var $name = 'TournamentMatchPlayer';		
	
	var $belongsTo = array(
					'User' => array(
							'className' => 'User',
							'foreignKey' => 'user_id',
						),
					'Race' => array(
							'className' => 'Race',
							'foreignKey' => 'race_id',
						),
					);
}
?>