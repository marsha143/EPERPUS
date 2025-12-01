import express from 'express';
import cors from 'cors';
import bodyParser from 'body-parser';
import ollama from 'ollama';
import mysql from 'mysql2/promise';
import dotenv from 'dotenv';

dotenv.config();

const app = express();
const port = 3000;

// Middleware
app.use(cors());
app.use(bodyParser.json());

// Koneksi database
const db = await mysql.createPool({
  host: "localhost",
  user: "root",
  password: "",
  database: "eperpus"
});

// Regex untuk topik Takumi
const takumiRegex = /(trimakasih|trima kasih|terima kasih|terimakasih|halo|helo|hallo|hai|takumi|politeknik takumi|kuliah|pelatihan|training|program|jurusan|biaya|beasiswa|pendaftaran|daftar|jepang|magang|kerja ke jepang)/i;

// Memory chat per IP
const memory = {};
const MAX_MEMORY = 20;

// Greeting awal
app.get("/greeting", (req, res) => {
  const userId = req.ip;
  if (!memory[userId]) memory[userId] = [];

  const greeting = `Selamat Datang di Takumi Training Center!  
Saya adalah AI Assistant resmi yang siap membantu menjawab semua pertanyaanmu seputar pelatihan, pendaftaran, biaya, dan karier ke Jepang.  
Ada yang bisa dibantu hari ini?`;

  memory[userId].push({ role: "assistant", content: greeting });
  res.json({ reply: greeting.trim() });
});

