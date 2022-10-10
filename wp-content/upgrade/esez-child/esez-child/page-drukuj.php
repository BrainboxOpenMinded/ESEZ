
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta name="robots" content="noindex">   
<?php wp_head(); ?>
</head>
<body>

<?php
$ewidencja_id = $_GET['ewidencja_id'];

$author_id = get_post_field( 'post_author', $ewidencja_id );
$user = get_the_author_meta( 'ID' );
global $current_user;
wp_get_current_user();

/* Dane do tabeli */
$specyfikacja_ceremonii_pogrzebowej = get_field( 'uslugi_pogrzebowe', $ewidencja_id );
$uslugi_zlecone = get_field( 'uslugi_zlecone', $ewidencja_id );

// Zmarły
$kod_opaski = get_the_title( $ewidencja_id );
$numer_opaski = get_field( 'numer_opaski', $ewidencja_id );
$imie_zmarlego = get_field( 'imie_zmarlego', $ewidencja_id );
$nazwisko_zmarlego = get_field( 'nazwisko_zmarlego', $ewidencja_id );
$pesel = get_field( 'pesel', $ewidencja_id );
$waga = get_field( 'waga', $ewidencja_id );
$miejsce_odbioru = get_field( 'miejsce_odbioru', $ewidencja_id );
$adres_odbioru_inne = get_field( 'adres_odbioru_inne', $ewidencja_id );
$adres_odbioru_inne_nazwa = $adres_odbioru_inne['adres_odbioru_inne-nazwa'];
$adres_odbioru_inne_miasto = $adres_odbioru_inne['adres_odbioru_inne-miasto'];
$adres_odbioru_inne_adres = $adres_odbioru_inne['adres_odbioru_inne-ulica-nr-domu'];
$adres_odbioru_dom = get_field( 'adres_odbioru_dom', $ewidencja_id );
$adres_odbioru_dom_miasto = $adres_odbioru_dom['adres_odbioru_dom-miasto'];
$adres_odbioru_dom_adres = $adres_odbioru_dom['adres_odbioru_dom-ulica-nr-domu'];
$data_odbioru_ciala = get_field( 'data_odbioru_ciala', $ewidencja_id );
$notatki_do_druku = get_field( 'notatki_do_druku', $ewidencja_id );
$godzina__data_pogrzebu = get_field( 'godzina__data_pogrzebu', $ewidencja_id );
$data_pogrzebu = get_field( 'data_pogrzebu', $ewidencja_id );
$godzina_pogrzebu = get_field( 'godzina_pogrzebu', $ewidencja_id );
$ceremonia_pozegnalna = get_field( 'ceremonia_pozegnalna', $ewidencja_id );
$ceremonia_pozegnalna_data = $ceremonia_pozegnalna['data'];
$ceremonia_pozegnalna_godzina = $ceremonia_pozegnalna['godzina'];
$ceremonia_pozegnalna_miejsce = $ceremonia_pozegnalna['miejsce'];
$ceremonia_pozegnalna_adres = $ceremonia_pozegnalna['adres'];

// Zgłaszający + organizator
$szczegoly_odbioru = get_field( 'szczegoly_odbioru', $ewidencja_id );
$imie_nazwisko_zglaszajacego = get_field( 'imie_nazwisko_zglaszajacego', $ewidencja_id );
$telefon_zglaszajacego = get_field( 'telefon_zglaszajacego', $ewidencja_id );
$mail_zglaszajacego = get_field( 'mail_zglaszajacego', $ewidencja_id );
$notatka_zglaszajacego = get_field( 'notatka', $ewidencja_id );
$nr_dowodu_zglaszajacego = get_field( 'nr_dowodu_zglaszajacego', $ewidencja_id );
$kto_organizuje_pogrzeb = get_field( 'kto_organizuje_pogrzeb', $ewidencja_id );
$firma_organizujaca_pogrzeb = get_field( 'firma_organizujaca_pogrzeb', $ewidencja_id );
$data_wydania_ciala = get_field( 'data_wydania_ciala', $ewidencja_id );

//Grupa - zasiłek pogrzebowy
$zasilek_pogrzebowy = get_field( 'zasilek_pogrzebowy_inne', $ewidencja_id );
$odebrac_zasilek_pogrzebowy = $zasilek_pogrzebowy['odebrac_zasilek_pogrzebowy'];
$zasilek_zaksiegowany = $zasilek_pogrzebowy['zasilek_zaksiegowany'];
$kwota_zasilku = $zasilek_pogrzebowy['cena']; //CENA-

$rodzaj_pogrzebu = get_field( 'rodzaj_pogrzebu', $ewidencja_id );
$kremacja_wykonana = get_field( 'kremacja_wykonana', $ewidencja_id );
$data_kremacji = get_field( 'data_kremacji', $ewidencja_id );

//Grupa - trumna
$trumna = get_field( 'trumna', $ewidencja_id );
$numer_trumny = $trumna['numer_trumny'];
$wzrost = $trumna['wzrost'];
$waga2 = $trumna['waga'];
$trumna_cena = $trumna['cena']; //CENA

