import express from 'express';
import cors from 'cors';
import bodyParser from 'body-parser';
import ollama from 'ollama';
import mysql from 'mysql2/promise';
import dotenv from 'dotenv';

dotenv.config();

const app = express();
const port = 3000;

app.use(cors());
app.use(bodyParser.json());

// Koneksi DB
const db = await mysql.createPool({
  host: process.env.DB_HOST || "localhost",
  user: process.env.DB_USER || "root",
  password: process.env.DB_PASS || "",
  database: "eperpus"
});

// Konfigurasi
const DENDA_PER_HARI = 1000;
const MAKS_HARI_PINJAM = 14;

// Memory chat
const memory = {};
const MAX_MEMORY = 20;

// === PROSEDUR PEMINJAMAN TERBARU & FINAL (2 cara) ===
const prosedurPeminjaman = `Ada **2 cara mudah** untuk meminjam buku di EPERPUS (keduanya 100% GRATIS):

**1. Pinjam Langsung (paling cepat)**
- Datang ke perpustakaan
- Bawa buku yang ingin dipinjam
- Serahkan buku + kartu mahasiswa ke petugas
- Petugas akan langsung mencatat peminjaman di sistem
- Buku bisa langsung dibawa pulang (maks. 14 hari)

**2. Booking Dulu Lewat Web (praktis kalau takut kehabisan)**
- Login ke web anggota EPERPUS
- Cari & booking buku yang kamu inginkan
- Datang ke perpustakaan (maks. 2×24 jam setelah booking)
- Tunjukkan bukti booking + kartu mahasiswa ke petugas
- Petugas akan meng-ACC dan menyerahkan buku fisiknya

Kedua cara sama-sama gratis, tanpa biaya peminjaman apapun.  
Hanya ada denda Rp 1.000/hari jika telat mengembalikan ya 

Butuh bantuan cari buku atau mau saya bantu bookingkan? Langsung bilang saja!`;

// === GREETING ===
app.get("/greeting", (req, res) => {
  const userId = req.ip;
  if (!memory[userId]) memory[userId] = [];

  const greeting = `Halo! Selamat datang di E-Perpus Politeknik Takumi  
Saya **Pustakun**, AI Pustakawan resmi yang siap bantu kamu 24/7 untuk:  
• Booking & peminjaman buku (langsung atau online)  
• Cek status booking / peminjaman  
• Hitung denda keterlambatan  
• Rekomendasi buku terbaik  

Mau pinjam buku atau ada yang ditanyakan hari ini?`;

  memory[userId].push({ role: "assistant", content: greeting });
  res.json({ reply: greeting.trim() });
});

// === CHAT UTAMA ===
app.post("/chat", async (req, res) => {
  const { message } = req.body;
  if (!message || message.trim() === "") return res.json({ reply: "Silakan ketik pertanyaan." });

  const userId = req.ip;
  if (!memory[userId]) memory[userId] = [];
  if (memory[userId].length > MAX_MEMORY) memory[userId] = memory[userId].slice(-MAX_MEMORY);

  let reply = "";
  const lowerMsg = message.toLowerCase();

  try {
    // 1. Tanya cara pinjam / booking
    if (/cara pinjam|pinjam buku|booking|book|prosedur|meminjam|gimana pinjam/i.test(lowerMsg)) {
      reply = prosedurPeminjaman;
    }

    // 2. Detail buku
    else if (/detail|info|cari|judul buku/i.test(lowerMsg)) {
      const match = message.match(/(?:detail|info|cari)\s*(?:buku)?\s*["']?([^"']+)["']?/i);
      const judulCari = match ? match[1].trim() : "";

      if (!judulCari || judulCari.length < 2) {
        reply = "Mau cari buku apa? Tulis judul atau keyword ya.\nContoh: cari buku Rich Dad";
      } else {
        const [rows] = await db.query(`
          SELECT judul, penulis, tahun, kategori, tersedia, jumlah_eksemplar 
          FROM buku WHERE LOWER(judul) LIKE ? LIMIT 1
        `, [`%${judulCari.toLowerCase()}%`]);

        if (rows.length > 0) {
          const b = rows[0];
          const status = b.tersedia ? "Tersedia" : "Sedang dipinjam";
          reply = `
<div style="background:#f8fff0;padding:20px;border-radius:12px;border-left:6px solid #4caf50;font-family:Arial;">
  <h3 style="margin:0 0 12px;color:#2e7d32;">${b.judul}</h3>
  <p><strong>Penulis:</strong> ${b.penulis || "-"}</p>
  <p><strong>Tahun:</strong> ${b.tahun || "-"}</p>
  <p><strong>Kategori:</strong> ${b.kategori || "Umum"}</p>
  <p><strong>Status:</strong> <span style="color:${b.tersedia ? '#2e7d32' : '#d32f2f'};font-weight:bold;">${status}</span></p>
  <p><strong>Tersedia:</strong> ${b.tersedia ? "Bisa langsung dipinjam atau di-booking" : "Coba booking dulu ya"}</p>
</div>`;
        } else {
          reply = `Maaf, buku "${judulCari}" belum ada di koleksi kami. Coba judul lain atau tanya saya rekomendasi ya!`;
        }
      }
    }

    // 3. Rekomendasi buku (Ollama)
    else if (/rekomendasi|saran|novel bagus|mau baca apa|rekomendasikan/i.test(lowerMsg)) {
      const systemPrompt = `Kamu adalah pustakawan ramah di perpustakaan kampus. Berikan 3–5 rekomendasi buku sesuai minat pengguna. Gunakan bahasa Indonesia santai dan menarik. Sebutkan judul + penulis + 1 kalimat alasan.`;
      const messages = [{ role: "system", content: systemPrompt }, ...memory[userId].slice(-10), { role: "user", content: message }];
      const response = await ollama.chat({ model: "qwen2.5:3b", messages });
      reply = response.message.content.trim();
    }

    // 4. Pertanyaan umum perpus (Ollama)
    else if (/perpus|perpustakaan|pinjam|kembali|denda|telat|jam buka|booking|admin/i.test(lowerMsg)) {
      const systemPrompt = `Kamu adalah Pustakun, AI Pustakawan Politeknik Takumi. Jawab ramah dan jelas dalam bahasa Indonesia. Jelaskan aturan peminjaman (ada 2 cara: langsung & booking), denda Rp 1.000/hari, batas 14 hari, dll. Kalau di luar topik perpus, arahkan ke petugas.`;
      const messages = [{ role: "system", content: systemPrompt }, ...memory[userId].slice(-10), { role: "user", content: message }];
      const response = await ollama.chat({ model: "qwen2.5:3b", messages });
      reply = response.message.content.trim();
    }

    // 5. Fallback
    else {
      reply = `Maaf, saya hanya bisa membantu urusan perpustakaan (booking, peminjaman, denda, rekomendasi buku, dll).  
Kalau ada pertanyaan lain, silakan tanya langsung ke petugas perpustakaan ya!`;
    }

    // Simpan ke memory
    memory[userId].push({ role: "user", content: message });
    if (reply) memory[userId].push({ role: "assistant", content: reply });

    return res.json({ reply });

  } catch (err) {
    console.error(err);
    return res.json({ reply: "Maaf, sistem sedang bermasalah. Coba lagi dalam beberapa menit ya!" });
  }
});

app.get("/", (_, res) => res.send("E-Perpus AI + Booking System berjalan!"));
app.listen(port, () => {
  console.log(`E-Perpus AI Server (dengan booking) berjalan di http://localhost:${port}`);
});