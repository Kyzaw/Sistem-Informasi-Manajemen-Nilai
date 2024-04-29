<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "poin");

// Query the data
$query = "SELECT tanggal, SUM(nilai) as total FROM mahasiswa GROUP BY tanggal";
$result = mysqli_query($conn, $query);

// Find the date with the most points
$max_points = 0;
$max_date = '';
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['total'] > $max_points) {
        $max_points = $row['total'];
        $max_date = $row['tanggal'];
    }
}

// Create the data array for the chart
$data = [
    'labels' => [],
    'data' => []
];
while ($row = mysqli_fetch_assoc($result)) {
    $data['labels'][] = $row['tanggal'];
    $data['data'][] = $row['total'];
}

// Output the data as JSON
header('Content-Type: application/json');
echo json_encode($data);