//Grupa - urna
$urna = get_field( 'urna', $ewidencja_id );
$numer_urny = $urna['numer_urny'];
$urna_cena = $urna['cena']; //CENA

//Grupa - relikwiarz
$relikwiarz = get_field( 'relikwiarz', $ewidencja_id );
$numer_relikwiarza = $relikwiarz['numer_relikwiarza'];
$relikwiarz_cena = $relikwiarz['cena']; //CENA

//Grupa - tabliczka
$tabliczka = get_field( 'tabliczka', $ewidencja_id );
$rodzaj_tabliczki = $tabliczka['rodzaj'];
$tabliczka_numer_trumny = $tabliczka['numer_trumny'];
$tabliczka_numer_urny = $tabliczka['numer_urny'];
$tabliczka_pierwsze_imie = $tabliczka['pierwsze_imie'];
$tabliczka_drugie_imie = $tabliczka['drugie_imie'];
$tabliczka_cena = $tabliczka['cena']; //CENA

//Grupa - zdjęcie
$zdjecie = get_field( 'zdjecie', $ewidencja_id );
$wybor_zdjecia = $zdjecie['wybor_zdjecia'];
$zdjecie_cena = $zdjecie['cena']; //CENA

//Grupa - krzyż
$krzyz = get_field( 'krzyz', $ewidencja_id );
$wybor_krzyza = $krzyz['wybor_krzyza'];
$krzyz_cena = $krzyz['cena']; //CENA

//Grupa - eksportacja
$eksportacja_zwlok = get_field( 'eksportacja_zwlok', $ewidencja_id );
$skad_eksportacja_zwlok = $eksportacja_zwlok['skad'];
$eksportacja_zwlok_cena = $eksportacja_zwlok['cena']; //CENA

//Grupa - zabezpieczenie
$zabezpieczenie = get_field( 'zabezpieczenie', $ewidencja_id );
$ilosc_zabezpieczenie = $zabezpieczenie['ilosc_szt'];
$zabezpieczenie_cena = $zabezpieczenie['cena']; //CENA

//Grupa - przechowalnia
$przechowalnia = get_field( 'przechowalnia', $ewidencja_id );
$przechowalnia_data_od = $przechowalnia['data_od'];
$przechowalnia_data_do = $przechowalnia['data_do'];
$przechowalnia_cena = $przechowalnia['cena']; //CENA

//Grupa - Przygotowanie osoby zmarłej
$przygotowanie_osoby_zmarlej = get_field( 'przygotowanie_osoby_zmarlej', $ewidencja_id );
$przygotowanie_osoby_zmarlej_uslugi = $przygotowanie_osoby_zmarlej['uslugi'];
$przygotowanie_osoby_zmarlej_cena = $przygotowanie_osoby_zmarlej['cena']; //CENA

//Grupa - Transport ciala
$transport_ciala = get_field( 'transport_ciala', $ewidencja_id );
$transport_ciala_rodzaj = $transport_ciala['rodzaj'];
$transport_ciala_cena = $transport_ciala['cena']; //CENA

//Grupa - Przeczekanie przez ceremonię pogrzebową
$przeczekanie_przez_ceremonie = get_field( 'przeczekanie_przez_ceremonie', $ewidencja_id );
$przeczekanie_przez_ceremonie_cena = $przeczekanie_przez_ceremonie['cena']; //CENA

//Grupa - Obsługa pogrzebu
$obsluga_pogrzebu = get_field( 'obsluga_pogrzebu', $ewidencja_id );
$obsluga_pogrzebu_pracownicy = $obsluga_pogrzebu['pracownicy'];
$obsluga_pogrzebu_cena = $obsluga_pogrzebu['cena']; //CENA

//Grupa - Dostawa trumny
$dostawa = get_field( 'dostawa', $ewidencja_id );
$dostawa_do = $dostawa['usluga'];
$dostawa_cena = $dostawa['cena']; //CENA

//Grupa - Odbiór zasiłku pogrzebowego
$odbior_zasilku = get_field( 'zasilek_pogrzebowy', $ewidencja_id );
$odbior_zasilku_cena = $odbior_zasilku['cena']; //CENA

//Grupa - Kompleksowa organizacja
$kompleksowa_organizacja_pogrzebu = get_field( 'kompleksowa_organizacja_pogrzebu', $ewidencja_id );
$kompleksowa_organizacja_pogrzebu_wybor = $kompleksowa_organizacja_pogrzebu['wybor'];
$kompleksowa_organizacja_pogrzebu_cena = $kompleksowa_organizacja_pogrzebu['cena']; //CENA

//Grupa - Akcesoria pogrzebowe
$akcesoria_pogrzebowe = get_field( 'akcesoria_pogrzebowe', $ewidencja_id );
$akcesoria_pogrzebowe_cena = $akcesoria_pogrzebowe['cena']; //CENA

