<?php
	$title = "Letzte Literatur";

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
		<?php
			// Suche zuletzt hinzugefügte Literatur
			require_once("include/suche.php");
			$search = new Suche();

			if (empty($search->Treffer) === false)
			{
				echo "<tbody>";
				// Gebe alle gefundenen Treffer aus
				foreach ($search->Treffer as $cur)
				{
				?>
					<tr>
					<td><a href="lit.<?=$ext; ?>?id=<?=htmlspecialchars($cur->Nr); ?>">
						<?=htmlspecialchars($cur->Titel);?></a>
					</td>
					<td><?=htmlspecialchars($cur->Autor);?></td>
					<td><?=htmlspecialchars($cur->Verlag);?></td>
					<td><?=htmlspecialchars($cur->ISBN);?></td>
					</tr>
				<?php
				}
				echo "</tbody>";
			}
			else
			{
				echo "<tbody><tr><td colspan=\"4\">Keine Literatur vorhanden</td></tr></tbody>";
			}
		?>
	</table>
	<?php
		// Sind Mitgliedsrechte vorhanden, gebe Hinzufüge- und Importierknopf aus
		if ($login->IsMember() === true)
		{
		?>
			<hr>
			<form style="display:inline" action="litmod.php">
				<span>
					<input type="submit" value="Literatur hinzuf&uuml;gen">
				</span>
			</form>
			<form style="display:inline" action="bibtex.php">
				<span>
					<input type="submit" value="BibTeX importieren">
				</span>
			</form>
		<?php
		}
	?>


</div>
<?php	require_once("include/footer.php"); ?>
