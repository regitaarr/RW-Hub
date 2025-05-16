<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php';

// Fungsi untuk menghapus data
if (isset($_GET['hapus'])) {
    $nik = $_GET['hapus'];
    $deleteQuery = "DELETE FROM warga_pendatang WHERE nik = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("s", $nik);
    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='lihat_pendatang.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location.href='lihat_pendatang.php';</script>";
    }
}

// Pagination setup
$limit = 10; // Maksimal baris per halaman
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Hitung total data
$totalQuery = "SELECT COUNT(*) AS total FROM warga_pendatang";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalData = $totalRow['total'];
$totalPages = ceil($totalData / $limit);

// Ambil data dari tabel `warga_pendatang` dengan limit dan offset
$query = "SELECT * FROM warga_pendatang LIMIT ? OFFSET ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendatang</title>
    <link rel="icon" href="images/logo.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
        .container-main {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(8.5px);
            -webkit-backdrop-filter: blur(8.5px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            margin-top: 80px;
            margin-bottom: 40px;
        }
        .card-header {
            background: #6a11cb !important;
            border-radius: 15px 15px 0 0;
        }
        .card-title {
            font-weight: 600;
            color: #ffffff;
        }
        .btn-primary, .btn-success, .btn-info, .btn-danger, .btn-secondary {
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover, .btn-success:hover, .btn-info:hover, .btn-danger:hover, .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        .table-responsive {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        table {
            color: #ffffff;
        }
        th, td {
            vertical-align: middle !important;
        }
        thead th {
            background-color: rgba(255, 255, 255, 0.2);
            border-bottom: 2px solid #ffffff;
        }
        tbody tr:nth-child(odd) {
            background-color: rgba(255, 255, 255, 0.05);
        }
        tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .pagination .page-link {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border: none;
            border-radius: 50px;
            margin: 0 2px;
        }
        .pagination .page-item.active .page-link {
            background-color: #ffffff;
            color: #6a11cb;
        }
        .pagination .page-link:hover {
            background-color: rgba(255, 255, 255, 0.4);
            color: #6a11cb;
        }
        .btn-back {
            background-color: #ff6f61;
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background-color: #ff3b2e;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            color: #ffffff;
        }
        @media (max-width: 768px) {
            .container-main {
                padding: 20px;
            }
            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
            .pagination {
                justify-content: center;
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
                    <a class="nav-link active" href="lihat_pendatang.php">Data Pendatang</a>
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
                <i class="fa fa-table"></i> Data Pendatang
            </h3>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between flex-wrap">
                <a href="tambah_pendatang.php" class="btn btn-primary mb-2">
                    <i class="fa fa-plus"></i> Tambah Data
                </a>
                <a href="dashboard.php" class="btn btn-back">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat Asal</th>
                            <th>Alamat Tujuan</th>
                            <th>Alasan Pindah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php $no = $offset + 1; ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['nik']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?></td>
                                    <td><?php echo htmlspecialchars($row['alamat_asal']); ?></td>
                                    <td><?php echo htmlspecialchars($row['alamat_tujuan']); ?></td>
                                    <td><?php echo htmlspecialchars($row['alasan_pindah']); ?></td>
                                    <td>
                                        <a href="detail_pendatang.php?nik=<?php echo urlencode($row['nik']); ?>" class="btn btn-info btn-sm me-1 mb-1">
                                            <i class="fa fa-eye"></i> Detail
                                        </a>
                                        <a href="edit_pendatang.php?nik=<?php echo urlencode($row['nik']); ?>" class="btn btn-success btn-sm me-1 mb-1">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href="lihat_pendatang.php?hapus=<?php echo urlencode($row['nik']); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm mb-1">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data pendatang.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($i === $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
