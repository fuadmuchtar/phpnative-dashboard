<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: login');
};

if (!isset($_SESSION['name'])) {
    $user = $_COOKIE['nm'];
} else {
    $user = $_SESSION['name'];
};

require 'functions.php';

$page = $_GET['page'];

if ($_GET['page'] == 'jadwal') {
    $add_jadwal = true;
    $active = 'active';
};

if ($_GET['page'] == 'tugas') {
    $add_tugas = true;
    $active2 = 'active';
};

if ($_GET['page'] == 'catatan') {
    $add_catatan = true;
    $active3 = 'active';
};

// submit act

if (isset($_POST['add-jadwal'])) {
    if (add($_POST, $page) > 0) {
        header('Location: jadwal');
    }
};

if (isset($_POST['add-tugas'])) {
    if (add($_POST, $page) > 0) {
        header('Location: tugas');
    }
};

if (isset($_POST['add-catatan'])) {
    if (add($_POST, $page) > 0) {
        header('Location: catatan');
    }
};

$matkuls = query("SELECT * FROM jadwal")

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add - <?= ucwords($page);?></title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <!-- <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div> -->
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="dashboard">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Menu
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item <?= $active; ?>">
                <a class="nav-link" href="jadwal">
                    <i class="fas fa-fw fa-calendar-alt"></i>
                    <span>Jadwal</span></a>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item <?= $active2; ?>">
                <a class="nav-link" href="tugas">
                    <i class="fas fa-fw fa-clipboard-list"></i>
                    <span>Tugas</span></a>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item <?= $active3; ?>">
                <a class="nav-link" href="catatan">
                    <i class="fas fa-fw fa-book-open"></i>
                    <span>Catatan</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <nav class="navbar">
                        <h1 class="h6 mb-0 text-dark"><?= $hari . ", " . date("d F Y") ?></h1>
                    </nav>

                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Hi, <?= $user; ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="logout" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- PAGE ADD JADWAL -->

                <?php if (isset($add_jadwal)) : ?>
                    <!-- isi content -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <!-- Illustrations -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold">Tambah Jadwal</h6>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post" width="100%">
                                            <div class="form-group">
                                                <label for="hari_jadwal">Hari</label><br>
                                                <select name="hari_jadwal" id="hari_jadwal" class="custom-select" required>
                                                    <option selected disabled value="">- Pilih hari -</option>
                                                    <option value="Senin">Senin</option>
                                                    <option value="Selasa">Selasa</option>
                                                    <option value="Rabu">Rabu</option>
                                                    <option value="Kamis">Kamis</option>
                                                    <option value="Jumat">Jumat</option>
                                                    <option value="Sabtu">Sabtu</option>
                                                    <option value="Minggu">Minggu</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_jadwal">Jadwal</label>
                                                <input type="text" class="form-control" name="nama_jadwal" id="nama_jadwal" placeholder="apa jadwal anda?" required>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col">
                                                        <label for="waktu1">Dari jam: </label>
                                                        <input type="time" class="form-control" name="dari_jam" id="waktu1" placeholder="Waktu" required>
                                                    </div>
                                                    <div class="col">
                                                        <label for="waktu2">Sampai:</label>
                                                        <input type="time" class="form-control" name="sampai_jam" id="waktu2" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode_ruang">Ruangan</label><br>
                                                <input type="text" class="form-control" name="kode_ruang" id="kode_ruang" maxlength="20" placeholder="masukkan nama ruangan..">
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="add-jadwal">Tambah</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- PAGE ADD TUGAS -->
                <?php if (isset($add_tugas)) : ?>
                    <!-- isi content -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <!-- Illustrations -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold">Tambah Tugas</h6>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post" width="100%">
                                            <div class="form-group">
                                                <label for="mata_kuliah">Mata Kuliah</label><br>
                                                <select name="mata_kuliah" id="mata_kuliah" class="custom-select" required>
                                                    <option selected disabled value="">- Pilih mata kuliah -</option>
                                                    <?php foreach ($matkuls as $matkul) :?>
                                                        <option value="<?= $matkul['nama_mk']?>"><?= $matkul['nama_mk']?></option>
                                                        <?php endforeach;?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="judul_tugas">Tugas</label>
                                                <textarea class="form-control" name="judul_tugas" id="judul_tugas" placeholder="apa tugas anda?" rows="2" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col">
                                                        <label for="deadline">Deadline </label>
                                                        <input type="date" class="form-control" name="deadline" id="deadline" placeholder="Deadline" required>
                                                    </div>
                                                    <div class="col">
                                                        <label for="waktu">Waktu</label>
                                                        <input type="time" class="form-control" name="waktu" id="waktu" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="add-tugas">Tambah</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- PAGE ADD CATATAN -->
                <?php if (isset($add_catatan)) : ?>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6 mb-4">

                                <!-- Illustrations -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold">Tambah Catatan</h6>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post" width="100%">
                                            <div class="form-group">
                                                <label for="nama_cat">Nama Catatan</label>
                                                <input type="text" class="form-control" name="nama_cat" id="nama_cat" maxlength="50" placeholder="mau diberi apa namanya?" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="keterangan_cat">Keterangan</label>
                                                <textarea class="form-control" name="keterangan_cat" id="keterangan_cat" placeholder="masukkan keterangan..." rows="5"></textarea>
                                            </div>
                                            <input type="hidden" name="dibuat_cat" value="">
                                            <button type="submit" class="btn btn-primary" name="add-catatan">Tambah</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Fuad_much 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <!-- Added script -->

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

</body>

</html>