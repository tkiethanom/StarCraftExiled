<?php 
	echo $tournament['Tournament']['name'];
	
	echo "<table class='tournament'><tr>";
		foreach($tournament_matches as $round_num => $round){
			$class_round = '';
			if($round_num > 1){
				$class_round = 'tournament-round-inner';
			}
			echo "<td class='tournament-round $class_round'>";
			foreach($round as $match){
				echo "<div class='tournament-match'>";
				
				for($i = 0; $i < 2; $i++){
					if(!empty($match['TournamentMatchPlayer'][$i])){
						$player = $match['TournamentMatchPlayer'][$i];
						echo "<div class='match-info'>
									<div class='match-player'>
										<div class='wins'>{$player['wins']}</div>
										<div class='race-symbol race-symbol-{$player['Race']['name']}'></div>			
										<div class='name'><a href='/profile/{$player['User']['id']}' >{$player['User']['username']}</a></div>
										<br style='clear:left'/>
									</div>
								</div>";
					}
					else{
						echo "<div class='match-info match-info-inactive'>
								<div class='match-player'>
								</div>
							</div>";
					}
				}
				echo "</div>";
			}
			echo "</td>";
		}
	echo "</tr></table>";
?>