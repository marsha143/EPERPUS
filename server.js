import express from "express";
import cors from "cors";
import bodyParser from "body-parser";
import mysql from "mysql2/promise";
import dotenv from "dotenv";

dotenv.config();

const app = express();
const port = 3000;

app.use(cors());
app.use(bodyParser.json());

const db = await mysql.createPool({
  host: process.env.DB_HOST || "localhost",
  user: process.env.DB_USER || "root",
  password: process.env.DB_PASS || "",
  database: "eperpus",
  waitForConnections: true,
  connectionLimit: 10,
});

app.get("/cover/:url(*)", async (req, res) => {
  try {
    const imageUrl = decodeURIComponent(req.params.url);

    const response = await fetch(imageUrl);
    if (!response.ok) {
      return res.status(404).send("Image not found");
    }

    const buffer = Buffer.from(await response.arrayBuffer());

    res.setHeader(
      "Content-Type",
      response.headers.get("content-type") || "image/jpeg"
    );
    res.setHeader("Cache-Control", "public, max-age=86400");

    res.send(buffer);
  } catch (err) {
    console.error("Cover error:", err.message);
    res.status(500).send("Failed to load image");
  }
});


const kataKunciPerpus = [
  "buku","novel","komik","manga","pinjam","booking","kembali","denda","telat",
  "jam buka","perpus","perpustakaan","rekomendasi","saran","cari","judul",
  "penulis","genre","romance","thriller","fantasy","horor","misteri","fiksi"
];

function isTopikPerpus(pesan) {
  return kataKunciPerpus.some(k => pesan.toLowerCase().includes(k));
}

const salam = ["Yokoso! Selamat datang di Perpustakaan Takumi!", "Hiii! Perpus online siap bantu", "Hai, ada yang bisa kami bantu hari ini?"];
const terimaKasih = ["No problem! Kapan pun butuh bantuan, hubungi kami.", "Terima kasih kembali, silakan hubungi kami jika butuh bantuan.", "Seneng banget bisa bantu", "Sip! Happy reading"];
const dadah = ["Dadah! Sehat selalu ya", "Selamat beraktivitas, sampai bertemu lagi.","Bye-bye! Jaga kesehatan!","Sayonara! Sampai bertemu kembali!", "Sampai jumpa lagi, bookworm!"];

function cekUcapanRamah(pesan) {
  const l = pesan.toLowerCase().trim();
  if (/terima ?kasih|makasih|thanks|thx|makasi|tq|trims/i.test(l))
    return terimaKasih[Math.floor(Math.random() * terimaKasih.length)];
  if (/halo|hai|hi|hey|pagi|siang|sore|malam|ass?alam/i.test(l) && l.split(" ").length <= 5)
    return salam[Math.floor(Math.random() * salam.length)] + " Ada yang bisa dibantu soal buku?";
  if (/bye|dadah|dah|sampai jumpa|babay/i.test(l))
    return dadah[Math.floor(Math.random() * dadah.length)];
  return null;
}

async function rekomendasiBuku(genreHint = "") {
  try {
    let sql = `
      SELECT 
        b.judul_buku,
        b.cover,
        p.nama_penulis,
        g.jenis_genre
      FROM buku b
      JOIN penulis p ON b.id_penulis = p.id
      JOIN genre g ON b.id_genre = g.id
      WHERE b.judul_buku IS NOT NULL
    `;

     const params = [];

    if (genreHint) {
      sql += ` AND g.jenis_genre LIKE ?`;
      params.push(`%${genreHint}%`);
    }

    sql += ` ORDER BY RAND() LIMIT 6`;

    const [rows] = await db.execute(sql, params);

    if (!rows.length) {
      return "Buku belum tersedia untuk genre tersebut 😅";
    }

    let teks = "📚 Rekomendasi Buku Untuk Kamu:\n\n";
    rows.forEach((b, i) => {
      teks += `${i + 1}. ${b.judul_buku}\n`;
      teks += `   Penulis: ${b.nama_penulis}\n`;
      teks += `   Genre: ${b.jenis_genre}\n`;

      if (b.cover) {
        teks += `   http://localhost:3000/cover/${encodeURIComponent(b.cover)}\n`;
      }
      teks += "Ketersediaan atau informasi buku lainnya bisa langsung cek di halaman Koleksi buku ya!📚\n";
    });

    return teks;
  } catch (err) {
    console.error(err);
    return "⚠️ Gagal mengambil data buku.";
  }
}


