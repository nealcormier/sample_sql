<div id="team-listing-wrapper">
	<?php
		$event_options = "<option value='0'>select an event</option>";
		$counter = 1;
		$event_counts = db_query("SELECT Count(*) as Total FROM hodc_events WHERE Status = 1");
		foreach ($event_counts as $total) :
			$event_count = intval($total->Total);
		endforeach;
		$result_events = db_query("SELECT * FROM hodc_events WHERE Status = 1");
		foreach ($result_events as $event) {
			$event_options .= "<option value='$event->EventNo'>$event->Title</option>";
			?>
			<div class="listing-event-title"><?php echo $event->Title; ?> <span style="font-size: 75%;">[<a class="event-wrapper-link" en="<?php echo $event->EventNo; ?>" href="#">hide</a>]</span></div>
			<div id="event-wrapper-<?php echo $event->EventNo; ?>" class="event-wrapper">
				<?php
					$result_teams = db_query("SELECT * FROM hodc_teams WHERE EventNo = $event->EventNo AND Status = 1 ORDER BY Name");
					foreach ($result_teams as $team) {
						?>
						<div class="team-table-header" id="team-<?php echo $event->EventNo; ?>-<?php echo $team->TeamNo; ?>">
							<div class="listing-team-name"><?php echo $team->Name; ?></div>
							<span class="team-options">
								<a class="send-team-link" tn="<?php echo $team->TeamNo; ?>" ev="<?php echo $event->EventNo; ?>">Send</a>
								<a class="rename-team-link">Rename</a>
								<a class="delete-team-link" tn="<?php echo $team->TeamNo; ?>" ev="<?php echo $event->EventNo; ?>">Delete</a></span>
							<div style="clear:both;"></div>
						</div>
						<table id="event-<?php echo $event->EventNo; ?>-<?php echo $team->TeamNo; ?>">
							<tbody>
							<?php
								$result_volunteers = db_query("SELECT * FROM hodc_volunteers WHERE TeamNo = $team->TeamNo AND Status = 1 ORDER BY LastName, FirstName");
								foreach ($result_volunteers as $volunteer) {
									if ($team->TeamLeaderNo == $volunteer->VolunteerNo) :
										$team_leader_indicator = '*';
									else :
										$team_leader_indicator = '';
									endif;
									echo "<tr id='vn-$volunteer->VolunteerNo'>
											<td>
												$volunteer->FirstName $volunteer->LastName<span class='team-leader-indicator'>$team_leader_indicator</span> ($volunteer->ShirtSize)
											</td>
											<td>
												<a href='mailto:$volunteer->Email'>$volunteer->Email</a>
											</td>
											<td>
												$volunteer->Phone
											</td>
											<td>
												<a id='remove-delete-$volunteer->VolunteerNo' href='#' vn='$volunteer->VolunteerNo' ev='$event->EventNo' class='remove-team-member'>remove</a>
											</td>
										</tr>";
								}
							?>
							</tbody>
						</table>
					<?php
					}
				?>
				<div class="team-table-header">
					<div class="listing-team-name">Individuals</div>
					<div style="clear:both;"></div>
				</div>
				<table id="event-<?php echo $event->EventNo; ?>-0">
					<tbody>

					<?php
						$result_volunteers = db_query("SELECT * FROM hodc_volunteers WHERE TeamNo = 0 AND Status = 1 AND EventNo = $event->EventNo ORDER BY LastName, FirstName");
						foreach ($result_volunteers as $volunteer) {
							echo "<tr id='vn-$volunteer->VolunteerNo'>
								<td>
									$volunteer->FirstName $volunteer->LastName ($volunteer->ShirtSize)
								</td>
								<td>
									<a href='mailto:$volunteer->Email'>$volunteer->Email</a>
								</td>
								<td>
									$volunteer->Phone
								</td>
								<td>
									<a id='remove-delete-$volunteer->VolunteerNo' href='#' vn='$volunteer->VolunteerNo' class='delete-volunteer'>delete</a>
								</td>
								<td>
									<a href='#' vn='$volunteer->VolunteerNo' class='assign-volunteer'>assign</a>
								</td>
							</tr>";
						}
						if ($event_count == $counter) :
							?>
							<tr id="assign-wrapper">
								<td  colspan="4">
									<strong>Assign</strong>
									<form id="assign-to-team-form">
										<input type="hidden" id="fassignvolunteerno" name="fassignvolunteerno" value="" />
										<br />
										<strong>Event</strong>
										<br />
										<select id="fevent" name="fevent" class="select_menu large_text">
											<?php echo $event_options; ?>
										</select>
										<br />
										<strong>Team</strong>
										<br />
										<select id="fteam" name="fteam" class="select_menu large_text">
										</select>
										<br />
										<a href="#" id="assign-volunteer-link">Assign</a>
										&nbsp;
										&nbsp;
										<a href="#" id="cancel-assign-volunteer-link">Cancel</a>
									</form>
								</td>
							</tr>

						<?php
						endif;
						$counter++;
					?>
					</tbody>
				</table>
			</div>
		<?php
		}
	?>
</div>