<?php

namespace Database\Seeders;

use App\Models\Artikel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $artikels = [
            [
                'thumbnail' => 'storage/artikel_photos/kucing_vaksin.jpg',
                'judul' => 'Pentingnya Vaksinasi Rutin untuk Kucing Peliharaan',
                'deskripsi' => 'Vaksinasi adalah salah satu cara terpenting untuk melindungi kesehatan kucing Anda. Kucing membutuhkan vaksinasi rutin untuk mencegah berbagai penyakit serius seperti panleukopenia (distemper), calicivirus, rhinotracheitis, dan rabies.

Vaksin bekerja dengan cara menstimulasi sistem kekebalan kucing untuk mengenali dan melawan patogen tertentu. Ketika kucing divaksinasi, tubuhnya akan mengembangkan antibodi yang akan memberikan perlindungan jika terpapar penyakit tersebut di masa depan.

Jadwal vaksinasi kucing:
- Kitten (8-9 minggu): Vaksin pertama FVRCP
- 12 minggu: Booster FVRCP dan tes FeLV/FIV
- 16 minggu: Booster FVRCP final dan vaksin rabies pertama
- 1 tahun: Booster FVRCP dan rabies
- Dewasa: Booster sesuai rekomendasi dokter hewan

Beberapa faktor yang mempengaruhi jadwal vaksinasi termasuk usia, riwayat kesehatan, gaya hidup (dalam ruangan vs luar ruangan), dan risiko paparan penyakit di lingkungan Anda.

Jangan lupa untuk selalu berkonsultasi dengan dokter hewan untuk menentukan jadwal vaksinasi yang tepat untuk kucing Anda.',
                'penulis' => 'drh. Budi Santoso',
                'tanggal' => Carbon::now()->subDays(2),
            ],
            [
                'thumbnail' => 'storage/artikel_photos/anjing_makanan.jpg',
                'judul' => 'Cara Merawat Bulu Anjing agar Tetap Sehat dan Mengkilap',
                'deskripsi' => 'Bulu yang sehat dan mengkilap bukan hanya membuat anjing Anda terlihat cantik, tapi juga menandakan kesehatan yang baik. Berikut adalah beberapa tips untuk merawat bulu anjing Anda:

1. Sikat secara rutin: Tergantung pada jenis bulunya, anjing membutuhkan penyikatan dari beberapa kali seminggu hingga harian. Ini membantu menghilangkan bulu mati, mencegah kusut, dan mendistribusikan minyak alami kulit.

2. Mandikan secukupnya: Terlalu sering memandikan anjing dapat menghilangkan minyak alami dan menyebabkan kulit kering. Untuk kebanyakan anjing, mandi sebulan sekali sudah cukup. Gunakan sampo khusus anjing dengan pH yang seimbang.

3. Nutrisi yang tepat: Makanan berkualitas tinggi yang kaya akan asam lemak omega-3 dan omega-6 dapat memperkuat folikel rambut dan membuat bulu lebih berkilau. Pertimbangkan untuk menambahkan suplemen minyak ikan ke dalam makanan anjing Anda.

4. Kontrol parasit: Kutu dan tungau dapat menyebabkan iritasi kulit dan kerontokan bulu. Pastikan anjing Anda mendapatkan pengobatan preventif yang teratur untuk parasit eksternal.

5. Hidrasi: Pastikan anjing Anda selalu memiliki akses ke air bersih. Hidrasi yang baik penting untuk kesehatan kulit dan bulu.

6. Periksa masalah kesehatan: Perubahan mendadak pada kondisi bulu bisa menjadi tanda masalah kesehatan. Jika Anda melihat kerontokan berlebih, bercak botak, atau perubahan tekstur, konsultasikan dengan dokter hewan.

Dengan perawatan yang tepat, bulu anjing Anda akan tetap sehat dan berkilau, mencerminkan kondisi kesehatannya yang optimal.',
                'penulis' => 'drh. Siti Nurhayati',
                'tanggal' => Carbon::now()->subDays(5),
            ],
            [
                'thumbnail' => 'storage/artikel_photos/obesitas_hewan.jpg',
                'judul' => 'Mengenali dan Mencegah Obesitas pada Hewan Peliharaan',
                'deskripsi' => 'Obesitas adalah masalah kesehatan yang serius dan semakin umum pada hewan peliharaan. Diperkirakan sekitar 50% anjing dan kucing di Indonesia mengalami kelebihan berat badan. Kondisi ini dapat memperpendek umur dan menyebabkan berbagai masalah kesehatan seperti diabetes, penyakit jantung, masalah sendi, dan menurunnya kualitas hidup.

Bagaimana mengenali obesitas pada hewan peliharaan:
- Anda tidak dapat merasakan tulang rusuk dengan mudah
- Tidak ada lekukan pinggang yang terlihat dari atas
- Perut menggantung dari samping
- Bertambahnya berat badan
- Menurunnya aktivitas dan stamina

Penyebab utama obesitas pada hewan peliharaan:
- Pemberian makan berlebihan
- Kurang olahraga
- Genetik
- Sterilisasi (dapat menurunkan kebutuhan kalori)
- Penyakit tertentu seperti hipotiroidisme

Tips untuk mencegah dan mengatasi obesitas:
1. Ukur porsi makanan dengan tepat sesuai kebutuhan kalori hewan Anda
2. Batasi camilan dan makanan sisa meja
3. Tingkatkan aktivitas fisik harian
4. Pilih makanan khusus untuk manajemen berat badan jika diperlukan
5. Pemeriksaan kesehatan rutin untuk memantau berat badan

Jika Anda khawatir hewan peliharaan Anda kelebihan berat badan, konsultasikan dengan dokter hewan. Mereka dapat membantu Anda menyusun rencana penurunan berat badan yang aman dan efektif sesuai dengan kebutuhan spesifik hewan Anda.',
                'penulis' => 'drh. Hendra Wijaya',
                'tanggal' => Carbon::now()->subDays(10),
            ],
            [
                'thumbnail' => 'storage/artikel_photos/kucing_cacingan.jpg',
                'judul' => 'Gejala dan Penanganan Cacingan pada Kucing',
                'deskripsi' => 'Infeksi cacing adalah salah satu masalah kesehatan paling umum pada kucing. Berbagai jenis cacing seperti cacing gelang, cacing tambang, cacing pita, dan cacing jantung dapat menginfeksi kucing Anda dan menyebabkan masalah kesehatan serius.

Gejala umum cacingan pada kucing:
- Penurunan berat badan meskipun nafsu makan tetap normal atau meningkat
- Perut membesar (terutama pada anak kucing)
- Bulu kusam dan tidak sehat
- Diare atau muntah (kadang dengan cacing yang terlihat)
- Sembelit
- Area anus yang gatal, menyebabkan kucing menyeret pantatnya di lantai
- Batuk (pada kasus cacing jantung)
- Kelelahan dan kelemahan

Cara penularan:
- Menelan telur cacing dari lingkungan yang terkontaminasi
- Memakan mangsa yang terinfeksi
- Dari induk ke anak kucing melalui susu atau selama kehamilan
- Melalui gigitan nyamuk (untuk cacing jantung)

Penanganan dan pencegahan:
1. Pemberian obat cacing secara rutin, biasanya setiap 3-6 bulan untuk kucing dewasa
2. Anak kucing memerlukan program pemberian obat cacing yang lebih sering
3. Menjaga kebersihan kotak pasir
4. Mencegah kucing berburu dan memakan hewan liar
5. Pengobatan pencegahan cacing jantung bulanan untuk kucing di daerah berisiko tinggi

Penting untuk diingat bahwa beberapa jenis cacing dapat ditularkan ke manusia, terutama anak-anak. Konsultasikan dengan dokter hewan Anda untuk jadwal pemberian obat cacing yang tepat dan produk yang paling sesuai untuk kucing Anda.',
                'penulis' => 'drh. Dewi Safitri',
                'tanggal' => Carbon::now()->subDays(15),
            ],
            [
                'thumbnail' => 'storage/artikel_photos/anjing_rabies.jpg',
                'judul' => 'Bahaya Rabies dan Pentingnya Vaksinasi pada Anjing',
                'deskripsi' => 'Rabies adalah penyakit virus yang mematikan yang menyerang sistem saraf pusat mamalia, termasuk anjing dan manusia. Saat gejala klinis muncul, rabies hampir selalu berakhir fatal. Di Indonesia, rabies masih menjadi masalah kesehatan masyarakat yang serius di beberapa daerah.

Bagaimana rabies menyebar:
- Virus rabies menyebar melalui air liur hewan yang terinfeksi
- Penularan utama terjadi melalui gigitan
- Paparan pada luka terbuka atau selaput lendir juga bisa menyebabkan infeksi

Gejala rabies pada anjing:
1. Fase prodromal (2-3 hari): Perubahan perilaku, demam ringan, menjilat berlebihan di tempat gigitan
2. Fase ganas (2-4 hari): Mudah terangsang, agresif, halusinasi, kejang, hipersalivasi
3. Fase paralitik (2-4 hari): Kelumpuhan rahang bawah, kesulitan menelan, paralisis lanjut yang berakhir pada kematian

Pencegahan rabies:
- Vaksinasi rutin adalah satu-satunya cara efektif untuk mencegah rabies pada anjing
- Anjing harus divaksin pertama kali pada usia 3-4 bulan
- Booster diberikan 1 tahun kemudian, lalu setiap 1-3 tahun tergantung jenis vaksin dan regulasi setempat
- Hindari kontak dengan hewan liar atau anjing liar yang perilakunya mencurigakan
- Sterilisasi untuk membantu mengendalikan populasi anjing liar

Jika anjing Anda digigit oleh hewan yang dicurigai rabies, atau jika Anda digigit oleh anjing:
- Cuci luka dengan sabun dan air mengalir selama 15 menit
- Segera cari pertolongan medis
- Laporkan ke dinas kesehatan atau puskeswan setempat

Vaksinasi rabies bukan hanya melindungi anjing Anda, tetapi juga kesehatan keluarga dan masyarakat.',
                'penulis' => 'drh. Ahmad Fauzi',
                'tanggal' => Carbon::now()->subDays(20),
            ],
            [
                'thumbnail' => 'storage/artikel_photos/steril_hewan.jpg',
                'judul' => 'Manfaat Sterilisasi dan Kastrasi untuk Kesehatan Hewan Peliharaan',
                'deskripsi' => 'Sterilisasi (untuk betina) dan kastrasi (untuk jantan) adalah prosedur bedah yang mencegah hewan peliharaan bereproduksi. Selain membantu mengatasi masalah populasi hewan liar dan terlantar, prosedur ini juga memberikan banyak manfaat kesehatan dan perilaku.

Manfaat untuk kucing dan anjing betina (sterilisasi):
- Mencegah kehamilan yang tidak diinginkan
- Menghilangkan siklus birahi dan perilaku terkait
- Menghilangkan risiko pyometra (infeksi rahim) yang mengancam jiwa
- Mengurangi risiko kanker payudara secara signifikan jika dilakukan sebelum birahi pertama
- Mengurangi perilaku meraung dan menandai wilayah pada kucing

Manfaat untuk kucing dan anjing jantan (kastrasi):
- Mengurangi atau menghilangkan perilaku menandai teritori dengan urine
- Mengurangi agresi terkait hormon dan perilaku berkeliaran mencari pasangan
- Menghilangkan risiko kanker testis
- Mengurangi risiko masalah prostat
- Mengurangi perilaku kawin yang tidak diinginkan seperti menggosokkan tubuh dan mounting

Waktu yang tepat untuk sterilisasi/kastrasi:
- Umumnya antara usia 4-6 bulan
- Beberapa penelitian terbaru menunjukkan manfaat potensial menunggu hingga hewan mencapai kematangan seksual untuk beberapa breed besar
- Konsultasikan dengan dokter hewan Anda untuk timing yang optimal berdasarkan usia, breed, dan kondisi kesehatan

Mitos yang perlu diluruskan:
- Sterilisasi/kastrasi TIDAK menyebabkan hewan menjadi gemuk - pemberian makan dan olahraga yang tepat tetap penting
- Tidak benar bahwa betina harus memiliki satu kali kelahiran sebelum disterilisasi
- Prosedur ini tidak mengubah kepribadian dasar hewan peliharaan Anda

Pembedahan ini adalah prosedur rutin yang aman dengan risiko komplikasi minimal. Hewan biasanya pulih dengan cepat dan dapat kembali ke aktivitas normal dalam beberapa hari.',
                'penulis' => 'drh. Ratna Kusuma',
                'tanggal' => Carbon::now()->subDays(30),
            ],
            [
                'thumbnail' => 'storage/artikel_photos/parvo_anjing.jpg',
                'judul' => 'Mengenal Parvovirus pada Anjing: Gejala, Pengobatan, dan Pencegahan',
                'deskripsi' => 'Parvovirus adalah penyakit virus yang sangat menular dan sering fatal pada anjing, terutama anak anjing. Virus ini menyerang sel-sel yang membelah dengan cepat dalam tubuh, khususnya pada saluran pencernaan, sumsum tulang, dan jantung (pada anak anjing yang sangat muda).

Gejala Parvovirus:
- Muntah parah
- Diare berdarah dengan bau yang khas
- Kehilangan nafsu makan
- Lesu dan lemah
- Demam atau suhu tubuh rendah (hipotermia)
- Dehidrasi cepat

Gejala biasanya muncul 3-7 hari setelah paparan dan perkembangan penyakit sangat cepat. Tanpa pengobatan, kematian dapat terjadi dalam 48-72 jam akibat dehidrasi dan/atau sepsis.

Faktor risiko:
- Anak anjing berusia 6 minggu hingga 6 bulan paling rentan
- Anjing yang tidak divaksinasi
- Breed tertentu seperti Rottweiler, Doberman Pinscher, dan Pit Bull terrier tampaknya lebih rentan
- Lingkungan dengan populasi anjing tinggi (tempat penampungan, toko hewan, dll)

Diagnosis dan pengobatan:
Diagnosis didasarkan pada gejala klinis dan tes cepat di klinik. Tidak ada obat antivirus khusus, sehingga pengobatan bersifat suportif:
- Perawatan intensif dengan cairan IV untuk mengobati dehidrasi
- Obat antimuntah dan antidiare
- Antibiotik untuk mencegah infeksi sekunder
- Transfusi plasma atau darah dalam kasus parah
- Nutrisi enteral atau parenteral

Pencegahan:
- Vaksinasi adalah cara terbaik untuk mencegah parvovirus
- Seri vaksinasi dimulai pada usia 6-8 minggu, dengan booster setiap 3-4 minggu hingga usia 16 minggu
- Anjing dewasa memerlukan booster sesuai rekomendasi dokter hewan
- Hindari tempat umum hingga seri vaksinasi selesai
- Praktik kebersihan yang baik, karena virus dapat bertahan hingga satu tahun di lingkungan

Parvovirus sangat menular dan tahan terhadap banyak disinfektan. Gunakan larutan pemutih 1:30 untuk membersihkan area yang terkontaminasi. Jika Anda mencurigai anjing Anda terinfeksi parvovirus, segera hubungi dokter hewan karena ini adalah kondisi darurat.',
                'penulis' => 'drh. Eko Prasetyo',
                'tanggal' => Carbon::now()->subDays(40),
            ],
        ];

        foreach ($artikels as $artikel) {
            Artikel::create($artikel);
        }
    }
}