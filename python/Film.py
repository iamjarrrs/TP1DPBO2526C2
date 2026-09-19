# Class Film
class Film :
    # COnstructor (inisialisasi)
    def __init__(self, idFilm=0, judul="", genre="", durasi=""):
        self.__id = idFilm
        self.__judul = judul
        self.__genre = genre
        self.__durasi = durasi

    # Setter and Getter untuk id
    def setId(self, idFilm):
        self.__id = idFilm
    def getId(self):
        return self.__id

    # Setter and Getter untuk judul
    def setJudul(self, judul):
        self.__judul = judul
    def getJudul(self):
        return self.__judul

    # Setter and Getter untuk genre
    def setGenre(self, genre):
        self.__genre = genre
    def getGenre(self):
        return self.__genre

    # Setter and Getter untuk durasi
    def setDurasi(self, durasi):
        self.__durasi = durasi
    def getDurasi(self):
        return self.__durasi