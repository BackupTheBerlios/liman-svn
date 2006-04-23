<?php
	$title = "Nutzer bearbeiten";
	//$extracss = "home.css";

	require("include/header.php");
?>
<div id="cfront" class="content">
	<br>
	
	<table id="bookdetails">
		<tbody>
			<tr>
				<th scope="row">Login:</th>	
				<td><input type="input" value="siwu"></td>
			</tr>
			<tr>
				<th scope="row">Vorname:</th>	
				<td><input type="input" value="Simon"></td>
			</tr>
			<tr>
				<th scope="row">Nachname:</th>	
				<td><input type="input" value="Wunderlich"></td>
			</tr>
			<tr>
				<th scope="row">E-Mail:</th>	
				<td><input type="input" value="siwu@hrz.tu-chemnitz.de"></td>
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
				<form action="usermod.php">
				<input type="submit" value="&Uuml;bernehmen"></form>
				<br> </td>
			</tr>

		</tbody>
	</table>
</div>
<?php	require("include/footer.php"); ?>


