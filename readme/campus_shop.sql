-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 08, 2022 alle 09:48
-- Versione del server: 10.4.18-MariaDB
-- Versione PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `campus_shop`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `appartenenza_categorie`
--

CREATE TABLE `appartenenza_categorie` (
  `id_categoria` int(10) UNSIGNED NOT NULL,
  `id_prodotto` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `appartenenza_categorie`
--

INSERT INTO `appartenenza_categorie` (`id_categoria`, `id_prodotto`) VALUES
(1, 15),
(1, 19),
(1, 20),
(1, 21),
(1, 28),
(1, 30),
(1, 31),
(1, 32),
(1, 34),
(2, 13),
(2, 17),
(2, 18),
(2, 22),
(2, 28),
(2, 31),
(2, 32),
(2, 33),
(3, 12),
(3, 14);

-- --------------------------------------------------------

--
-- Struttura della tabella `carta`
--

CREATE TABLE `carta` (
  `codice` char(16) NOT NULL,
  `cvv` char(255) NOT NULL,
  `scadenza` date NOT NULL,
  `id_cliente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` char(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`id`, `nome`) VALUES
(1, 'primo'),
(2, 'secondo'),
(3, 'dolce');

-- --------------------------------------------------------

--
-- Struttura della tabella `cliente`
--

CREATE TABLE `cliente` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` char(254) NOT NULL,
  `password` char(255) NOT NULL,
  `CF` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `cliente`
--

INSERT INTO `cliente` (`id`, `email`, `password`, `CF`) VALUES
(1, 'cliente1@gmail.com', '$2y$10$r.mVVldZA.dljcmTqIomEuJ5yyXCP9nV1FxZIn4571gHJRqXsBhNW', '1234567891111111');

-- --------------------------------------------------------

--
-- Struttura della tabella `collo`
--

CREATE TABLE `collo` (
  `id` int(10) UNSIGNED NOT NULL,
  `quantita_prodotto` int(11) NOT NULL,
  `id_prodotto` int(10) UNSIGNED NOT NULL,
  `id_spedizione` int(10) UNSIGNED DEFAULT NULL,
  `id_ordine` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `notifica_cliente`
--

CREATE TABLE `notifica_cliente` (
  `id` int(10) UNSIGNED NOT NULL,
  `testo` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `id_cliente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `notifica_venditore`
--

CREATE TABLE `notifica_venditore` (
  `id` int(10) UNSIGNED NOT NULL,
  `testo` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `id_venditore` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `ordine`
--

CREATE TABLE `ordine` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_cliente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `ordine`
--

INSERT INTO `ordine` (`id`, `id_cliente`) VALUES
(60, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `pagamento`
--

CREATE TABLE `pagamento` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_ordine` int(10) UNSIGNED NOT NULL,
  `data` date NOT NULL,
  `totale` decimal(6,2) NOT NULL,
  `codice_carta` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto`
--

CREATE TABLE `prodotto` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` char(254) NOT NULL,
  `prezzo` decimal(6,2) NOT NULL,
  `quantita_disponibile` int(11) NOT NULL,
  `visibile` tinyint(1) NOT NULL DEFAULT 1,
  `foto` char(254) NOT NULL,
  `descrizione` varchar(1024) NOT NULL,
  `id_venditore` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `prodotto`
--

INSERT INTO `prodotto` (`id`, `nome`, `prezzo`, `quantita_disponibile`, `visibile`, `foto`, `descrizione`, `id_venditore`) VALUES
(12, 'VEGAN-LOW PROTEIN-BISCUITS', '3.00', 44, 1, '1640770439269931596_441447650817981_7371766389568225664_n.jpg', 'Oggi vi ripropongo la ricetta degli omini di pan di zenzero, rivisitata per renderla idonea a chi preferisce ricette #senzalattosio #vegan #senzauova ed anche per i bambini piccoli, per il loro ridotto contenuto di proteine. Inoltre come al solito questo impasto è facilissimo da manipolare, e durante le feste potete divertirvi a farli in famiglia, senza rischiare che si sciolga.', 3),
(13, 'ROTOLI FRITTATA ARCOBALENO', '8.00', 47, 1, '1640770529268947190_1081135672711030_3401660203519247447_n.jpg', 'E\' quasi Ntale, e come ogni anno arriva il momento di pianificare il pranzo natalizio per stupire amici e familiari... ma come farlo unendo gusto e leggerezza? Spesso infatti ricorriamo a delle soluzioni buonissime ma molto pesanti come fritti e insaccati, oppure banali come i classici grissini e prosciutto. Qui vi lascio una serie di idee di facile realizzazione, molto proteiche e che, a seconda di come le farcite potrenno davvero essere super leggere.', 3),
(14, 'MILLEFOGLIE DI ZUCCA', '6.00', 49, 1, '1640770591266368965_1133847760692593_2672983834905039169_n.jpg', 'Come mangiare la zucca è una domanda che avrebbe mille risposte. Se però avete tempo e voglia di coccolarvi con una bella ricetta di quelle che sanno di casa, ecco quello che fa per voi: strati di zucca, prosciutto e formaggio con una crosticina deliziosa. Wow.\r\nQuesto a dimostrare il fatto che la verdura, se cucinata bene anche se in modo semplice, è davvero gustosa, e non vi farà rimpiangere anche in una cena fra amici la pizza o la carne ai ferri.', 3),
(15, 'PASTA BROCCOLI E CREMA DI RICOTTA', '10.00', 50, 1, '1640770637263265656_427547722207893_8345635815783798483_n.jpg', 'Oggi vi propongo una ricetta che con la carbonara non ha davvero nulla a che fare, ma alla quale mi sono ispirata per creare una ricetta #vegetariana. Al posto della pancetta ho usato il broccolo, e invece della crema di uovo ne ho realizzata una a base di ricotta e zafferano. Gustosa, e bilanciata, senza una montagna di grassi saturi o colesterlo tipici della carbonara che è buonissima, ma che per un pasto da ogni giorno possiamo provare a rivisitare così!', 3),
(17, 'CROSTONI FETA E ZUCCA', '4.00', 46, 1, '1640770803256255661_407151697744114_4562949950298888296_n.jpg', 'Oggi vi propongo un nuovo abbinamento tra verdura e feta, che potete usare come alternativa ad un pranzo quando non vi va la pasta, come aperitivo o come cena veloce.\r\n', 3),
(18, 'INSALATONA CON ROASTBEEF', '8.00', 46, 1, '1640770871251838791_731338527787219_5807192835931033449_n.jpg', 'Oggi vi propongo un\'idea insalatona per una cena leggera e gustosa ma comunque bilanciata. In casa mia abbiamo abbinato il piatto che vedete a piacimento con piadina o con pane ai 5 cereali, in modo da aggiungere la parte di carboidrati. Questa ricetta è perfetta anche come antipasto leggero, potete proporla come rotolini di roastbeef con dentro grana e rucola, oppure mantenerla così!', 3),
(19, 'COUS COUS CON RAGU DI VERDURE E SALSICCIA', '7.00', 49, 1, '1640770939248392675_262818989116466_3313525450643966090_n.jpg', 'Oggi ho proposto in casa questo piatto molto gustoso e colorato. Prepararlo è molto semplice, e di solito incontra i gusti di tutti, perché la salsiccia fatica a non piacere. Per cercare però di variare, oggi ho usato quelle di misto pollo, tacchino e suino. Davvero buono, è andato spazzolato e hanno apprezzato tutti, soprattutto perché cuocendo insieme carne e verdure queste si insaporiscono e vengono più facilmente accettate anche da chi non è amante!', 3),
(20, 'MARI E MONTI AUTUNNALE', '5.00', 46, 1, '1640770993246014777_404571654586692_861884367193031724_n.jpg', 'Oggi vi propongo quello che a vedersi parebbe un piatto sofisticato e complesso, ma che, e ve ne renderete conto dagli ingredietni, è davvero semplice! Oggi ho scelto una pasta biologica, per testarla e provare le differenze da quella classica, e prossimamente vi fornirò qualche informazione in più se anche voi non conoscente la differenza tra questo mondo e quello della agricoltura convenzionale.', 3),
(21, 'PASTA MEDITERRANEA ALLE MELANZANE', '8.00', 49, 1, '1640771040244988510_1983566518475275_945528675089498275_n.jpg', 'Oggi vi propongo questa semplicissima ricetta di una pasta veloce e sfiziosa. la ho realizzata saltando in padella pomodorini, melanzane, acciughe e capperi. Ci ho condito la pasta e in pochi minuti il sugo era pronto. A volte infatti più che il tempo, che spesso usiamo come scusa, quello che manca sono le idee.', 3),
(22, 'BASTONCINI FINDUS', '7.50', 500, 1, '1640771116244054256_388302672961948_8658937649294775357_n.jpg', 'Tutti conosciamo questo piatto di pesce: facile, veloce e già pronto quando arriviamo di corsa da una giornata di lavoro! Ma quale sarebbe la differenza nel cucinarli da 0? Un costo inferiore, una minore quantità di sale e grassi e qualche minuto in più! Sfruttando però magari un\'oretta di tempo libero potreste prepararne un po\' in anticipo, acquistando magari del pesce in offerta come nel mio caso, decidendo la quantità di sale e olio da aggiungere, per poi conservarli in freezer fino al momento dell\'uso! Vi assicuro che il sapore e la qualità ve li faranno apprezzare molto di più di un surgelato già pronto, per non parlare del risparmio economico ed ecologico, nell\'acquisto di prodotti con minor packaging.', 3),
(26, 'CAPRESE', '5.00', 50, 1, '1640774512243487776_382795440121197_5611928328926217279_n.jpg', 'Oggi non vi lascio una ricetta, perchè questo piatto chiaramente non ne ha bisogno. La conoscete tutti, è fresca, gustosa e buonissima. La Caprese è solo fatta di pomodoro, mozzarella e basilico che potete divertirvi a presentare come più vi piace!', 3),
(27, 'PANZANELLA', '3.00', 50, 1, '1640774667242280690_871196763793440_5388089897479396290_n.jpg', 'Tradizione spesso è sinonimo di gusto bontà, ma purtroppo anche di unto, pesante, fritto e condito. Questo è uno dei pochi piatti che quest\'estate ho mangiato davvero spesso e che adoro perchè è un piatto del riciclo, che potete fare in vari modi a seconda di ciò che avete a casa e che soprattutto si presta ad essere declinato a antipasto o contorno proprio per la sua leggerezza e versatilità.', 3),
(28, 'PAELLA LEGGERA SOLO PESCE', '4.00', 50, 1, '1640774805241731568_362935738888274_6550244617185790662_n.jpg', 'Vi capita mai di sentire il nome di un piatto e pensare \"buono, ma pensante!!\" Beh questo probabilmente è il caso anche della Paella che però, come in tanti altri casi, talvolta diventa pesante soprattutto perché lo arricchiamo di grassi, insaccati, condimenti e perché ne mangiamo una quantità esagerata. Realizzandola invece con riso, pesce e verdure, di base non è affatto un piatto da demonizzare...', 4),
(30, 'RAVIOLI CINESI AL VAPORE', '12.00', 50, 1, '241314007_266638898628623_8933409526572468517_n.jpg', 'Oggi vi propongo un delizioso piatto etnico: eccoli, i ravioli al vapore! Non so se anche a voi ma io adoro la cucina cinese. Agrodolce e saporita. Unico problema? Che quando prendo il cinese finisco per mangiare una quantità esagerata, perché essendo molto condito è buonissimo, ogni forchettata ne tira un altra (o bacchettata se siete capaci di usarle) ma purtroppo è anche molto pensante e spesso finisco per stare quasi male.', 4),
(31, 'CRESPELLE DI VERDURE E SPECK', '9.50', 49, 1, '1640779372240941376_234169341959594_8541100423665422403_n.jpg', 'Come creare un pranzo con una buona quantità di proteine, senza avere a disposizione una bistecca? Ecco quà come lo puoi realizzare: mettendo insieme diverse fonti proteiche in quantità più basse, e ricordando sempre di mettere tanta verdura fresca che d\'estate non manca e una parte di carbo per cui io oggi ho usato farina integrale. E ricorda che se scegli delle fonti proteiche che contengono grassi saturi come nel mio caso (come speck, latticini, uova) evita di aggiungere altri grassi come panna o mascarpone e magari prediligi, se ad esempio vuoi preprare una besciamelle il latte scremato e l\'olio di oliva.', 4),
(32, 'COUS COUS VERDE', '4.00', 49, 1, '1640779471240164412_137589178541651_3836377840770296549_n.jpg', 'D\'estate cucinare leggero è ancora più facile se si usano piccole strategie e mangiare il cous cous è una di queste. Quando lo si cuoce questo cereale aumenta molto di volume, in più se condito con tante verdure fa davvero molta resa con poche calorie. Io oggi lo ho preparato con zucchine, peperoni, melanzane, cipolla di tropea e erbe varie come origano e basilico per dare un tocco total green, ma tu puoi scegliere le verdure che più ti piacciono.', 4),
(33, 'PESCE ALLE VERDURE', '15.00', 50, 1, '1640779529236370948_4180187095429501_753351806808497893_n.jpg', 'Oggi vi propongo un piatto veloccissimo ed estivo, che ci può aiutare anche d\'estate a consumare un pò di pesce! Va benissimo mangiarlo in insalata ma ovviamente bisogna fare attenzione a non cadere nella monotonia e scegliere sempre gamberetti, tonno o salmone affumicato. Il pesce azzurro infatti contiene meno metalli pesanti dei grossi pesci come spada e tonno, ma ha comunque un buon apporto di omega 3, e se fresco o surgelato contiene meno sale del pesce conservato.', 4),
(34, 'PINK RISO BASMATI E VERDURE', '8.00', 50, 1, '1640779739234568252_175016798030886_4152721877885199583_n.jpg', 'Oggi vi propongo una nuova ricetta per mangiare il riso d\'estate in maniera fresca e golosa. Spesso siamo abituati a pensare che cucinare sia brigoso, soprattutto quando si scelgono alcuni prodotti come le verdure o il pesce. Beh, questo è sicuramente un mito da sfatare perchè le verdure, soprattutto se tagliate piccole e cotte per breve tempo, si preprano velocemente, conservano meglio i loro preziosi nutrienti e ci consentono di creare sempre piatti nuovi e freschi, senza il rischio di cadere nella comodità del piatto o del sugo già pronto. Oggi vi prensento in particolare questa versione con la rapa rossa, che se acquistate già bollita, è velocissima da preprare e arricchirà il vostro piatto di polifenoli e antiossidanti.\r\n', 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `spedizione`
--

CREATE TABLE `spedizione` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` date NOT NULL,
  `stato` char(16) NOT NULL,
  `incasso` decimal(6,2) NOT NULL,
  `id_venditore` int(10) UNSIGNED NOT NULL,
  `id_cliente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `venditore`
--

CREATE TABLE `venditore` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` char(254) NOT NULL,
  `password` char(255) NOT NULL,
  `email` char(254) NOT NULL,
  `pIva` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `venditore`
--

INSERT INTO `venditore` (`id`, `nome`, `password`, `email`, `pIva`) VALUES
(3, 'Ristorante di Jo', '$2y$10$r.mVVldZA.dljcmTqIomEuJ5yyXCP9nV1FxZIn4571gHJRqXsBhNW', 'ecommerce@ristojo.it', '12345678911'),
(4, 'Agriturismo da Jo', '$2y$10$r.mVVldZA.dljcmTqIomEuJ5yyXCP9nV1FxZIn4571gHJRqXsBhNW', 'ecommerce@agriturismojo.it', '12345678912');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `appartenenza_categorie`
--
ALTER TABLE `appartenenza_categorie`
  ADD PRIMARY KEY (`id_categoria`,`id_prodotto`),
  ADD KEY `FKapp_PRO` (`id_prodotto`);

--
-- Indici per le tabelle `carta`
--
ALTER TABLE `carta`
  ADD PRIMARY KEY (`codice`),
  ADD KEY `FKutilizza` (`id_cliente`);

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDCLIENTE_1` (`email`);

--
-- Indici per le tabelle `collo`
--
ALTER TABLE `collo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKcompone` (`id_prodotto`),
  ADD KEY `FKviaggia` (`id_spedizione`),
  ADD KEY `FKfa_parte` (`id_ordine`);

--
-- Indici per le tabelle `notifica_cliente`
--
ALTER TABLE `notifica_cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKnotifica` (`id_cliente`);

--
-- Indici per le tabelle `notifica_venditore`
--
ALTER TABLE `notifica_venditore`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKallerta` (`id_venditore`);

--
-- Indici per le tabelle `ordine`
--
ALTER TABLE `ordine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKriempie` (`id_cliente`);

--
-- Indici per le tabelle `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `FKcertifica_ID` (`id_ordine`);

--
-- Indici per le tabelle `prodotto`
--
ALTER TABLE `prodotto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKha` (`id_venditore`);

--
-- Indici per le tabelle `spedizione`
--
ALTER TABLE `spedizione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKinvia` (`id_venditore`),
  ADD KEY `FKriceve` (`id_cliente`);

--
-- Indici per le tabelle `venditore`
--
ALTER TABLE `venditore`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDVENDITORE_1` (`email`),
  ADD UNIQUE KEY `pIva` (`pIva`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT per la tabella `collo`
--
ALTER TABLE `collo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT per la tabella `notifica_cliente`
--
ALTER TABLE `notifica_cliente`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT per la tabella `notifica_venditore`
--
ALTER TABLE `notifica_venditore`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT per la tabella `ordine`
--
ALTER TABLE `ordine`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT per la tabella `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT per la tabella `spedizione`
--
ALTER TABLE `spedizione`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT per la tabella `venditore`
--
ALTER TABLE `venditore`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `appartenenza_categorie`
--
ALTER TABLE `appartenenza_categorie`
  ADD CONSTRAINT `FKapp_CAT` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `FKapp_PRO` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotto` (`id`);

--
-- Limiti per la tabella `carta`
--
ALTER TABLE `carta`
  ADD CONSTRAINT `FKutilizza` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`);

--
-- Limiti per la tabella `collo`
--
ALTER TABLE `collo`
  ADD CONSTRAINT `FKcompone` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotto` (`id`),
  ADD CONSTRAINT `FKfa_parte` FOREIGN KEY (`id_ordine`) REFERENCES `ordine` (`id`),
  ADD CONSTRAINT `FKviaggia` FOREIGN KEY (`id_spedizione`) REFERENCES `spedizione` (`id`);

--
-- Limiti per la tabella `notifica_cliente`
--
ALTER TABLE `notifica_cliente`
  ADD CONSTRAINT `FKnotifica` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`);

--
-- Limiti per la tabella `notifica_venditore`
--
ALTER TABLE `notifica_venditore`
  ADD CONSTRAINT `FKallerta` FOREIGN KEY (`id_venditore`) REFERENCES `venditore` (`id`);

--
-- Limiti per la tabella `ordine`
--
ALTER TABLE `ordine`
  ADD CONSTRAINT `FKriempie` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`);

--
-- Limiti per la tabella `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `FKcertifica_FK` FOREIGN KEY (`id_ordine`) REFERENCES `ordine` (`id`);

--
-- Limiti per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  ADD CONSTRAINT `FKha` FOREIGN KEY (`id_venditore`) REFERENCES `venditore` (`id`);

--
-- Limiti per la tabella `spedizione`
--
ALTER TABLE `spedizione`
  ADD CONSTRAINT `FKinvia` FOREIGN KEY (`id_venditore`) REFERENCES `venditore` (`id`),
  ADD CONSTRAINT `FKriceve` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
