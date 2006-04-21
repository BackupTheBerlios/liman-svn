<?php
	$title = "Home";
	//$extracss = "home.css";

	require("include/header.php");
?>
<div id="cfront" class="content">
	TestBlablabla
	<hr>

	<div id="loginbox">
		<form action="login.<?=$ext;?>" id="loginform">
			<div>
			<label for="login">Login:</label><input id="login" name="login" value="" type="text">
			<label for="password">Passwort:</label><input id="password" name="password" type="password">
			<input type="submit" value="Login">
			</div>
		</form>
	</div>

	<hr>

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
				<td><a href="book.<?=$ext;?>?id=123">Algorithmen</a></td>
				<td>Sedgewick</td>
				<td>Pearson Studium</td>
				<td>3-8273-7032-9</td>
			</tr>
			<tr>
				<td><a href="book.<?=$ext;?>?id=456">Python - kurz und gut</a></td>
				<td>Mark Lutz</td>
				<td>O'Reilly</td>
				<td>3-89721-240-4</td>
			</tr>
			<tr>
				<td><a href="book.<?=$ext;?>?id=456">Angewandte Kryptographie</a></td>
				<td>Bruce Schneier</td>
				<td>Addison-Wesley</td>
				<td>3-89319-854-7</td>
			</tr>
		</tbody>
	</table>

	<hr>
	
	<table id="bookdetails">
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
				<th scope="row">ISBN:</th>	
				<td>3-8273-7032-9</td>
			</tr>
			<tr>
				<th scope="row">Bemerkung:</th>	
				<td>Robert Sedgewicks bekanntes Standardwerk stellt die wichtigsten Algorithmen klar und umfassend dar. Von elementaren Datenstrukturen und Algorithmen wie Such- und Sortieralgorithmen schlägt Sedgewick einen Bogen bis hin zu modernen Ansätzen und vermittelt dem Leser einen fundierten Überblick über die vielfältigen Möglichkeiten der Problemlösung anhand von Datenstrukturen.</td>
			</tr>
		</tbody>
	</table>

	<hr>
	<h3>BibTeX-Test</h3>
	<pre><?php
		require($basepath."include/bibtex.php");
		$example = " aber trotzdem wird dieses kaputte dokument nicht falsch erkannt
		@article{     lin1973,
			author = \"Shen Lin and Brian W. Kernighan\",
			title = \"An Effective Heuristic Algorithm for the Travelling-Salesman Problem\",
			journal = \"Operations Research\",
			volume = 21,
			year = 1973,
			pages = \"498-516\"
		}
		

		hier kann auch etwas unsinn stehen

		@ARTICLE{whole-journal,
			key = \"GAJ\",
			journal = {Journal},
			year = 1986,
			volume = 41,
			number = 7,
			month = {adfasdf \mbox{asd}},
			note = {The entire issue{}}
			}
			
			@inbook{inbook-minimal,
			author = \"Donald E. Knuth\",
			title = \"Fundamental Algorithms\",
			publisher = \"Addison-Wesley\",
			year = \"1973\",
			chapter = \"1.2\",
			}
			@inbook{	inbook-minimal,author = Donald,
				title = {alles gute kommt von oben}}

		alle kinder gottes haben schuhe

		oder wie wir{ } auch immer sagen sollten

		testen wir doch mal einfach unsinn

		@misc{ processing-software,
		author = \"For Signal Processing\",
		title = \"Software Synthesis and Code Generation\",
		url = \"citeseer.ist.psu.edu/638190.html\" }";
		
		if (($asd = BibTeX::parse($example)) !== false)
		{
			foreach($asd as $d)
			{
				echo htmlspecialchars($d->toString());
			}
		}
	?>
	</pre>
</div>
<?php	require("include/footer.php"); ?>