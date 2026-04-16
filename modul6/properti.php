<?php
class Mobil {
    public $warna;
    private $merek; //hanya bisa diakses dalam class
    protected $ukuran; // properti ukuran bisa diakses oleh class tururnan

    //konstuktor
    public function __construct($warna, $merek, $ukuran) {
        $this->warna = $warna;
        $this->merek = $merek;
        $this->ukuran = $ukuran;
    }

    public function getMerek() {
        return $this->merek;
    }

    protected function getUkuran(){
        return $this->ukuran;
    }
}

$mobilBaru = new Mobil ("Hijau", "Honda", "JDM");

echo " Warna Mobil : " . $mobilBaru->warna;
echo " Merek Mobil : ". $mobilBaru->getMerek();

?>