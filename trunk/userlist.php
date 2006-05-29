<?php
	$title = "Nutzer";
	//$extracss = "home.css";

	require_once("include/header.php");
?>
<div id="cfront" class="content">
	<form action="usermod.php">
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
		<tbody>
			<?php
				/// \todo richtig implementieren
				require_once("include/mitglied.php");
				$members = Mitglied::GetAll();
				for ($i = 0; $i < count($members); $i++)
				{
					$cur = $members[$i];
			?>
			<tr>
				<td><a href="user.<?=$ext;?>?id=<?=htmlspecialchars($cur->Nr); ?>"><?=htmlspecialchars($cur->Login); ?></a></td>
				<td><?=htmlspecialchars($cur->Vorname); ?></td>
				<td><?=htmlspecialchars($cur->Nachname); ?></td>
				<td><?=htmlspecialchars($cur->Email); ?></td>
				<td>
					<?php
						if ($login->IsAdministrator() === true || $login->Nr == $cur->Nr)
						{
							echo "<input type=\"submit\" value=\"Bearbeiten\">";
						}
						else
						{
							echo "<input type=\"submit\" value=\"Details\">";
						}
					?>
				</td>
			</tr>
			<?php
				}
			?>
		</tbody>
	</table>
	</form>

	<?php
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
			echo "<p style=\"text-align: center\">Sie sind nicht berechtigt alle Nutzerinformationen einzusehen</p>";
		}
		else
		{
			echo "<p style=\"text-align: center\">Sie sind nicht berechtigt Nutzerinformationen einzusehen</p>";
		}
	?>

</div>
<?php	require_once("include/footer.php"); ?>

