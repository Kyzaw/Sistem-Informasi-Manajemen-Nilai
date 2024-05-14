<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Grafik Nilai</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        <a class="nav-link" href="charts.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Grafik Nilai
                        </a>
                    </div>
                </div>

            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-10">
                    <label for="tanggalPilihan">Pilih Tanggal:</label>
                    <input type="date" id="tanggalPilihan" name="tanggalPilihan"
                        value="<?php echo $tanggalTertentu; ?>">
                    <button onclick="updateChart()">Perbarui Grafik</button>
                    <canvas id="nilaiChart"></canvas>
                </div>
                <div class="container mt-5">
                    <canvas id="nilaiChart"></canvas>
                </div>

                <script>
                    function updateChart() {
                        var tanggalDipilih = document.getElementById('tanggalPilihan').value;
                        // Anda bisa menambahkan logika untuk mengambil data baru berdasarkan tanggal yang dipilih
                        console.log('Tanggal yang dipilih: ' + tanggalDipilih);
                        // Contoh: Anda bisa memuat ulang halaman dengan parameter tanggal atau memanggil AJAX untuk mengambil data baru
                        window.location.href = 'charts.php?tanggal=' + tanggalDipilih;
                    }
                </script>

                <?php
                require 'function.php';
                // Menentukan tanggal tertentu
                $tanggalTertentu = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d'); // Mengambil tanggal dari URL atau tanggal saat ini
                
                // Query untuk mengambil data nilai terbesar pada tanggal tertentu
                $chartQuery = "SELECT mahasiswa.namamhs, nilai.nilaimhs FROM nilai JOIN mahasiswa ON nilai.idmhs = mahasiswa.idmhs WHERE mahasiswa.tanggal = '$tanggalTertentu' ORDER BY nilai.nilaimhs DESC LIMIT 10";
                $chartResult = mysqli_query($conn, $chartQuery);
                $dataNama = [];
                $dataNilai = [];

                if ($chartResult) {
                    while ($row = mysqli_fetch_assoc($chartResult)) {
                        $dataNama[] = $row['namamhs'];
                        $dataNilai[] = $row['nilaimhs'];
                    }
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
                ?>

                <script>
                    // Mengubah data PHP menjadi JSON untuk JavaScript
                    var namaMhs = <?php echo json_encode($dataNama, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
                    var nilaiMhs = <?php echo json_encode($dataNilai, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

                    // Membuat grafik batang
                    var ctx = document.getElementById('nilaiChart').getContext('2d');
                    var nilaiChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: namaMhs,
                            datasets: [{
                                label: 'Nilai Mahasiswa pada ' + '<?php echo $tanggalTertentu; ?>',
                                data: nilaiMhs,
                                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                                borderColor: 'rgba(0, 123, 255, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    enabled: true
                                }
                            }
                        }
                    });
                </script>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website By Kyzaww</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <div>
        <canvas id="myChart"></canvas>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous">
    </script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="assets/demo/chart-pie-demo.js"></script>
</body>

</html>