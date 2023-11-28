<?php
date_default_timezone_set('Asia/Jakarta');
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: login');
};

if (!isset($_GET['page'])) {
    header('Location: jadwal');
};

if(!isset($_SESSION['name'])){
    $user = $_COOKIE['nm'];
}else{
    $user = $_SESSION['name'];
};

require 'functions.php';

$tgl = date("D");
$hari = nama_hari($tgl);

$page = $_GET['page'];

$schedule = query("SELECT * FROM jadwal ORDER BY CASE WHEN hari_mk = 'Senin' THEN 1
WHEN hari_mk = 'Selasa' THEN 2
WHEN hari_mk = 'Rabu' THEN 3
WHEN hari_mk = 'Kamis' THEN 4
WHEN hari_mk = 'Jumat' THEN 5
WHEN hari_mk = 'Sabtu' THEN 6
WHEN hari_mk = 'Minggu' THEN 7
END ASC, dari_jam");
$assignment = query("SELECT * FROM tugas ORDER BY CASE WHEN status_tugas = 'belum' THEN 1
WHEN status_tugas = 'sudah' THEN 2
WHEN status_tugas = 'lewat' THEN 3 END ASC, deadline_tugas");
$notes = query("SELECT * FROM catatan ORDER BY dibuat_cat DESC");

$page2 = ucfirst($page);

if ($_GET['page'] == 'jadwal') {
    $menu_jadwal = true;
    $active = 'active';
};

if ($_GET['page'] == 'tugas') {
    $menu_tugas = true;
    $active2 = 'active';
};

if ($_GET['page'] == 'catatan') {
    $menu_catatan = true;
    $active3 = 'active';
};

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="fuad_muchtar" content="">

    <title>Menu</title>

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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Hi, <?= $user;?></span>
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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Daftar <?= $page2; ?></h1>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <a href="add?page=<?= $page; ?>" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span class="text">Tambah Data</span>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <!-- Page Jadwal -->
                                <?php if (isset($menu_jadwal)) : ?>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Hari</th>
                                                <th>Jadwal</th>
                                                <th>Waktu</th>
                                                <th>Ruangan</th>
                                                <th> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($schedule as $sch) : ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $sch['hari_mk'] ?></td>
                                                    <td><?= $sch['nama_mk'] ?></td>
                                                    <td>
                                                        <?= date("H:i", strtotime($sch['dari_jam'])) ?> -
                                                        <?= date("H:i", strtotime($sch['sampai_jam'])) ?>
                                                    </td>
                                                    <td><?= $sch['ruang_mk'] ?></td>
                                                    <td>
                                                        <a href="hapus?page=jadwal&id=<?= $sch['id']; ?>" onclick="return confirm('Apakah anda ingin menghapus data?')" class="btn btn-danger">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-trash"></i>
                                                            </span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php endif; ?>

                                <!-- Page Tugas -->
                                <?php if (isset($menu_tugas)) : ?>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Mata Kuliah</th>
                                                <th>Tugas</th>
                                                <th>Deadline</th>
                                                <th>Waktu</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($assignment as $row) : ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td><?= $row['mk_tugas']; ?></td>
                                                    <td class="col-3"><?= $row['jdl_tugas']; ?></td>
                                                    <td><?= nama_hari(date("l", strtotime($row['deadline_tugas']))) . date(", d F Y", strtotime($row['deadline_tugas'])); ?></td>
                                                    <td><?= date("H:i", strtotime($row['waktu_tugas'])); ?></td>
                                                    <?php $status = $row['status_tugas']; ?>
                                                    <?php if ($status == 'sudah') : ?>
                                                    <?php
                                                        $hide = '';
                                                        $stts2 = 'success';
                                                    elseif ($status == 'belum') : ?>
                                                    <?php
                                                        $hide = '';
                                                        $stts2 = 'warning';
                                                    elseif ($status == 'lewat') : ?>
                                                        <?php
                                                        $hide = 'hidden';
                                                        $stts2 = 'danger'; ?>
                                                    <?php endif; ?>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-<?= $stts2; ?> dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <?= ucfirst($status); ?>
                                                            </button>
                                                            <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item" href="status?stts=y&id=<?= $row['id'] ?>">Sudah</a>
                                                                <div class="dropdown-divider" <?= $hide; ?>></div>
                                                                <a class="dropdown-item" href="status?stts=n&id=<?= $row['id'] ?>" <?= $hide ?>>Belum</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="edit?page=tugas&id=<?= $row['id']; ?>" class="btn btn-info">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-info-circle"></i>
                                                            </span>
                                                        </a> |
                                                        <a href="hapus?page=tugas&id=<?= $row['id']; ?>" onclick="return confirm('Apakah anda ingin menghapus data?')" class="btn btn-danger">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-trash"></i>
                                                            </span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php $i++ ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php endif; ?>

                                <?php if (isset($menu_catatan)) : ?>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th class="col-3">Nama Catatan</th>
                                                <th class="col-4">Keterangan</th>
                                                <th>Dibuat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($notes as $note) : ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td><?= $note['nama_cat']; ?></td>
                                                    <td><?= $note['keterangan_cat']; ?></td>
                                                    <td><?= nama_hari(date('l', strtotime($note['dibuat_cat']))) . date(', d F Y', strtotime($note['dibuat_cat'])); ?></td>
                                                    <td>
                                                        <a href="edit?page=catatan&id=<?= $note['id']; ?>" class="btn btn-info">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-info-circle"></i>
                                                            </span>
                                                        </a> |
                                                        <a href="hapus?page=catatan&id=<?= $note['id']; ?>" onclick="return confirm('Apakah anda ingin menghapus data?')" class="btn btn-danger">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-trash"></i>
                                                            </span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                    </div>

                    <!-- Content Row -->

                    <div class="row">

                    </div>

                    <!-- Content Row -->
                    <div class="row">

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

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

</body>

</html>