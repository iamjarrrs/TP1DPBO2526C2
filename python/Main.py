from Film import Film

# Function untuk mencetak baris data film
def cetakFilm(f):
    print(f"| {f.getId():<4} | {f.getJudul():<25} | {f.getGenre():<12} | {f.getDurasi():<8} |")

def main():
    # Menggunakan list untuk menampung sekumpulan objek Film
    daftarFilm = []
    pilihan = 0

    # Perulangan menu utama
    while pilihan != 6:
        print("\n==============================================")
        print("         SISTEM MANAJEMEN BIOSKOP            ")
        print("==============================================")
        print("  [1] Tambah Film")
        print("  [2] Tampilkan Semua Film")
        print("  [3] Update Film")
        print("  [4] Hapus Film")
        print("  [5] Cari Film")
        print("  [6] Keluar")
        print("----------------------------------------------")
        
        try:
            pilihan = int(input("Pilih Menu (1-6): "))
        except ValueError:
            print(">> Input harus berupa angka!")
            continue

        print("----------------------------------------------")

        # Option 1: Tambah Film Baru
        if pilihan == 1:
            print(">>> TAMBAH FILM BARU <<<")
            idFilm = int(input("Masukkan ID           : "))
            judul = input("Masukkan Judul        : ")
            genre = input("Masukkan Genre        : ")
            durasi = input("Masukkan Durasi (min) : ")

            # Menambahkan objek Film baru ke list
            daftarFilm.append(Film(idFilm, judul, genre, durasi))
            print("\n[+] Data film berhasil ditambahkan!")

        # Option 2: Tampilkan Semua Film
        elif pilihan == 2:
            print(">>> DAFTAR FILM <<<")
            if not daftarFilm:
                print("[!] Belum ada data film yang tersimpan.")
            else:
                print("+------+---------------------------+--------------+----------+")
                print(f"| {'ID':<4} | {'JUDUL':<25} | {'GENRE':<12} | {'DURASI':<8} |")
                print("+------+---------------------------+--------------+----------+")
                for f in daftarFilm:
                    cetakFilm(f)
                print("+------+---------------------------+--------------+----------+")

        # Option 3: Update Data Film
        elif pilihan == 3:
            print(">>> UPDATE DATA FILM <<<")
            idFilm = int(input("Masukkan ID Film yang akan diupdate: "))

            found = False
            for f in daftarFilm:
                if f.getId() == idFilm:
                    print("\n[ Data Lama Ditemukan ]")
                    print(f"Judul : {f.getJudul()} | Genre: {f.getGenre()} | Durasi: {f.getDurasi()}")
                    print("----------------------------------------------")

                    judul = input("Masukkan Judul Baru        : ")
                    genre = input("Masukkan Genre Baru        : ")
                    durasi = input("Masukkan Durasi Baru (min) : ")

                    # Mengubah data via setter
                    f.setJudul(judul)
                    f.setGenre(genre)
                    f.setDurasi(durasi)
                    print("\n[+] Data film berhasil diperbarui!")
                    found = True
                    break

            if not found:
                print(f"[!] Film dengan ID {idFilm} tidak ditemukan.")

        # Option 4: Hapus Data Film
        elif pilihan == 4:
            print(">>> HAPUS FILM <<<")
            idFilm = int(input("Masukkan ID Film yang akan dihapus: "))

            found = False
            for i in range(len(daftarFilm)):
                if daftarFilm[i].getId() == idFilm:
                    daftarFilm.pop(i)
                    print("\n[+] Data film berhasil dihapus!")
                    found = True
                    break

            if not found:
                print(f"[!] Film dengan ID {idFilm} tidak ditemukan.")

        # Option 5: Cari Film
        elif pilihan == 5:
            print(">>> CARI FILM <<<")
            idFilm = int(input("Masukkan ID Film yang dicari: "))

            found = False
            for f in daftarFilm:
                if f.getId() == idFilm:
                    print("\n[ Film Ditemukan ]")
                    print("+------+---------------------------+--------------+----------+")
                    print(f"| {'ID':<4} | {'JUDUL':<25} | {'GENRE':<12} | {'DURASI':<8} |")
                    print("+------+---------------------------+--------------+----------+")
                    cetakFilm(f)
                    print("+------+---------------------------+--------------+----------+")
                    found = True
                    break

            if not found:
                print(f"[!] Film dengan ID {idFilm} tidak ditemukan.")

        # Option 6: Keluar
        elif pilihan == 6:
            print("Terima kasih telah menggunakan sistem ini!")

if __name__ == "__main__":
    main()