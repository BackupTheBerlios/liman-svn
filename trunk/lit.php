<?php
	$title = "Literaturdetails";
	//$extracss = "home.css";

	require_once("include/header.php");
	require_once("include/literatur.php");

	if (isset($_GET["id"]))
	{
		$literatur = new Literatur($_GET["id"]);
	}
	else
	{
		$literatur = new Literatur(0);
	}
?>
<div id="cfront" class="content">
	
	<table id="litdetails">
		<tbody>
			<tr>
				<th scope="row">Titel:</th>	
				<td><?=htmlspecialchars($literatur->Titel); ?></td>
			</tr>
			<tr>
				<th scope="row">Autor:</th>	
				<td><?php
					$autorlist = "";
					for ($j = 0; $j < count($literatur->Autoren); $j++)
					{
						if ($j != 0)
						{
							$autorlist .= ", ";
						}
						$autorlist .= $literatur->Autoren[$j]->Name;
					}
					echo htmlspecialchars($autorlist);
				?></td>
			</tr>
			<tr>
				<th scope="row">Erscheinungsjahr:</th>	
				<td><?=htmlspecialchars($literatur->Jahr); ?></td>
			</tr>
			<tr>
				<th scope="row">Verlag:</th>	
				<td><?=htmlspecialchars($literatur->Verlag); ?></td>
			</tr>
			<tr>
				<th scope="row">Verlagsort:</th>	
				<td><?=htmlspecialchars($literatur->Ort); ?></td>
			</tr>

			<tr>
				<th scope="row">ISBN:</th>	
				<td><?=htmlspecialchars($literatur->ISBN); ?></td>
			</tr>
			<tr>
				<th scope="row">Beschreibung:</th>	
				<td><?=nl2br(htmlspecialchars($literatur->Beschreibung)); ?></td>
			</tr>
			<tr>
				<th scope="row">Bibtex:</th>	
				<td>
					<pre><?= htmlspecialchars($literatur->ToBibtex()); ?></pre>
				</td>
			</tr>
			<?php
				if ($login->IsMember() === true)
				{
			?>
				<tr>
					<th scope="row">Aktionen:</th>	
					<td><form style="display:inline" action="litmod.<?=$ext;?>?id=<?=htmlspecialchars($_GET["id"]);?>" method="post">
							<span><input type="submit" value="Bearbeiten"></span>
						</form>
						<form style="display:inline" action="litmod.<?=$ext;?>?delete=&amp;id=<?=htmlspecialchars($_GET["id"]);?>" method="post">
							<span><input type="submit" value="L&ouml;schen"></span>
					</form></td>
				</tr>
			<?php
				}
			?>
		</tbody>
	</table>
	<hr>

	<table id="litkommentare">
		<tbody>
			<?php
				$nocomment = false; // hat der user schon etwas kommentiert?
				for ($i = 0; $i < count($literatur->Kommentare); $i++)
				{
					$cur = $literatur->Kommentare[$i];
					if ($login->Nr == $cur->Verfasser_Nr)
					{
						$nocomment = true;
					}
			?>
				<tr>
					<th scope="row"><?=htmlspecialchars($cur->Verfasser_Name);?>:</th>	
					<td><?=htmlspecialchars($cur->Text);?></td>
					<td><?php
						// Darf der User löschen?
						if ($login->Nr == $cur->Verfasser_Nr || $login->IsAdministrator() === true)
						{
							echo "<span style=\"font-size: xx-small\"><a href=\"loeschen.php?id=".$cur->Nr."\">(loeschen)</a></span>";
						}
					?></td>
				</tr>
			<?
				}

				// Soll Kommentar-Hinzufügen-Box erscheinen?
				if ($login->IsMember() === true && 
					($login->IsAdministrator() === true || $nocomment === false))
				{
			?>
				<tr>
					<th scope="row">Neuer Kommentar:</th>	
					<td>
					<textarea cols=40 rows=10></textarea><br>
					<input type="submit" value="Kommentar senden"></td>
					<td>&nbsp;</td>
				</tr>
			<?php
				}
			?>

		</tbody>
	</table>
</div>
<?php	require_once("include/footer.php"); ?>
