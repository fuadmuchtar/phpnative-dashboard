<?php
date_default_timezone_set('Asia/Jakarta');
$conn = mysqli_connect('localhost', 'root', '', 'pj_phpnative_dashboard');
// $conn = mysqli_connect('sql105.infinityfree.com', 'if0_35064849', 'uplOad1', 'if0_35064849_db_pendidikanku');


$query = "";
lewat($query);
$tgl = date("D");
$hari = nama_hari($tgl);
$date = date('Y-m-d');

function nama_hari($tgl = '')
{
    $hari = date('D', strtotime($tgl));

    // membuat array hari
    $nama_hari = [
        "Sun" => "Minggu",
        "Mon" => "Senin",
        "Tue" => "Selasa",
        "Wed" => "Rabu",
        "Thu" => "Kamis",
        "Fri" => "Jumat",
        "Sat" => "Sabtu"
    ];
    return $nama_hari[$hari];
};

function query($query)
{
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
};

function add($data, $page)
{
    global $conn;

    $page = $_GET['page'];

    if ($page == 'jadwal') {
        $hari = $data['hari_jadwal'];
        $jadwal = $data['nama_jadwal'];
        $jam1 = $data['dari_jam'];
        $jam2 = $data['sampai_jam'];
        $ruang = htmlspecialchars(strtoupper($data['kode_ruang']));

        mysqli_query($conn, "INSERT INTO jadwal VALUES(
            '', '$hari', '$jadwal', '$jam1', '$jam2', '$ruang', '' 
        );");

        return mysqli_affected_rows($conn);
    };

    if ($page == 'tugas') {
        $mk = htmlspecialchars(ucwords($data['mata_kuliah']));
        $judul_tugas = htmlspecialchars(ucfirst($data['judul_tugas']));
        //$keterangan_tugas = htmlspecialchars($data['keterangan_tugas']);
        $deadline = $data['deadline'];
        $waktu = $data['waktu'];
        $status = 'belum';

        mysqli_query($conn, "INSERT INTO tugas VALUES (
        '', '$mk', '$judul_tugas', '', '$deadline', '$waktu', '$status'
        );");

        return mysqli_affected_rows($conn);
    };

    if ($page == 'catatan') {
        $nama_cat = htmlspecialchars(ucwords($data['nama_cat']));
        $ket_cat = htmlspecialchars(ucfirst($data['keterangan_cat']));
        $dibuat = date('Y-m-d H:i:s');

        //$tggl_cat = $data['dibuat_cat'];

        mysqli_query($conn, "INSERT INTO catatan VALUES (
        '', '$nama_cat', '$ket_cat', '$dibuat'
        );");

        return mysqli_affected_rows($conn);
    }
}

function edit($data, $page)
{
    global $conn;

    $page = $_GET['page'];

    if ($page == 'tugas') {
        $id = $data['id'];
        $matkul_tugas = htmlspecialchars($data['mk_tugas']);
        $judul_tugas = htmlspecialchars($data['judul_tugas']);
        $deadline = $data['deadline'];
        $waktu = $data['waktu'];

        $query = "UPDATE tugas SET
        mk_tugas = '$matkul_tugas',
        jdl_tugas = '$judul_tugas',
        deadline_tugas = '$deadline',
        waktu_tugas = '$waktu'
        WHERE id = $id
        ";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    };

    if ($page == 'catatan') {
        $id = $data['id'];
        $nama_cat = htmlspecialchars($data['nama_cat']);
        $keterangan_cat = htmlspecialchars($data['keterangan_cat']);

        $query = "UPDATE catatan SET
        nama_cat = '$nama_cat',
        keterangan_cat = '$keterangan_cat'
        WHERE id = $id
        ";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    };
}

function hapus($id, $page)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM $page WHERE id = $id");

    return mysqli_affected_rows($conn);
};

function lewat($query)
{
    global $conn;

    $date = date('Y-m-d');
    $waktu = date('H:i');
    $query = "UPDATE tugas SET status_tugas = 'lewat' WHERE status_tugas = 'belum' AND deadline_tugas <= '$date' AND waktu_tugas < '$waktu'";

    mysqli_query($conn, $query);
}

function signup($data)
{
    global $conn;

    $fName = htmlspecialchars(ucwords($data['fName']));
    $lName = htmlspecialchars(ucwords($data['lName']));
    $username = strtolower(stripslashes($data['username']));
    $password = mysqli_escape_string($conn, $data['password']);
    $password2 = mysqli_escape_string($conn, $data['password2']);
    $level = 'user';

    // cek username
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Username sudah terdaftar!');
              </script>";
        return false;
    };

    // cek password
    if ($password !== $password2) {
        echo "<script>
        alert('konfirmasi password tidak sesuai!');
        </script>";
        return false;
    };

    // encrypt password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // masukkan user
    mysqli_query($conn, "INSERT INTO users VALUES(
        '', '$fName', '$lName', '$username', '$password', '$level'
    );");

    return mysqli_affected_rows($conn);
};
