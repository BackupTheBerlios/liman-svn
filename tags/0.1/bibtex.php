<?php
	$title = "BibTeX Importieren";

	require_once("include/header.php");

	// Abbruch wenn keine Mitgliedsrechte vorhanden
	if ($login->IsMember() === false)
	{
		echo "<div id=\"error\">Sie sind für diese Aktion nicht berechtigt</div>";
		require_once("include/footer.php");
		die();
	}
?>
<div id="cfront" class="content">
<?php
	// Zeige Importformular, wenn noch keine Daten gesendet wurden
	if (empty($_FILES["bibtexfile"]) === true && empty($_POST["bibtextext"]) === true)
	{
	?>
		<form action="bibtex.<?=$ext;?>" id="bibtexfileform" method="post" enctype="multipart/form-data">
		<fieldset>
			<legend><b>BibTeX-Datei importieren</b></legend>
		
		
			<table class="bibteximport">
				<tbody>
					<tr>
						<th scope=row><label for="bibtextext">Datei:</label></th>
						<td><input class="input_file" type="file" id="bibtexfile" name="bibtexfile"></td>
					</tr>
					<tr>
						<th></th>
						<td><input type="submit" value="Importieren"></td>
					</tr>
				</tbody>
			</table>
		</fieldset>
		</form>
	
		<hr>
		
		<form action="bibtex.<?=$ext;?>" id="bibtextextform" method="post">
		<fieldset>
			<legend><b>BibTeX importieren</b></legend>
			<table class="bibteximport">
				<tbody>
					<tr>
						<th scope=row><label for="bibtextext">BibTeX:</label></th>
						<td><textarea cols="20" rows="10" name="bibtextext" id="bibtextext"></textarea></td>
					</tr>
					<tr>
						<th></th>
						<td><input type="submit" value="Importieren"></td>
					</tr>
				</tbody>
			</table>
		</fieldset>
		</form>
	<?php
	}
	else
	{
		// BibTeX-Daten entweder von Dateiupload oder übergebenen Textdaten
		$bibtex = "";
		if (empty($_FILES["bibtexfile"]) === false)
		{
			// Wenn Datei hochgeladen wurde, lese Inhalt der Datei
			$bibtex = file_get_contents($_FILES["bibtexfile"]["tmp_name"]);
		}
		elseif (empty($_POST["bibtextext"]) === false)
		{
			// Wenn Textdaten hochgeladen wurden, entferne automatisch
			// hinzugefügte Backslashes vor Zeichen mit besonderer Bedeutung
			$bibtex = stripslashes($_POST["bibtextext"]);
		}

		// Fehler, wenn "nichts" hochgeladen/übergeben wurde
		if ($bibtex === false || empty($bibtex) === true)
		{
			echo "<div id=\"error\">Konnte nichts zum importieren lesen</div>";
		}
		else
		{
			// Importiere BibTeX in Datenbank
			require_once("include/literatur.php");
			$imported = Literatur::InsertBibTeX($bibtex);

			// Gebe je nach Anzahl importierter Literatureinträge Text aus
			switch ($imported)
			{
			case 0:
				echo "<p style=\"text-align: center\">Keine Literatur wurde importiert</p>";
				break;
			case 1:
				echo "<p style=\"text-align: center\">Ein Literatureintrag wurde importiert</p>";
				break;
			default:
				echo "<p style=\"text-align: center\">$imported Literatureinträge wurden importiert</p>";
			}
		}
	}
	?>
</div>
<?php	require_once("include/footer.php"); ?>
