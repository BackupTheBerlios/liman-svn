<?php
	$title = "Nutzer";
	//$extracss = "home.css";

	require("include/header.php");
?>
<div id="cfront" class="content">
	<br>
	<table id="userlist">
		<thead>
			<tr>
				<th scope="col">Login</th>
				<th scope="col">Vorame</th>
				<th scope="col">Nachname</th>
				<th scope="col">E-Mail</th>
				<th scope="col">Aktionen</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><a href="user.<?=$ext;?>?id=123">siwu</a></td>
				<td>Simon</td>
				<td>Wunderlich</td>
				<td>siwu@hrz.tu-chemnitz.de</td>
				<td><input type="submit" value="Details">
					<input type="submit" value="Bearbeiten">
					</td>
			</tr>
			<tr>
				<td><a href="user.<?=$ext;?>?id=456">hans</a></td>
				<td>Hans</td>
				<td>Wurst</td>
				<td>hans@foobar.de</td>
				<td><input type="submit" value="Details"></td>
			</tr>
		</tbody>
	</table>


</div>
<?php	require("include/footer.php"); ?>

