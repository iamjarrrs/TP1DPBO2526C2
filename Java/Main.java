import java.util.ArrayList;
import java.util.Scanner;

public class Main {

    // Untuk mencetak detail objek film dengan format rapi
    public static void cetakFilm(Film f) {
        System.out.printf("| %-4d | %-25s | %-12s | %3d min |\n", f.getId(), f.getJudul(), f.getGenre(), f.getDurasi());
    }

    public static void main(String[] args) {
        ArrayList<Film> daftarFilm = new ArrayList<>();
        Scanner scanner = new Scanner(System.in);
        int pilihan = 0;

        while (pilihan != 6) {
            System.out.println("\n==============================================");
            System.out.println("         SISTEM MANAJEMEN BIOSKOP            ");
            System.out.println("==============================================");
            System.out.println("  [1] Tambah Film");
            System.out.println("  [2] Tampilkan Semua Film");
            System.out.println("  [3] Update Film");
            System.out.println("  [4] Hapus Film");
            System.out.println("  [5] Cari Film");
            System.out.println("  [6] Keluar");
            System.out.println("----------------------------------------------");
            System.out.print("Pilih Menu (1-6): ");
            
            if (!scanner.hasNextInt()) {
                System.out.println(">> Input harus berupa angka!");
                scanner.nextLine();
                continue;
            }
            
            pilihan = scanner.nextInt();
            scanner.nextLine(); // Clear buffer newline

            System.out.println("----------------------------------------------");

            if (pilihan == 1) {
                System.out.println(">>> TAMBAH FILM BARU <<<");
                System.out.print("Masukkan ID           : ");
                int id = scanner.nextInt();
                scanner.nextLine();

                System.out.print("Masukkan Judul        : ");
                String judul = scanner.nextLine();

                System.out.print("Masukkan Genre        : ");
                String genre = scanner.nextLine();

                System.out.print("Masukkan Durasi (min) : ");
                String durasi = scanner.nextLine();
                scanner.nextLine();

                daftarFilm.add(new Film(id, judul, genre, durasi));
                System.out.println("\n[+] Data film berhasil ditambahkan!");

            } else if (pilihan == 2) {
                System.out.println(">>> DAFTAR FILM <<<");
                if (daftarFilm.isEmpty()) {
                    System.out.println("[!] Belum ada data film yang tersimpan.");
                } else {
                    System.out.println("+------+---------------------------+--------------+---------+");
                    System.out.printf("| %-4s | %-25s | %-12s | %-7s |\n", "ID", "JUDUL", "GENRE", "DURASI");
                    System.out.println("+------+---------------------------+--------------+---------+");
                    for (Film f : daftarFilm) {
                        cetakFilm(f);
                    }
                    System.out.println("+------+---------------------------+--------------+---------+");
                }

            } else if (pilihan == 3) {
                System.out.println(">>> UPDATE DATA FILM <<<");
                System.out.print("Masukkan ID Film yang akan diupdate: ");
                int id = scanner.nextInt();
                scanner.nextLine();

                boolean found = false;
                for (Film f : daftarFilm) {
                    if (f.getId() == id) {
                        System.out.println("\n[ Data Lama Ditemukan ]");
                        System.out.println("Judul : " + f.getJudul() + " | Genre: " + f.getGenre() + " | Durasi: " + f.getDurasi() + " min");
                        System.out.println("----------------------------------------------");

                        System.out.print("Masukkan Judul Baru        : ");
                        String judul = scanner.nextLine();

                        System.out.print("Masukkan Genre Baru        : ");
                        String genre = scanner.nextLine();

                        System.out.print("Masukkan Durasi Baru (min) : ");
                        String durasi = scanner.nextLine();
                        scanner.nextLine();

                        f.setJudul(judul);
                        f.setGenre(genre);
                        f.setDurasi(durasi);
                        System.out.println("\n[+] Data film berhasil diperbarui!");
                        found = true;
                        break;
                    }
                }
                if (!found) {
                    System.out.println("[!] Film dengan ID " + id + " tidak ditemukan.");
                }

            } else if (pilihan == 4) {
                System.out.println(">>> HAPUS FILM <<<");
                System.out.print("Masukkan ID Film yang akan dihapus: ");
                int id = scanner.nextInt();
                scanner.nextLine();

                boolean found = false;
                for (int i = 0; i < daftarFilm.size(); i++) {
                    if (daftarFilm.get(i).getId() == id) {
                        daftarFilm.remove(i);
                        System.out.println("\n[+] Data film berhasil dihapus!");
                        found = true;
                        break;
                    }
                }
                if (!found) {
                    System.out.println("[!] Film dengan ID " + id + " tidak ditemukan.");
                }

            } else if (pilihan == 5) {
                System.out.println(">>> CARI FILM <<<");
                System.out.print("Masukkan ID Film yang dicari: ");
                int id = scanner.nextInt();
                scanner.nextLine();

                boolean found = false;
                for (Film f : daftarFilm) {
                    if (f.getId() == id) {
                        System.out.println("\n[ Film Ditemukan ]");
                        System.out.println("+------+---------------------------+--------------+---------+");
                        System.out.printf("| %-4s | %-25s | %-12s | %-7s |\n", "ID", "JUDUL", "GENRE", "DURASI");
                        System.out.println("+------+---------------------------+--------------+---------+");
                        cetakFilm(f);
                        System.out.println("+------+---------------------------+--------------+---------+");
                        found = true;
                        break;
                    }
                }
                if (!found) {
                    System.out.println("[!] Film dengan ID " + id + " tidak ditemukan.");
                }

            } else if (pilihan == 6) {
                System.out.println("Terima kasih telah menggunakan sistem ini!");
            } else {
                System.out.println("[!] Pilihan menu tidak valid.");
            }
        }

        scanner.close();
    }
}