//Grupa - Obrazki pamiątkowe
$obrazki_pamiatkowe = get_field( 'obrazki_pamiatkowe', $ewidencja_id );
$obrazki_pamiatkowe_numer = $obrazki_pamiatkowe['numer'];
$obrazki_pamiatkowe_sztuki = $obrazki_pamiatkowe['sztuki'];
$obrazki_pamiatkowe_cena = $obrazki_pamiatkowe['cena']; //CENA

//Grupa - e-Nekrologi
$enekrologi = get_field( 'e-nekrologi', $ewidencja_id );
$enekrologi_cena = $enekrologi['cena']; //CENA

//Grupa - Transmisja online
$transmisja_online = get_field( 'transmisja_online', $ewidencja_id );
$transmisja_online_cena = $transmisja_online['cena']; //CENA

//Grupa - Klepsydry
$klepsydry = get_field( 'klepsydry', $ewidencja_id );
$klepsydry_ile_sztuk = $klepsydry['ile_sztuk'];
$klepsydry_cena = $klepsydry['cena']; //CENA

//Grupa - Gołębie na pogrzebie
$golebie_na_pogrzebie = get_field( 'golebie_na_pogrzebie', $ewidencja_id );
$golebie_na_pogrzebie_cena = $golebie_na_pogrzebie['cena']; //CENA

//Grupa - Inne
$inne_uslugi_zakladu = get_field( 'inne_uslugi_zakladu', $ewidencja_id );
$inne_uslugi_zakladu_opis = $inne_uslugi_zakladu['opis'];
$inne_uslugi_zakladu_cena = $inne_uslugi_zakladu['cena']; //CENA

//USŁUGI ZLECONE

//Grupa - Rachunek z zarządu cmentarza
$rachunek_z_zarzadu_cmentarza = get_field( 'rachunek_z_zarzadu_cmentarza', $ewidencja_id );
$rachunek_z_zarzadu_cmentarza_cena = $rachunek_z_zarzadu_cmentarza['cena']; //CENA

//Grupa - Rachunek za kremację
$rachunek_za_kremacje = get_field( 'rachunek_za_kremacje', $ewidencja_id );
$rachunek_za_kremacje_cena = $rachunek_za_kremacje['cena']; //CENA

//Grupa - Rachunek za otwarcie i zamknięcie grobu/murowanie grobowca
$rachunek_za_otwarcie_i_zamkniecie_grobu = get_field( 'rachunek_za_otwarcie_i_zamkniecie_grobu', $ewidencja_id );
$rachunek_za_otwarcie_i_zamkniecie_grobu_cena = $rachunek_za_otwarcie_i_zamkniecie_grobu['cena']; //CENA

//Grupa - Kopanie grobu
$kopanie_grobu = get_field( 'kopanie_grobu', $ewidencja_id );
$kopanie_grobu_sposob = $kopanie_grobu['sposob'];
$kopanie_grobu_cena = $kopanie_grobu['cena']; //CENA

//Grupa - Rodzaj ceremonii
$rodzaj_ceremonii = get_field( 'rodzaj_ceremonii', $ewidencja_id );
$rodzaj_ceremonii_rodzaj = $rodzaj_ceremonii['rodzaj'];
$rodzaj_ceremonii_cena = $rodzaj_ceremonii['cena']; //CENA

//Grupa - Oprawa muzyczna
$oprawa_muzyczna = get_field( 'oprawa_muzyczna', $ewidencja_id );
$oprawa_muzyczna_rodzaj = $oprawa_muzyczna['rodzaj'];
$oprawa_muzyczna_cena = $oprawa_muzyczna['cena']; //CENA

//Grupa - Kaplica przedpogrzebowa
$kaplica_przedpogrzebowa = get_field( 'kaplica_przedpogrzebowa', $ewidencja_id );
$kaplica_przedpogrzebowa_cena = $kaplica_przedpogrzebowa['cena']; //CENA

//Grupa - Odzież dla zmarłych
$odziez_dla_zmarlych = get_field( 'odziez_dla_zmarlych', $ewidencja_id );
$odziez_dla_zmarlych_opis = $odziez_dla_zmarlych['opis'];
$odziez_dla_zmarlych_cena = $odziez_dla_zmarlych['cena']; //CENA

//Grupa - Nekrolog do prasy
$nekrolog_do_prasy = get_field( 'nekrolog_do_prasy', $ewidencja_id );
$nekrolog_do_prasy_cena = $nekrolog_do_prasy['cena']; //CENA

//Grupa - Autokar - Mikrobus
$autokar = get_field( 'autokar', $ewidencja_id );
$autokar_cena = $autokar['cena']; //CENA

//Grupa - Przechowalnia w szpitalu
$przechowalnia_w_szpitalu = get_field( 'przechowalnia_w_szpitalu', $ewidencja_id );
$przechowalnia_w_szpitalu_data_od = $przechowalnia_w_szpitalu['data_od'];
$przechowalnia_w_szpitalu_data_do = $przechowalnia_w_szpitalu['data_do'];
$przechowalnia_w_szpitalu_cena = $przechowalnia_w_szpitalu['cena']; //CENA

