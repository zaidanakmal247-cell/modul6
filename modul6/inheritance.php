<?php
class Mobil {
    public $merk; 
    public $warna;

    public function __construct($merk, $warna) {
        $this->merk = $merk;
        $this->warna = $warna;
    }

    public function tampilkanInfo() {
        return "Mobil Merk: $this->merk, Warna: $this->warna";
    }
}

class MobilSport extends Mobil {
    public $kecepatanMaks; 

    public function __construct($merk, $warna, $kecepatanMaks) {
        parent::__construct($merk, $warna);
        $this->kecepatanMaks = $kecepatanMaks;
    }

    public function tampilkanInfoSport() {
        return $this->tampilkanInfo() . ", Kecepatan Maksimal: $this->kecepatanMaks km/jam";
    }
}

$mobil = new MobilSport("Ferrari", "Merah", 350);
echo $mobil->tampilkanInfoSport(); 
?>