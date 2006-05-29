<?php
	$title = "Erweiterte Suche";
	//$extracss = "home.css";

	require_once("include/header.php");
?>
<div id="cfront" class="content">
	<h3>Autoren- und Titelsuche</h3>
	<form action="search.<?=$ext;?>" id="searchform" method="get">
	<table class="searchmore">
		<tbody>
			<tr>
				<td scope=row><label for="autor">Autor:</label></td>
				<td><input id="autor" name="autor"></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td scope=row><label for="titel">Titel:</label></td>
				<td><input type="text" id="titel" name="titel"></td>
				<td><input type="submit" value="Suche"></td>
			</tr>
		</tbody>
	</table>
	</form>
	<hr>
	
	<h3>Volltextsuche</h3>
	<form action="search.<?=$ext;?>" id="searchform" method="get">
	<table class="searchmore">
		<tbody>
			<tr>
				<td scope=row><label for="suchbegriff">Suchbegriff:</label></td>
				<td><input type="text" id="suchbegriff" name="suchbegriff"></td>
				<td><input type="submit" value="Suche"></td>
			</tr>
		</tbody>
	</table>
	</form>
</div>
<?php	require_once("include/footer.php"); ?>
