<?php
	$title = "Nutzer bearbeiten/hinzuf&uuml;gen";
	//$extracss = "home.css";

	require("include/header.php");
?>
<div id="cfront" class="content">
	<br>
	
	<form action="usermod.php">
	<table id="bookdetails">
		<tbody>
			<tr>
				<th scope="row">Login:</th>	
				<td><input type="text" value="siwu"></td>
			</tr>
			<tr>
				<th scope="row">Vorname:</th>	
				<td><input type="text" value="Simon"></td>
			</tr>
			<tr>
				<th scope="row">Nachname:</th>	
				<td><input type="text" value="Wunderlich"></td>
			</tr>
			<tr>
				<th scope="row">E-Mail:</th>	
				<td><input type="text" value="siwu@hrz.tu-chemnitz.de"></td>
			</tr>
			<tr>
				<th scope="row">Passwort:</th>	
				<td><input type="password" value="password"></td>
			</tr>
			<tr>
				<th scope="row">Passwort (wiederholen):</th>	
				<td><input type="password" value="password"></td>
			</tr>

			<tr>
				<th scope="row">Aktionen:</th>	
				<td>
				<input type="submit" value="&Uuml;bernehmen">
				<br> </td>
			</tr>

		</tbody>
	</table>
	</form>
</div>
<?php	require("include/footer.php"); ?>


