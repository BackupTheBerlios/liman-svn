<?php
	$title = "Literaturliste";
	//$extracss = "home.css";

	require("include/header.php");
?>
<div id="cfront" class="content">
	
	<br>
	<table id="searchresult">
		<thead>
			<tr>
				<th scope="col">Titel</th>
				<th scope="col">Autor</th>
				<th scope="col">Verlag</th>
				<th scope="col">ISBN</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><a href="lit.<?=$ext;?>?id=123">Algorithmen</a></td>
				<td>Sedgewick</td>
				<td>Pearson Studium</td>
				<td>3-8273-7032-9</td>
			</tr>
			<tr>
				<td><a href="lit.<?=$ext;?>?id=456">Python - kurz und gut</a></td>
				<td>Mark Lutz</td>
				<td>O'Reilly</td>
				<td>3-89721-240-4</td>
			</tr>
			<tr>
				<td><a href="lit.<?=$ext;?>?id=456">Angewandte Kryptographie</a></td>
				<td>Bruce Schneier</td>
				<td>Addison-Wesley</td>
				<td>3-89319-854-7</td>
			</tr>
		</tbody>
	</table>
	<br>
	<hr>
	<br>
	<form action="litmod.php">
		<div>
			<input type="submit" value="Literatur hinzuf&uuml;gen">
		</div>
	</form>


</div>
<?php	require("include/footer.php"); ?>
