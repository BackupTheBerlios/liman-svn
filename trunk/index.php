<?php
	$title = "Literaturliste";
	//$extracss = "home.css";

	require_once("include/header.php");
?>
<div id="cfront" class="content">
	
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
			<?php
				require_once("include/suche.php");
				$search = new Suche();
				for ($i = 0; $i < count($search->Treffer); $i++)
				{
					$cur = $search->Treffer[$i];
			?>
				<tr>
					<td><a href="lit.<?=$ext;?>?id=<?=htmlspecialchars($cur->Nr);?>"><?=htmlspecialchars($cur->Titel);?></a></td>
					<td><?=htmlspecialchars($cur->Autor);?></td>
					<td><?=htmlspecialchars($cur->Verlag);?></td>
					<td><?=htmlspecialchars($cur->ISBN);?></td>
				</tr>
			<?php
				}
			?>
		</tbody>
	</table>
	<?php
		if ($login->IsMember() === true)
		{
	?>
		<hr>
		<form action="litmod.php">
			<div>
				<input type="submit" value="Literatur hinzuf&uuml;gen">
			</div>
		</form>
	<?php
		}
	?>


</div>
<?php	require_once("include/footer.php"); ?>
