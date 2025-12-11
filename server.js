import express from 'express';
import cors from 'cors';
import bodyParser from 'body-parser';
import mysql from 'mysql2/promise';
import dotenv from 'dotenv';

dotenv.config();

const app = express();
const port = 3000;

app.use(cors());
app.use(bodyParser.json());

const db = await mysql.createPool({
  host: process.env.DB_HOST || "localhost",
  user: process.env.DB_USER || "root",
  password: process.env.DB_PASS || "",
  database: "eperpus"
});

const topikDiizinkan = [
  "buku", "novel", "komik", "manga", "pinjam", "booking", "kembali", "denda", 
  "telat", "perpanjang", "perpus", "perpustakaan", "jam buka", "rekomendasi", 
  "cari buku", "judul", "penulis", "kategori", "romance", "tersedia","thriller", "fantasy", "hilang", "rusak", "genre"
];

const jawabanCepat = {
  "cara meminjam": ["Datang bawa buku + kartu mahasiswa → langsung bisa bawa pulang (maks 7 hari)", "Bisa langsung ke loket atau booking dulu lewat web biar aman"],
  "booking": ["Login → cari buku → klik Booking → datang dalam 1×24 jam → buku langsung dikasih!", "Booking dulu biar nggak kehabisan. Setelah booking wajib ambil dalam 24 jam ya"],
  "denda": ["Denda ringan kok: Rp 500/hari, tapi jangan lupa mengembalikan buku ya!"],
  "berapa denda": ["Denda ringan kok: Rp 500/hari, tapi jangan lupa mengembalikan buku ya!"],
  "jam buka": ["Senin–Jumat: 08.00–16.00, Sabtu: 09.00–14.00, Minggu TUTUP", "Buka Senin sampai Sabtu aja ya!"],
  "buku jepang": ["Ada banyak! Manga, novel Jepang, kamus, sampai buku pelajaran bahasa Jepang", "Koleksi Jepang lengkap banget: One Piece, Naruto, sampai light novel ada!"],
  "novel": ["Ada novel Indonesia, terjemahan Inggris, Jepang, Korea. Mau genre apa?", "Novel banyak! Dari romance, thriller, sampai fantasy ada semua"],
  "komik": ["Ada One Piece, Naruto, Attack on Titan, sampai komik lokal juga!", "Komiknya up to date! Dari yang lama sampai terbaru ada"],
  "cara mengembalikan": ["Bisa langsung mendatangi admin perpustakaan ya!"],
  "terima kasih": ["Sama-sama! Senang bisa bantu soal buku", "Anytime! Kalau butuh rekomendasi lagi langsung tanya ya"]
};

function isTopikDiizinkan(pesan) {
  const lower = pesan.toLowerCase();
  return topikDiizinkan.some(kata => lower.includes(kata));
}


async function askGemma(userMessage, history = []) {
  try {
    const response = await fetch("http://localhost:11434/api/chat", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        model: "gemma3:4b",
        messages: [
          { 
            role: "system", 
            content: "Kamu adalah Pustakun, AI KHUSUS perpustakaan. HANYA boleh jawab tentang buku, peminjaman, denda, booking, dan layanan perpus. Kalau pertanyaan di luar itu, jawab: 'Maaf, saya hanya bisa bantu urusan buku dan perpustakaan ya!'. Jawab singkat, ramah, bahasa Indonesia." 
          },
          ...history.slice(-10),
          { role: "user", content: userMessage }
        ],
        stream: false,
        options: { num_predict: 100, temperature: 0.7 }
      })
    });
    if (!response.ok) return "Maaf, AI lagi istirahat sebentar...";
    const data = await response.json();
    return data.message?.content?.trim();
  } catch {
    return "AI lagi sibuk, coba lagi ya!";
  }
}

// Memory
const memory = {};
const MAX_MEMORY = 30;

// === ROUTE CHAT ===
app.post("/chat", async (req, res) => {
  const { message } = req.body;
  if (!message?.trim()) return res.json({ reply: "Tulis pertanyaan tentang buku dulu yuk!" });

  const userId = req.ip || "unknown";
  if (!memory[userId]) memory[userId] = [];
  if (memory[userId].length > MAX_MEMORY) memory[userId] = memory[userId].slice(-MAX_MEMORY);

  const msg = message.toLowerCase().trim();
  let reply = "";


  if (!isTopikDiizinkan(message)) {
    reply = "Maaf, saya hanya bisa bantu urusan buku, peminjaman, denda, dan perpustakaan ya! Kalau ada pertanyaan tentang buku, langsung tanya aja";
  }

  else {
    for (const key in jawabanCepat) {
      if (msg.includes(key)) {
        const pilihan = jawabanCepat[key];
        reply = Array.isArray(pilihan) ? pilihan[Math.floor(Math.random() * pilihan.length)] : pilihan;
        break;
      }
    }


    if (!reply) {
      if (/rekomendasi|saran|novel|mau baca|bagus|rekomendasikan/i.test(msg)) {
        reply = await askGemma(`Rekomendasi 3-4 buku untuk: "${message}". Jawab singkat dan menarik.`, memory[userId]);
      } else {
        reply = await askGemma(message, memory[userId]);
      }
    }
  }


  memory[userId].push({ role: "user", content: message });
  memory[userId].push({ role: "assistant", content: reply });

  res.json({ reply });
});

app.get("/", (req, res) => res.send("Pustakun AI — HANYA JAWAB TENTANG BUKU & PERPUSTAKAAN!"));
app.listen(port, () => {
  console.log(`Pustakun AI (gemma3:4b) berjalan di http://localhost:${port}`);
  console.log(`Hanya jawab tentang buku!`);
});