# Panduan Sistem Penilaian Prestasi Murid (Hafazan)

## Gambaran Keseluruhan

Sistem penilaian prestasi murid telah dibangunkan untuk membolehkan guru menilai kemajuan hafazan murid secara berperingkat mengikut ayat dan penggal.

## Aliran Kerja

### 1. Pilih Kelas
Guru memilih kelas daripada senarai kelas yang tersedia dalam sistem.

### 2. Pilih Murid
Selepas kelas dipilih, senarai nama murid dalam kelas tersebut akan dipaparkan. Guru kemudian memilih murid yang ingin dinilai.

### 3. Pilih Subjek
Setelah murid dipilih, guru akan memilih subjek hafazan daripada menu dropdown:
- Surah Al-Mulk
- Surah Al-Kahf
- Surah Yasin
- Surah Ar-Rahman

### 4. Penilaian Prestasi
Sistem akan memaparkan senarai ayat untuk subjek yang dipilih (contoh: Surah Al-Mulk Ayat 1-15).

Guru boleh:
- Memilih penggal (Penggal 1 atau Penggal 2)
- Menilai setiap ayat dengan tahap pencapaian:
  - **AM (Ansar Maju)** - Tahap permulaan
  - **M (Maju)** - Tahap sederhana
  - **SM (Sangat Maju)** - Tahap cemerlang

### 5. Melihat Rekod Terdahulu
Sistem akan memaparkan penilaian terdahulu (jika ada) di bawah setiap ayat untuk rujukan guru.

## Struktur Database

### Jadual: prestasi

Medan tambahan yang ditambah:
- `ayat` - Menyimpan nombor ayat (cth: "Ayat 1", "Ayat 2")
- `penggal` - Menyimpan penggal penilaian ("Penggal 1" atau "Penggal 2")
- `tahapPencapaian` - Menyimpan tahap pencapaian ("AM", "M", atau "SM")

Medan sedia ada:
- `ID_Prestasi` - Primary key
- `ID_Guru` - Foreign key ke jadual guru
- `MyKidID` - Foreign key ke jadual murid
- `subjek` - Nama subjek/surah
- `markah` - Nullable (untuk kegunaan lain)
- `gred` - Nullable (untuk kegunaan lain)
- `tarikhRekod` - Tarikh penilaian direkod

## Fail yang Diubahsuai/Ditambah

1. **Migration File**: `database/migrations/2025_12_18_000000_modify_prestasi_table_for_hafazan.php`
   - Menambah medan baru untuk penilaian hafazan

2. **Controller**: `app/Http/Controllers/PrestasiController.php`
   - Kaedah `index()` - Memaparkan halaman prestasi dengan pemilihan kelas, murid, dan subjek
   - Kaedah `store()` - Menyimpan penilaian prestasi
   - Kaedah `getAyatList()` - Menjana senarai ayat berdasarkan subjek

3. **Model**: `app/Models/Prestasi.php`
   - Menambah medan `ayat`, `penggal`, dan `tahapPencapaian` ke dalam `$fillable`

4. **View**: `resources/views/guru/prestasiMurid.blade.php`
   - Borang pemilihan kelas, murid, dan subjek
   - Jadual penilaian ayat dengan radio button untuk tahap pencapaian
   - Paparan rekod penilaian terdahulu

5. **Routes**: `routes/web.php`
   - GET `/guru/prestasi-murid` - Memaparkan halaman prestasi
   - POST `/guru/prestasi-murid` - Menyimpan penilaian

## Cara Menggunakan

1. Log masuk sebagai guru
2. Navigasi ke menu "Prestasi Murid"
3. Pilih kelas daripada dropdown
4. Pilih murid daripada senarai yang dipaparkan
5. Pilih subjek hafazan
6. Pilih penggal (Penggal 1 atau Penggal 2)
7. Tandakan tahap pencapaian untuk setiap ayat
8. Klik butang "Simpan Penilaian"

## Nota Penting

- Sistem akan memaparkan penilaian terdahulu (jika ada) untuk rujukan
- Guru boleh menilai semula murid untuk penggal yang sama (sistem akan kemaskini rekod)
- Setiap ayat boleh dinilai secara berasingan untuk setiap penggal
- Penilaian disimpan dengan tarikh rekod semasa

## Ciri-ciri Utama

✅ Pemilihan berperingkat (Kelas → Murid → Subjek)
✅ Sokongan pelbagai subjek hafazan
✅ Penilaian mengikut penggal (Penggal 1 & Penggal 2)
✅ Tiga tahap pencapaian (AM, M, SM)
✅ Paparan rekod terdahulu
✅ Kemaskini penilaian yang sedia ada
✅ Antara muka yang mesra pengguna
