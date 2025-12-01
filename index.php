<?php include("./config/db.php"); ?>
<?php include('./admin/layouts/header.php'); ?>
<?php $q = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM buku");
$r = mysqli_fetch_assoc($q);
$jumlah_buku = $r['jumlah'];

?>
<header class="header-2">
    <div class="page-header min-vh-75 relative" style="background-image: url('./assets/img/Gedung-Takumi-AI.jpg')">
        <span class="mask bg-gradient-primary opacity-4"></span>
        <div class="container">
            <div class="row">
                <div class="col-lg-7 text-center mx-auto">
                    <h1 class="text-white pt-3 mt-n5">EPERPUS 2.0</h1>
                    <p class="lead text-white mt-3">Elektronic Perpustakaan <br> Politeknik Takumi</p>
                    <a href="login">
                        <button type="submit" class="btn bg-white text-dark">Login</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-n6">
    <section class="pt-3 pb-4" id="count-stats">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 mx-auto py-3">
                    <div class="row">
                        <div class="col-md-12 position-relative">
                            <div class="p-3 text-center">
                                <h1 class="text-gradient text-primary"><span id="state1"
                                        countTo="<?=$jumlah_buku?>">0</span>+</h1>
                                <h5 class="mt-3">Jumlah Buku Yang Tersedia</h5>
                                <p class="text-sm font-weight-normal">Tersedia buku pendidikan, novel, juga komik
                                    berbahasa Jepang!</p>
                            </div>
                            <hr class="vertical dark">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ai-chat-section py-5 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5 text-center mx-auto mb-4">
                    <dotlottie-wc class="lottie-buku"
                        src="https://lottie.host/e72dc47c-1505-4f3c-94c4-f09f4e525def/Xdp7tUP0iw.lottie"
                        style="width: 300px; height: 300px;" autoplay loop>
                    </dotlottie-wc>
                    <h2 class="fw-bold mt-3 text-primary">Tanya AI Perpustakaan</h2>
                    <p class="text-muted px-3">
                        Punya pertanyaan tentang perpustakaan, buku, atau layanan kami?
                        Tanyakan langsung ke asisten AI kami!
                    </p>
                </div>

                <!-- Kanan: Kotak Chat -->
                <div class="col-md-7">
                    <div class="ai-chat-box shadow-lg p-4">
                        <div class="chat-header p-3 mb-3 text-white rounded">
                            <h5 class="mb-0"><i class="fas fa-robot me-2"></i>Asisten AI</h5>
                            <span class="chat-subtitle">Siap membantu menjawab pertanyaan Anda</span>
                        </div>

                        <!-- Area Chat (bisa diganti iframe atau widget) -->
                        <div class="chat-area mb-3 p-3 bg-light rounded border">
                            <div id="chat-box"></div>
                        </div>

                        <!-- Input -->

                            <input type="text" id="user-input" class="form-control me-2"
                                placeholder="Ketik pertanyaan kamu di sini...">
                            <button id="send-btn" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="my-5 py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 ms-auto me-auto p-lg-4 mt-lg-0 mt-4">
                    <div class="rotating-card-container">
                        <div
                            class="card card-rotate card-background card-background-mask-primary shadow-primary mt-md-0 mt-5">
                            <div class="front front-background"
                                style="background-image: url('./assets/img/lobi.jpeg'); background-size: cover;">
                                <div class="card-body py-7 text-center">
                                    <i class="material-icons text-white text-4xl my-3">touch_app</i>
                                    <h3 class="text-white">Kunjungi <br /> Perpustakaan Kami</h3>
                                    <p class="text-white opacity-8">Kami selalu terbuka untuk Anda yang ingin membaca
                                        dan mencari suasana belajar yang nyaman.
                                        Temukan lokasi kami melalui peta berikut.</p>
                                </div>
                            </div>
                            <div class="back back-background"
                                style="background-image: url('./assets/img/alamat.jpeg'); background-size: cover;">
                                <div class="card-body pt-7 text-center">
                                    <h3 class="text-white">Google Maps</h3>
                                    <p class="text-white opacity-8">Kebon Kopi, Jl. Raya Kodam, RT.004/RW.002, Serang,
                                        Cikarang Sel., Kabupaten Bekasi, Jawa Barat 17530
                                    </p>
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.2423186332753!2d107.11986287499154!3d-6.3626767936273625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e699b63eab60837%3A0xd4d020252918e2e9!2sPoliteknik%20Takumi!5e0!3m2!1sen!2sid!4v1762490559439!5m2!1sen!2sid"
                                        width="290" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 ms-auto">
                    <div class="row justify-content-start">
                        <div class="col-md-6">
                            <div class="info">
                                <i class="material-icons text-gradient text-primary text-3xl">content_copy</i>
                                <h5 class="font-weight-bolder mt-3">— Soekarno </h5>
                                <p class="pe-5">“Membaca adalah tindakan paling revolusioner. Dengan kata-kata, kita
                                    membebaskan pikiran.”</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info">
                                <i class="material-icons text-gradient text-primary text-3xl">flip_to_front</i>
                                <h5 class="font-weight-bolder mt-3">— George R.R. Martin</h5>
                                <p class="pe-3">“Seseorang yang membaca akan hidup berkali-kali; yang tidak membaca
                                    hanya sekali.”</p>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-start mt-5">
                        <div class="col-md-6 mt-3">
                            <i class="material-icons text-gradient text-primary text-3xl">book</i>
                            <h5 class="font-weight-bolder mt-3">— Ali bin Abi Thalib</h5>
                            <p class="pe-5">“Ilmu pengetahuan akan menjaga pemiliknya, ketika harta hanya dijaga oleh
                                pemiliknya.”</p>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="info">
                                <i class="material-icons text-gradient text-primary text-3xl">devices</i>
                                <h5 class="font-weight-bolder mt-3">— Marcus Tullius Cicero</h5>
                                <p class="pe-3">“Perpustakaan adalah tempat di mana pikiran datang untuk beristirahat
                                    dan jiwa menemukan cahaya.”</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<footer class="bg-light pt-5 pb-4 mt-5 border-top">
    <div class="container text-center">
        <p class="mb-3 text-muted" style="font-size: 15px;">
            Layanan perpustakaan digital untuk mengdukung kemudahan akses peminjaman buku anda
        </p>
        <p class="fw-bold mb-2" style="font-size: 16px; color:#444;">
            Ikuti Politeknik Takumi
        </p>
        <div class="d-flex justify-content-center gap-4 mb-4">
            <a href="#" class="text-danger" style="font-size: 28px;"><i class="bi bi-instagram"></i></a>
            <a href="#" class="text-danger" style="font-size: 28px;"><i class="bi bi-tiktok"></i></a>
            <a href="#" class="text-danger" style="font-size: 28px;"><i class="bi bi-youtube"></i></a>
        </div>
        <div class="text-muted" style="font-size: 14px;">
            © 2025 EPERPUS<span class="text-danger">
        </div>

    </div>
