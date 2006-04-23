<?php
	$title = "Nutzerdetails";
	//$extracss = "home.css";

	require("include/header.php");
?>
<div id="cfront" class="content">
	<br>
	
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
				<th scope="row">E-Mail:</th>	
				<td>siwu@hrz.tu-chemnitz.de</td>
			</tr>
			<tr>
				<th scope="row">Aktionen:</th>	
				<td>
				<form action="usermod.php">
				<input type="submit" value="Bearbeiten"></form>
				<br> </td>
			</tr>

		</tbody>
	</table>
</div>
<?php	require("include/footer.php"); ?>

