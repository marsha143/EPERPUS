<?php include("./config/db.php"); ?>
<?php include('./layouts/header.php'); ?>
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
                    <h1 class="text-white pt-3 mt-n5">EPERPUS</h1>
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
<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 ms-auto">
                <h4 class="mb-1">Thank you for your support!</h4>
            </div>
        </div>

<?php include('./layouts/footer.php');?>