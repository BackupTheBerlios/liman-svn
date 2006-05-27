<?php
	$title = "Literaturdetails";
	//$extracss = "home.css";

	require_once("include/header.php");
	require_once("include/literatur.php");

	$literatur;
	if (isset($_GET["id"]))
	{
		$literatur = new Literatur($_GET["id"]);
	}
	else
	{
		$literatur = new Literatur(0);
	}
?>
<div id="cfront" class="content">
	<hr>
	
	<table id="litdetails">
		<tbody>
			<tr>
				<th scope="row">Titel:</th>	
				<td><?=htmlspecialchars($literatur->Titel); ?></td>
			</tr>
			<tr>
				<th scope="row">Autor:</th>	
				<td><?php
					$autorlist = "";
					for ($j = 0; $j < count($literatur->Autoren); $j++)
					{
						if ($j != 0)
						{
							$autorlist .= ", ";
						}
						$autorlist .= $literatur->Autoren[$j]->Name;
					}
					echo htmlspecialchars($autorlist);
				?></td>
			</tr>
			<tr>
				<th scope="row">Erscheinungsjahr:</th>	
				<td><?=htmlspecialchars($literatur->Jahr); ?></td>
			</tr>
			<tr>
				<th scope="row">Verlag:</th>	
				<td><?=htmlspecialchars($literatur->Verlag); ?></td>
			</tr>
			<tr>
				<th scope="row">Verlagsort:</th>	
				<td><?=htmlspecialchars($literatur->Ort); ?></td>
			</tr>

			<tr>
				<th scope="row">ISBN:</th>	
				<td><?=htmlspecialchars($literatur->ISBN); ?></td>
			</tr>
			<tr>
				<th scope="row">Beschreibung:</th>	
				<td><?=nl2br(htmlspecialchars($literatur->Beschreibung)); ?></td>
			</tr>
			<tr>
				<th scope="row">Bibtex:</th>	
				<td>
					<pre><?= htmlspecialchars($literatur->ToBibtex()); ?></pre>
				</td>
			</tr>
			<tr>
				<th scope="row">Aktionen:</th>	
				<td><input type="submit" value="Bearbeiten"><input type="submit" value="L&ouml;schen"><br> </td>
			</tr>
		</tbody>
	</table>
	<hr>

	<table id="litkommentare">
		<tbody>
			<?php
				for ($i = 0; $i < count($literatur->Kommentare); $i++)
				{
					$cur = $literatur->Kommentare[$i];
			?>
				<tr>
					<th scope="row"><?=htmlspecialchars($cur->Verfasser_Name);?>:</th>	
					<td><?=htmlspecialchars($cur->Text);?></td>
					<td><span style="font-size: xx-small"><a href="loeschen.php">(loeschen)</a></span></td>
				</tr>
			<?
				}
			?>
			<tr>
				<th scope="row">Neuer Kommentar:</th>	
				<td>
				<textarea cols=40 rows=10></textarea><br>
				<input type="submit" value="Kommentar senden"></td>
				<td>&nbsp;</td>
			</tr>

		</tbody>
	</table>
</div>
<?php	require_once("include/footer.php"); ?>
