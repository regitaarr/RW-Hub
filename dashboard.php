<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

// Menyambungkan koneksi database
include 'db_connect.php';

// Ambil data admin yang sedang login
$username = $_SESSION['admin'];
$query = "SELECT * FROM admin_rw WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Ambil data statistik dari database
$totalPendudukQuery = "SELECT COUNT(*) AS total FROM warga_pendatang";
$totalPendudukResult = $conn->query($totalPendudukQuery);
$totalPenduduk = $totalPendudukResult->fetch_assoc()['total'];

$genderQuery = "SELECT jenis_kelamin, COUNT(*) AS jumlah FROM warga_pendatang GROUP BY jenis_kelamin";
$genderResult = $conn->query($genderQuery);
$genderData = [];
while ($row = $genderResult->fetch_assoc()) {
    $genderData[$row['jenis_kelamin']] = $row['jumlah'];
}

$jobQuery = "SELECT pekerjaan, COUNT(*) AS jumlah FROM warga_pendatang GROUP BY pekerjaan";
$jobResult = $conn->query($jobQuery);
$jobData = [];
while ($row = $jobResult->fetch_assoc()) {
    $jobData[$row['pekerjaan']] = $row['jumlah'];
}

$educationQuery = "SELECT pendidikan, COUNT(*) AS jumlah FROM warga_pendatang GROUP BY pendidikan";
$educationResult = $conn->query($educationQuery);
$educationData = [];
while ($row = $educationResult->fetch_assoc()) {
    $educationData[$row['pendidikan']] = $row['jumlah'];
}

$reasonQuery = "SELECT alasan_pindah, COUNT(*) AS jumlah FROM warga_pendatang GROUP BY alasan_pindah";
$reasonResult = $conn->query($reasonQuery);
$reasonData = [];
while ($row = $reasonResult->fetch_assoc()) {
    $reasonData[$row['alasan_pindah']] = $row['jumlah'];
}

// Ambil data tanggal pindah per tahun
$dateQuery = "SELECT YEAR(tanggal_pindah) AS tahun, COUNT(*) AS jumlah FROM warga_pendatang GROUP BY YEAR(tanggal_pindah)";
$dateResult = $conn->query($dateQuery);
$dateData = [];
while ($row = $dateResult->fetch_assoc()) {
    $dateData[$row['tahun']] = $row['jumlah'];
}

// Filter undefined keys or empty values from dateData
$dateData = array_filter($dateData, function($value, $key) {
    return !is_null($key) && $key !== "" && $value > 0;
}, ARRAY_FILTER_USE_BOTH);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="images/logo.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
            color: #ffffff;
        }
        .navbar {
            background: rgba(0, 0, 0, 0.7) !important;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(8.5px);
            -webkit-backdrop-filter: blur(8.5px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        h1, h3 {
            color: #ffffff;
        }
        .card {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            color: #ffffff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .chart-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        canvas {
            max-width: 100%;
            height: auto;
        }
        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }
        .navbar-brand {
            font-weight: 600;
            font-size: 1.5rem;
        }
        .nav-link {
            color: #ffffff !important;
            font-weight: 500;
        }
        .nav-link.active {
            color: #ffd700 !important;
        }
        @media (max-width: 768px) {
            .chart-container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
		<img src="images\logo.png" width="50px">
        <a class="navbar-brand" href="#">RWHub</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tambah_pendatang.php">Tambah Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="lihat_pendatang.php">Data Pendatang</a>
                </li>
            </ul>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>
<div class="container mt-5 pt-4">
    <h2 class="mb-4-center">Sistem Pencatatan Data Pendatang - RW 02, Kubangpari</h2>
    <h3 class="mb-4">Selamat Datang, <?php echo htmlspecialchars($user['username']); ?>!</h3>

    <div class="row mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card text-center">
                <h5>Total Pendatang</h5>
                <h2><?php echo $totalPenduduk; ?></h2>
            </div>
        </div>
        <!-- Tambahkan kartu statistik lainnya jika diperlukan -->
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="chart-container">
                <canvas id="genderChart"></canvas>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="chart-container">
                <canvas id="jobChart"></canvas>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6 col-md-12">
            <div class="chart-container">
                <canvas id="educationChart"></canvas>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="chart-container">
                <canvas id="reasonChart"></canvas>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="chart-container">
                <canvas id="dateChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    const genderData = <?php echo json_encode($genderData); ?>;
    const jobData = <?php echo json_encode($jobData); ?>;
    const educationData = <?php echo json_encode($educationData); ?>;
    const reasonData = <?php echo json_encode($reasonData); ?>;
    const dateData = <?php echo json_encode($dateData); ?>;

    const createChart = (id, labels, data, title, colors, type = 'pie') => {
        new Chart(document.getElementById(id), {
            type: type,
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors,
                    borderColor: 'rgba(255, 255, 255, 0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: '#ffffff'
                        }
                    },
                    title: {
                        display: true,
                        text: title,
                        color: '#ffffff',
                        font: {
                            size: 18
                        }
                    }
                },
                scales: type === 'bar' ? {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#ffffff'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#ffffff'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)'
                        }
                    }
                } : {}
            }
        });
    };

    // Palet Warna Modern
    const palette = {
        primary: '#9b59b6',
        secondary: '#3498db',
        success: '#2ecc71',
        danger: '#e74c3c',
        warning: '#f1c40f',
        info: '#1abc9c',
        light: '#ecf0f1',
        dark: '#2c3e50'
    };

    createChart(
        'genderChart', 
        Object.keys(genderData), 
        Object.values(genderData), 
        'Statistik Jenis Kelamin', 
        [palette.primary, palette.secondary]
    );

    createChart(
        'jobChart', 
        Object.keys(jobData), 
        Object.values(jobData), 
        'Statistik Pekerjaan', 
        [
            palette.primary, palette.secondary, palette.success, 
            palette.danger, palette.warning, palette.info, 
            palette.dark, palette.light, '#8e44ad'
        ]
    );

    createChart(
        'educationChart', 
        Object.keys(educationData), 
        Object.values(educationData), 
        'Statistik Pendidikan', 
        [
            palette.primary, palette.secondary, palette.success, 
            palette.danger, palette.warning, palette.info, 
            palette.dark, palette.light, '#8e44ad'
        ]
    );

    createChart(
        'reasonChart', 
        Object.keys(reasonData), 
        Object.values(reasonData), 
        'Statistik Alasan Pindah', 
        [palette.primary, palette.secondary, palette.success, palette.danger, palette.warning, palette.info, palette.dark]
    );

    // Bar chart for date data
    createChart(
        'dateChart', 
        Object.keys(dateData), 
        Object.values(dateData), 
        'Statistik Tanggal Pindah per Tahun', 
        [palette.primary, palette.secondary, palette.success, palette.danger, palette.warning], 
        'bar'
    );
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
