<?php
require 'functions.php';

$id = $_GET['id'];
$page = $_GET['page'];

if (hapus($id, $page) > 0) {
    header('Location: menu.php?page=' . $page);
};
?>