<?php
	$title = "Literatur bearbeiten/hinzuf&uuml;gen";
	//$extracss = "home.css";

	require("include/header.php");
?>
<div id="cfront" class="content">
	<br>

	<table id="litadd">
		<tbody>
			<tr>
				<th scope="row">Titel:</th>	
				<td><input type="text"></td>
			</tr>
			<tr>
				<th scope="row">Autor:<br>
				<span style="font-size:8px">(Mehrere Autoren durch<br> Kommata trennen)</span>				</th>	
				<td><input type="text"></td>
			</tr>
			<tr>
				<th scope="row">Erscheinungsjahr:</th>	
				<td><input type="text"></td>
			</tr>
			<tr>
				<th scope="row">Stichworte:</th>	
				<td><input type="text"></td>
			</tr>
			<tr>
				<th scope="row">Art:</th>	
				<td><select>
				<option>Buch</option>
				<option>Paper</option>
				<option>Hochglanzmagazin</option>
				<option>Boulevardmagazin</option>
				</select>
				</td>
			</tr>


			<tr>
				<th scope="row">Verlag:</th>	
				<td><input type="text"></td>
			</tr>
			<tr>
				<th scope="row">Verlagsort:</th>	
				<td><input type="text"></td>
			</tr>

			<tr>
				<th scope="row">ISBN:</th>	
				<td><input type="text"></td>
			</tr>
			<tr>
				<th scope="row">Bemerkung:</th>	
				<td><textarea cols="20" rows="10"></textarea></td>
			</tr>
			<tr>
				<th scope="row">Aktionen:</th>	
				<td><input type="submit" value="&Uuml;bernehmen"></td>
			</tr>

		</tbody>
	</table>
</div>
<?php	require("include/footer.php"); ?>

