<header class="bg-gradient-dark">
    <div class="page-header min-vh-10" style="background-image: url('./assets/img/bg9.jpg');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 text-center mx-auto my-auto">
                    <h1 class="text-white">EPERPUS</h1>
                    <p class="lead mb-4 text-white opacity-8"></p>
                    <h6 class="text-white mb-2 mt-5"></h6>
                </div>
            </div>
</header>
<nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3 navbar-transparent">
    <div class="container">
        <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
            data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0 ms-lg-12 ps-lg-5" id="navigation">
            <ul class="navbar-nav navbar-nav-hover ms-auto">
                <li class="nav-item dropdown dropdown-hover mx-2 ms-lg-6">
                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuPages2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="material-icons opacity-6 me-2 text-md">dashboard</i>
                        Pages
                        <img src="./assets/img/down-arrow-white.svg" alt="down-arrow"
                            class="arrow ms-auto ms-md-2 d-lg-block d-none">
                        <img src="./assets/img/down-arrow-dark.svg" alt="down-arrow"
                            class="arrow ms-auto ms-md-2 d-lg-none d-block">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-animation" aria-labelledby="dropdownMenuPages2">
                        <li>
                            <a class="dropdown-item <?= $page == 'home_anggota' ? 'active' : '' ?>"
                                href="app_anggota?page=home_anggota">
                                <i class="material-icons opacity-6 me-2 text-md">home</i>
                                Home
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= $page == 'buku_anggota' ? 'active' : '' ?>"
                                href="app_anggota?page=buku_anggota">
                                <i class="material-icons opacity-6 me-2 text-md">table_view</i>
                                Books
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= $page == 'peminjaman_anggota' ? 'active' : '' ?>"
                                href="app_anggota?page=peminjaman_anggota">
                                <i class="material-icons opacity-6 me-2 text-md">format_textdirection_r_to_l</i>
                                Riwayat peminjaman
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown dropdown-hover mx-2">
                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuBlocks"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="material-icons opacity-6 me-2 text-md">view_day</i>
                        Akun
                        <img src="./assets/img/down-arrow-white.svg" alt="down-arrow"
                            class="arrow ms-auto ms-md-2 d-lg-block d-none">
                        <img src="./assets/img/down-arrow-dark.svg" alt="down-arrow"
                            class="arrow ms-auto ms-md-2 d-lg-none d-block">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-animation" aria-labelledby="dropdownMenuPages2">
                        <li>
                            <a class="dropdown-item <?= $page == 'profile_anggota' ? 'active' : '' ?>"
                                href="app_anggota?page=profile_anggota">
                                <i class="material-icons opacity-6 me-2 text-md">table_view</i>
                                Profile
                            </a>
                        </li>
                        <li class="nav-item my-auto ms-3 ms-lg-0">
                            <a href="logout" class="btn btn-sm bg-white mb-0 me-1 mt-2 mt-md-0">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="d-flex align-items-center ms-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchModal">
                Search Buku
            </button>
        </div>

    </div>
</nav>