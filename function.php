<?php
session_start();

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_nilai");
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// Menambahkan nilai
if (isset($_POST['nilaimasuk'])) {
  $namamhs = mysqli_real_escape_string($conn, $_POST['namamhs']);
  $nilaimhs = mysqli_real_escape_string($conn, $_POST['nilai']);
  $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);

  // Memasukkan data ke tabel mahasiswa
  $query1 = "INSERT INTO mahasiswa(namamhs, tanggal) VALUES ('$namamhs', '$tanggal')";
  $result1 = mysqli_query($conn, $query1);

  if ($result1) {
    $idmhs = mysqli_insert_id($conn); // Mendapatkan ID mahasiswa yang baru ditambahkan
    $query2 = "INSERT INTO nilai(idmhs, nilaimhs) VALUES ('$idmhs', '$nilaimhs')";
    $result2 = mysqli_query($conn, $query2);

    if ($result2) {
      header("location:index.php");
    } else {
      echo 'Gagal menambahkan nilai';
      header('location:index.php');
    }
  } else {
    echo 'Gagal menambahkan mahasiswa';
    header('location:index.php');
  }
}

// Update Info
if (isset($_POST['updatenilai'])) {
  $idmhs = $_POST['idmhs'];
  $namamhs = mysqli_real_escape_string($conn, $_POST['namamhs']);
  $nilaimhs = mysqli_real_escape_string($conn, $_POST['nilaimhs']);
  $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);

  $update = mysqli_query($conn, "UPDATE mahasiswa SET namamhs='$namamhs', tanggal='$tanggal' WHERE idmhs='$idmhs'");
  if ($update) {
    $updateNilai = mysqli_query($conn, "UPDATE nilai SET nilaimhs='$nilaimhs' WHERE idmhs='$idmhs'");
    if ($updateNilai) {
      header('location:index.php');
    } else {
      echo 'Gagal memperbarui nilai';
      header('location:index.php');
    }
  } else {
    echo 'Gagal memperbarui mahasiswa';
    header('location:index.php');
  }
}

// Delete Info
if (isset($_POST['deletenilai'])) {
  $idmhs = $_POST['idmhs'];

  $deleteNilai = mysqli_query($conn, "DELETE FROM nilai WHERE idmhs='$idmhs'");
  if ($deleteNilai) {
    $deleteMahasiswa = mysqli_query($conn, "DELETE FROM mahasiswa WHERE idmhs='$idmhs'");
    if ($deleteMahasiswa) {
      header('location:index.php');
    } else {
      echo 'Gagal menghapus mahasiswa';
      header('location:index.php');
    }
  } else {
    echo 'Gagal menghapus nilai';
    header('location:index.php');
  }
}

if (isset($_POST['tambahnilai'])) {
  $idmhs = $_POST['namanya'];
  $tambahnilai = $_POST['nilaitambah'];

  // Cek apakah sudah ada nilai untuk idmhs ini
  $cekNilai = mysqli_query($conn, "SELECT idnilai FROM nilai WHERE idmhs='$idmhs'");
  if ($row = mysqli_fetch_assoc($cekNilai)) {
    $idnilai = $row['idnilai']; // Menggunakan ID nilai yang sudah ada

    // Memperbarui nilai di tabel nilai
    $updateNilai = "UPDATE nilai SET nilaimhs=nilaimhs + $tambahnilai WHERE idmhs='$idmhs'";
    if (mysqli_query($conn, $updateNilai)) {
      echo "<script>alert('Nilai berhasil diperbarui!');</script>";
    } else {
      echo "<script>alert('Error saat memperbarui nilai: " . mysqli_error($conn) . "');</script>";
    }
  } else {
    // Membuat nilai baru di tabel nilai jika belum ada
    $queryInsertNilai = "INSERT INTO nilai (idmhs, nilaimhs) VALUES ('$idmhs', '$tambahnilai')";
    if (mysqli_query($conn, $queryInsertNilai)) {
      $idnilai = mysqli_insert_id($conn); // Mendapatkan ID nilai yang baru dibuat
      echo "<script>alert('Nilai berhasil ditambahkan!');</script>";
    } else {
      echo "<script>alert('Error saat membuat nilai baru: " . mysqli_error($conn) . "');</script>";
    }
  }
}



