<?php
date_default_timezone_set('Asia/Jakarta');
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

$assignment = query("SELECT * FROM tugas WHERE status_tugas = 'belum' ORDER BY deadline_tugas, waktu_tugas");
$schedule = query("SELECT * FROM jadwal WHERE hari_mk = '$hari' ORDER BY dari_jam");
$notes = query("SELECT * FROM catatan ORDER BY dibuat_cat DESC");

$menanti = count(query("SELECT * FROM tugas WHERE status_tugas = 'belum'"));
$lewat = count(query("SELECT * FROM tugas WHERE status_tugas = 'lewat'"));
$selesai = count(query("SELECT * FROM tugas WHERE status_tugas = 'sudah'"));
$total = count(query("SELECT * FROM tugas"));

count($schedule) > 0 ? $show = true : $noshow = true;
count($assignment) > 0 ? $isi = true : $kosong = true;
count($notes) > 0 ? $adanotes = true : $nonotes = true;

if (date("Y")>2023){
    $cp = true;
};

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>My Dashboard</title>

    <!-- Custom fonts for this template-->
    <link
      href="vendor/fontawesome-free/css/all.min.css"
      rel="stylesheet"
      type="text/css"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet"
    />

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet" />
  </head>

  <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
      <ul
        class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled"
        id="accordionSidebar"
      >
        <!-- Sidebar - Brand -->
        <a
          class="sidebar-brand d-flex align-items-center justify-content-center"
          href="dashboard"
        >
          <div class="sidebar-brand-icon">
            <i class="fas fa-graduation-cap"></i>
          </div>
          <!-- <div class="sidebar-brand-text mx-3"><sup></sup></div> -->
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0" />

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
          <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span></a
          >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <!-- Heading -->
        <div class="sidebar-heading">Menu</div>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
          <a class="nav-link" href="jadwal">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Jadwal</span></a
          >
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
          <a class="nav-link" href="tugas">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Tugas</span></a
          >
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
          <a class="nav-link" href="catatan">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Catatan</span></a
          >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block" />

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
          <nav
            class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
          >
            <!-- Sidebar Toggle (Topbar) -->
            <button
              id="sidebarToggleTop"
              class="btn btn-link d-md-none rounded-circle mr-3"
            >
              <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Navbar -->
            <nav class="navbar">
              <h1 class="h6 mb-0 text-dark">
                <?= $hari . ", " . date("d F Y") ?>
              </h1>
            </nav>

            <ul class="navbar-nav ml-auto">
              <div class="topbar-divider d-none d-sm-block"></div>

              <!-- Nav Item - User Information -->
              <li class="nav-item dropdown no-arrow">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="userDropdown"
                  role="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small"
                    >Hi,
                    <?= $user; ?></span
                  >
                  <img
                    class="img-profile rounded-circle"
                    src="img/undraw_profile.svg"
                  />
                </a>
                <!-- Dropdown - User Information -->
                <div
                  class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                  aria-labelledby="userDropdown"
                >
                  <a
                    class="dropdown-item"
                    href="logout"
                    data-toggle="modal"
                    data-target="#logoutModal"
                  >
                    <i
                      class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"
                    ></i>
                    Logout
                  </a>
                </div>
              </li>
            </ul>
          </nav>
          <!-- End of Topbar -->

          <!-- Begin Page Content -->
          <div class="container-fluid">
            <div class="d-flex">
              <div class="mr-auto p-2">
                <div
                  class="d-sm-flex align-items-center justify-content-between mb-4"
                >
                  <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                </div>
              </div>
            </div>

            <!-- Content Row -->
            <div class="row">
              <!-- Pending Requests Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div
                          class="text-xs font-weight-bold text-warning text-uppercase mb-1"
                        >
                          Tugas Menanti
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <?= $menanti ?>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i
                          class="fas fa-exclamation-circle fa-2x text-gray-300"
                        ></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div
                          class="text-xs font-weight-bold text-success text-uppercase mb-1"
                        >
                          Tugas Dikerjakan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <?= $selesai ?>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Pending Requests Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div
                          class="text-xs font-weight-bold text-danger text-uppercase mb-1"
                        >
                          Tugas Terlewatkan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <?= $lewat ?>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div
                          class="text-xs font-weight-bold text-primary text-uppercase mb-1"
                        >
                          Total Tugas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <?= $total; ?>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i
                          class="fas fa-clipboard-list fa-2x text-gray-300"
                        ></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Content Row -->

            <div class="row">
              <div class="col">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                  >
                    <h6 class="m-0 font-weight-bold text-primary">
                      Tugas Menanti
                    </h6>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="table-responsive">
                      <?php if (isset($isi)) : ?>
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Mata Kuliah</th>
                            <th scope="col">Tugas</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Waktu</th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($assignment as $row) : ?>
                          <tr>
                            <th scope="row"><?= $row['mk_tugas']; ?></th>
                            <td><?= $row['jdl_tugas']; ?></td>
                            <td>
                              <?= nama_hari(date("l", strtotime($row['deadline_tugas']))) . date(", d F Y", strtotime($row['deadline_tugas'])); ?>
                            </td>
                            <td>
                              <?= date("H:i", strtotime($row['waktu_tugas'])); ?>
                            </td>
                            <td>
                              <a
                                href="status?id=<?= $row['id'] ?>&stts=z"
                                class="btn btn-warning btn-sm"
                              >
                                <span class="icon text-white-50">
                                  <i class="fas fa-check"></i>
                                </span>
                              </a>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                      <?php endif; ?>
                      <?php if (isset($kosong)) : ?>
                      <p>Selamat, anda tidak ada tugas!</p>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <!-- Area Chart -->
              <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                  >
                    <h6 class="m-0 font-weight-bold text-primary">Catatan</h6>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <?php if (isset($adanotes)) : ?>
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Nama Catatan</th>
                          <th scope="col">Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($notes as $row2) : ?>
                        <tr>
                          <th class="col-4"><?= $row2['nama_cat']; ?></th>
                          <td><?= $row2['keterangan_cat']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                    <?php endif; ?>
                    <?php if (isset($nonotes)) : ?>
                    <p>Tidak ada catatan...</p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <!-- Pie Chart -->
              <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                  >
                    <h6 class="m-0 font-weight-bold text-primary">
                      Jadwal Hari Ini
                    </h6>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <?php if (isset($show)) : ?>
                    <div class="text-center">
                      <h4>
                        <strong><?= $hari; ?></strong>
                      </h4>
                    </div>
                    <table class="table">
                      <?php foreach ($schedule as $sch) : ?>
                      <tr>
                        <th class="col-6">
                          <?= date("H:i", strtotime($sch['dari_jam'])) . " - " . date("H:i", strtotime($sch['sampai_jam'])) . " " . $sch['ruang_mk']; ?>
                        </th>
                        <td><?= $sch['nama_mk']; ?></td>
                      </tr>
                      <?php endforeach; ?>
                    </table>
                    <?php endif; ?>
                    <?php if (isset($noshow)) : ?>
                    <div class="text-center">
                      <p><strong>tidak ada jadwal</strong></p>
                    </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.container-fluid -->
          </div>
          <!-- End of Main Content -->
        </div>

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span
                >Copyright &copy; Fuad_much 2023<?php if(isset($cp)){echo " - " . date("Y");}?></span
              >
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
    <div
      class="modal fade"
      id="logoutModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button
              class="close"
              type="button"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            Select "Logout" below if you are ready to end your current session.
          </div>
          <div class="modal-footer">
            <button
              class="btn btn-secondary"
              type="button"
              data-dismiss="modal"
            >
              Cancel
            </button>
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
