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

					if (count($literatur->Autoren) > 0)
					{
						$autornamen = array();
						foreach ($literatur->Autoren as $autor)
						{
							$autornamen[] = $autor->Name;
						}
	
						$autorlist = implode(", ", $autornamen);
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
				require_once("include/form_helper.php");
				$owncomment = ""; // hat der user schon etwas kommentiert?
				foreach ($literatur->Kommentare as $cur)
				{
					if ($login->Nr == $cur->Verfasser_Nr)
					{
						$owncomment->Text = $cur->Text;
						$owncomment->Nr = $cur->Nr;
						
					}
			?>
				<tr>
					<th scope="row"><?=htmlspecialchars($cur->Verfasser_Name);?>:</th>	
					<td class="kommentar"><?=htmlspecialchars($cur->Text);?></td>
					<td><?php
						// Darf der User löschen?
						if ($login->Nr == $cur->Verfasser_Nr || $login->IsAdministrator() === true)
						{
							echo "<span style=\"font-size: xx-small\">";
							echo "<a href=\"commentmod.php?delete&amp;id=".$cur->Nr."&amp;litid=".htmlspecialchars($_GET["id"])."\">(löschen)</a></span>";
						}
					?></td>
				</tr>
			<?php
				}
			?>
		</tbody>
	</table>

	<?php
		if ($login->IsMember() === true)
		{
			require_once("include/form_helper.php");
			// Soll Kommentar-Hinzufügen-Box erscheinen oder Update-Box?
			if (empty($owncomment) === true)
			{
		?>
			<form action="commentmod.<?=$ext;?>?insert=" method="post">
			<span>
				<?=form_input("hidden", "litid", $_GET["id"]);?>
				<?=form_input("hidden", "userid", $login->Nr);?>
			</span>
			<table id="litkommentaradd">
				<tbody>
					<tr>
						<th scope="row">Neuer Kommentar:</th>	
						<td>
							<textarea id="text" name="text" cols=40 rows=10></textarea>
						</td>
					</tr>
					<tr>
						<th scope="row"></th>
						<td><input type="submit" value="Kommentar senden"></td>
						
					</tr>
				</tbody>
			</table>
			</form>
		<?php
			}
			else
			{
		?>
			<form action="commentmod.<?=$ext;?>?update" method="post">
			<span>
				<?=form_input("hidden", "litid", $_GET["id"]);?>
				<?=form_input("hidden", "id", $owncomment->Nr);?>
			</span>
			<table id="litkommentarmod">
				<tbody>
					<tr>
						<th scope="row"><label for="text">Kommentar ändern:</label></th>	
						<td>
							<textarea id="text" name="text" cols=40 rows=10><?=htmlspecialchars($owncomment->Text);?></textarea>
						</td>
					</tr>
					<tr>
						<th scope="row"></th>
						<td><input type="submit" value="Kommentar senden"></td>
						
					</tr>
				</tbody>
			</table>
			</form>
		<?php
			}
		}
	?>
</div>
<?php	require_once("include/footer.php"); ?>
