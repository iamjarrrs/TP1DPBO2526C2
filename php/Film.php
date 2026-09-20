<?php
// Class Film untuk merepresentasikan objek film
class Film {
    // Atribut privat (encapsulation)
    private $id;
    private $judul;
    private $genre;
    private $durasi;
    private $gambar; // path file lokal, contoh: "uploads/spiderman.jpg"

    // Constructor
    public function __construct($id = 0, $judul = "", $genre = "", $durasi = "", $gambar = "") {
        $this->id     = $id;
        $this->judul  = $judul;
        $this->genre  = $genre;
        $this->durasi = $durasi;
        $this->gambar = $gambar;
    }

    // Getter & Setter ID
    public function setId($id){ $this->id = $id; }
    public function getId(){ return $this->id; }

    // Getter & Setter Judul
    public function setJudul($judul){ $this->judul = $judul; }
    public function getJudul(){ return $this->judul; }

    // Getter & Setter Genre
    public function setGenre($genre){ $this->genre = $genre; }
    public function getGenre(){ return $this->genre; }

    // Getter & Setter Durasi
    public function setDurasi($durasi){ $this->durasi = $durasi; }
    public function getDurasi(){ return $this->durasi; }

    // Getter & Setter Gambar
    public function setGambar($gambar){ $this->gambar = $gambar; }
    public function getGambar(){ return $this->gambar; }
}
?>