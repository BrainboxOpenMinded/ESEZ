<?php 
    if(get_field('trumna')):
        $trumna = get_field('trumna');
        $trumna_cena = (float)$trumna['cena'];
        endif;
        if(get_field('urna')):
        $urna = get_field('urna');
        $urna_cena = (float)$urna['cena'];
        endif;
        $relikwiarz = get_field('relikwiarz');
        $relikwiarz_cena = (float)$relikwiarz['cena'];
        $zdjecie = get_field('zdjecie');
        $zdjecie_cena = (float)$zdjecie['cena'];
        $tabliczka = get_field('tabliczka');
        $tabliczka_cena = (float)$tabliczka['cena'];
        $krzyz = get_field('krzyz');
        $krzyz_cena = (float)$krzyz['cena'];
        $zabezpieczenie = get_field('zabezpieczenie');
        $zabezpieczenie_cena = (float)$zabezpieczenie['cena'];
        $eksortacja = get_field('eksportacja_zwlok');
        $eksortacja_cena = (float)$eksortacja['cena'];
        $przechowalnia = get_field('przechowalnia');
        $przechowalnia_cena = (float)$przechowalnia['cena'];
        $przygotowanie_osoby_zmarlej = get_field('przygotowanie_osoby_zmarlej');
        $przygotowanie_osoby_zmarlej_cena = (float)$przygotowanie_osoby_zmarlej['cena'];
        $transport_ciala = get_field('transport_ciala');
        $transport_ciala_cena = (float)$transport_ciala['cena'];
        $przeczekanie_przez_ceremonie = get_field('przeczekanie_przez_ceremonie');
        $przeczekanie_przez_ceremonie_cena = (float)$przeczekanie_przez_ceremonie['cena'];
        $obsluga_pogrzebu = get_field('obsluga_pogrzebu');
        $obsluga_pogrzebu_cena = (float)$obsluga_pogrzebu['cena'];
        $klepsydry = get_field('klepsydry');
        $klepsydry_cena = (float)$klepsydry['cena'];
        $dostawa = get_field('dostawa');
        $dostawa_cena = (float)$dostawa['cena'];
        $zasilek_pogrzebowy = get_field('zasilek_pogrzebowy');
        $zasilek_pogrzebowy_cena = (float)$zasilek_pogrzebowy['cena'];
        $kompleksowa_organizacja_pogrzebu = get_field('kompleksowa_organizacja_pogrzebu');
        $kompleksowa_organizacja_pogrzebu_cena = (float)$kompleksowa_organizacja_pogrzebu['cena'];
        $akcesoria_pogrzebowe = get_field('akcesoria_pogrzebowe');
        $akcesoria_pogrzebowe_cena = (float)$akcesoria_pogrzebowe['cena'];
        $obrazki_pamiatkowe = get_field('obrazki_pamiatkowe');
        $obrazki_pamiatkowe_cena = (float)$obrazki_pamiatkowe['cena'];
        $enekrologi = get_field('e-nekrologi');
        $enekrologi_cena = (float)$enekrologi['cena'];
        $transmisja_online = get_field('transmisja_online');
        $transmisja_online_cena = (float)$transmisja_online['cena'];
        $golebie_na_pogrzebie = get_field('golebie_na_pogrzebie');
        $golebie_na_pogrzebie_cena = (float)$golebie_na_pogrzebie['cena'];
        $inne_uslugi_zakladu = get_field('inne_uslugi_zakladu');
        $inne_uslugi_zakladu_cena = (float)$inne_uslugi_zakladu['cena'];
        if(get_field('uslugi_zlecone') == true) :
        $rachunek_z_zarzadu_cmentarza = get_field('rachunek_z_zarzadu_cmentarza');
        $rachunek_z_zarzadu_cmentarza_cena = (float)$rachunek_z_zarzadu_cmentarza['cena'];
        $rachunek_za_kremacje = get_field('rachunek_za_kremacje');
        $rachunek_za_kremacje_cena = (float)$rachunek_za_kremacje['cena'];
        $rachunek_za_otwarcie_i_zamkniecie_grobu  = get_field('rachunek_za_otwarcie_i_zamkniecie_grobu');
        $rachunek_za_otwarcie_i_zamkniecie_grobu_cena = (float)$rachunek_za_otwarcie_i_zamkniecie_grobu['cena'];
        $kopanie_grobu = get_field('kopanie_grobu');
        $kopanie_grobu_cena = (float)$kopanie_grobu['cena'];
        $rodzaj_ceremonii = get_field('rodzaj_ceremonii');
        $rodzaj_ceremonii_cena = (float)$rodzaj_ceremonii['cena'];
        $oprawa_muzyczna = get_field('oprawa_muzyczna');
        $oprawa_muzyczna_cena = (float)$oprawa_muzyczna['cena'];
        $kaplica_przedpogrzebowa = get_field('kaplica_przedpogrzebowa');
        $kaplica_przedpogrzebowa_cena = (float)$kaplica_przedpogrzebowa['cena'];
        $odziez_dla_zmarlych = get_field('odziez_dla_zmarlych');
        $odziez_dla_zmarlych_cena = (float)$odziez_dla_zmarlych['cena'];
        $nekrolog_do_prasy = get_field('nekrolog_do_prasy');
        $nekrolog_do_prasy_cena = (float)$nekrolog_do_prasy['cena'];
        $autokar = get_field('autokar');
        $autokar_cena = (float)$autokar['cena'];
        $przechowalnia_w_szpitalu = get_field('przechowalnia_w_szpitalu');
        $przechowalnia_w_szpitalu_cena = (float)$przechowalnia_w_szpitalu['cena'];
        $inne_uslugi_zlecone = get_field('inne_uslugi_zlecone');
        $inne_uslugi_zlecone_cena = (float)$inne_uslugi_zlecone['cena'];
        endif;
        $inne_zasilek_pogrzebowy = get_field('inne_zasilek_pogrzebowy');
        $inne_zasilek_pogrzebowy_cena = (float)isset($inne_zasilek_pogrzebowy['cena']);
        $inne_zasilek_pogrzebowy = get_field('inne_zasilek_pogrzebowy');
        $inne_zasilek_pogrzebowy_cena = (float)isset($inne_zasilek_pogrzebowy['cena']);
        $zasilek_pogrzebowy_inne = get_field('zasilek_pogrzebowy_inne');
        $zasilek_pogrzebowy_inne_cena = (float)$zasilek_pogrzebowy_inne['cena'];
        $odebrac_zasilek = $zasilek_pogrzebowy_inne['odebrac_zasilek_pogrzebowy'];
        $wplacona_zaliczka = get_field('wplacona_zaliczka');
        $wplacona_zaliczka_cena = (float)$wplacona_zaliczka['cena'];
        ?>

