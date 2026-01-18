<body class="g-sidenav-show  bg-gray-200">
    <aside
        class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
        id="sidenav-main">
        <div class="sidenav-header">
            <a class="navbar-brand m-0">
                <img src="./assets/img/logo-takumi.png" class="navbar-brand-img h-100" alt="main_logo">
            </a>
        </div>
        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($page == 'home')
                        echo 'active bg-gradient-primary'; ?>" href="app?page=home">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">account_balance</i>
                        </div>
                        <span class="nav-link-text ms-1">Beranda</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($page == 'peminjaman')
                        echo 'active bg-gradient-primary'; ?>" href="app?page=peminjaman">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                        </div>
                        <span class="nav-link-text ms-1">Proses peminjaman</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($page == 'booking')
                        echo 'active bg-gradient-primary'; ?>" href="app?page=booking">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">event_note</i>

                        </div>
                        <span class="nav-link-text ms-1">Pemesanan Buku</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center
     <?= $Buku ? 'active bg-gradient-primary' : '' ?>" data-bs-toggle="collapse" href="#menuBuku" role="button"
                        aria-expanded="<?= $Buku ? 'true' : 'false' ?>" aria-controls="menuBuku">

                        <div class="d-flex align-items-center">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">menu_book</i>
                            </div>
                            <span class="nav-link-text ms-1">Buku</span>
                        </div>
                    </a>

                    <div class="collapse <?= $Buku ? 'show' : '' ?>" id="menuBuku">
                        <ul class="nav ms-4">
                            <li class="nav-item">
                                <a class="nav-link text-white <?= $page == 'buku' ? 'active' : '' ?>"
                                    href="app?page=buku">Daftar Buku</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white <?= $page == 'kondisi_buku' ? 'active' : '' ?>"
                                    href="app?page=kondisi_buku">Kondisi Buku</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white <?= $page == 'genre' ? 'active' : '' ?>"
                                    href="app?page=genre">Genre</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white <?= $page == 'penulis' ? 'active' : '' ?>"
                                    href="app?page=penulis">Penulis</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center
     <?= $Anggota ? 'active bg-gradient-primary' : '' ?>" data-bs-toggle="collapse" href="#menuAnggota" role="button"
                        aria-expanded="<?= $Anggota ? 'true' : 'false' ?>" aria-controls="menuAnggota">

                        <div class="d-flex align-items-center">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">group</i>
                            </div>
                            <span class="nav-link-text ms-1">Anggota</span>
                        </div>
                    </a>

                    <div class="collapse <?= $Anggota ? 'show' : '' ?>" id="menuAnggota">
                        <ul class="nav ms-4">
                            <li class="nav-item">
                                <a class="nav-link text-white <?= $page == 'anggota' ? 'active' : '' ?>"
                                    href="app?page=anggota">
                                    Data Anggota
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white <?= ($page=='anggota_request' && $view=='pendaftaran') ? 'active' : '' ?>"
                                    href="app?page=anggota_request&view=pendaftaran">
                                    Permohonan pendaftaran
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white <?= ($page=='anggota_request' && $view=='index') ? 'active' : '' ?>"
                                    href="app?page=anggota_request">
                                    Permohonan ubah profile
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link text-white" href="logout" class="nav-link text-body font-weight-bold px-0">
                        <i class="material-icons opacity-10">logout</i>
                        <span class="nav-link-text ms-1">Keluar</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">