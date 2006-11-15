-- 
-- Tabellenstruktur für Tabelle `liman_Autoren`
-- 

DROP TABLE IF EXISTS `liman_Autoren`;
CREATE TABLE IF NOT EXISTS `liman_Autoren` (
  `Autor_Nr` int(11) NOT NULL auto_increment,
  `Autorname` varchar(40) NOT NULL,
  PRIMARY KEY  (`Autor_Nr`),
  UNIQUE KEY `Autorname` (`Autorname`),
  FULLTEXT KEY `Autorname_2` (`Autorname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Daten für Tabelle `liman_Autoren`
-- 

INSERT INTO `liman_Autoren` (`Autor_Nr`, `Autorname`) VALUES (1, 'Robert Sedgewick'),
(2, 'Dinu C. Gherman'),
(3, 'Christian Tismer'),
(4, 'Bruce Schneier'),
(5, 'Christian Krause');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `liman_Bibliothek`
-- 

DROP TABLE IF EXISTS `liman_Bibliothek`;
CREATE TABLE IF NOT EXISTS `liman_Bibliothek` (
  `Literatur_Nr` int(11) NOT NULL auto_increment,
  `Art` enum('Buch','Artikel','Broschüre','Protokoll','Anleitung','Diplomarbeit','Dissertation','Techn. Bericht','Unveröffentlicht','Sonstiges') NOT NULL,
  `Titel` varchar(40) NOT NULL,
  `Jahr` int(11) NOT NULL,
  `Verlag` varchar(40) NOT NULL,
  `ISBN` varchar(20) NOT NULL,
  `Beschreibung` text NOT NULL,
  `Ort` varchar(40) NOT NULL,
  `Stichworte` varchar(100) NOT NULL,
  PRIMARY KEY  (`Literatur_Nr`),
  FULLTEXT KEY `Titel` (`Titel`,`Verlag`,`ISBN`,`Beschreibung`,`Ort`,`Stichworte`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Daten für Tabelle `liman_Bibliothek`
-- 

INSERT INTO `liman_Bibliothek` (`Literatur_Nr`, `Art`, `Titel`, `Jahr`, `Verlag`, `ISBN`, `Beschreibung`, `Ort`, `Stichworte`) VALUES (1, 'Buch', 'Algorithmen', 1998, 'Pearson Studium', '3-8273-7032-9', 'Robert Sedgewicks bekanntes Standardwerk stellt die wichtigsten Algorithmen klar und umfassend dar. Von elementaren Datenstrukturen und Algorithmen wie Such- und Sortieralgorithmen schlägt Sedgewick einen Bogen bis hin zu modernen Ansätzen und vermittelt dem Leser einen fundierten Überblick über die vielfältigen Möglichkeiten der Problemlösung anhand von Datenstrukturen.', 'Bonn ; München ; Paris [u.a.]', 'AVL, Listen, RB, Bäume,'),
(2, 'Buch', 'Python - kurz und gut', 2002, 'O''Reilly', '3-89721-240-4', '"Python - kurz und gut" ist eine kompakte Referenz zum schnellen Nachschlagen aller wichtigen Sprachmerkmale und Elemente von Python.', 'Köln', 'Datentypen, Anweisungen, Funktionen, Objektorientierte Programmierung, Überladungsmethoden, Biblioth'),
(3, 'Buch', 'Angewandte Kryptographie', 1996, 'Addison-Wesley', '3-89319-854-7', 'Diese zweite Auflage des Klassikers über Kryptographie bietet eine umfassenden Überblick über die moderne Kyptographie. Programmierer und Datenkommunikations-Fachleute erfahren, wie sie Verfahren zur Ver- und Entschlüsselung von Nachrichten in die Praxis umsetzen. Das Buch beschreibt nicht nur zahlreiche kryptographische Algorithmen, sondern gibt auch praktische Hinweise zur Implementierung kryptographischer Software.', 'München', 'RSA, XOR, MD5, SHA, Public Key'),
(4, 'Diplomarbeit', 'Verteilte Datensicherung', 2002, '', '', 'Diese Arbeit beschreibt ein Konzept für eine verteilte Datensicherung unter Nutzung freier Ressourcen von Arbeitsplatzrechnern. Das vorzustellende System beinhaltet entsprechende Maßnahmen, um sowohl die Authentizität und Vertraulichkeit der zu sichernden Daten zu gewährleisten, als auch eine möglichst hohe Wahrscheinlichkeit für die Wiederherstellung zu erreichen.', 'Chemnitz', 'P2P, Datensicherung, Integrität');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `liman_Kommentare`
-- 

DROP TABLE IF EXISTS `liman_Kommentare`;
CREATE TABLE IF NOT EXISTS `liman_Kommentare` (
  `Kommentar_Nr` int(11) NOT NULL auto_increment,
  `Kommentartext` text NOT NULL,
  `Literatur_Nr` int(11) NOT NULL,
  `Mitglieds_Nr` int(11) NOT NULL,
  PRIMARY KEY  (`Kommentar_Nr`),
  KEY `Literatur_Nr` (`Literatur_Nr`,`Mitglieds_Nr`),
  FULLTEXT KEY `Kommentartext` (`Kommentartext`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Daten für Tabelle `liman_Kommentare`
-- 

INSERT INTO `liman_Kommentare` (`Kommentar_Nr`, `Kommentartext`, `Literatur_Nr`, `Mitglieds_Nr`) VALUES (1, 'Tolle Dramatik, wirklich fesselnder Storyverlauf, nur das Ende war ein bisschen matt.', 1, 2);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `liman_Literatur_Autor`
-- 

DROP TABLE IF EXISTS `liman_Literatur_Autor`;
CREATE TABLE IF NOT EXISTS `liman_Literatur_Autor` (
  `Autor_Nr` int(11) NOT NULL,
  `Literatur_Nr` int(11) NOT NULL,
  KEY `Autor_Nr` (`Autor_Nr`,`Literatur_Nr`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='n-m-Relationstabelle Literatur-Autor';

-- 
-- Daten für Tabelle `liman_Literatur_Autor`
-- 

INSERT INTO `liman_Literatur_Autor` (`Autor_Nr`, `Literatur_Nr`) VALUES (1, 1),
(2, 2),
(3, 2),
(4, 3),
(5, 4);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `liman_Mitglieder`
-- 

DROP TABLE IF EXISTS `liman_Mitglieder`;
CREATE TABLE IF NOT EXISTS `liman_Mitglieder` (
  `Mitglieds_Nr` int(11) NOT NULL auto_increment,
  `Name` varchar(20) NOT NULL,
  `Vorname` varchar(20) NOT NULL,
  `Email` text NOT NULL,
  `Login` varchar(12) NOT NULL,
  `Passwort` varchar(40) NOT NULL,
  `Rechte` enum('Benutzer','Administrator') NOT NULL,
  PRIMARY KEY  (`Mitglieds_Nr`),
  UNIQUE KEY `Login` (`Login`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Daten für Tabelle `liman_Mitglieder`
-- 

INSERT INTO `liman_Mitglieder` (`Mitglieds_Nr`, `Name`, `Vorname`, `Email`, `Login`, `Passwort`, `Rechte`) VALUES (1, 'Wunderlich', 'Simon', 'siwu@hrz.tu-chemnitz.de', 'siwu', 'c47c25460079d8a87d44175b732f73af2e92b6d2', 'Administrator'),
(2, 'Wurst', 'Hans', 'hans@foobar.de', 'hans', 'c47c25460079d8a87d44175b732f73af2e92b6d2', 'Benutzer');
