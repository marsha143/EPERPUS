<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/apple-icon.png">
    <link rel="apple-touch-icon" sizes="76x76" href="asset/img/apple-icon.png">
    <link rel="icon" type="image/png" href="asset/img/apple-icon.png">
    <title>
        EPERPUS
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="asset/css/nucleo-icons.css" rel="stylesheet" />
    <link href="asset/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="/assets/css/material-kit.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.5/dist/dotlottie-wc.js" type="module"></script>
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</head>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.ai-chat-section {
  background: linear-gradient(to bottom, #fcfcfe, #fcfcfe);
}

.ai-bot-img {
  width: 160px;
  animation: float 3s ease-in-out infinite;
}

@keyframes float {
  0% { transform: translateY(0); }
  50% { transform: translateY(-8px); }
  100% { transform: translateY(0); }
}

/* ====== TEMA DASAR AI ====== */
.ai-theme {
  border-radius: 18px;
  background: #ffffff;
}

/* HEADER CHAT (MENIRU AI BIRU) */
/* HEADER */
.ai-header {
  background: linear-gradient(135deg, #ec407a, #d81b60);
  padding: 14px;
  border-radius: 16px;
}

.ai-icon {
  background: rgba(255,255,255,0.2);
  padding: 8px;
  border-radius: 50%;
  color: white;
}

/* CHAT AREA */
.chat-area {
  height: 320px;
  overflow-y: auto;
}

/* AI MESSAGE */
.ai-message {
  background: #F1E7E7;
  padding: 14px 16px;
  border-radius: 16px;
  margin-bottom: 12px;
  max-width: 90%;
  color: #444;
}

/* USER MESSAGE */
.user-message {
  background: #ec407a;
  color: white;
  padding: 14px 16px;
  border-radius: 16px;
  margin-bottom: 12px;
  max-width: 90%;
  margin-left: auto;
}

/* POPULAR BUTTON */
.popular-btn {
  background: #fce4ec;
  border: none;
  border-radius: 12px;
  padding: 10px;
  font-size: 14px;
  transition: 0.2s;
}

.popular-btn:hover {
  background: #f8bbd0;
}

.ai-icon {
  background: rgba(255,255,255,0.2);
  padding: 6px 8px;
  border-radius: 50%;
  margin-right: 6px;
}
.book-cover img {
  max-width: 120px;
  border-radius: 10px;
  margin: 8px 0;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}



.lottie-buku {
    display: block;
    margin: 0 auto;
    transform: translateX(20px);
}
footer a {
    text-decoration: none;
    transition: 0.3s;
}

footer a:hover {
    opacity: 0.6;
    transform: translateY(-3px);
}


.popular-questions {
    margin-bottom: 14px;
}

.popular-label {
    font-size: 0.85rem;
    color: #6b7280;
    margin-bottom: 6px;
}

.popular-btn {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e1e4f0;
    padding: 8px 10px;
    font-size: 0.85rem;
    text-align: left;
    display: flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
    transition: all 0.15s ease;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.popular-btn:hover {
    border-color: #ff4b8f;         
    box-shadow: 0 6px 16px rgba(15, 23, 42, 0.08);
    transform: translateY(-1px);
}
.text-pink {
    color: #e91e63 ;
}
.navbar-nav .nav-link {
    position: relative;
    z-index: 1;
}
.hero {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(180deg, #ffd6df, #fbe4ea);
}

.hero-card {
    background: rgba(255,255,255,0.85);
    padding: 50px 60px;
    border-radius: 30px;
    text-align: center;
    max-width: 700px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.15);
    animation: fadeUp 1s ease;
}

.hero-card h1 {
    font-size: 36px;
    color: #b06b78;
    margin-bottom: 5px;
}

.hero-card h2 {
    font-size: 24px;
    color: #c38c98;
    margin-bottom: 20px;
}

.hero-card p {
    color: #666;
    font-size: 16px;
    margin-bottom: 30px;
}

.btn-daftar {
    display: inline-block;
    background: #d87c8c;
    color: #fff;
    padding: 14px 35px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}

.btn-daftar:hover {
    background: #c56a79;
    transform: translateY(-3px);
}

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}


</style>
</head>

<body class="index-page bg-gray-200">