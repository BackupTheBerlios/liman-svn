<?php
	$title = "Erweiterte Suche";

	require_once("include/header.php");
?>
<div id="cfront" class="content">

	<form action="search.<?=$ext;?>" id="extrasearchform" method="get">
	<fieldset>
   		 <legend><b>Autoren- und Titelsuche</b></legend>
	
	
		<table class="searchmore">
			<tbody>
				<tr>
					<th scope=row><label for="autor">Autor:</label></th>
					<td><input class="input_text" type="text" id="autor" name="autor"></td>
				</tr>
				<tr>
					<th scope=row><label for="titel">Titel:</label></th>
					<td><input class="input_text" type="text" id="titel" name="titel"></td>
				</tr>
				<tr>
					<th></th>
					<td><input type="submit" value="Suche"></td>
				</tr>
			</tbody>
		</table>
	</fieldset>
	</form>

	<hr>
	
	<form action="search.<?=$ext;?>" id="fulltextform" method="get">
	<fieldset>
   		<legend><b>Volltextsuche</b></legend>
		<table class="searchmore">
			<tbody>
				<tr>
					<th scope=row><label for="suchbegriff">Suchbegriff:</label></th>
					<td><input class="input_text" type="text" id="suchbegriff" name="suchbegriff"></td>
				</tr>
				<tr>
					<th></th>
					<td><input type="submit" value="Suche"></td>
				</tr>
			</tbody>
		</table>
	</fieldset>
	</form>
</div>
<?php	require_once("include/footer.php"); ?>
