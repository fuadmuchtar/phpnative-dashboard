<?php 
require 'functions.php';

$id = $_GET['id'];
$status = $_GET['stts'];

if($status == 'y'){
    global $conn;

    mysqli_query($conn, "UPDATE tugas set status_tugas = 'sudah' WHERE id = $id");
    header('Location: menu.php?page=tugas');
    exit;
};

if($status == 'n'){
    global $conn;

    mysqli_query($conn, "UPDATE tugas set status_tugas = 'belum' WHERE id = $id");
    header('Location: menu.php?page=tugas');
    exit;
};

if($status == 'z'){
    global $conn;

    mysqli_query($conn, "UPDATE tugas set status_tugas = 'sudah' WHERE id = $id");
    header('Location: index.php');
    exit;
};

?>