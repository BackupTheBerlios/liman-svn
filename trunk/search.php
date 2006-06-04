<?php
	//$extracss = "home.css";

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

	if (isset($_GET["suchbegriff"]) === true)
	{
		$search = new Suche($_GET["suchbegriff"]);
	}
	elseif (isset($_GET["autor"]) === true && isset($_GET["titel"]) === true)
	{
		$search = new Suche($_GET["titel"], $_GET["autor"]);
	}
	else
	{
		$search = new Suche();
	}

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

		for ($i = 0; $i < count($search->Treffer); $i++)
		{
			$cur = $search->Treffer[$i];
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
		echo "<div id=\"warning\">Keine Treffern gefunden</div>";
	}
?>


<?php
	if ($login->IsMember() === true)
	{
?>
	<hr>
	<form action="litmod.php">
		<div>
			<input type="submit" value="Literatur hinzuf&uuml;gen">
		</div>
	</form>
<?php
	}
?>
</div>
<?php	require_once("include/footer.php"); ?>