app.post("/chat", async (req, res) => {
  const { message } = req.body || {};
  const pesan = (message || "").toString().trim();

  if (!pesan) {
    return res.json({ reply: "Hai! Mau cari buku, minta rekomendasi, atau tanya perpus?" });
  }

  let reply = "";


  const ucapan = cekUcapanRamah(pesan);
  if (ucapan) {
    reply = ucapan;
  }

  else if (!isTopikPerpus(pesan)) {
    reply = "Maaf ya, aku cuma bisa bantu urusan buku, peminjaman, denda, dan layanan perpustakaan aja";
  }

  else if (/rekomendasi|rekom|saran|bagus|mau baca|novel bagus|best|populer|seru|keren|romance|thriller|fantasy|horror|misteri|romansa/i.test(pesan.toLowerCase())) {
    const genreHint = pesan.toLowerCase().match(/(romance|thriller|fantasy|horror|misteri|romansa|fantasi|self improvement)/i)?.[0] || "";
    reply = await rekomendasiBuku(genreHint);
  }
  else {
    const jawabanUmum = {
      pinjam: "Untuk meminjam buku, kamu cukup membawa kartu perpustakaan beserta buku yang ingin dipinjam, lalu serahkan kepada admin perpustakaan. Admin akan mendata peminjamanmu terlebih dahulu, jadi pastikan kartu perpustakaanmu dibawa, ya! Prosesnya cepat dan tidak rumit, jadi kamu bisa langsung membawa pulang buku pilihanmu setelah data dicatat.",
      kembalikan: "Kamu bisa melakukan booking buku langsung melalui website perpustakaan. Caranya: login terlebih dahulu, lalu buka menu 'Pengajuan Pemesanan Buku'. Setelah itu, klik tombol 'Tambah Buku', pilih judul buku yang kamu inginkan, dan klik 'Simpan'. Setelah permintaan terkirim, admin perpustakaan akan memproses pemesananmu. Kamu juga bisa memantau status pemesanan melalui halaman akunmu. Dengan fitur ini, kamu tidak perlu khawatir kehabisan buku!",
      booking:  "Kamu bisa melakukan booking buku langsung melalui website perpustakaan. Caranya: login terlebih dahulu, lalu buka menu 'Pengajuan Pemesanan Buku'. Setelah itu, klik tombol 'Tambah Buku', pilih judul buku yang kamu inginkan, dan klik 'Simpan'. Setelah permintaan terkirim, admin perpustakaan akan memproses pemesananmu. Jika di ACC, kamu dapat langsung menemui admin perpustakaan untuk mengambil buku. Dengan fitur ini, kamu tidak perlu khawatir kehabisan buku!",
      denda:  "Perpustakaan menerapkan denda keterlambatan sebesar Rp500 per hari untuk setiap buku yang terlambat dikembalikan. Nominal ini memang kecil, tetapi tetap lebih baik jika kamu mengembalikan buku tepat waktu agar tidak menumpuk ya! Denda ini juga membantu memastikan buku dapat kembali dipinjam oleh anggota lain tepat pada waktunya. Jadi yuk, biasakan mengatur jadwal pengembalian agar tidak lupa!",
        "jam buka": "Perpustakaan Takumi buka setiap hari Senin hingga Jumat mulai pukul 08.00 sampai 16.00. Pada hari Sabtu, Minggu, serta tanggal merah, perpustakaan tutup. Kamu bisa berkunjung, meminjam buku, atau berkonsultasi dengan admin selama jam operasional tersebut. Jangan lupa cek jadwal sebelum datang ya!"
    };
    const lower = pesan.toLowerCase();
    reply = jawabanUmum.pinjam && lower.includes("pinjam") ? jawabanUmum.pinjam :
            jawabanUmum.booking && lower.includes("booking") ? jawabanUmum.booking :
            jawabanUmum.kembalikan && lower.includes("kembalikan") ? jawabanUmum.kembalikan :
            jawabanUmum.denda && lower.includes("denda") ? jawabanUmum.denda :
            jawabanUmum["jam buka"] && lower.includes("jam") ? jawabanUmum["jam buka"] :
            "Maaf aku kurang paham, coba tanya soal buku atau perpus ya!";
  }

  res.json({ reply });
});

app.get("/test-db", async (req, res) => {
  try {
    const [rows] = await db.execute("SELECT COUNT(*) as total FROM buku");
    res.json({ status: "Database Connected!", total_buku: rows[0].total });
  } catch (err) {
    res.json({ error: err.message });
  }
});

app.get("/", (req, res) => {
  res.send(`
    <h1>Pustakun AI + eperpus</h1>
    <p><a href="/test-db">Test Koneksi DB</a></p>
  `);
});

app.listen(port, () => {
  console.log(`Pustakun AI berjalan di http://localhost:${port}`);
  console.log(`Rekomendasi buku`);
});