</footer>
<script>
const chatBox = document.getElementById("chat-box");
const input = document.getElementById("user-input");
const btn = document.getElementById("send-btn");
const API_URL = "http://localhost:3000/chat";

/* ========= ADD MESSAGE ========= */
function addMessage(content, type = "bot") {
    const div = document.createElement("div");
    div.className = "message " + (type === "bot" ? "bot-message" : "user-message");

    if (type === "bot") {
        div.innerHTML = `
      <div class="bot-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
	<g fill="none">
		<path d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z" />
		<path fill="#fff" d="M9.107 5.448c.598-1.75 3.016-1.803 3.725-.159l.06.16l.807 2.36a4 4 0 0 0 2.276 2.411l.217.081l2.36.806c1.75.598 1.803 3.016.16 3.725l-.16.06l-2.36.807a4 4 0 0 0-2.412 2.276l-.081.216l-.806 2.361c-.598 1.75-3.016 1.803-3.724.16l-.062-.16l-.806-2.36a4 4 0 0 0-2.276-2.412l-.216-.081l-2.36-.806c-1.751-.598-1.804-3.016-.16-3.724l.16-.062l2.36-.806A4 4 0 0 0 8.22 8.025l.081-.216zM19 2a1 1 0 0 1 .898.56l.048.117l.35 1.026l1.027.35a1 1 0 0 1 .118 1.845l-.118.048l-1.026.35l-.35 1.027a1 1 0 0 1-1.845.117l-.048-.117l-.35-1.026l-1.027-.35a1 1 0 0 1-.118-1.845l.118-.048l1.026-.35l.35-1.027A1 1 0 0 1 19 2" />
	</g>
</svg></div>
      <div class="bot-text">${content}</div>
    `;
    } else {
        div.innerHTML = `
      <div class="user-text">${content}</div>
      <div class="user-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
	<circle cx="12" cy="6" r="4" fill="#fff" />
	<path fill="#fff" d="M20 17.5c0 2.485 0 4.5-8 4.5s-8-2.015-8-4.5S7.582 13 12 13s8 2.015 8 4.5" />
</svg></div>
    `;
    }

    chatBox.appendChild(div);

    requestAnimationFrame(() => {
        chatBox.scrollTop = chatBox.scrollHeight;
    });
}

