<?php
	//$extracss = "home.css";

	// Wähle Seitentitel nach ausgewählter Aktion
	if (isset($_GET["suchbegriff"]) === true)
	{
		$title = "Suchergebnisse f&uuml;r \"".htmlspecialchars($_GET["suchbegriff"])."\"";
	}
	elseif (isset($_GET["autor"]) === true && isset($_GET["titel"]) === true)
	{
		$title = "Suchergebnisse f&uuml;r \"".htmlspecialchars($_GET["autor"])."\" und \"".htmlspecialchars($_GET["titel"])."\"";
	}
	else
	{
		$title = "Letzte Literatur";
	}

	require_once("include/header.php");
?>
<div id="cfront" class="content">
<?php
	require_once("include/suche.php");

	// Welche Art von Suche?
	if (isset($_GET["suchbegriff"]) === true)
	{
		// Volltextsuche nach Suchbegriff
		$search = new Suche($_GET["suchbegriff"]);
	}
	elseif (isset($_GET["autor"]) === true && isset($_GET["titel"]) === true)
	{
		// Suche nach Autor und Titel
		$search = new Suche($_GET["titel"], $_GET["autor"]);
	}
	else
	{
		// Suche zuletzt hinzugefügte Literatur
		$search = new Suche();
	}

	// Wurde etwas gefunden?
	if (empty($search->Treffer) === false)
	{
	?>
		<table id="searchresult">
			<thead>
				<tr>
					<th scope="col">Titel</th>
					<th scope="col">Autor</th>
					<th scope="col">Verlag</th>
					<th scope="col">ISBN</th>
				</tr>
			</thead>
		<tbody>
	<?php
		// Gebe alle gefundenen Treffer aus
		foreach ($search->Treffer as $cur)
		{
	?>
		<tr>
			<td><a href="lit.<?=$ext;?>?id=<?=htmlspecialchars($cur->Nr);?>"><?=htmlspecialchars($cur->Titel);?></a></td>
			<td><?=htmlspecialchars($cur->Autor);?></td>
			<td><?=htmlspecialchars($cur->Verlag);?></td>
			<td><?=htmlspecialchars($cur->ISBN);?></td>
		</tr>
	<?php
		}
	?>
			</tbody>
		</table>	
	<?php
	}
	else
	{
		// Wenn nicht, gebe Information aus
		echo "<div id=\"warning\">Keine Treffern gefunden</div>";
	}
?>


<?php
	// Sind Mitgliedsrechte vorhanden, gebe Hinzufüge- und Importierknopf aus
	if ($login->IsMember() === true)
	{
	?>
		<hr>
		<form style="display:inline" action="litmod.php">
			<span>
				<input type="submit" value="Literatur hinzuf&uuml;gen">
			</span>
		</form>
		<form style="display:inline" action="bibtex.php">
			<span>
				<input type="submit" value="BibTeX importieren">
			</span>
		</form>
	<?php
	}
?>
</div>
<?php	require_once("include/footer.php"); ?>
