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