//Grupa - Inne
$inne_uslugi_zlecone = get_field( 'inne_uslugi_zlecone', $ewidencja_id );
$inne_uslugi_zlecone_opis = $inne_uslugi_zlecone['opis'];
$inne_uslugi_zlecone_cena = $inne_uslugi_zlecone['cena']; //CENA

//Grupa - Wpłacona zaliczka
$wplacona_zaliczka = get_field( 'wplacona_zaliczka', $ewidencja_id );
$wplacona_zaliczka_cena = $wplacona_zaliczka['cena']; //CENA-

//Uwagi
$uwagi = get_field( 'uwagi', $ewidencja_id );


/* Dane do tabeli - koniec */

if ( !empty( $ewidencja_id ) ) {
    if (is_user_logged_in() && $current_user->ID == $author_id) {
?>
<!-- Tabelka start -->
<table class="table tabela-druk" style="width: 794px; font-size: 14px;">
  <tr>    
    <td width="26%">
      <img src="<?php echo $current_user->image; ?>" style="max-height: 150px;">
    </td>
    <td width="56%">
	<strong>Numer opaski:</strong> <?php echo $numer_opaski; ?><br>
      <strong>Zmarła osoba:</strong> <?php echo $imie_zmarlego . ' ' . $nazwisko_zmarlego; ?><br>
      <strong>PESEL Zmarłego:</strong> <?php echo $pesel; ?><br>
      <strong>Waga Zmarłego:</strong> <?php echo $waga; ?><br>
    <?php if ($miejsce_odbioru == 'Dom') { ?>
      <strong>Odbiór: <?php echo $miejsce_odbioru; ?></strong> <?php echo $adres_odbioru_dom_adres; ?>, <?php echo $adres_odbioru_dom_miasto; ?><br>
    <?php } else { ?>
      <strong>Odbiór: <?php echo $miejsce_odbioru; ?></strong> <?php echo $adres_odbioru_inne_nazwa; ?> <?php echo $adres_odbioru_inne_adres; ?>, <?php echo $adres_odbioru_inne_miasto; ?><br>
    <?php } ?>
      <strong>Data i godzina odbioru ciała:</strong> <?php echo $data_odbioru_ciala; ?><br>
	<?php if ($szczegoly_odbioru) { ?>
      <strong>Imię i nazwisko Zgłaszającego:</strong> <?php echo $imie_nazwisko_zglaszajacego; ?><br>
      <?php if ($nr_dowodu_zglaszajacego) { ?>
      <strong>Numer dowodu Zgłaszającego:</strong> <?php echo $nr_dowodu_zglaszajacego; ?><br>
      <?php }
       if ($telefon_zglaszajacego) { ?>
      <strong>Telefon Zgłaszającego:</strong> <?php echo $telefon_zglaszajacego; ?><br>
      <?php }
      if ($mail_zglaszajacego) { ?>
      <strong>Mail Zgłaszającego:</strong> <?php echo $mail_zglaszajacego; ?><br>
      <?php }
      if ($notatka_zglaszajacego) { ?>
        <strong>Notatki:</strong> <?php echo $notatka_zglaszajacego; ?><br>
      <?php }
      } ?>
      <?php if ($firma_organizujaca_pogrzeb) { ?>
      <strong>Firma organizująca pogrzeb:</strong> <?php echo $firma_organizujaca_pogrzeb; ?><br>
      <?php 
      } 
      if ($data_wydania_ciala) { ?>
      <strong>Data wydania ciała:</strong> <?php echo $data_wydania_ciala; ?><br>
    <?php } ?>
    </td>
    <td width="18%"><div class="showQRCode"></div></td>
  </tr>
  <tr>
    <td colspan="2">
      <strong>Odebrać zasiłek pogrzebowy: </strong>
      <?php if ($odebrac_zasilek_pogrzebowy) {
        echo 'tak';
      } else {
        echo 'nie';
      } ?>
    </td>
    <td style="text-align: right;"><?php if ($odebrac_zasilek_pogrzebowy) { ?><strong>Kwota: </strong><?php echo $kwota_zasilku; ?> zł<?php } ?></td>
  </tr>  
  <tr>
    <td colspan="3"><strong>Rodzaj pogrzebu: </strong><?php echo $rodzaj_pogrzebu; ?>
    <?php if ($rodzaj_pogrzebu == 'Kremacyjny') { ?>
      &emsp;<strong>Data kremacji: </strong><?php echo $data_kremacji; ?>
    <?php } ?>
    </td>
  </tr>
<?php if ($ceremonia_pozegnalna_data || $ceremonia_pozegnalna_godzina) { ?>
  <tr>
    <td colspan="3">
      <strong>Pożegnanie:</strong> <?php echo $ceremonia_pozegnalna_data . ' ' . $ceremonia_pozegnalna_godzina; ?>
    </td>
  </tr>
<?php } ?>
<?php if ($data_pogrzebu || $godzina_pogrzebu) { ?>
  <tr>
    <td colspan="3">
      <strong>Pogrzeb:</strong> <?php echo $data_pogrzebu . ' ' . $godzina_pogrzebu; ?>
    </td>
  </tr>
<?php } ?>
<?php /* if ($ceremonia_pozegnalna_adres || $ceremonia_pozegnalna_godzina || $ceremonia_pozegnalna_miejsce || $ceremonia_pozegnalna_data) { ?>
  <tr>
    <td colspan="3">
      <strong>Ceremonia pożegnalna: </strong><?php echo $ceremonia_pozegnalna_data . ' o godz. ' . $ceremonia_pozegnalna_godzina . ' ' . $ceremonia_pozegnalna_miejsce . ' ' . $ceremonia_pozegnalna_adres; ?>
    </td>
  </tr>
<?php }*/ ?>
<?php if ($specyfikacja_ceremonii_pogrzebowej) { ?>
  <tr style="background-color:#eee; font-weight: 800;
    text-transform: uppercase;"><td style="text-align:center;" colspan="2">Usługi zakładu</td><td style="text-align: right;">Cena</td>
  </tr>
<?php if ($trumna_cena !=='') { ?>
  <tr>
    <td colspan="2"><strong>Rodzaj trumny:</strong> <?php echo $numer_trumny; ?>&emsp;<strong>Wzrost:</strong> <?php echo $wzrost; ?>  <strong>&emsp;Waga:</strong> <?php echo $waga2; ?></td>
    <td style="text-align: right;"><strong><?php echo $trumna_cena; ?> zł netto</strong></td>
  </tr>
<?php } ?>
<?php if ( $urna_cena !=='') { ?>
  <tr>
    <td colspan="2"><strong>Rodzaj urny:</strong> <?php echo $numer_urny; ?></td>
    <td style="text-align: right;"><strong><?php echo $urna_cena; ?> zł netto</strong></td>
  </tr>
<?php } ?>
<?php if ($relikwiarz_cena !=='') { ?>
  <tr>
    <td colspan="2"><strong>Numer relikwiarza:</strong> <?php echo $numer_relikwiarza; ?></td>
    <td style="text-align: right;"><strong><?php echo $relikwiarz_cena; ?> zł netto</strong></td>
  </tr>
<?php } ?>
<?php if ($tabliczka_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Tabliczka:</strong>
      <?php if( $rodzaj_tabliczki ): ?>
        <?php foreach( $rodzaj_tabliczki as $rodzaj ): ?>
          <?php echo $rodzaj; ?> 
        <?php endforeach; ?>
      <?php endif; ?>
      na trumnę nr <?php echo $tabliczka_numer_trumny; ?> / urnę nr <?php echo $tabliczka_numer_urny; ?>, imiona: <?php echo $tabliczka_pierwsze_imie . ' ' .$tabliczka_drugie_imie ; ?></td>
    <td style="text-align: right;"><strong><?php echo $tabliczka_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($zdjecie_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Zdjęcie:</strong>
      <?php if( $wybor_zdjecia ): ?>
        <?php foreach( $wybor_zdjecia as $wybor ): ?>
          <?php echo $wybor; ?> 
        <?php endforeach; ?>
      <?php endif; ?></td>
    <td style="text-align: right;"><strong><?php echo $zdjecie_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($krzyz_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Krzyż:</strong>
      <?php if( $wybor_krzyza ): ?>
        <?php foreach( $wybor_krzyza as $wybor ): ?>
          <?php echo $wybor; ?> 
        <?php endforeach; ?>
      <?php endif; ?></td>
    <td style="text-align: right;"><strong><?php echo $krzyz_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($eksportacja_zwlok_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Eksportacja zwłok:</strong>
      <?php if( $skad_eksportacja_zwlok ): ?>
        <?php foreach( $skad_eksportacja_zwlok as $skad ): ?>
          <?php echo $skad; ?> 
        <?php endforeach; ?>
      <?php endif; ?></td>
    <td style="text-align: right;"><strong><?php echo $eksportacja_zwlok_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($zabezpieczenie_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Zabezpieczenie (pokrowiec sanitarny):</strong> <?php echo $ilosc_zabezpieczenie; ?></td>
    <td style="text-align: right;"><strong><?php echo $zabezpieczenie_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($przechowalnia_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Przechowalnia:</strong> od <?php echo $przechowalnia_data_od; ?>&emsp;do <?php echo $przechowalnia_data_do; ?></td>
    <td style="text-align: right;"><strong><?php echo $przechowalnia_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($przygotowanie_osoby_zmarlej_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Przygotowanie osoby zmarłej:</strong>
      <?php if( $przygotowanie_osoby_zmarlej_uslugi ): ?>
        <?php foreach( $przygotowanie_osoby_zmarlej_uslugi as $usluga ): ?>
          <?php echo $usluga . ', '; ?> 
        <?php endforeach; ?>
      <?php endif; ?></td>
    <td style="text-align: right;"><strong><?php echo $przygotowanie_osoby_zmarlej_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($transport_ciala_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Transport do pogrzebu:</strong>
      <?php if( $transport_ciala_rodzaj ): ?>
        <?php foreach( $transport_ciala_rodzaj as $transport_rodzaj ): ?>
          <?php echo $transport_rodzaj . ', '; ?> 
        <?php endforeach; ?>
      <?php endif; ?></td>
    <td style="text-align: right;"><strong><?php echo $transport_ciala_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($przeczekanie_przez_ceremonie_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Przeczekanie przez ceremonię pogrzebową</strong>
    </td>
    <td style="text-align: right;"><strong><?php echo $przeczekanie_przez_ceremonie_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($obsluga_pogrzebu_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Obsługa pogrzebu:</strong>
      <?php if( $obsluga_pogrzebu_pracownicy ): ?>
        <?php foreach( $obsluga_pogrzebu_pracownicy as $pracownicy ): ?>
          <?php echo $pracownicy . '-osobowa '; ?> 
        <?php endforeach; ?>
      <?php endif; ?></td>
    <td style="text-align: right;"><strong><?php echo $obsluga_pogrzebu_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($dostawa_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Dostawa trumny do </strong>
      <?php if( $dostawa_do): ?>
        <?php foreach( $dostawa_do as $dost ): ?>
          <?php echo $dost; ?> 
        <?php endforeach; ?>
      <?php endif; ?></td>
    <td style="text-align: right;"><strong><?php echo $dostawa_cena; ?> zł netto</strong></td>
  </tr>
  <?php }
if ($dostawa_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Odbiór zasiłku pogrzebowego</strong>
    </td>
    <td style="text-align: right;"><strong><?php echo $odbior_zasilku_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($kompleksowa_organizacja_pogrzebu_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Kompleksowa organizacja </strong>
      <?php if( $kompleksowa_organizacja_pogrzebu_wybor): ?>
        <?php foreach( $kompleksowa_organizacja_pogrzebu_wybor as $wyb ): ?>
          <?php echo $wyb; ?> 
        <?php endforeach; ?>
      <?php endif; ?>
    </td>
    <td style="text-align: right;"><strong><?php echo $kompleksowa_organizacja_pogrzebu_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($akcesoria_pogrzebowe_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Akcesoria pogrzebowe</strong>
    </td>
    <td style="text-align: right;"><strong><?php echo $akcesoria_pogrzebowe_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($obrazki_pamiatkowe_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Obrazki pamiątkowe:</strong> numer: <?php echo $obrazki_pamiatkowe_numer; ?>&emsp; <?php echo $obrazki_pamiatkowe_sztuki; ?> szt.
    </td>
    <td style="text-align: right;"><strong><?php echo $obrazki_pamiatkowe_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($enekrologi_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>e-Nekrolog na stronie</strong>
    </td>
    <td style="text-align: right;"><strong><?php echo $enekrologi_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($transmisja_online_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Transmisja online (streaming video)</strong>
    </td>
    <td style="text-align: right;"><strong><?php echo $transmisja_online_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($klepsydry_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Klepsydry:</strong> <?php echo $klepsydry_ile_sztuk; ?> szt.
    </td>
    <td style="text-align: right;"><strong><?php echo $klepsydry_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($golebie_na_pogrzebie_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Gołębie na pogrzebie</strong>
    </td>
    <td style="text-align: right;"><strong><?php echo $golebie_na_pogrzebie_cena; ?> zł netto</strong></td>
  </tr>
<?php }
if ($inne_uslugi_zakladu_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Inne:</strong> <?php echo $inne_uslugi_zakladu_opis; ?>&emsp;
    </td>
    <td style="text-align: right;"><strong><?php echo $inne_uslugi_zakladu_cena; ?> zł netto</strong></td>
  </tr>
<?php
  } ?>

  <tr style="background-color:#eee; font-weight: 800;
  text-transform: uppercase; text-align:right;"><td colspan="3"><!-- Podliczanie kwot -->

        
  <?php
  $calkowita_kwota_uslugipogrzebowe =
   (float)$trumna_cena
   +(float)$urna_cena
   +(float)$relikwiarz_cena
   +(float)$tabliczka_cena
   +(float)$zdjecie_cena
   +(float)$krzyz_cena
   +(float)$eksportacja_zwlok_cena
   +(float)$zabezpieczenie_cena
   +(float)$przechowalnia_cena
   +(float)$przygotowanie_osoby_zmarlej_cena
   +(float)$transport_ciala_cena
   +(float)$przeczekanie_przez_ceremonie_cena
   +(float)$obsluga_pogrzebu_cena
   +(float)$dostawa_cena
   +(float)$odbior_zasilku_cena
   +(float)$kompleksowa_organizacja_pogrzebu_cena
   +(float)$akcesoria_pogrzebowe_cena
   +(float)$obrazki_pamiatkowe_cena
   +(float)$enekrologi_cena
   +(float)$transmisja_online_cena
   +(float)$klepsydry_cena
   +(float)$golebie_na_pogrzebie_cena
   +(float)$inne_uslugi_zakladu_cena;
  $suma_z_podatkiem = $calkowita_kwota_uslugipogrzebowe;
  ?>
  <strong>Usł. pogrzebowe netto:</strong> <?php echo number_format($calkowita_kwota_uslugipogrzebowe,2,',',' ') . ' zł'; ?><br />
  <strong>Wartość VAT:</strong> <?php echo number_format($calkowita_kwota_uslugipogrzebowe*0.08,2,',',' ') . ' zł'; ?><br />
  <strong>Usł. pogrzebowe brutto:</strong> <?php echo number_format($suma_z_podatkiem*1.08,2,',',' ') . ' zł'; ?><br />

</td>
</tr>

 <?php } ?>
  <!-- Usługi zlecone -->
  <?php if ($uslugi_zlecone) { ?>
  <tr style="background-color:#eee; font-weight: 900; text-transform: uppercase;">
    <td colspan="2" style="text-align: center;">
      <strong>Usługi zlecone</strong>
    </td>
    <td style="text-align: right;">Cena</td>
  </tr>
<?php
if ($rachunek_z_zarzadu_cmentarza_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Rachunek z zarządu cmentarza</strong>
    </td>
    <td style="text-align: right;"><strong><?php echo $rachunek_z_zarzadu_cmentarza_cena; ?> zł brutto</strong></td>
  </tr>
<?php }
if ($rachunek_za_kremacje_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Rachunek za kremację</strong>
    </td>
    <td style="text-align: right;"><strong><?php echo $rachunek_za_kremacje_cena; ?> zł brutto</strong></td>
  </tr>
<?php }
if ($rachunek_za_otwarcie_i_zamkniecie_grobu_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Rachunek za otwarcie i zamknięcie grobu/murowanie grobowca</strong>
    </td>
    <td style="text-align: right;"><strong><?php echo $rachunek_za_otwarcie_i_zamkniecie_grobu_cena; ?> zł brutto</strong></td>
  </tr>
<?php }
if ($kopanie_grobu_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Kopanie grobu:</strong>
      <?php if( $kopanie_grobu_sposob ): ?>
        <?php foreach( $kopanie_grobu_sposob as $sposob ): ?>
          <?php echo $sposob; ?> 
        <?php endforeach; ?>
      <?php endif; ?>
    </td>
    <td style="text-align: right;"><strong><?php echo $kopanie_grobu_cena; ?> zł brutto</strong></td>
  </tr>
<?php }
if ($rodzaj_ceremonii_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Rodzaj ceremonii:</strong>
      <?php if( $rodzaj_ceremonii_rodzaj): ?>
        <?php foreach( $rodzaj_ceremonii_rodzaj as $rodzc ): ?>
          <?php echo $rodzc; ?> 
        <?php endforeach; ?>
      <?php endif; ?>
    </td>
    <td style="text-align: right;"><strong><?php echo $rodzaj_ceremonii_cena; ?> zł brutto</strong></td>
  </tr>
<?php }
if ($oprawa_muzyczna_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Oprawa muzyczna:</strong>
      <?php if( $oprawa_muzyczna_rodzaj ): ?>
        <?php foreach( $oprawa_muzyczna_rodzaj as $rodzajop ): ?>
          <?php echo $rodzajop; ?> 
        <?php endforeach; ?>
      <?php endif; ?>
    </td>
    <td style="text-align: right;"><strong><?php echo $oprawa_muzyczna_cena; ?> zł brutto</strong></td>
  </tr>
<?php }
if ($kaplica_przedpogrzebowa_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Kaplica przedpogrzebowa</strong>
    </td>
    <td style="text-align: right;"><strong><?php echo $kaplica_przedpogrzebowa_cena; ?> zł brutto</strong></td>
  </tr>
<?php }
if ($odziez_dla_zmarlych_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Odzież dla zmarłych </strong> <?php echo $odziez_dla_zmarlych_opis; ?>
    </td>
    <td style="text-align: right;"><strong><?php echo $odziez_dla_zmarlych_cena; ?> zł brutto</strong></td>
  </tr>
<?php }
if ($nekrolog_do_prasy_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Nekrolog do prasy </strong> <?php echo $nekrolog_do_prasy_opis; ?>
    </td>
    <td style="text-align: right;"><strong><?php echo $nekrolog_do_prasy_cena; ?> zł brutto</strong></td>
  </tr>
<?php }
if ($autokar_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Autokar - Mikrobus </strong> <?php echo $autokar_opis; ?>
    </td>
    <td style="text-align: right;"><strong><?php echo $autokar_cena; ?> zł brutto</strong></td>
  </tr>
<?php }
if ($przechowalnia_w_szpitalu_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Przechowalnia w szpitalu:</strong> od <?php echo $przechowalnia_w_szpitalu_data_od; ?>&emsp; do <?php echo $przechowalnia_w_szpitalu_data_do; ?></td>
    <td style="text-align: right;"><strong><?php echo $przechowalnia_w_szpitalu_cena; ?> zł brutto</strong></td>
  </tr>
<?php }

if( have_rows('oprawa_florystyczna', $ewidencja_id) )  : 
  echo '<tr><td colspan="3"><strong>Oprawa florystyczna:</strong></td></tr>';
  $suma_kwiaty = 0; ?>
  <?php while( have_rows('oprawa_florystyczna', $ewidencja_id) ): the_row();
  echo '<tr>';
  ?>
      <?php if( get_row_layout() == 'dodaj_kwiaty' ): ?>
          <?php
          $cena_kwiaty = get_sub_field('cena');
          $suma_kwiaty = $suma_kwiaty + $cena_kwiaty; ?>
          <td colspan="2"><strong>Nazwa:</strong> <?php echo get_sub_field('nazwa'); ?>
          &emsp; <strong>Napis na szarfie:</strong> <?php echo get_sub_field('napis_na_szarfie'); ?>    </td>
          <td style="text-align: right;"><strong><?php echo $cena_kwiaty; ?> zł brutto</strong></td>
      <?php endif; ?>
  <?php 
  echo '</tr>';
  endwhile; ?>
  <?php  
  endif; 

if ($inne_uslugi_zlecone_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Inne: </strong> <?php echo $inne_uslugi_zlecone_opis; ?>
    </td>
    <td style="text-align: right;"><strong><?php echo $inne_uslugi_zlecone_cena; ?> zł brutto</strong></td>
  </tr>  
<?php }
} ?>
<?php if( $wplacona_zaliczka_cena !=='') { ?>
  <tr>
    <td colspan="2">
      <strong>Wpłacona zaliczka </strong> 
    </td>
    <td style="text-align: right;"><strong><?php echo $wplacona_zaliczka_cena; ?> zł</strong></td>
  </tr>
<?php } ?>
<?php if( $uwagi) { ?>
  <tr>
    <td colspan="3"><strong>Uwagi:</strong> <?php echo $uwagi; ?> </td>
  </tr>
<?php } ?>
<?php if ($notatki_do_druku) { ?>
  <tr>
    <td colspan="3">
      <strong>Notatki:</strong> <?php echo $notatki_do_druku; ?>
    </td>
  </tr>
<?php } ?>
<?php if($specyfikacja_ceremonii_pogrzebowej || $uslugi_zlecone): ?>
  <tr style="background-color:#eee; font-weight: 800;
    text-transform: uppercase; text-align:right;"><td colspan="3"><!-- Podliczanie kwot -->
  
  <?php if($uslugi_zlecone): ?>
    <strong>&emsp;Usł. zlecone:</strong>            
    <?php
    $calkowita_kwota_zlecone =
    (float)$suma_kwiaty
    +(float)$rachunek_z_zarzadu_cmentarza_cena
    +(float)$rachunek_za_kremacje_cena
    +(float)$rachunek_za_otwarcie_i_zamkniecie_grobu_cena
    +(float)$kopanie_grobu_cena
    +(float)$rodzaj_ceremonii_cena
    +(float)$oprawa_muzyczna_cena
    +(float)$kaplica_przedpogrzebowa_cena
    +(float)$odziez_dla_zmarlych_cena
    +(float)$nekrolog_do_prasy_cena
    +(float)$autokar_cena
    +(float)$przechowalnia_w_szpitalu_cena
    +(float)$inne_uslugi_zlecone_cena;
    echo number_format($calkowita_kwota_zlecone, 2,',',' ') . ' zł';
    ?><br />
  <?php endif;

  ?>
  
    <strong>&emsp;Suma brutto (usł. zakładu + usł. zlecone):</strong>
    <?php
      $całkowita_kwota = $calkowita_kwota_uslugipogrzebowe*1.08 + $calkowita_kwota_zlecone;
      echo number_format($całkowita_kwota,2,',', ' ') . ' zł';
    ?> 
	<br />
	<strong>&emsp;Zasiłek i zaliczki:</strong>            
    <?php
    if ($odebrac_zasilek_pogrzebowy) {
      $suma_zaliczek = (float)$kwota_zasilku+(float)$wplacona_zaliczka_cena; 
    } else {
      $suma_zaliczek = (float)$wplacona_zaliczka_cena; 
    }    
    ?>
    <?php echo '-' . number_format($suma_zaliczek,2,',',' ') . ' zł'; ?>
    <br />
	<strong>&emsp;Pozostało do zapłaty:</strong>
	<?php
	  $do_zaplaty = $całkowita_kwota - $suma_zaliczek;
      echo number_format($do_zaplaty,2,',', ' ') . ' zł';
    ?> 
  </td>
  </tr> 
<?php endif; ?> 
</table>
<!-- Tabelka koniec -->

<button class="acf-button button button-primary button-large button-drukuj" onclick="window.print()">Drukuj zestawienie</button>
<script>
    jQuery(document).ready(function ($) {
      $.ajax({
        url: 'https://esez.pl/generate_code.php',
        type: 'POST',
        cache: false,
        data: {
          formData: 'https://esez.pl/z/<?php echo get_the_title($ewidencja_id); ?>'
        },
        success: function (response) {
          $(".showQRCode").html(response);
        },
      });
    });
</script>
<?php 
}
}
wp_footer();
?>
</body>
</html>