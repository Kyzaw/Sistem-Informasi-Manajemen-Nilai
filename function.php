<?php
session_start();

// Connect to database
$conn = mysqli_connect("localhost", "root", "", "500ribu");
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
  $query1 = "INSERT INTO mahasiswa(namamhs, nilaimhs, tanggal) VALUES ('$namamhs', '$nilaimhs', '$tanggal')";
  $result1 = mysqli_query($conn, $query1);

  if ($result1) {
    header("location:index.php");
  } else {
    echo 'gagal mulu';
    header('location:index.php');
  }

}


//Update Info
if(isset($_POST['updatenilai'])){
  $idmhs = $_POST['idmhs'];
  $namamhs = $_POST['namamhs'];
  $nilaimhs = $_POST['nilai'];
  $tanggal = $_POST['tanggal'];

  $update = mysqli_query($conn,"update mahasiswa set namamhs='$namamhs', nilai='$nilaimhs', tanggal='$tanggal' where idmhs ='$idmhs'");
  if ($update) {
    header('location:index.php');
  }else {
    echo 'Gagal';
    header('location:index.php');
  }
}

//Delete Info
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

//Tambah Nilai
if(isset($_POST['tambahnilai'])){
  $idmhs = $_POST['idnya'];
  $namanya = $_POST['namanya'];
  $nilaimasuk = $_POST['nilaimasuk'];

  $ceknilai = mysqli_query($conn,"select * from mahasiswa where namamhs='$namanya'");
  $ambildatanya = mysqli_fetch_array($ceknilai);

  $nilaisekarang = $ambildatanya["nilaimhs"];
  $tambahkannilai = $nilaisekarang+$nilaimasuk;

  $nilaimasuk = "INSERT INTO nilai(idmhs, nilaimasuk) VALUES ('$idnya','$nilaimasuk')";
  $updatenilai = mysqli_query($conn,"update mahasiswa set nilaimhs='$tambahkannilai'where idmhs='$idnya'");
  if ($nilaimasuk&&$updatenilai) {
    header("location:index.php");
  } else {
    echo 'gagal mulu';
    header('location:index.php');
  }

}