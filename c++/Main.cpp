#include <iostream>
#include <vector>   // Pustaka untuk array dinamis (vector)
#include <string>   // Pustaka untuk manipulasi tipe data string
#include <iomanip>  // Pustaka untuk memformat tampilan output (setw, left, right)
#include "Film.cpp" // Meng-include file kelas Film

using namespace std;

// Procedure untuk mencetak satu baris data film dengan format tabel yang rapi
void cetakFilm(Film f) {
    // left/right dan setw digunakan untuk mengatur lebar kolom dan rata kiri/kanan
    cout << "| " << left << setw(4) << f.getId()
         << " | " << left << setw(25) << f.getJudul()
         << " | " << left << setw(12) << f.getGenre()
         << " | " << left << setw(8) << f.getDurasi() << " |\n";
}

int main() {
    // Deklarasi vector bertipe Film untuk menyimpan kumpulan objek Film secara dinamis
    vector<Film> daftarFilm;
    int pilihan = 0;

    // Perulangan menu utama hingga pengguna memilih menu 6 (Keluar)
    while (pilihan != 6) {
        cout << "\n==============================================\n";
        cout << "         SISTEM MANAJEMEN BIOSKOP            \n";
        cout << "==============================================\n";
        cout << "  [1] Tambah Film\n";
        cout << "  [2] Tampilkan Semua Film\n";
        cout << "  [3] Update Film\n";
        cout << "  [4] Hapus Film\n";
        cout << "  [5] Cari Film\n";
        cout << "  [6] Keluar\n";
        cout << "----------------------------------------------\n";
        cout << "Pilih Menu (1-6): ";
        cin >> pilihan;

        cout << "----------------------------------------------\n";

        // Option 1: Tambah Film Baru
        if (pilihan == 1) {
            int id;
            string judul, genre, durasi;

            cout << ">>> TAMBAH FILM BARU <<<\n";
            cout << "Masukkan ID           : "; cin >> id;
            cin.ignore(); // Membersihkan sisa karakter newline (\n) di buffer stdin
            cout << "Masukkan Judul        : "; getline(cin, judul);
            cout << "Masukkan Genre        : "; getline(cin, genre);
            cout << "Masukkan Durasi (min) : "; getline(cin, durasi);

            // push_back() digunakan untuk menambahkan objek Film baru ke urutan paling belakang vector
            daftarFilm.push_back(Film(id, judul, genre, durasi));
            cout << "\n[+] Data film berhasil ditambahkan!\n";

        // Option 2: Tampilkan Semua Film
        } else if (pilihan == 2) {
            cout << ">>> DAFTAR FILM <<<\n";
            
            // empty() mengembalikan true jika vector belum memiliki elemen
            if (daftarFilm.empty()) {
                cout << "[!] Belum ada data film yang tersimpan.\n";
            } else {
                // Cetak header tabel
                cout << "+------+---------------------------+--------------+----------+\n";
                cout << "| " << left << setw(4) << "ID"
                     << " | " << left << setw(25) << "JUDUL"
                     << " | " << left << setw(12) << "GENRE"
                     << " | " << left << setw(8) << "DURASI" << " |\n";
                cout << "+------+---------------------------+--------------+----------+\n";
                
                // size() mengembalikan jumlah elemen yang tersimpan di dalam vector
                for (int i = 0; i < daftarFilm.size(); i++) {
                    cetakFilm(daftarFilm[i]);
                }
                cout << "+------+---------------------------+--------------+----------+\n";
            }

        // Option 3: Update Data Film
        } else if (pilihan == 3) {
            int id;
            cout << ">>> UPDATE DATA FILM <<<\n";
            cout << "Masukkan ID Film yang akan diupdate: "; cin >> id;

            bool found = false;
            for (int i = 0; i < daftarFilm.size(); i++) {
                if (daftarFilm[i].getId() == id) {
                    string judul, genre, durasi;

                    cout << "\n[ Data Lama Ditemukan ]\n";
                    cout << "Judul : " << daftarFilm[i].getJudul() << " | Genre: " << daftarFilm[i].getGenre() << " | Durasi: " << daftarFilm[i].getDurasi() << "\n";
                    cout << "----------------------------------------------\n";

                    cin.ignore();
                    cout << "Masukkan Judul Baru        : "; getline(cin, judul);
                    cout << "Masukkan Genre Baru        : "; getline(cin, genre);
                    cout << "Masukkan Durasi Baru (min) : "; getline(cin, durasi);

                    // Mengubah atribut objek melalui method setter
                    daftarFilm[i].setJudul(judul);
                    daftarFilm[i].setGenre(genre);
                    daftarFilm[i].setDurasi(durasi);

                    cout << "\n[+] Data film berhasil diperbarui!\n";
                    found = true;
                    break;
                }
            }
            if (!found) {
                cout << "[!] Film dengan ID " << id << " tidak ditemukan.\n";
            }

        // Option 4: Hapus Data Film
        } else if (pilihan == 4) {
            int id;
            cout << ">>> HAPUS FILM <<<\n";
            cout << "Masukkan ID Film yang akan dihapus: "; cin >> id;

            bool found = false;
            for (int i = 0; i < daftarFilm.size(); i++) {
                if (daftarFilm[i].getId() == id) {
                    // erase() menghapus elemen pada posisi iterator tertentu (begin() + indeks)
                    daftarFilm.erase(daftarFilm.begin() + i);
                    cout << "\n[+] Data film berhasil dihapus!\n";
                    found = true;
                    break;
                }
            }
            if (!found) {
                cout << "[!] Film dengan ID " << id << " tidak ditemukan.\n";
            }

        // Option 5: Cari Film Berdasarkan ID
        } else if (pilihan == 5) {
            int id;
            cout << ">>> CARI FILM <<<\n";
            cout << "Masukkan ID Film yang dicari: "; cin >> id;

            bool found = false;
            for (int i = 0; i < daftarFilm.size(); i++) {
                if (daftarFilm[i].getId() == id) {
                    cout << "\n[ Film Ditemukan ]\n";
                    cout << "+------+---------------------------+--------------+----------+\n";
                    cout << "| " << left << setw(4) << "ID"
                         << " | " << left << setw(25) << "JUDUL"
                         << " | " << left << setw(12) << "GENRE"
                         << " | " << left << setw(8) << "DURASI" << " |\n";
                    cout << "+------+---------------------------+--------------+----------+\n";
                    cetakFilm(daftarFilm[i]);
                    cout << "+------+---------------------------+--------------+----------+\n";
                    found = true;
                    break;
                }
            }
            if (!found) {
                cout << "[!] Film dengan ID " << id << " tidak ditemukan.\n";
            }

        // Option 6: Keluar
        } else if (pilihan == 6) {
            cout << "Terima kasih telah menggunakan sistem ini!\n";
        }
    }

    return 0;
}