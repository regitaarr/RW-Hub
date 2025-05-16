<?php
session_start();
include 'db_connect.php';

// Cek apakah NIK tersedia di URL
if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];
    $query = "SELECT * FROM warga_pendatang WHERE nik = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nik);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    // Jika data tidak ditemukan
    if (!$data) {
        $error_message = "Data pendatang dengan NIK $nik tidak ditemukan.";
    }
} else {
    $error_message = "NIK tidak disediakan.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Data Pendatang</title>
    <link rel="icon" href="images/logo.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); /* Gradasi ungu ke biru */
            min-height: 100vh;
            color: #000000; /* Warna teks umum hitam */
        }
        .navbar {
            background: rgba(0, 0, 0, 0.8) !important; /* Navbar gelap */
        }
        .container-main {
            background: rgba(255, 255, 255, 0.95); /* Latar belakang putih terang */
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(0, 0, 0, 0.1);
            margin-top: 100px; /* Menyesuaikan margin top agar navbar tidak menutupi */
            margin-bottom: 40px;
            color: #000000; /* Warna teks di dalam container-main hitam */
        }
        .card-header {
            background: #6a11cb !important; /* Warna header ungu */
            border-radius: 15px 15px 0 0;
            color: #ffffff;
        }
        .card-title {
            font-weight: 600;
            color: #ffffff;
        }
        .table th {
            background-color: #f8f9fa; /* Warna latar belakang header tabel */
            color: #000000; /* Warna teks header tabel */
            font-weight: 600;
        }
        .table td {
            vertical-align: middle;
            color: #000000; /* Warna teks tabel hitam */
        }
        .btn-custom-back {
            background-color: #ffc107; /* Warna tombol kembali kuning */
            color: #000000; /* Warna teks tombol kembali hitam */
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        .btn-custom-back:hover {
            background-color: #e0a800;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        .btn-back-icon {
            margin-right: 5px; /* Spasi antara ikon dan teks */
        }
        @media (max-width: 768px) {
            .container-main {
                padding: 20px;
            }
            .card-title {
                text-align: center;
            }
            .btn-custom-back {
                width: 100%;
                margin-bottom: 10px;
            }
            .table th, .table td {
                font-size: 14px; /* Ukuran font tabel lebih kecil pada layar kecil */
            }
        }
    </style>
</head>
<body>
<!-- Navbar -->
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
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
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

<!-- Main Container -->
<div class="container container-main">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fa fa-user"></i> Detail Pendatang
            </h3>
        </div>
        <div class="card-body">
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php elseif ($data): ?>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th scope="row">NIK</th>
                            <td><?php echo htmlspecialchars($data['nik']); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">No. KK</th>
                            <td><?php echo htmlspecialchars($data['no_kk']); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Nama</th>
                            <td><?php echo htmlspecialchars($data['nama']); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Tempat Lahir</th>
                            <td><?php echo htmlspecialchars($data['tempat_lahir']); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Tanggal Lahir</th>
                            <td><?php echo htmlspecialchars($data['tanggal_lahir']); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Jenis Kelamin</th>
                            <td><?php echo htmlspecialchars($data['jenis_kelamin']); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Agama</th>
                            <td><?php echo htmlspecialchars($data['agama']); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Pekerjaan</th>
                            <td><?php echo htmlspecialchars($data['pekerjaan']); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Pendidikan</th>
                            <td><?php echo htmlspecialchars($data['pendidikan']); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Alamat Asal</th>
                            <td><?php echo nl2br(htmlspecialchars($data['alamat_asal'])); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Alamat Tujuan</th>
                            <td><?php echo nl2br(htmlspecialchars($data['alamat_tujuan'])); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Alasan Pindah</th>
                            <td><?php echo htmlspecialchars($data['alasan_pindah']); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Tanggal Pindah</th>
                            <td><?php echo htmlspecialchars($data['tanggal_pindah']); ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <div class="card-footer">
            <a href="lihat_pendatang.php" class="btn btn-custom-back">
                <i class="fa fa-arrow-left btn-back-icon"></i> Kembali
            </a>
        </div>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
