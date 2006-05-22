<?php
	$title = "Nutzer";
	//$extracss = "home.css";

	require("include/header.php");
?>
<div id="cfront" class="content">
	<br>
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
	<br>
	<hr>
	<br>
	<form action="usermod.php">
		<div>
			<input type="submit" value="Nutzer hinzuf&uuml;gen">
		</div>
	</form>


</div>
<?php	require("include/footer.php"); ?>

