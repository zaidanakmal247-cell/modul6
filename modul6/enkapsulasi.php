<?php
class Mobil {
    public $merk; 
    private $kecepatanMaksimum; 
    protected $jumlahPintu; 

    public function __construct($merk, $kecepatan, $pintu) {
        $this->merk = $merk;
        $this->kecepatanMaksimum = $kecepatan;
        $this->jumlahPintu = $pintu;
    }

    public function getKecepatanMaksimum() {
        return $this->kecepatanMaksimum; 
    }

    protected function getJumlahPintu() {
        return $this->jumlahPintu; 
    }
}

$mobil1 = new Mobil ("Toyota", 180, 4);
echo "Merk Mobil: " . $mobil1->merk . "<br>"; 
echo "Kecepatan Maksimum: " . $mobil1->getKecepatanMaksimum() . " km/jam<br>";
?>