<div class="totalcost-container">
<?php if( have_rows('oprawa_florystyczna') ): 
    $suma_kwiaty = 0; ?>
    <?php while( have_rows('oprawa_florystyczna') ): the_row(); ?>
        <?php if( get_row_layout() == 'dodaj_kwiaty' ): ?>
            <?php
            $cena_kwiaty = get_sub_field('cena');
            $suma_kwiaty =(float)$suma_kwiaty + (float)$cena_kwiaty; ?>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>
    <?php if(get_field('uslugi_pogrzebowe')): ?>
    <a class="cennik-link" href="#specyfikacja"><span><strong>Usł. pogrzebowe:</strong>
            <label>
                <?php
            $calkowita_kwota_uslugipogrzebowe = $trumna_cena+$urna_cena+$relikwiarz_cena+$tabliczka_cena+$zdjecie_cena+$krzyz_cena+$eksortacja_cena+$zabezpieczenie_cena+$przechowalnia_cena+$przygotowanie_osoby_zmarlej_cena+$transport_ciala_cena+$przeczekanie_przez_ceremonie_cena+$obsluga_pogrzebu_cena+$dostawa_cena+$zasilek_pogrzebowy_cena+$kompleksowa_organizacja_pogrzebu_cena+$akcesoria_pogrzebowe_cena+$obrazki_pamiatkowe_cena+$enekrologi_cena+$transmisja_online_cena+$klepsydry_cena+$golebie_na_pogrzebie_cena+$inne_uslugi_zakladu_cena;
            $suma_z_podatkiem = $calkowita_kwota_uslugipogrzebowe;
            echo number_format($suma_z_podatkiem*1.08,2,',',' ') . ' zł';
        ?>
            </label>
        </span>
    </a>
    <?php endif; ?>
    <?php if(get_field('uslugi_zlecone')): ?>
    <a class="cennik-link" href="#zlecone"><span><strong>Usł. zlecone:</strong>
            <label>
                <?php
            $calkowita_kwota_zlecone = $rachunek_z_zarzadu_cmentarza_cena+$rachunek_za_kremacje_cena+$rachunek_za_otwarcie_i_zamkniecie_grobu_cena+$kopanie_grobu_cena+$rodzaj_ceremonii_cena+$oprawa_muzyczna_cena+$kaplica_przedpogrzebowa_cena+$odziez_dla_zmarlych_cena+$nekrolog_do_prasy_cena+$autokar_cena+$przechowalnia_w_szpitalu_cena+$suma_kwiaty+$inne_uslugi_zlecone_cena;
            echo number_format($calkowita_kwota_zlecone, 2,',',' ') . ' zł';
        ?>
            </label>
        </span>
    </a>
        <?php endif; ?>
        <?php if($odebrac_zasilek == true || !empty($wplacona_zaliczka_cena) ) : ?>
    <a class="cennik-link" href="#zasilek"><span><strong>Zasiłek i zaliczki:</strong>
            <label>
        <?php
        if ($odebrac_zasilek) {
            $suma_zaliczek = $zasilek_pogrzebowy_inne_cena+$wplacona_zaliczka_cena; 
            } else {
            $suma_zaliczek = $wplacona_zaliczka_cena; 
            } ?>
    
        <?php echo '-' . number_format($suma_zaliczek,2,',',' ') . ' zł'; ?>
            </label>
        </span>
        </a>
        <?php endif; ?>
        <span><strong>Suma brutto:</strong>
            <label>
            <?php
            $całkowita_kwota = $calkowita_kwota_uslugipogrzebowe*1.08 + $calkowita_kwota_zlecone - $suma_zaliczek;
            echo number_format($całkowita_kwota,2,',', ' ') . ' zł';
        ?>
            </label>
        </span>
</div>