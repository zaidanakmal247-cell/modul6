<?php
class Mobil {
    public function maju() {
        echo " Mobil Bergerak Maju ";
    }

    public function berhenti(){
        echo " Mobil Berhenti ";

    }

    public function belok($arah) {
        echo " Mobil Berbelok ke " . $arah;
    }
}

//Membuat Objek dari Class Mobil
$myCar = new Mobil();

//Memanggil Method
$myCar->maju();
$myCar->berhenti();
$myCar->belok("kanan");
?>