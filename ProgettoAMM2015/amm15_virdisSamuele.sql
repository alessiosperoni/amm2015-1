-- phpMyAdmin SQL Dump
-- version 4.2.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 15, 2015 at 07:41 PM
-- Server version: 5.5.41-0ubuntu0.14.10.1
-- PHP Version: 5.5.12-2ubuntu4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `amm15_virdisSamuele`
--

-- --------------------------------------------------------

--
-- Table structure for table `Corsi`
--

CREATE TABLE IF NOT EXISTS `Corsi` (
`Codice` bigint(20) unsigned NOT NULL,
  `Descrizione` varchar(300) DEFAULT NULL,
  `Durata` varchar(10) DEFAULT NULL,
  `NMax` int(11) DEFAULT NULL,
  `Nome` varchar(20) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `Corsi`
--

INSERT INTO `Corsi` (`Codice`, `Descrizione`, `Durata`, `NMax`, `Nome`) VALUES
(1, 'Il pugilato e'' uno sport da combattimento e una forma di autodifesa.A livello competitivo esso si svolge all''interno di uno spazio quadrato chiamato ring, tra due atleti che si affrontano colpendosi con i pugni chiusi(protetti da appositi guantoni), allo scopo di indebolire e atterrare l''avversario.', '2h 30min', 21, 'Pugilato'),
(2, 'Il sollevamento pesi, o pesistica e'' una disciplina atletica nel quale i concorrenti tentano di sollevare pesi montati su un bilanciere d''acciaio.', '3h', 10, 'Sollevamento pesi'),
(3, 'Il nuoto e'' l''attivita'' motoria che permette il galleggiamento e il moto del proprio corpo nell''acqua. Il nuoto coinvolge quasi tutti i muscoli del corpo.', '4h', 15, 'Nuoto'),
(4, 'Il CrossFit e'' un programma di rafforzamento e condizionamento fisico.', '5h', 11, 'CrossFit'),
(5, 'La danza e'' un''arte performativa e anche uno sport che si esprime nel movimento del corpo umano secondo un piano prestabilito, detto coreografia, o attraverso l''improvvisazione.', '4h 30m', 100, 'Danza'),
(6, 'L''allenamento funzionale e'' oggi un allenamento di estrema completezza e di grande impatto emotivo, che garantisce fidelizzazione e spirito di gruppo.', '2h', 17, 'Funzionale');

-- --------------------------------------------------------

--
-- Table structure for table `Edizioni`
--

CREATE TABLE IF NOT EXISTS `Edizioni` (
`Numero` bigint(20) unsigned NOT NULL,
  `Giorno` varchar(10) DEFAULT NULL,
  `Ora` time DEFAULT NULL,
  `Prezzo` varchar(10) DEFAULT NULL,
  `CodiceCorso` bigint(20) unsigned DEFAULT NULL,
  `IdIstruttore` bigint(20) unsigned DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `Edizioni`
--

INSERT INTO `Edizioni` (`Numero`, `Giorno`, `Ora`, `Prezzo`, `CodiceCorso`, `IdIstruttore`) VALUES
(1, 'Lunedi''', '10:20:00', '30 euro', 1, 45217),
(2, 'martedi''', '15:00:00', '35 euro', 2, 48915),
(3, 'giovedi''', '12:30:00', '40 euro', 3, 45217),
(4, 'domenica', '14:30:00', '25 euro', 4, 45217),
(5, 'mercoledi''', '11:30:00', '22 euro', 5, 48915),
(6, 'martedi''', '18:30:00', '20 euro', 6, 45217);

-- --------------------------------------------------------

--
-- Table structure for table `Iscrizioni`
--

CREATE TABLE IF NOT EXISTS `Iscrizioni` (
`id` bigint(20) unsigned NOT NULL,
  `DataIscrizione` date DEFAULT NULL,
  `Pagato` varchar(2) DEFAULT NULL,
  `NumeroEdizione` bigint(20) unsigned DEFAULT NULL,
  `idUtente` bigint(20) unsigned DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `Iscrizioni`
--

INSERT INTO `Iscrizioni` (`id`, `DataIscrizione`, `Pagato`, `NumeroEdizione`, `idUtente`) VALUES
(1, '2015-02-01', 'SI', 2, 2),
(2, '2000-04-02', 'SI', 5, 1),
(3, '2015-08-07', 'NO', 3, 1),
(4, '2015-03-01', 'SI', 4, 2),
(5, '2013-10-05', 'SI', 1, 1),
(6, '2015-08-02', 'NO', 6, 3),
(7, '2015-08-15', 'SI', 1, 2),
(8, '2002-01-01', 'SI', 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Istruttori`
--

CREATE TABLE IF NOT EXISTS `Istruttori` (
  `password` varchar(128) DEFAULT NULL,
  `username` varchar(128) DEFAULT NULL,
  `id` bigint(10) unsigned NOT NULL,
  `Cognome` varchar(20) DEFAULT NULL,
  `Nome` varchar(20) DEFAULT NULL,
  `CodiceFiscale` varchar(16) DEFAULT NULL,
  `Email` varchar(126) DEFAULT NULL,
  `DataNascita` date DEFAULT NULL,
  `CodiceCorso` bigint(20) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Istruttori`
--

INSERT INTO `Istruttori` (`password`, `username`, `id`, `Cognome`, `Nome`, `CodiceFiscale`, `Email`, `DataNascita`, `CodiceCorso`) VALUES
('Progetto15', 'istruttore', 45217, 'Ghiglieri', 'Stefano', 'SGHGLR12O1LAP01P', 'ste2@hotmail.com', '1981-08-13', 1),
('Ammprogetto1', 'MaxPower', 48915, 'Power', 'Massimo', 'MPWR13EP0A123VGL', 'maxPower@live.it', '1980-05-01', 2);

-- --------------------------------------------------------

--
-- Table structure for table `Utenti`
--

CREATE TABLE IF NOT EXISTS `Utenti` (
  `password` varchar(128) DEFAULT NULL,
  `username` varchar(128) DEFAULT NULL,
`id` bigint(20) unsigned NOT NULL,
  `Cognome` varchar(20) DEFAULT NULL,
  `Nome` varchar(20) DEFAULT NULL,
  `DataNascita` date DEFAULT NULL,
  `Telefono` varchar(10) DEFAULT NULL,
  `DataCertificato` date DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Utenti`
--

INSERT INTO `Utenti` (`password`, `username`, `id`, `Cognome`, `Nome`, `DataNascita`, `Telefono`, `DataCertificato`) VALUES
('Progetto15', 'utente', 1, 'Virdis', 'Samuele', '1994-01-03', '3452451238', '2015-08-20'),
('Ammprogetto1', 'paolo', 2, 'Perra', 'Paolo', '1990-05-04', '3427810111', '2015-04-06'),
('Provaquest0', 'giulio', 3, 'Sanna', 'Giulio', '1870-07-04', '3407412365', '2010-10-09'),
('Provaquest0', 'claudio', 4, 'Serra', 'Claudio', '1994-05-10', '3425878104', '2015-08-19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Corsi`
--
ALTER TABLE `Corsi`
 ADD PRIMARY KEY (`Codice`);

--
-- Indexes for table `Edizioni`
--
ALTER TABLE `Edizioni`
 ADD PRIMARY KEY (`Numero`), ADD KEY `CodiceCorso` (`CodiceCorso`), ADD KEY `MatricolaIstruttore` (`IdIstruttore`);

--
-- Indexes for table `Iscrizioni`
--
ALTER TABLE `Iscrizioni`
 ADD PRIMARY KEY (`id`), ADD KEY `NumeroEdizione` (`NumeroEdizione`), ADD KEY `idUtente` (`idUtente`);

--
-- Indexes for table `Istruttori`
--
ALTER TABLE `Istruttori`
 ADD PRIMARY KEY (`id`), ADD KEY `CodiceCorso` (`CodiceCorso`);

--
-- Indexes for table `Utenti`
--
ALTER TABLE `Utenti`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Corsi`
--
ALTER TABLE `Corsi`
MODIFY `Codice` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `Edizioni`
--
ALTER TABLE `Edizioni`
MODIFY `Numero` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `Iscrizioni`
--
ALTER TABLE `Iscrizioni`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `Utenti`
--
ALTER TABLE `Utenti`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Edizioni`
--
ALTER TABLE `Edizioni`
ADD CONSTRAINT `edizione2_fk` FOREIGN KEY (`IdIstruttore`) REFERENCES `Istruttori` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `edizione_fk` FOREIGN KEY (`CodiceCorso`) REFERENCES `Corsi` (`Codice`) ON UPDATE CASCADE;

--
-- Constraints for table `Iscrizioni`
--
ALTER TABLE `Iscrizioni`
ADD CONSTRAINT `iscrizioni2_fk` FOREIGN KEY (`NumeroEdizione`) REFERENCES `Edizioni` (`Numero`) ON UPDATE CASCADE,
ADD CONSTRAINT `iscrizioni_fk` FOREIGN KEY (`idUtente`) REFERENCES `Utenti` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `Istruttori`
--
ALTER TABLE `Istruttori`
ADD CONSTRAINT `istruttore_fk` FOREIGN KEY (`CodiceCorso`) REFERENCES `Corsi` (`Codice`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
