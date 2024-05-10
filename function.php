<?php
session_start();

// Connect to database
$conn = mysqli_connect("localhost", "root", "", "dbnilai");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// menambahkan nilai
if (isset($_POST['nilaimasuk'])) {
  $namamhs = $_POST['namamhs'];
  $nilaimhs = $_POST['nilai'];
  $tanggal = $_POST['tanggal'];

  $namamhs = mysqli_real_escape_string($conn, $namamhs);
  $nilaimhs = mysqli_real_escape_string($conn, $nilaimhs);
  $tanggal = mysqli_real_escape_string($conn, $tanggal);

  // Insert into database
  $query1 = "INSERT INTO mahasiswa(namamhs, tanggal) VALUES ('$namamhs', '$tanggal')";
  $result1 = mysqli_query($conn, $query1);

  if ($result1) {
    header("location:index.php");
  } else {
    echo 'gagal mulu';
    header('location:index.php');
  }

  $query2 = "INSERT INTO nilai(nilaimhs) VALUES ('$nilaimhs')";
  $result2 = mysqli_query($conn, $query2);

  if ($result) {
    header("location:index.php");
  } else {
    echo 'gagal mulu';
    header('location:index.php');
  }

}


//Update Info
if (isset($_POST['updatenilai'])) {
  $idmhs = $_POST['idmhs'];
  $namamhs = $_POST['namamhs'];
  $nilaimhs = $_POST['nilaimhs'];
  $tanggal = $_POST['tanggal'];

  $update = mysqli_query($conn, "update mahasiswa set namamhs='$namamhs', nilaimhs='$nilaimhs', tanggal='$tanggal' where idmhs ='$idmhs'");
  if ($update) {
    header('location:index.php');
  } else {
    echo 'Gagal';
    header('location:index.php');
  }
}

//Delete Info
if (isset($_POST['deletenilai'])) {
  $idmhs = $_POST['idmhs'];

  $delete = mysqli_query($conn, "delete from mahasiswa where idmhs='$idmhs'");
  if ($delete) {
    header('location:index.php');
  } else {
    echo 'Gagal';
    header('location:index.php');
  }
}

//Tambah Nilai
if (isset($_POST['tambahnilai'])) {
  $idmhs = $_POST['idmhs'];
  $nilaitambah = $_POST['nilaimasuk'];

  $idnya = mysqli_real_escape_string($conn, $idnya);
  $nilaitambah = mysqli_real_escape_string($conn, $nilaitambah);

  // Insert into database
  $query2 = "INSERT INTO nilai(idmhs, nilaimasuk) VALUES ('$idmhs', '$nilaitambah')";
  $result1 = mysqli_query($conn, $query2);

  if ($result1) {
    header("location:index.php");
  } else {
    echo 'gagal mulu';
    header('location:index.php');
  }
  
}