<?php
class Kendaraan {
    public $merk;
    public $warna;

    public function tampilkaninfo() {
        return "Kendaraan ini adalah  $this->merk dengan warna $this->warna.";
    }
}

$myMobil = new Kendaraan();
echo $myMobil->tampilkaninfo();
?>