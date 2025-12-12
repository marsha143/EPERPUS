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

app.use("/covers", express.static("covers"));

const db = await mysql.createPool({
  host: process.env.DB_HOST || "localhost",
  user: process.env.DB_USER || "root",
  password: process.env.DB_PASS || "",
  database: "eperpus",
  waitForConnections: true,
  connectionLimit: 10,
});

const kataKunciPerpus = [
  "buku","novel","komik","manga","pinjam","booking","kembali","denda","telat",
  "jam buka","perpus","perpustakaan","rekomendasi","saran","cari","judul","penulis","genre",
  "romance","thriller","fantasy","horor","misteri","fiksi","romansa","best","populer"
];

function isTopikPerpus(pesan) {
  const lower = pesan.toLowerCase();
  return kataKunciPerpus.some(k => lower.includes(k));
}

const salam = ["Halo booklover!", "Hai hai!", "Hiii! Perpus online siap bantu", "Yo! Mau cari buku apa?"];
const terimaKasih = ["Sama-sama ya!", "Anytime!", "Seneng banget bisa bantu", "Sip! Happy reading"];
const dadah = ["Dadah! Jangan lupa balikin buku ya", "Bye!", "Sampai jumpa lagi, bookworm!"];

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
      WHERE b.judul_buku IS NOT NULL AND b.judul_buku != ''
    `;

    const params = [];

    if (genreHint) {
      sql += ` AND g.jenis_genre LIKE ?`;
      params.push(`%${genreHint}%`);
    }

    sql += ` ORDER BY RAND() LIMIT 6`;

    const [rows] = await db.execute(sql, params);

    if (rows.length === 0) {
      return genreHint 
        ? `Buku genre "${genreHint}" lagi kosong nih. Coba genre lain yuk!`
        : "Koleksi buku lagi kosong nih. Coba nanti lagi ya!";
    }

    let teks = "Ini beberapa rekomendasi buku dari perpustakaan kita:\n\n";
    rows.forEach((book, i) => {
      teks += `${i + 1}. *${book.judul_buku}*\n`;
      teks += `   Penulis: ${book.nama_penulis}\n`;
      teks += `   Genre: ${book.jenis_genre}\n`;
      if (book.cover && book.cover.trim() !== "") {
        teks += `   Cover: http://localhost:3000/covers/${book.cover}\n`;
      }
      teks += "\n";
    });
    teks += "Untuk detailnya langsung ke halaman koleksi buku ya!";
    return teks;

  } catch (err) {
    console.error("Error rekomendasi:", err);
    return "Maaf, lagi ada masalah ambil data buku. Coba lagi dalam 10 detik ya!";
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
      pinjam: "Bawa kartu mahasiswa + buku → langsung ke loket. Proses cepet kok!",
      kembalikan: "Bawa kartu mahasiswa + buku → langsung ke loket. Pengembalian selesai!",
      booking: "Bisa booking lewat web, datang ambil dalam 1×24 jam ya!",
      denda: "Denda Rp500/hari per buku. Masih ringan kan?",
      "jam buka": "Senin–Jumat: 08.00–16.00\nSabtu–Minggu & tanggal merah: Tutup"
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
    <p>Database Connected! Rekomendasi & pencarian buku langsung dari koleksi kampus</p>
    <p><a href="/test-db">Test Koneksi DB</a></p>
  `);
});

app.listen(port, () => {
  console.log(`Pustakun AI berjalan di http://localhost:${port}`);
  console.log(`Rekomendasi buku langsung dari tabel buku + penulis + genre`);
});