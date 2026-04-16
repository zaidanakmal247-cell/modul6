<?php
class Mobil{
    public $warna;

    public function setWarna($warna){
        $this->warna = $warna;
    }

    public function getWarna() {
        return $this->warna;
    }
}

$mobil1 = new Mobil();
$mobil1->setWarna("Biru");

$mobil2 = new Mobil();
$mobil2->setWarna("Merah");

echo "Warna Mobil pertama : " . $mobil1->getWarna() ."<br>";
echo "Warna Mobil Kedua : " . $mobil2->getWarna();