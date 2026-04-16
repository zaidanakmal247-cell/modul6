<?php
class Mobil {
    public $merk;
    public $warna;

    //konstuktor : dijalankan saat objek dibuat
public function __construct($merk, $warna) {
    $this->merk = $merk;
    $this->warna = $warna;
    echo "Mobil $this->merk dengan warna $this->warna telah dibuat. <br>";
}

public function jalankan() {
    echo "Mobil $this->merk dengan warna $this->warna telah dibuat. <br>";
}

// Destruktor : dijalankan saat objek tidak lagi digunakan
public function __destruct() {
    echo "Mobil $this->merk telah dihentikan dan dihapus dari memori. <br>";
}
}

//membuat objek mobil
$mobil1 = new Mobil("Toyota", "Merah");
$mobil1->jalankan();

//objek akan dihapus secara otomatis setelah skrip selesai
?>