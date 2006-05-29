<?php
	$title = "Nutzer bearbeiten/hinzuf&uuml;gen";
	//$extracss = "home.css";

	require_once("include/header.php");
?>
<div id="cfront" class="content">
	
	<form action="usermod.<?=$ext;?>?add" id="litaddform" method="post">
	<table id="bookdetails">
		<tbody>
			<tr>
				<th scope="row">Login:</th>	
				<td><input type="text" value="siwu" name="login" id="login"></td>
			</tr>
			<tr>
				<th scope="row">Vorname:</th>	
				<td><input type="text" value="Simon" name="vorname" id="vorname"></td>
			</tr>
			<tr>
				<th scope="row">Nachname:</th>	
				<td><input type="text" value="Wunderlich" name="nachname" id="nachname"></td>
			</tr>
			<tr>
				<th scope="row">E-Mail:</th>	
				<td><input type="text" value="siwu@hrz.tu-chemnitz.de" name="email" id="email"></td>
			</tr>
			<tr>
				<th scope="row" name="rechte" id="rechte">Rechte:</th>	
				<td><select>
				<option>Administrator</option>
				<option>Mitarbeiter</option>
				</select>
				</td>
			</tr>

			<tr>
				<th scope="row">Passwort:</th>	
				<td><input type="password" value="password" name="passwort" id="passwort"></td>
			</tr>
			<tr>
				<th scope="row">Passwort (wiederholen):</th>	
				<td><input type="password" value="password" name="passwort_check" id="passwort_check"></td>
			</tr>

			<tr>
				<th scope="row">Aktionen:</th>	
				<td>
				<input type="submit" value="&Uuml;bernehmen">
				</td>
			</tr>

		</tbody>
	</table>
	</form>
</div>
<?php	require_once("include/footer.php"); ?>
