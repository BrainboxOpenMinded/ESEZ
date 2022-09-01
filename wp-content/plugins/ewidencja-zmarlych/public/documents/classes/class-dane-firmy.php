<?php

class Firma
{
    private $firma_nazwa;
    private $firma_ulica;
    private $firma_kod_pocztowy;
    private $firma_miejscowsc;

    public function get_nazwa() {
        $firma_id = get_current_user_id();
        $this->firma_nazwa = get_field('nazwa_firmy', 'user_'. $firma_id );
        return strval($this->firma_nazwa);
    }

    public function get_ulica() {
        $firma_id = get_current_user_id();
        $this->firma_ulica = get_field('ulica', 'user_'. $firma_id );
        return strval($this->firma_ulica);
    }

    public function get_kod_pocztowy() {
        $firma_id = get_current_user_id();
        $this->firma_kod_pocztowy = get_field('kod_pocztowy', 'user_'. $firma_id );
        return strval($this->firma_kod_pocztowy);
    }

    public function get_miejscowosc() {
        $firma_id = get_current_user_id();
        $this->firma_miejscowosc = get_field('miejscowosc', 'user_'. $firma_id );
        return strval($this->firma_miejscowosc);
    }

    public function __toString() {
        return "{$this->firma_ulica} {$this->firma_kod_pocztowy} {$this->firma_miejscowosc}";
    }
}