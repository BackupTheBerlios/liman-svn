<?php
	// W�hle Seitentitel nach ausgew�hlter Aktion
	if (isset($_GET["delete"]) === true)
	{
		$title = "Literatur l�schen";
	}
	elseif (isset($_GET["id"]) === true || isset($_POST["id"]) === true)
	{
		$title = "Literatur �ndern";
	}
	else
	{
		$title = "Literatur hinzuf�gen";
	}

	require_once("include/header.php");

	// Abbruch wenn keine Mitgliedsrechte vorhanden
	if ($login->IsMember() === false)
	{
		echo "<div id=\"error\">Sie sind f�r diese Aktion nicht berechtigt</div>";
		require_once("include/footer.php");
		die();
	}
?>
<div id="cfront" class="content">
<?php
	$error_occurred = false; // Fehler beim Verarbeiten aufgetreten?
	$error_titel = false;
	$error_autor = false;
	$error_jahr = false;

	// �berpr�fe wichtige Parameter bei Insert und Update auf Vorhandensein
	if (isset($_GET["insert"]) === true || isset($_GET["update"]) === true)
	{
		if (empty($_POST["titel"]) === true)
		{
			$error_titel = true;
			$error_occurred = true;
		}

		if (empty($_POST["autor"]) === true)
		{
			$error_autor = true;
			$error_occurred = true;
		}

		if (empty($_POST["jahr"]) === false && is_numeric($_POST["jahr"]) === false)
		{
			$error_jahr = true;
			$error_occurred = true;
		}
	}

	// Gebe Fehler bei Parameter�berpr�fung aus
	if ($error_occurred == true)
	{
		echo "<div id=\"error_list\">Es scheinen Fehler bei der Verarbeitung aufgetreten zu sein:<ul>";
		
		if ($error_titel === true)
		{
			echo "<li>Sie m�ssen einen Titel f�r die Literatur angeben</li>";
		}

		if ($error_autor === true)
		{
			echo "<li>Sie m�ssen mindestens einen Autor angeben</li>";
		}

		if ($error_jahr === true)
		{
			echo "<li>Das Jahr muss eine Zahl sein</li>";
		}

		echo "</ul></div>";
	}

	// Gebe Formular aus, wenn keine Schreibaktionen ausgef�hrt werden
	if ((isset($_GET["delete"]) === false && isset($_GET["insert"]) === false && isset($_GET["update"]) === false)
		|| $error_occurred === true)
	{
		// Lese id aus, wenn vorhanden
		if (isset($_POST["id"]) === true)
		{
			$id = $_POST["id"];
		}
		elseif (isset($_GET["id"]) === true)
		{
			$id = $_GET["id"];
		}
		else
		{
			unset($id);
		}

		require_once("include/form_helper.php");
		// Lese Literatur aus, wenn id bekannt ist und vorher kein Fehler aufgetreten ist
		if ($error_occurred === false && (isset($_GET["id"]) === true || isset($_POST["id"]) === true))
		{
			require_once("include/literatur.php");

			$lit = new Literatur($id);
			$titel = $lit->Titel;
			$autor = "";
			$jahr = $lit->Jahr;
			$stichworte = $lit->Stichworte;

			if (isset($lit->Art) === true)
			{
				$art = $lit->Art->GetDisplayText();
			}
			else
			{
				$art = "Buch";
			}

			$autor = "";
			if (empty($lit->Autoren) === false)
			{
				$autornamen = array();
				foreach ($lit->Autoren as $cur)
				{
					$autornamen[] = $cur->Name;
				}

				$autor = implode(", ", $autornamen);
			}

			$verlag = $lit->Verlag;
			$ort = $lit->Ort;
			$isbn = $lit->ISBN;
			$beschreibung = $lit->Beschreibung;
		}
		else
		{
			// Sollte vorher Fehler aufgetreten sein, lese Parameter aus.
			// Sollten vorher keine Fehler aufgetreten sein (keine
			// id bekannt), setze Default Wert

			// Setze Titel
			if (isset($_POST["titel"]) === true)
			{
				$titel = stripslashes($_POST["titel"]);
			}
			else
			{
				$titel = "";
			}

			// Setze Autoren
			if (isset($_POST["autor"]) === true)
			{
				$autor = stripslashes($_POST["autor"]);
			}
			else
			{
				$autor = "";
			}

			// Setze Jahr
			if (isset($_POST["jahr"]) === true)
			{
				$jahr = stripslashes($_POST["jahr"]);
			}
			else
			{
				$jahr = date("Y");
			}

			// Setze Stichworte
			if (isset($_POST["stichworte"]) === true)
			{
				$stichworte = stripslashes($_POST["stichworte"]);
			}
			else
			{
				$stichworte = "";
			}

			// Setze Art
			if (isset($_POST["art"]) === true)
			{
				$art = stripslashes($_POST["art"]);
			}
			else
			{
				$art = "Buch";
			}

			// Setze Verlag
			if (isset($_POST["verlag"]) === true)
			{
				$verlag = stripslashes($_POST["verlag"]);
			}
			else
			{
				$verlag = "";
			}

			// Setze Ort
			if (isset($_POST["ort"]) === true)
			{
				$ort = stripslashes($_POST["ort"]);
			}
			else
			{
				$ort = "";
			}

			// Setze ISBN
			if (isset($_POST["isbn"]) === true)
			{
				$isbn = stripslashes($_POST["isbn"]);
			}
			else
			{
				$isbn = "";
			}

			// Setze Beschreibung
			if (isset($_POST["beschreibung"]) === true)
			{
				$beschreibung = stripslashes($_POST["beschreibung"]);
			}
			else
			{
				$beschreibung = "";
			}
		}

		if (empty($id) === true)
		{
			// Gebe Hinzuf�gen-Formular aus
			echo "<form action=\"litmod.".$ext."?insert\" id=\"litaddform\" method=\"post\">";
		}
		else
		{
			// Gebe Update-Formular aus
			echo "<form action=\"litmod.".$ext."?update\" id=\"litupdateform\" method=\"post\">";
			echo form_input("hidden", "id", $id);
		}

		// Gebe Formular mit vorher bestimmten Werten aus
	?>
		<table id="litadd">
			<tbody>
				<tr>
					<th scope="row">Titel:</th>	
					<td><?=form_input("text", "titel", $titel, $error_titel);?></td>
				</tr>
				<tr>
					<th scope="row">Autor:</th>
					<td><?=form_input("text", "autor", $autor, $error_autor);?></td>
				</tr>
				<tr>
					<th scope="row">Erscheinungsjahr:</th>	
					<td><?=form_input("text", "jahr", $jahr, $error_jahr);?></td>
				</tr>
				<tr>
					<th scope="row">Stichworte:</th>	
					<td><?=form_input("text", "stichworte", $stichworte);?></td>
				</tr>
				<tr>
					<th scope="row">Art:</th>	
					<td><?=form_select(array("Anleitung", "Artikel", "Brosch�re", "Buch", "Diplomarbeit",
						"Dissertation", "Protokoll", "Sonstiges", "Techn. Bericht", "Unver�ffentlicht"),
						"art", $art);?>
					</td>
				</tr>
				<tr>
					<th scope="row">Verlag:</th>	
					<td><?=form_input("text", "verlag", $verlag);?></td>
				</tr>
				<tr>
					<th scope="row">Verlagsort:</th>	
					<td><?=form_input("text", "ort", $ort);?></td>
				</tr>
	
				<tr>
					<th scope="row">ISBN:</th>	
					<td><?=form_input("text", "isbn", $isbn);?></td>
				</tr>
				<tr>
					<th scope="row">Bemerkung:</th>	
					<td><textarea cols="20" rows="10" name="beschreibung" id="beschreibung"><?=htmlspecialchars($beschreibung); ?></textarea></td>
				</tr>
				<tr>
					<th scope="row">Aktionen:</th>	
					<td><input type="submit" value="&Uuml;bernehmen"></td>
				</tr>
	
			</tbody>
		</table>
		</form>
	<?php
	}
	else
	{
		// F�hre Schreibaktionen aus
		require_once("include/literatur.php");


		// Suche gew�hlte Aktion
		if (isset($_GET["delete"]) === true)
		{
			// L�schen wenn akzeptiert wurde
			if (isset($_POST["accept"]) === true)
			{
				// Fehlerhafte Daten zum L�schen �bertragen?
				if (empty($_POST["id"]) === true || is_numeric($_POST["id"]) === false)
				{
					// Wenn ja, gebe Fehler aus
					echo "<p id=\"error\">Literatur konnte nicht gel�scht werden, da es ein Fehler bei der �bertragung der Informationen der Literatur gab</p>";
				}
				else
				{
					// Wenn nicht, l�sche Literatur und gebe Erfolgsmeldung aus
					Literatur::Delete($_POST["id"]);
					echo "<p style=\"text-align: center\">Literatur wurde entfernt</p>";
				}
			}
			else
			{
				// Frage ob Literatur gel�scht werden soll
				require_once("include/form_helper.php");
				echo "<div id=\"warning\" style=\"margin-top: 2em\">";
				echo "Wollen sie die Literatur wirklich entfernen?";
				echo "<form action=\"litmod.".$ext."?delete\" id=\"litupdateform\" method=\"post\">";
				echo form_input("hidden", "id", $_GET["id"]);
				echo form_input("hidden", "accept", "true");
				echo "<input type=\"submit\" value=\"Best�tigen\">";
				echo "</form></div>";
			}
		}
		elseif  (isset($_GET["insert"]) === true)
		{
			if (isset($_POST["accept"]) === false)
			{
				// Suche ob �hnliche Literatur existiert
				require_once("include/suche.php");
				$search = new Suche($_POST["titel"], $_POST["autor"]);
				if (empty($search->Treffer) === false)
				{
				?>
					Es wurde �hnliche Literatur gefunden:
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
					// Gebe gefundene Literatur zur�ck
					foreach ($search->Treffer as $cur)
					{
				?>
					<tr>
						<td><a href="lit.<?=$ext; ?>?id=<?=htmlspecialchars($cur->Nr); ?>"><?=htmlspecialchars($cur->Titel); ?></a></td>
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
					// Frage nach Best�tigung zum Hinzuf�gen
					require_once("include/form_helper.php");
					echo "<div id=\"warning\" style=\"margin-top: 2em\">";
					echo "Trotzdem hinzuf�gen?";
					echo "<form action=\"litmod.".$ext."?insert\" id=\"litupdateform\" method=\"post\">";
					echo form_input("hidden", "accept", "true");
					echo form_input("hidden", "titel", $_POST["titel"]);
					echo form_input("hidden", "autor", $_POST["autor"]);
					echo form_input("hidden", "jahr", $_POST["jahr"]);
					echo form_input("hidden", "stichworte", $_POST["stichworte"]);
					echo form_input("hidden", "art", $_POST["art"]);
					echo form_input("hidden", "verlag", $_POST["verlag"]);
					echo form_input("hidden", "ort", $_POST["ort"]);
					echo form_input("hidden", "isbn", $_POST["isbn"]);
					echo form_input("hidden", "beschreibung", $_POST["beschreibung"]);
					echo "<input type=\"submit\" value=\"Best�tigen\">";
					echo "</form></div>";
				}
			}

			// Anlegen, wenn keine �hnlichen B�cher gefunden wurden oder wenn akzeptiert wurde
			if (isset($_POST["accept"]) === true || empty($search->Treffer) === true)
			{
				// Fehlerhafte Daten zum Anlegen �bertragen?
				if (isset($_POST["art"]) === false || isset($_POST["verlag"]) === false ||
					isset($_POST["isbn"]) === false || isset($_POST["beschreibung"]) === false ||
					isset($_POST["ort"]) === false || isset($_POST["stichworte"]) === false)
				{
					// Wenn ja, gebe Fehler aus
					echo "<p id=\"error\">Literatur konnte nicht angelegt werden, da es ein Fehler bei der �bertragung der Informationen der Literatur gab</p>";
				}
				else
				{
					// Wenn nicht, lege Literatur an und gebe Erfolgsmeldung aus
					Literatur::Insert($_POST["autor"], $_POST["art"], $_POST["titel"], $_POST["jahr"], $_POST["verlag"], $_POST["isbn"], $_POST["beschreibung"], $_POST["ort"], $_POST["stichworte"]);
					echo "<p style=\"text-align: center\">Literatur wurde hinzugef�gt</p>";
				}
			}
		}
		elseif (isset($_GET["update"]) === true)
		{
			// Fehlerhafte Daten zum �ndern �bertragen?
			if (empty($_POST["id"]) === true || is_numeric($_POST["id"]) === false ||
				isset($_POST["art"]) === false || isset($_POST["verlag"]) === false ||
				isset($_POST["isbn"]) === false || isset($_POST["beschreibung"]) === false ||
				isset($_POST["ort"]) === false || isset($_POST["stichworte"]) === false)
			{
				// Wenn ja, gebe Fehler aus
				echo "<p id=\"error\">Literatur konnte nicht ge�ndert werden, da es ein Fehler bei der �bertragung der Informationen der Literatur gab</p>";
			}
			else
			{
				// Wenn nicht, �ndere Literatur und gebe Erfolgsmeldung aus
				Literatur::Update($_POST["id"], $_POST["autor"], $_POST["art"], $_POST["titel"], $_POST["jahr"], $_POST["verlag"], $_POST["isbn"], $_POST["beschreibung"], $_POST["ort"], $_POST["stichworte"]);
				echo "<p style=\"text-align: center\">Literatur wurde ge�ndert</p>";
			}
		}
	}
?>
</div>
<?php	require_once("include/footer.php"); ?>
