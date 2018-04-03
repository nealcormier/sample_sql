<div id="team-listing-wrapper">
	<?php
		$result = db_query("SELECT SUM(Amount) as TotalDonations, d.TeamNo, t.Name FROM hodc_donations d LEFT JOIN hodc_teams t ON d.TeamNo = t.TeamNo  WHERE d.TeamNo > 0 and d.Status = 1 GROUP BY d.TeamNo ORDER BY TotalDonations DESC LIMIT 0,50");
		$counter = 1;
	?>
	<div>
		<!--<p class="donate-block-right-title">Team Fundraisers</p>-->

		<?php
			//	foreach ($result as $donor) {
			//		echo "<p class='donate-block-right-name'>$counter. $donor->Name<br /><span style='color:#FFFFFF;font-weight: normal;'>$" . $donor->TotalDonations . " raised</span></p>";
			//		$counter++;
			//	}
		?>
	</div>
	<?php
		$result_events = db_query("SELECT * FROM hodc_events WHERE Status = 1 LIMIT 0,1");
		foreach ($result_events as $event) {
	?>
			<div class="listing-event-title"><?php echo $event->Title; ?></div>
			<div class="listing-team-name"><?php echo $team->Name; ?></div>


			<table id="event-<?php echo $event->EventNo; ?>-<?php echo $team->TeamNo; ?>">
				<tbody>
				<?php
					$total_amount = 0.00;
					//$result_volunteers = db_query("SELECT * FROM hodc_donations WHERE Status = 1 AND Email <> 'mderevere@gmail.com' AND Email <> 'nacer@acme.com' ORDER BY LastName, FirstName");
					$result_donors = db_query("SELECT * FROM hodc_donations WHERE Email <> 'mderevere@gmail.com' AND Email <> 'nacer@acme.com' AND Status >= 0 AND EntryTS >= '2015-04-01' ORDER BY LastName, FirstName ");
					foreach ($result_donors as $volunteer) {
						$total_amount += $volunteer->Amount;
						$registration = ($volunteer->VolunteerNo > 0) ? '*' : '';
						echo "<tr id='vn-$volunteer->VolunteerNo'>
									<td>
										$volunteer->FirstName $volunteer->LastName
									</td>
									<td>
										<a href='mailto:$volunteer->Email'>$volunteer->Email</a>
									</td>
									<td>
										$volunteer->Phone
									</td>
									<td style='text-align: right;'>
										{$volunteer->Amount}
									</td>
									<td>$registration</td>
								</tr>";
					}
					$total_amount_text = '$' . number_format(floatval($total_amount), 2);
					echo "<tr><td><strong>Total</strong></td><td>&nbsp;</td><td>&nbsp;</td><td style='text-align: right;'>$total_amount_text</td></tr>"
				?>
				</tbody>
			</table>




			

			<div class="listing-event-title">Prior Donors</div>
			<table id="event-prior-donors">
				<tbody>
				<?php
					$total_amount = 0.00;
					//$result_volunteers = db_query("SELECT * FROM hodc_donations WHERE Status = 1 AND Email <> 'mderevere@gmail.com' AND Email <> 'nacer@acme.com' ORDER BY LastName, FirstName");
					$result_donors = db_query("SELECT * FROM hodc_donations WHERE Status = 1 AND Email <> 'mderevere@gmail.com' AND Email <> 'nacer@acme.com' AND EntryTS <= '2015-03-31' ORDER BY LastName, FirstName ");
					foreach ($result_donors as $volunteer) {
						$total_amount += $volunteer->Amount;
						$registration = ($volunteer->VolunteerNo > 0) ? '*' : '';
						echo "<tr id='vn-$volunteer->VolunteerNo'>
									<td>
										$volunteer->FirstName $volunteer->LastName
									</td>
									<td>
										<a href='mailto:$volunteer->Email'>$volunteer->Email</a>
									</td>
									<td>
										$volunteer->Phone
									</td>
									<td style='text-align: right;'>
										{$volunteer->Amount}
									</td>
									<td>$registration</td>
								</tr>";
					}
					echo "<tr><td><strong>Total</strong></td><td>&nbsp;</td><td>&nbsp;</td><td style='text-align: right;'>$total_amount</td></tr>"
				?>
				</tbody>
			</table>
		<?php
		}
	?>
</div>