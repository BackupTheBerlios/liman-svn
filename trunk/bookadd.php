<?php
	$title = "Hinzuf&uuml;gen";
	//$extracss = "home.css";

	require("include/header.php");
?>
<div id="cfront" class="content">
	<br>

	<table id="bookadd">
		<tbody>
			<tr>
				<th scope="row">Titel:</th>	
				<td><input type="input"></td>
			</tr>
			<tr>
				<th scope="row">Autor:</th>	
				<td><input type="input"></td>
			</tr>
			<tr>
				<th scope="row">Erscheinungsjahr:</th>	
				<td><input type="input"></td>
			</tr>
			<tr>
				<th scope="row">Verlag:</th>	
				<td><input type="input"></td>
			</tr>
			<tr>
				<th scope="row">ISBN:</th>	
				<td><input type="input"></td>
			</tr>
			<tr>
				<th scope="row">Bemerkung:</th>	
				<td><textarea></textarea></td>
			</tr>
			<tr>
				<th scope="row">Aktionen:</th>	
				<td><input type="submit" value="Hinzuf&uuml;gen"></td>
			</tr>

		</tbody>
	</table>

	</pre>
</div>
<?php	require("include/footer.php"); ?>