/* ========= TYPING LOADER ========= */
function addTyping() {
    if (document.getElementById("typing")) return;

    const div = document.createElement("div");
    div.className = "message bot-message";
    div.id = "typing";
    div.innerHTML = `
    <div class="bot-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
	<g fill="none">
		<path d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z" />
		<path fill="#fff" d="M9.107 5.448c.598-1.75 3.016-1.803 3.725-.159l.06.16l.807 2.36a4 4 0 0 0 2.276 2.411l.217.081l2.36.806c1.75.598 1.803 3.016.16 3.725l-.16.06l-2.36.807a4 4 0 0 0-2.412 2.276l-.081.216l-.806 2.361c-.598 1.75-3.016 1.803-3.724.16l-.062-.16l-.806-2.36a4 4 0 0 0-2.276-2.412l-.216-.081l-2.36-.806c-1.751-.598-1.804-3.016-.16-3.724l.16-.062l2.36-.806A4 4 0 0 0 8.22 8.025l.081-.216zM19 2a1 1 0 0 1 .898.56l.048.117l.35 1.026l1.027.35a1 1 0 0 1 .118 1.845l-.118.048l-1.026.35l-.35 1.027a1 1 0 0 1-1.845.117l-.048-.117l-.35-1.026l-1.027-.35a1 1 0 0 1-.118-1.845l.118-.048l1.026-.35l.35-1.027A1 1 0 0 1 19 2" />
	</g>
</svg></div>
    <div class="bot-text">
      <div class="typing-wrapper">
        <span class="typing-dot"></span>
        <span class="typing-dot"></span>
        <span class="typing-dot"></span>
      </div>
    </div>
  `;

    chatBox.appendChild(div);
    chatBox.scrollTop = chatBox.scrollHeight;
}

function removeTyping() {
    const t = document.getElementById("typing");
    if (t) t.remove();
}

/* ========= GREETING ========= */
window.addEventListener("load", async () => {
    try {
        const res = await fetch("http://localhost:3000/greeting");
        const data = await res.json();
        addMessage(data.reply, "bot");
    } catch {
        addMessage("Halo! Saya Takumi AI 👋", "bot");
    }
});

/* ========= SEND MESSAGE ========= */
async function sendMessage() {
    const msg = input.value.trim();
    if (!msg) return;

    addMessage(msg, "user");
    input.value = "";
    addTyping();

    try {
        const res = await fetch(API_URL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                message: msg
            })
        });

        const data = await res.json();
        removeTyping();
        addMessage(data.reply, "bot");
    } catch {
        removeTyping();
        addMessage("⚠️ Server sedang sibuk, coba lagi ya.", "bot");
    }
}

/* ========= EVENTS ========= */
btn.addEventListener("click", sendMessage);
input.addEventListener("keydown", e => {
    if (e.key === "Enter") sendMessage();
});

/* QUICK BUTTON */
function sendQuick(text) {
    input.value = text;
    sendMessage();
}
</script>
<?php include('./admin/layouts/footer.php');?>