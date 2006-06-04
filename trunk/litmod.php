<?php
	$title = "Literatur bearbeiten/hinzuf&uuml;gen";
	//$extracss = "home.css";

	require_once("include/header.php");

	if ($login->IsMember() === false)
	{
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

	if ($error_occurred == true)
	{
		echo "<div id=\"error_list\">Es scheinen Fehler bei der Verarbeitung aufgetreten zu sein:<ul>";
		
		if ($error_titel === true)
		{
			echo "<li>Sie müssen einen Titel für die Literatur angeben</li>";
		}

		if ($error_autor === true)
		{
			echo "<li>Sie müssen mindestens einen Autor angeben</li>";
		}

		if ($error_jahr === true)
		{
			echo "<li>Das Jahr muss eine Zahl sein</li>";
		}

		echo "</ul></div>";
	}


	if ((isset($_GET["delete"]) === false && isset($_GET["insert"]) === false && isset($_GET["update"]) === false)
		|| $error_occurred === true)
	{
		require_once("include/form_helper.php");
		if (isset($_GET["id"]) === true || isset($_POST["id"]) === true)
		{
			require_once("include/literatur.php");

			if (isset($_POST["id"]) === true)
			{
				$id = $_POST["id"];
			}
			else
			{
				$id = $_GET["id"];
			}

			$lit = new Literatur($_GET["id"]);
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
			if (isset($lit->Autoren) === true)
			{
				for ($j = 0; $j < count($lit->Autoren); $j++)
				{
					if ($j != 0)
					{
						$autor .= ", ";
					}
					$autor .= $lit->Autoren[$j]->Name;
				}
			}

			$verlag = $lit->Verlag;
			$ort = $lit->Ort;
			$isbn = $lit->ISBN;
			$beschreibung = $lit->Beschreibung;
		}
		else
		{
			if (isset($_POST["titel"]) === true)
			{
				$titel = stripslashes($_POST["titel"]);
			}
			else
			{
				$titel = "";
			}

			if (isset($_POST["autor"]) === true)
			{
				$autor = stripslashes($_POST["autor"]);
			}
			else
			{
				$autor = "";
			}

			if (isset($_POST["jahr"]) === true)
			{
				$jahr = stripslashes($_POST["jahr"]);
			}
			else
			{
				$jahr = "";
			}

			if (isset($_POST["stichworte"]) === true)
			{
				$stichworte = stripslashes($_POST["stichworte"]);
			}
			else
			{
				$stichworte = "";
			}

			if (isset($_POST["art"]) === true)
			{
				$art = stripslashes($_POST["art"]);
			}
			else
			{
				$art = "Buch";
			}

			if (isset($_POST["verlag"]) === true)
			{
				$verlag = stripslashes($_POST["verlag"]);
			}
			else
			{
				$verlag = "";
			}

			if (isset($_POST["ort"]) === true)
			{
				$ort = stripslashes($_POST["ort"]);
			}
			else
			{
				$ort = "";
			}

			if (isset($_POST["isbn"]) === true)
			{
				$isbn = stripslashes($_POST["isbn"]);
			}
			else
			{
				$isbn = "";
			}

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
			echo "<form action=\"litmod.".$ext."?insert\" id=\"litaddform\" method=\"post\">";
		}
		else
		{
			echo "<form action=\"litmod.".$ext."?update\" id=\"litupdateform\" method=\"post\">";
			echo form_input("hidden", "id", $id);
		}
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
					<td><?=form_select(array("Anleitung", "Artikel", "Broschüre", "Buch", "Diplomarbeit",
						"Dissertation", "Protokoll", "Sonstiges", "Techn. Bericht", "Unveröffentlicht"),
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
					<td><textarea cols="20" rows="10" name="beschreibung" id="beschreibung"><?=htmlspecialchars($beschreibung);?></textarea></td>
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
		require_once("include/literatur.php");
		if (isset($_GET["delete"]) === true)
		{
			/// \todo Hier erstmal nachfragen, ob überhaupt Löschen
			
			Literatur::Delete($_GET["id"]);
		}
		elseif  (isset($_GET["insert"]) === true)
		{
			/// \todo Hier erstmal schauen, ob Literatur mit Titel und Autor existiert und entsprechend Nachfragen
			Literatur::Insert($_POST["autor"], $_POST["art"], $_POST["titel"], $_POST["jahr"], $_POST["verlag"], $_POST["isbn"], $_POST["beschreibung"], $_POST["ort"], $_POST["stichworte"]);
		}
		elseif (isset($_GET["update"]) === true)
		{
			Literatur::Update($_POST["id"], $_POST["autor"], $_POST["art"], $_POST["titel"], $_POST["jahr"], $_POST["verlag"], $_POST["isbn"], $_POST["beschreibung"], $_POST["ort"], $_POST["stichworte"]);
		}
	}
?>
</div>
<?php	require_once("include/footer.php"); ?>

