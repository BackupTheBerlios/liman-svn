<?php
	$title = "Erweiterte Suche";
	//$extracss = "home.css";

	require("include/header.php");
?>
<div id="cfront" class="content">
	<br><br>
	<h3>Volltextsuche</h3>
	<table id="searchmore">
		<tbody>
			<tr>
				<td scope=row>Suchbegriff:</td>
				<td><input></td>
				<td><input type="submit" value="Suche"></td>
			</tr>
		</tbody>
	</table>

	<hr>
	<h3>Autoren- und Titelsuche</h3>

	<table id="searchmore">
		<tbody>
			<tr>
				<td scope=row>Autor:</td>
				<td><input></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td scope=row>Titel:</td>
				<td><input></td>
				<td><input type="submit" value="Suche"></td>
			</tr>
		</tbody>
	</table><br><br>
	
	<br>


</div>
<?php	require("include/footer.php"); ?>


