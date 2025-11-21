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
                <?php $page = $_GET['page'] ?? 'home';?>
                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($page == 'home')
            echo 'active bg-gradient-primary'; ?>" href="app?page=home">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">account_balance</i>
                        </div>
                        <span class="nav-link-text ms-1">Home</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($page == 'buku')
            echo 'active bg-gradient-primary'; ?>" href="app?page=buku">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">table_view</i>
                        </div>
                        <span class="nav-link-text ms-1">Books</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($page == 'penulis')
            echo 'active bg-gradient-primary'; ?>" href="app?page=penulis">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Penulis</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($page == 'anggota')
            echo 'active bg-gradient-primary'; ?>" href="app?page=anggota">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Anggota</span>
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
                    <a class="nav-link text-white" href="logout" class="nav-link text-body font-weight-bold px-0">
                        <i class="material-icons opacity-10">dashboard</i>
                        <span class="nav-link-text ms-1">logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->