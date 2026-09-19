// Class Film
public class Film{
    // Atribute
    private int id;
    private String judul;
    private String genre;
    private String durasi; // dalam menit

    // Constuctor (inisialisasi)
    public Film(){
    }

    public Film(int id, String judul, String genre, String durasi){
        this.id = id;
        this.judul = judul;
        this.genre = genre;
        this.durasi = durasi;
    }

    // Setter and Getter untuk id
    public void setId(int id){this.id = id;}
    public int getId(){return this.id;}

    // Setter and Getter untuk judul
    public void setJudul(String judul){this.judul = judul;}
    public String getJudul(){return this.judul;}

    // Setter and Getter untuk genre
    public void setGenre(String genre){this.genre = genre;}
    public String getGenre(){return this.genre;}

    // Setter and Getter untuk durasi
    public void setDurasi(String durasi){this.durasi = durasi;}
    public String getDurasi(){return this.durasi;}
}