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
  $namamateri = $_POST['namamateri'];
  $nilaimhs = $_POST['nilai'];
  $tanggal = $_POST['tanggal'];

  $namamhs = mysqli_real_escape_string($conn, $namamhs);
  $namamateri = mysqli_real_escape_string($conn, $namamateri);
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

  $query2 = "INSERT INTO materi (namamateri) values ('$namamateri')";
  $result2 = mysqli_query($conn, $query2);

  if ($result2) {
    header("location:index.php");
  } else {
    echo "Gagal menambahkan data:" . mysqli_error($conn);
    header("location:index.php");
  }

}


//Update Nilai
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