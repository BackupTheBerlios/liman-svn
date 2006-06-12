<?php
	$title = "Nutzerdetails";
	//$extracss = "home.css";

	require_once("include/header.php");
	require_once("include/mitglied.php");

	// Abbruch wenn keine Mitgliedsrechte vorhanden
	if ($login->IsMember() === false)
	{
		require_once("include/footer.php");
		die();
	}
	elseif ($login->IsAdministrator() === false)
	{
		// Wenn keine Administratorrechte vorhanden sind
		// dürfen nur die eigenen Daten angesehen werden
		$_GET["id"] = $login->Nr;
		$_POST["id"] = $login->Nr;
	}

	// Lese Mitglied aus, wenn id übergeben wurde
	if (isset($_GET["id"]))
	{
		$mitglied = new Mitglied($_GET["id"]);
	}
	else
	{
		$mitglied = new Mitglied(0);
	}

	// gebe Informationen zu Mitglied aus
?>
<div id="cfront" class="content">
	<form action="usermod.php">
	
	<table id="bookdetails">
		<tbody>
			<tr>
				<th scope="row">Login:</th>	
				<td><?=htmlspecialchars($mitglied->Login);?></td>
			</tr>
			<tr>
				<th scope="row">Vorname:</th>	
				<td><?=htmlspecialchars($mitglied->Vorname);?></td>
			</tr>
			<tr>
				<th scope="row">Nachname:</th>	
				<td><?=htmlspecialchars($mitglied->Nachname);?></td>
			</tr>
			<tr>
				<th scope="row">Rechte:</th>	
				<td><?php
					// Wandle Zahlenrepräsentation der Rechte
					// in textuelle Repräsentation um
					switch ($mitglied->Rechte)
					{
					case 2:
						$rechte = "Administrator";
						break;
					default:
					case 1:
						$rechte = "Benutzer";
						break;
					}
					echo htmlspecialchars($rechte);
				?></td>
			</tr>

			<tr>
				<th scope="row">E-Mail:</th>	
				<td><?=htmlspecialchars($mitglied->Email);?></td>
			</tr>
			<tr>
				<th scope="row">Aktionen:</th>	
				<td>
					<form style="display:inline" action="usermod.<?=$ext;?>" method="post">
						<span>
							<input type="hidden" id="id" name="id" value="<?=htmlspecialchars($_GET["id"]);?>">
							<input type="submit" value="Bearbeiten">
						</span>
					</form>
				</td>
			</tr>
		</tbody>
	</table>
	</form>
</div>
<?php	require_once("include/footer.php"); ?>
