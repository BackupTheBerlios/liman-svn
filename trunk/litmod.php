<?php
	$title = "Literatur bearbeiten/hinzuf&uuml;gen";
	//$extracss = "home.css";

	require_once("include/header.php");
?>
<div id="cfront" class="content">
	<form action="litmod.<?=$ext;?>?add" id="litaddform" method="post">
	<table id="litadd">
		<tbody>
			<tr>
				<th scope="row">Titel:</th>	
				<td><input type="text" name="titel" id="titel"></td>
			</tr>
			<tr>
				<th scope="row">Autor:</th>
				<td><input type="text" name="autor" id="autor"></td>
			</tr>
			<tr>
				<th scope="row">Erscheinungsjahr:</th>	
				<td><input type="text" name="jahr" id="jahr"></td>
			</tr>
			<tr>
				<th scope="row">Stichworte:</th>	
				<td><input type="text"></td>
			</tr>
			<tr>
				<th scope="row">Art:</th>	
				<td><select name="art" id="art">
					<option>Anleitung</option>
					<option>Artikel</option>
					<option>Broschüre</option>
					<option>Buch</option>
					<option>Diplomarbeit</option>
					<option>Dissertation</option>
					<option>Protokoll</option>
					<option>Sonstiges</option>
					<option>Techn. Bericht</option>
					<option>Unveröffentlicht</option>
				</select>
				</td>
			</tr>


			<tr>
				<th scope="row">Verlag:</th>	
				<td><input type="text" name="verlag" id="verlag"></td>
			</tr>
			<tr>
				<th scope="row">Verlagsort:</th>	
				<td><input type="text" name="ort" id="ort"></td>
			</tr>

			<tr>
				<th scope="row">ISBN:</th>	
				<td><input type="text" name="isbn" id="isbn"></td>
			</tr>
			<tr>
				<th scope="row">Bemerkung:</th>	
				<td><textarea cols="20" rows="10" name="beschreibung" id="beschreibung"></textarea></td>
			</tr>
			<tr>
				<th scope="row">Aktionen:</th>	
				<td><input type="submit" value="&Uuml;bernehmen"></td>
			</tr>

		</tbody>
	</table>
	</form>
</div>
<?php	require_once("include/footer.php"); ?>

