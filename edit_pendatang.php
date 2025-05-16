<?php
session_start();
include 'db_connect.php';

// Ambil data berdasarkan NIK
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

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nik = $_POST['nik'];
    $no_kk = $_POST['no_kk'];

    // Validasi nomor KK harus terdiri dari 16 digit angka
    if (!preg_match('/^\d{16}$/', $no_kk)) {
        echo "<script>alert('Nomor KK harus terdiri dari 16 digit angka!');</script>";
    } else {
        $nama = $_POST['nama'];
        $tempat_lahir = $_POST['tempat_lahir'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $agama = $_POST['agama'];
        $pekerjaan = $_POST['pekerjaan'];
        $pendidikan = $_POST['pendidikan'];
        $alamat_asal = $_POST['alamat_asal'];
        $alamat_tujuan = $_POST['alamat_tujuan'];
        $alasan_pindah = $_POST['alasan_pindah'];
        $tanggal_pindah = $_POST['tanggal_pindah'];

        $updateQuery = "UPDATE warga_pendatang SET no_kk = ?, nama = ?, tempat_lahir = ?, tanggal_lahir = ?, jenis_kelamin = ?, agama = ?, pekerjaan = ?, pendidikan = ?, alamat_asal = ?, alamat_tujuan = ?, alasan_pindah = ?, tanggal_pindah = ? WHERE nik = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sssssssssssss", $no_kk, $nama, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $agama, $pekerjaan, $pendidikan, $alamat_asal, $alamat_tujuan, $alasan_pindah, $tanggal_pindah, $nik);

        if ($stmt->execute()) {
            echo "<script>alert('Data berhasil diperbarui!'); window.location.href='lihat_pendatang.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pendatang</title>
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
        .form-label {
            font-weight: 600;
        }
        .form-control, .form-select, textarea {
            background: rgba(255, 255, 255, 1); /* Latar belakang input putih */
            border: 1px solid #ced4da; /* Border standar Bootstrap */
            color: #000000; /* Warna teks input hitam */
            border-radius: 10px;
            padding: 10px 15px;
            font-weight: 500;
        }
        .form-control::placeholder, .form-select::placeholder, textarea::placeholder {
            color: rgba(0, 0, 0, 0.5); /* Placeholder hitam transparan */
        }
        .form-control:focus, .form-select:focus, textarea:focus {
            background: rgba(255, 255, 255, 1); /* Tetap putih saat fokus */
            color: #000000;
            box-shadow: none;
            border-color: #80bdff;
        }
        .alert {
            background: rgba(255, 0, 0, 0.8);
            border: none;
            border-radius: 10px;
            padding: 15px;
            font-weight: 600;
            color: #ffffff; /* Warna teks alert putih */
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
            .form-label {
                font-size: 1rem;
            }
            .form-control, .form-select, textarea {
                font-size: 0.9rem;
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
                <i class="fa fa-edit"></i> Edit Data Pendatang
            </h3>
        </div>
        <form method="POST" action="">
            <div class="card-body">
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($data) && $data): ?>
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="<?php echo htmlspecialchars($data['nik']); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="no_kk" class="form-label">No KK</label>
                        <input type="text" class="form-control" id="no_kk" name="no_kk" value="<?php echo htmlspecialchars($data['no_kk']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?php echo htmlspecialchars($data['tempat_lahir']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo htmlspecialchars($data['tanggal_lahir']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" <?php if ($data['jenis_kelamin'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                                <option value="Perempuan" <?php if ($data['jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                            </select>
                    </div>
                    <div class="mb-3">
                        <label for="agama" class="form-label">Agama</label>
                        <select name="agama" id="agama" class="form-select" required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam" <?php if ($data['agama'] == 'Islam') echo 'selected'; ?>>Islam</option>
                                <option value="Katolik" <?php if ($data['agama'] == 'Katolik') echo 'selected'; ?>>Katolik</option>
                                <option value="Kristen" <?php if ($data['agama'] == 'Kristen') echo 'selected'; ?>>Kristen</option>
                                <option value="Budha" <?php if ($data['agama'] == 'Budha') echo 'selected'; ?>>Budha</option>
                                <option value="Hindu" <?php if ($data['agama'] == 'Hindu') echo 'selected'; ?>>Hindu</option>
                                <option value="Konghucu" <?php if ($data['agama'] == 'Konghucu') echo 'selected'; ?>>Konghucu</option>
                            </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="pekerjaan" class="form-label">Pekerjaan</label>
                        <select name="pekerjaan" id="pekerjaan" class="form-select" required>
                                <option value="">Pilih Pekerjaan</option>
                                <option value="Tidak Bekerja" <?php if ($data['pekerjaan'] == 'Tidak Bekerja') echo 'selected'; ?>>Tidak Bekerja</option>
                                <option value="Pelajar" <?php if ($data['pekerjaan'] == 'Pelajar') echo 'selected'; ?>>Pelajar</option>
                                <option value="Mahasiswa" <?php if ($data['pekerjaan'] == 'Mahasiswa') echo 'selected'; ?>>Mahasiswa</option>
                                <option value="PNS" <?php if ($data['pekerjaan'] == 'PNS') echo 'selected'; ?>>PNS</option>
                                <option value="Wirausaha" <?php if ($data['pekerjaan'] == 'Wirausaha') echo 'selected'; ?>>Wirausaha</option>
                                <option value="Wiraswasta" <?php if ($data['pekerjaan'] == 'Wiraswasta') echo 'selected'; ?>>Wiraswasta</option>
                                <option value="Guru" <?php if ($data['pekerjaan'] == 'Guru') echo 'selected'; ?>>Guru</option>
                                <option value="Dosen" <?php if ($data['pekerjaan'] == 'Dosen') echo 'selected'; ?>>Dosen</option>
                                <option value="Lainnya" <?php if ($data['pekerjaan'] == 'Lainnya') echo 'selected'; ?>>Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pendidikan" class="form-label">Pendidikan</label>
                        <select name="pendidikan" id="pendidikan" class="form-select" required>
                                <option value="">Pilih Pendidikan</option>
                                <option value="Tidak/Belum Sekolah" <?php if ($data['pendidikan'] == 'Tidak/Belum Sekolah') echo 'selected'; ?>>Tidak/Belum Sekolah</option>
                                <option value="Tamat SD/Sederajat" <?php if ($data['pendidikan'] == 'Tamat SD/Sederajat') echo 'selected'; ?>>Tamat SD/Sederajat</option>
                                <option value="SLTP/Sederajat" <?php if ($data['pendidikan'] == 'SLTP/Sederajat') echo 'selected'; ?>>SLTP/Sederajat</option>
                                <option value="SLTA/Sederajat" <?php if ($data['pendidikan'] == 'SLTA/Sederajat') echo 'selected'; ?>>SLTA/Sederajat</option>
                                <option value="Diploma I/II" <?php if ($data['pendidikan'] == 'Diploma I/II') echo 'selected'; ?>>Diploma I/II</option>
                                <option value="Diploma III" <?php if ($data['pendidikan'] == 'Diploma III') echo 'selected'; ?>>Diploma III</option>
                                <option value="Strata I" <?php if ($data['pendidikan'] == 'Strata I') echo 'selected'; ?>>Strata I</option>
                                <option value="Strata II" <?php if ($data['pendidikan'] == 'Strata II') echo 'selected'; ?>>Strata II</option>
                                <option value="Strata III" <?php if ($data['pendidikan'] == 'Strata III') echo 'selected'; ?>>Strata III</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_asal" class="form-label">Alamat Asal</label>
                        <textarea class="form-control" id="alamat_asal" name="alamat_asal" rows="3" required><?php echo htmlspecialchars($data['alamat_asal']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_tujuan" class="form-label">Alamat Tujuan</label>
                        <textarea class="form-control" id="alamat_tujuan" name="alamat_tujuan" rows="3" required><?php echo htmlspecialchars($data['alamat_tujuan']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="alasan_pindah" class="form-label">Alasan Pindah</label>
                        <select name="alasan_pindah" id="alasan_pindah" class="form-select" required>
                                <option value="">Pilih Alasan Pindah</option>
                                <option value="Pekerjaan" <?php if ($data['alasan_pindah'] == 'Pekerjaan') echo 'selected'; ?>>Pekerjaan</option>
                                <option value="Pendidikan" <?php if ($data['alasan_pindah'] == 'Pendidikan') echo 'selected'; ?>>Pendidikan</option>
                                <option value="Keluarga" <?php if ($data['alasan_pindah'] == 'Keluarga') echo 'selected'; ?>>Keluarga</option>
                                <option value="Keamanan" <?php if ($data['alasan_pindah'] == 'Keamanan') echo 'selected'; ?>>Keamanan</option>
                                <option value="Kesehatan" <?php if ($data['alasan_pindah'] == 'Kesehatan') echo 'selected'; ?>>Kesehatan</option>
                                <option value="Perumahan" <?php if ($data['alasan_pindah'] == 'Perumahan') echo 'selected'; ?>>Perumahan</option>
                                <option value="Lainnya" <?php if ($data['alasan_pindah'] == 'Lainnya') echo 'selected'; ?>>Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_pindah" class="form-label">Tanggal Pindah</label>
                        <input type="date" class="form-control" id="tanggal_pindah" name="tanggal_pindah" value="<?php echo htmlspecialchars($data['tanggal_pindah']); ?>" required>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <?php if (isset($data) && $data): ?>
                    <button type="submit" class="btn btn-success me-2">Simpan Perubahan</button>
                    <a href="lihat_pendatang.php" class="btn btn-custom-back">
                        <i class="fa fa-arrow-left me-2"></i> Batal
                    </a>
                <?php else: ?>
                    <a href="lihat_pendatang.php" class="btn btn-custom-back">
                        <i class="fa fa-arrow-left me-2"></i> Kembali
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        const noKk = document.getElementById('no_kk').value;
        if (!/^\d{16}$/.test(noKk)) {
            alert('Nomor KK harus terdiri dari 16 digit angka.');
            event.preventDefault();
        }
    });
</script>
</body>
</html>
