<?php
require 'function.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">Sistem Informasi</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Nilai
                        </a>
                        <a class="nav-link" href="chart.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Diagram
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                        </div>

                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Nilai Praktikum</h1>
                    <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Perancangan Basis Data</li>
                        </ol>
                    <div class="container mt-3">
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                    Masukan Nilai
                                </button>
                                <br><br>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Materi</th>
                                        <th>Nilai</th>
                                        <th>Tanggal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                // Assuming the relationships between tables are:
                                // mahasiswa.idmhs = nilai.idmhs
                                // nilai.idmateri = materi.idmateri
                                
                                $query = "SELECT * from mahasiswa 
                                        INNER JOIN materi ON materi.kdmateri
                                        INNER JOIN nilai ON nilai.tanggal
                                        ";

                                $result = mysqli_query($conn, $query);

                                if (!$result) {
                                    die("Query failed: " . mysqli_error($conn));
                                }

                                $i = 1;
                                while ($data = mysqli_fetch_array($result)) {
                                    $namamhs = $data['namamhs'];
                                    $namamateri = $data['namamateri'];
                                    $nilaimhs = $data['nilaimhs'];
                                    $tanggal = $data['tanggal'];
                                    $idmhs = $data['idmhs'];

                                    ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $namamhs ?></td>
                                        <td><?= $namamateri ?></td>
                                        <td><?= $nilaimhs ?></td>
                                        <td><?= $tanggal ?></td>
                                    <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#edit<?=$idmhs;?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete<?=$idmhs;?>">
                                                Delete
                                            </button>
                                        </td>
                                       
                                    </tr>
                                    <!--Edit Modal -->
                                    <div class="modal fade" id="edit<?=$idmhs;?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <form method="post">
                                                    <div class="modal-body">
                                                        <input type="text" name="namamhs" value="<?=$namamhs;?>"
                                                            class="form-control" required><br>
                                                        <input type="number" name="nilai" value="<?=$nilai;?>"
                                                            class="form-control" required><br>
                                                        <input type="date" name="tanggal" value="<?=$tanggal;?>"
                                                            class="form-control"><br>
                                                        <input type="hidden" name="idmhs" value="<?=$idmhs;?>">
                                                        <button type="submit" class="btn btn-primary"
                                                            name="updatenilai">Update</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="delete<?= $idmhs; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Delete</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <form method="post">
                                                    <div class="modal-body">
                                                        Apakah anda yakin ingin menghapus <?=$namamhs;?>?
                                                        <input type="hidden" name="idmhs" value="<?= $idmhs; ?>">
                                                        <br>
                                                        <br>
                                                        <button type="submit" class="btn btn-danger"
                                                            name="deletenilai">Delete</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Nilai</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <input type="text" name="namamhs" placeholder="Nama Mahasiswa" class="form-control" required><br>
                    <input type="text" name="namamateri"placeholder="Materi"class="form-control"required><br>
                    <input type="number" name="nilai" placeholder="Nilai" class="form-control" required><br>
                    <input type="date" name="tanggal" placeholder="Tanggal" class="form-control"><br>
                    <button type="submit" class="btn btn-primary" name="nilaimasuk">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>

</html>