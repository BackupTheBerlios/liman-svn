<?php
	$title = "Unittest";
	$extracss = "unittest.css";

	require_once("include/header.php");

	require_once("include/tests/sqldb_mock.php");
	$sqldb = new SQLDB_Mock();

	function PrintTestResults($results)
	{
		if ($results === true)
		{
			echo "<td class=\"unitcorrect\">OK</td>";
		}
		else
		{
			echo "<td class=\"uniterror\">";
			echo nl2br(htmlspecialchars($results->ToString()));
			echo "</td>";
		}
	}
?>
<div id="cfront" class="content">
	
	<table id="testresults">
		<thead>
			<tr>
				<th scope="col">Funktion</th>
				<th scope="col">Resultat</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$login->Level = 2;

				// Autor
				require_once("include/autor.php");
				require_once("include/tests/autor.php");
				$autortest = new AutorTest();

				echo "<tr><td>Autor::Autor()</td>";
				$autortest->Setup();
				PrintTestResults($autortest->ConstructorTest());
				$autortest->TearDown();
				echo "</tr>";

				echo "<tr><td>Autor::GetAll()</td>";
				$autortest->Setup();
				PrintTestResults($autortest->GetAll());
				$autortest->TearDown();
				echo "</tr>";

				echo "<tr><td>Autor::Split()</td>";
				$autortest->Setup();
				PrintTestResults($autortest->Split());
				$autortest->TearDown();
				echo "</tr>";


				// Suche
				require_once("include/suche.php");
				require_once("include/tests/suche.php");
				$searchtest = new SucheTest();

				echo "<tr><td>Suche::LetzteLiteratur()</td>";
				$searchtest->Setup();
				PrintTestResults($searchtest->LetzteLiteratur());
				$searchtest->TearDown();
				echo "</tr>";

				echo "<tr><td>Suche::VolltextSuche()</td>";
				$searchtest->Setup();
				PrintTestResults($searchtest->VolltextSuche());
				$searchtest->TearDown();
				echo "</tr>";

				echo "<tr><td>Suche::AutorTitelSuche()</td>";
				$searchtest->Setup();
				PrintTestResults($searchtest->AutorTitelSuche());
				$searchtest->TearDown();
				echo "</tr>";
				
				// Kommentar
				require_once("include/kommentar.php");
				require_once("include/tests/kommentar.php");
				$kommentarTest = new KommentarTest();

				echo "<tr><td>Kommentar::Kommentar()</td>";
				$kommentarTest->Setup();
				PrintTestResults($kommentarTest->ConstructorTest());
				$kommentarTest->TearDown();
				echo "</tr>";
				
				echo "<tr><td>Kommentar::GetAll()</td>";
				$kommentarTest->Setup();
				PrintTestResults($kommentarTest->GetAll());
				$kommentarTest->TearDown();
				echo "</tr>";
				
				echo "<tr><td>Kommentar::Insert()</td>";
				$kommentarTest->Setup();
				PrintTestResults($kommentarTest->Insert());
				$kommentarTest->TearDown();
				echo "</tr>";
				
				echo "<tr><td>Kommentar::Update()</td>";
				$kommentarTest->Setup();
				PrintTestResults($kommentarTest->Update());
				$kommentarTest->TearDown();
				echo "</tr>";
				
				echo "<tr><td>Kommentar::Delete()</td>";
				$kommentarTest->Setup();
				PrintTestResults($kommentarTest->Delete());
				$kommentarTest->TearDown();
				echo "</tr>";
				
				// Mitglied
				require_once("include/mitglied.php");
				require_once("include/tests/mitglied.php");
				$mitgliedTest = new MitgliedTest();

				echo "<tr><td>Mitglied::Mitglied()</td>";
				$mitgliedTest->Setup();
				PrintTestResults($mitgliedTest->ConstructorTest());
				$mitgliedTest->TearDown();
				echo "</tr>";
				
				echo "<tr><td>Mitglied::GetAll()</td>";
				$mitgliedTest->Setup();
				PrintTestResults($mitgliedTest->GetAll());
				$mitgliedTest->TearDown();
				echo "</tr>";
				
				echo "<tr><td>Mitglied::Insert()</td>";
				$mitgliedTest->Setup();
				PrintTestResults($mitgliedTest->Insert());
				$mitgliedTest->TearDown();
				echo "</tr>";
				
				echo "<tr><td>Mitglied::Update()</td>";
				$mitgliedTest->Setup();
				PrintTestResults($mitgliedTest->Update());
				$mitgliedTest->TearDown();
				echo "</tr>";
				
				echo "<tr><td>Mitglied::Delete()</td>";
				$mitgliedTest->Setup();
				PrintTestResults($mitgliedTest->Delete());
				$mitgliedTest->TearDown();
				echo "</tr>";
			?>
		</tbody>
	</table>
</div>
<?php	require_once("include/footer.php"); ?>
