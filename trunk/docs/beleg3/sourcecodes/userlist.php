<?php
	$title = "Nutzer";

	require_once("include/header.php");
?>
<div id="cfront" class="content">
	<table id="userlist">
		<thead>
			<tr>
				<th scope="col">Login</th>
				<th scope="col">Vorname</th>
				<th scope="col">Nachname</th>
				<th scope="col">E-Mail</th>
				<th scope="col">Aktionen</th>
			</tr>
		</thead>
		<?php
			require_once("include/mitglied.php");

			// Lese alle Mitglieder aus (wenn Administrator)
			// oder eigene Daten (wenn Mitglied)
			$members = Mitglied::GetAll();
			if (empty($members) === false)
			{
				echo "<tbody>";
				foreach ($members as $cur)
				{
			?>
			<tr>
				<td><a href="user.<?=$ext;?>?id=<?=htmlspecialchars($cur->Nr); ?>"><?=htmlspecialchars($cur->Login); ?></a></td>
				<td><?=htmlspecialchars($cur->Vorname); ?></td>
				<td><?=htmlspecialchars($cur->Nachname); ?></td>
				<td><?=htmlspecialchars($cur->Email); ?></td>
				<td>
					<?php
						// Sind Mitgliedsrechte vorhanden, gebe Bearbeitenknopf bei eigenem Eintrag aus
						// bei Administratoren immer
						if ($login->IsAdministrator() === true || $login->Nr == $cur->Nr)
						{
							echo "<form style=\"display: inline\" method=\"post\" action=\"usermod.$ext?id=". htmlspecialchars($cur->Nr) ."\">";
							echo "<input type=\"submit\" value=\"Bearbeiten\">";
							echo "</form>";
						}
						
						// Sind Administratorrechte vorhanden, gebe L�schknopf aus
						if ($login->IsAdministrator() === true)
						{
							echo "<form style=\"display: inline\" method=\"post\" action=\"usermod.$ext?delete=&id=". htmlspecialchars($cur->Nr) ."\">";
							echo "<input type=\"submit\" value=\"L�schen\">";
							echo "</form>";
						}
					?>
				</td>
			</tr>
			<?php
				}
				echo "</tbody>";
			}
			else
			{
				echo "<tbody><tr><td colspan=\"5\">Keine Mitglieder gefunden</td></tr></tbody>";
			}
		?>
	</table>

	<?php
		// Sind Administratorrechte vorhanden, gebe Hinzuf�ge aus
		if ($login->IsAdministrator() === true)
		{
	?>
		<hr>
		<form action="usermod.php">
			<div>
				<input type="submit" value="Nutzer hinzuf&uuml;gen">
			</div>
		</form>
	<?php
		}
		elseif ($login->IsMember() === true)
		{
			echo "<p id=\"warning\">Sie sind nicht berechtigt alle Nutzerinformationen einzusehen</p>";
		}
		else
		{
			echo "<p id=\"warning\">Sie sind nicht berechtigt Nutzerinformationen einzusehen</p>";
		}
	?>

</div>
<?php	require_once("include/footer.php"); ?>

