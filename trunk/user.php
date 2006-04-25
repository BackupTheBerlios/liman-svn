<?php
	$title = "Nutzerdetails";
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
				<td>siwu</td>
			</tr>
			<tr>
				<th scope="row">Vorname:</th>	
				<td>Simon</td>
			</tr>
			<tr>
				<th scope="row">Nachname:</th>	
				<td>Wunderlich</td>
			</tr>
			<tr>
				<th scope="row">Rechte:</th>	
				<td>Administrator</td>
			</tr>

			<tr>
				<th scope="row">E-Mail:</th>	
				<td>siwu@hrz.tu-chemnitz.de</td>
			</tr>
			<tr>
				<th scope="row">Aktionen:</th>	
				<td>
				<input type="submit" value="Bearbeiten">
				<br> </td>
			</tr>
		</tbody>
	</table>
	</form>
</div>
<?php	require("include/footer.php"); ?>

