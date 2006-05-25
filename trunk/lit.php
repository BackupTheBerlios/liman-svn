<?php
	$title = "Literaturdetails";
	//$extracss = "home.css";

	require_once("include/header.php");
?>
<div id="cfront" class="content">
	<hr>
	
	<table id="litdetails">
		<tbody>
			<tr>
				<th scope="row">Titel:</th>	
				<td>Algorithmen</td>
			</tr>
			<tr>
				<th scope="row">Autor:</th>	
				<td>Sedgewick</td>
			</tr>
			<tr>
				<th scope="row">Erscheinungsjahr:</th>	
				<td>1998</td>
			</tr>
			<tr>
				<th scope="row">Verlag:</th>	
				<td>Pearson Studium</td>
			</tr>
			<tr>
				<th scope="row">Verlagsort:</th>	
				<td>Bonn ; München ; Paris [u.a.]</td>
			</tr>

			<tr>
				<th scope="row">ISBN:</th>	
				<td>3-8273-7032-9</td>
			</tr>
			<tr>
				<th scope="row">Bemerkung:</th>	
				<td>Robert Sedgewicks bekanntes Standardwerk stellt die wichtigsten Algorithmen klar und umfassend dar. Von elementaren Datenstrukturen und Algorithmen wie Such- und Sortieralgorithmen schlägt Sedgewick einen Bogen bis hin zu modernen Ansätzen und vermittelt dem Leser einen fundierten Überblick über die vielfältigen Möglichkeiten der Problemlösung anhand von Datenstrukturen.</td>
			</tr>
			<tr>
				<th scope="row">Bibtex:</th>	
				<td>
				<pre><?php
					require_once($basepath."include/bibtex.php");
					$example = " aber trotzdem wird dieses kaputte dokument nicht falsch erkannt
						@article{     lin1973,
									author = \"Sedgewick\",
									title = \"Algorithmen\",
									year = 1998
								}";
					if (($asd = BibTeX::parse($example)) !== false)
					{
						foreach($asd as $d)
						{
							echo htmlspecialchars($d->toString());
						}
					}
					?>
				</pre>
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
			<tr>
				<th scope="row">Hans Wurst:<br></th>	
				<td>Tolle Dramatik, wirklich fesselnder Storyverlauf, nur das Ende war ein bisschen matt.</td>
				<td><span style="font-size: 0.6em"><a href="loeschen.php">(loeschen)</a></span></td>
			</tr>
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
