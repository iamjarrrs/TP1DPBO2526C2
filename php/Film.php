<?php
// Class Film untuk merepresentasikan objek film
class Film {
    // Atribut privat (encapsulation)
    private $id;
    private $judul;
    private $genre;
    private $durasi;

    // Constructor
    public function __construct($id = 0, $judul = "", $genre = "", $durasi = "") {
        $this->id = $id;
        $this->judul = $judul;
        $this->genre = $genre;
        $this->durasi = $durasi;
    }

    // Setter and Getter untuk ID
    public function setId($id) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }

    // Setter and Getter untuk Judul
    public function setJudul($judul) {
        $this->judul = $judul;
    }
    public function getJudul() {
        return $this->judul;
    }

    // Setter and Getter untuk Genre
    public function setGenre($genre) {
        $this->genre = $genre;
    }
    public function getGenre() {
        return $this->genre;
    }

    // Setter and Getter untuk Durasi
    public function setDurasi($durasi) {
        $this->durasi = $durasi;
    }
    public function getDurasi() {
        return $this->durasi;
    }
}
?>