// Chat utama
app.post("/chat", async (req, res) => {
  const { message } = req.body;
  if (!message || message.trim() === "") return res.json({ reply: "Silakan ketik pertanyaan." });

  const userId = req.ip;
  if (!memory[userId]) memory[userId] = [];
  if (memory[userId].length > MAX_MEMORY) memory[userId] = memory[userId].slice(-MAX_MEMORY);

  let reply = "";

  try {
    // === DETAIL PELATIHAN SATU PER SATU ===
    if (/detail|info|jelasin|ceritain|tentang|apa itu/i.test(message) && /pelatihan|program|kursus|kelas|training/i.test(message)) {
      const match = message.match(/(?:detail|info|jelasin|ceritain|tentang|apa itu)\s*(?:pelatihan|program|kursus|kelas|training)?\s*([^?.!,]*)/i);
      const namaDicari = match ? match[1].trim() : "";

      if (!namaDicari || namaDicari.length < 2) {
        reply = `Maaf, nama pelatihan yang kamu maksud belum jelas
Contoh:\n• detail pelatihan digital marketing\n• info bahasa jepang`;
        memory[userId].push({ role: "assistant", content: reply });
        return res.json({ reply });
      }

      const [rows] = await db.query(`
        SELECT * FROM pelatihan 
        WHERE status_pelatihan = 'Aktif' 
          AND LOWER(nama_pelatihan) LIKE ? 
        LIMIT 1
      `, [`%${namaDicari.toLowerCase()}%`]);

      if (rows.length > 0) {
        const p = rows[0];
        reply = `
<div style="background:#e8f5e9; padding:20px; border-radius:12px; border-left:6px solid #4caf50; font-family:Arial,sans-serif;">
  <h3 style="color:#2e7d32; margin:0 0 15px 0;">${p.nama_pelatihan}</h3>
  ${p.deskripsi_lengkap || p.deskripsi_pelatihan || '<p>Pelatihan berkualitas tinggi bersama instruktur berpengalaman.</p>'}
  <p><strong>Level:</strong> ${p.level_pelatihan || "Semua Level"}</p>
  <p><strong>Durasi:</strong> ${p.durasi || "-"}</p>
  <p><strong>Biaya:</strong> Rp ${Number(p.harga_pelatihan).toLocaleString("id-ID")}</p>
  <div style="margin-top:20px; text-align:center;">
    <a href="https://pmb.takumi.ac.id" style="background:#388e3c;color:white;padding:12px 24px;text-decoration:none;border-radius:8px;margin:0 10px;font-weight:bold;">Daftar Sekarang</a>
    <a href="https://wa.link/s283dz" style="background:#25d366;color:white;padding:12px 24px;text-decoration:none;border-radius:8px;margin:0 10px;">Chat WA</a>
  </div>
</div>`;
        memory[userId].push({ role: "assistant", content: reply });
        return res.json({ reply });
      } else {
        reply = `Mohon maaf, pelatihan "${namaDicari}" belum tersedia saat ini. Nanti kalau dibuka saya kabari ya!`;
        memory[userId].push({ role: "assistant", content: reply });
        return res.json({ reply });
      }
    }

    // === BIAYA ===
    else if (/biaya|harga|berapa/i.test(message)) {
      const [rows] = await db.query("SELECT * FROM pelatihan WHERE status_pelatihan = 'Aktif'");
      reply = `<strong>Biaya Pelatihan Takumi</strong><br><br>
${rows.map(p => `• <strong>${p.nama_pelatihan}</strong>: Rp ${Number(p.harga_pelatihan).toLocaleString("id-ID")}`).join("<br>")}<br><br>
Tersedia beasiswa 100%, diskon early bird, cicilan 0%.<br>
Info lengkap: <a href="https://pmb.takumi.ac.id">pmb.takumi.ac.id</a>`;
      memory[userId].push({ role: "assistant", content: reply });
      return res.json({ reply });
    }

    // === DAFTAR PELATIHAN ===
    else if (/pelatihan|program|jurusan|ada apa/i.test(message)) {
      const [rows] = await db.query("SELECT * FROM pelatihan WHERE status_pelatihan='Aktif'");
      if (rows.length === 0) {
        reply = "Belum ada pelatihan aktif.";
      } else {
        reply = `<p>Di Takumi Training Center tersedia:</p><ul>${rows.map(p => `<li><strong>${p.nama_pelatihan}</strong>: ${p.keterangan_pelatihan}</li>`).join("")}</ul>
<p>Semua program sudah include bahasa Jepang + peluang magang/ke Jepang!</p>
<p>Detail: <a href="https://takumi.ac.id/program-studi/">https://takumi.ac.id/program-studi/</a></p>`;
      }
      memory[userId].push({ role: "assistant", content: reply });
      return res.json({ reply });
    }

    // === TOPIK TAKUMI → OLLAMA ===
    else if (takumiRegex.test(message)) {
      const systemPrompt = `Kamu adalah Takumi-san, AI resmi Politeknik Takumi Training Center. 
Jawab ramah, profesional, bahasa Indonesia, maksimal 3 paragraf. 
Hanya bahas: program pelatihan, pendaftaran, biaya, beasiswa, magang & kerja ke Jepang. 
Kalau di luar topik, arahkan ke WA: https://wa.me/6282258868305`;

      const messages = [
        { role: "system", content: systemPrompt },
        ...memory[userId].slice(-10),
        { role: "user", content: message }
      ];

      const response = await ollama.chat({
        model: "qwen2.5:3b",     // atau "llama3.2", "phi3", dll
        messages: messages
      });

      reply = response.message.content.trim();

      memory[userId].push({ role: "user", content: message });
      memory[userId].push({ role: "assistant", content: reply });

      return res.json({ reply });
    }

    // === FALLBACK ===
    else {
      reply = `Maaf, saya hanya bisa bantu soal Takumi Training Center (program, biaya, pendaftaran, magang Jepang). 
Kalau ada pertanyaan lain, langsung chat admin ya: 
<a href="https://wa.me/6282258868305">Chat WA Marketing Takumi</a>`;
      memory[userId].push({ role: "assistant", content: reply });
      return res.json({ reply });
    }

  } catch (err) {
    console.error("Error:", err.message);
    res.json({ reply: "Maaf, sedang ada gangguan teknis. Coba lagi sebentar ya!" });
  }
});

// Home
app.get("/", (_, res) => {
  res.send("Takumi AI Server + Ollama GRATIS berjalan!");
});

// Jalankan server
app.listen(port, () => {
  console.log(`Server jalan di http://localhost:${port}`);
  console.log("Full gratis pake Ollama lokal!");
});