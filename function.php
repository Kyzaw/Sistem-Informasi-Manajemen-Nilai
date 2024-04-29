<?php
session_start();

// Connect to database
$conn = mysqli_connect("localhost", "root", "", "nilai500");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// menambahkan nilai
if (isset($_POST['tambahnilai'])) {
  $namamhs = $_POST['namamhs'];
  $nilaimhs = $_POST['nilai'];
  $tanggal = $_POST['tanggal'];

  $namamhs = mysqli_real_escape_string($conn, $namamhs);
  $nilaimhs = mysqli_real_escape_string($conn, $nilai);
  $tanggal = mysqli_real_escape_string($conn, $tanggal);

  // Insert into database
  $query = "INSERT INTO mahasiswa (namamhs, nilai, tanggal) VALUES ('$namamhs', '$nilaimhs',)";
  $result = mysqli_query($conn, $query);

  if ($result) {
    header('Location: index.php');
    exit;
  } else {
    echo 'Gagal menambahkan data: ' . mysqli_error($conn);
  }
}

//Update Nilai
if(isset($_POST['updatenilai'])){
  $idmhs = $_POST['idmhs'];
  $namamhs = $_POST['namamhs'];
  $nilai = $_POST['nilai'];
  $tanggal = $_POST['tanggal'];

  $update = mysqli_query($conn,"update mahasiswa set namamhs='$namamhs', nilai='$nilai', tanggal='$tanggal' where idmhs ='$idmhs'");
  if ($update) {
    header('location:index.php');
  }else {
    echo 'Gagal';
    header('location:index.php');
  }
}

//Delete Nilai
if(isset($_POST['deletenilai'])){
  $idmhs = $_POST['idmhs'];

  $delete = mysqli_query($conn,"delete from mahasiswa where idmhs='$idmhs'");
  if ($delete) {
    header('location:index.php');
  } else {
    echo 'Gagal';
    header('location:index.php');
  }
}