#include <iostream>
#include <string>

using namespace std;

// Class Film
class Film {
private:
    // Atribut privat (encapsulation)
    int id;
    string judul;
    string genre;
    string durasi; // Tipe data durasi menggunakan string

public:
    // Default Constructor
    Film() {
        this->id = 0;
        this->judul = "";
        this->genre = "";
        this->durasi = "";
    }

    // Parameterized Constructor
    Film(int id, string judul, string genre, string durasi) {
        this->id = id;
        this->judul = judul;
        this->genre = genre;
        this->durasi = durasi;
    }

    // Setter and Getter untuk id
    void setId(int id) {
        this->id = id;
    }
    int getId() {
        return this->id;
    }

    // Setter and Getter untuk judul
    void setJudul(string judul) {
        this->judul = judul;
    }
    string getJudul() {
        return this->judul;
    }

    // Setter and Getter untuk genre
    void setGenre(string genre) {
        this->genre = genre;
    }
    string getGenre() {
        return this->genre;
    }

    // Setter and Getter untuk durasi
    void setDurasi(string durasi) {
        this->durasi = durasi;
    }
    string getDurasi() {
        return this->durasi;
    }

    // Destructor
    ~Film() {}
};