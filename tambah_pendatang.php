<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php';

$message = "";
$step = isset($_GET['step']) ? intval($_GET['step']) : 1;
$anggotaSaatIni = isset($_GET['anggota']) ? intval($_GET['anggota']) : 1;

// Proses form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($step === 1) {
        // Validasi No KK
        if (!preg_match('/^\d{16}$/', $_POST['no_kk'])) {
            $message = "No KK harus berupa 16 digit angka.";
        } else {
            // Periksa apakah No KK sudah ada
            $query_check_kk = "SELECT * FROM warga_pendatang WHERE no_kk = ?";
            $stmt_check_kk = $conn->prepare($query_check_kk);
            $stmt_check_kk->bind_param("s", $_POST['no_kk']);
            $stmt_check_kk->execute();
            $result_kk = $stmt_check_kk->get_result();

            if ($result_kk->num_rows > 0) {
                $message = "No KK sudah terdaftar. Harap gunakan No KK yang berbeda.";
            } else {
                $_SESSION['data_keluarga'] = $_POST;
                $_SESSION['anggota_keluarga'] = [];
                header("Location: ?step=2&anggota=1");
                exit();
            }
        }
    } elseif ($step === 2) {
        $jumlah_anggota = intval($_SESSION['data_keluarga']['jumlah_anggota']);

        // Validasi NIK
        if (!preg_match('/^\d{16}$/', $_POST['nik'])) {
            $message = "NIK anggota keluarga ke-" . $anggotaSaatIni . " harus berupa 16 digit angka.";
        } else {
            // Periksa apakah NIK sudah ada
            $query_check_nik = "SELECT * FROM warga_pendatang WHERE nik = ?";
            $stmt_check_nik = $conn->prepare($query_check_nik);
            $stmt_check_nik->bind_param("s", $_POST['nik']);
            $stmt_check_nik->execute();
            $result_nik = $stmt_check_nik->get_result();

            if ($result_nik->num_rows > 0) {
                $message = "NIK anggota keluarga ke-" . $anggotaSaatIni . " sudah terdaftar.";
            } else {
                // Simpan data anggota keluarga ke session
                $_SESSION['anggota_keluarga'][$anggotaSaatIni] = $_POST;

                // Cek apakah masih ada anggota berikutnya
                if ($anggotaSaatIni < $jumlah_anggota) {
                    header("Location: ?step=2&anggota=" . ($anggotaSaatIni + 1));
                    exit();
                } else {
                    // Simpan semua data ke database
                    $data_keluarga = $_SESSION['data_keluarga'];
                    $no_kk = $data_keluarga['no_kk'];
                    $alamat_asal = $data_keluarga['alamat_asal'];
                    $alamat_tujuan = $data_keluarga['alamat_tujuan'];
                    $alasan_pindah = $data_keluarga['alasan_pindah'];
                    $tanggal_pindah = $data_keluarga['tanggal_pindah'];

                    foreach ($_SESSION['anggota_keluarga'] as $anggota) {
                        $query = "INSERT INTO warga_pendatang 
                                  (nik, no_kk, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, pekerjaan, pendidikan, alamat_asal, alamat_tujuan, alasan_pindah, tanggal_pindah) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param(
                            "sssssssssssss",
                            $anggota['nik'],
                            $no_kk,
                            $anggota['nama'],
                            $anggota['tempat_lahir'],
                            $anggota['tanggal_lahir'],
                            $anggota['jenis_kelamin'],
                            $anggota['agama'],
                            $anggota['pekerjaan'],
                            $anggota['pendidikan'],
                            $alamat_asal,
                            $alamat_tujuan,
                            $alasan_pindah,
                            $tanggal_pindah
                        );

                        if (!$stmt->execute()) {
                            $message = "Gagal menyimpan data anggota keluarga ke-" . $anggotaSaatIni . ": " . $conn->error;
                            break;
                        }
                    }

                    if (empty($message)) {
                        // Bersihkan session setelah selesai
                        unset($_SESSION['data_keluarga']);
                        unset($_SESSION['anggota_keluarga']);
                        header("Location: lihat_pendatang.php?message=success");
                        exit();
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pendatang</title>
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
            color: #000000; /* Mengubah warna teks umum menjadi hitam */
        }
        .navbar {
            background: rgba(0, 0, 0, 0.7) !important;
        }
        .container-main {
            background: rgba(255, 255, 255, 0.9); /* Latar belakang putih terang */
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            /* backdrop-filter: blur(8.5px); */
            /* -webkit-backdrop-filter: blur(8.5px); */
            border: 1px solid rgba(255, 255, 255, 0.18);
            margin-top: 80px;
            margin-bottom: 40px;
            color: #000000; /* Warna teks di dalam container-main menjadi hitam */
        }
        .card-header {
            background: #6a11cb !important;
            border-radius: 15px 15px 0 0;
            color: #ffffff;
        }
        .card-title {
            font-weight: 600;
            color: #ffffff;
            /* text-shadow: 1px 1px 2px rgba(0,0,0,0.5); */ /* Opsional */
        }
        .btn-primary, .btn-success, .btn-info, .btn-danger, .btn-secondary {
            border-radius: 50px;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        .btn-primary:hover, .btn-success:hover, .btn-info:hover, .btn-danger:hover, .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
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
        label {
            color: #000000; /* Warna label hitam */
            font-weight: 600;
            /* text-shadow: 1px 1px 2px rgba(0,0,0,0.5); */ /* Dihapus untuk kontras yang lebih baik */
        }
        .alert {
            background: rgba(255, 0, 0, 0.8);
            border: none;
            border-radius: 10px;
            padding: 15px;
            font-weight: 600;
            color: #ffffff; /* Warna teks alert putih */
            /* text-shadow: 1px 1px 2px rgba(0,0,0,0.5); */ /* Opsional */
        }
        .btn-back {
            background-color: #ff6f61;
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            transition: all 0.3s ease;
            color: #ffffff;
            font-weight: 600;
        }
        .btn-back:hover {
            background-color: #ff3b2e;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        @media (max-width: 768px) {
            .container-main {
                padding: 20px;
            }
            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
            .card-title {
                text-align: center;
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
                    <a class="nav-link active" href="tambah_pendatang.php">Tambah Data</a>
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
            <h3 class="card-title">Tambah Data Pendatang</h3>
        </div>
        <form method="POST" action="">
            <div class="card-body">
                <?php if ($message): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <?php if ($step === 1): ?>
                    <!-- Input untuk informasi dasar -->
                    <div class="mb-4 row">
                        <label for="no_kk" class="col-sm-3 col-form-label">No KK</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="no_kk" name="no_kk" maxlength="16" placeholder="Masukkan No KK" required>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="jumlah_anggota" class="col-sm-3 col-form-label">Jumlah Anggota</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="jumlah_anggota" name="jumlah_anggota" min="1" max="20" placeholder="Masukkan Jumlah Anggota" required>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="alamat_asal" class="col-sm-3 col-form-label">Alamat Asal</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="alamat_asal" name="alamat_asal" rows="3" placeholder="Masukkan Alamat Asal" required></textarea>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="alamat_tujuan" class="col-sm-3 col-form-label">Alamat Tujuan</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="alamat_tujuan" name="alamat_tujuan" rows="3" placeholder="Masukkan Alamat Tujuan" required></textarea>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="alasan_pindah" class="col-sm-3 col-form-label">Alasan Pindah</label>
                        <div class="col-sm-6">
                            <select name="alasan_pindah" id="alasan_pindah" class="form-select" required>
                                <option value="">Pilih Alasan Pindah</option>
                                <option value="Pekerjaan">Pekerjaan</option>
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Keluarga">Keluarga</option>
                                <option value="Keamanan">Keamanan</option>
                                <option value="Kesehatan">Kesehatan</option>
                                <option value="Perumahan">Perumahan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="tanggal_pindah" class="col-sm-3 col-form-label">Tanggal Pindah</label>
                        <div class="col-sm-6">
                            <input type="date" class="form-control" id="tanggal_pindah" name="tanggal_pindah" required>
                        </div>
                    </div>
                <?php elseif ($step === 2): ?>
                    <!-- Input untuk anggota keluarga -->
                    <h5 class="mt-4 mb-3">Anggota Keluarga <?php echo htmlspecialchars($anggotaSaatIni); ?></h5>
                    <div class="mb-4 row">
                        <label for="nik" class="col-sm-3 col-form-label">NIK</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="nik" name="nik" maxlength="16" placeholder="Masukkan NIK" required>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" required>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="tempat_lahir" class="col-sm-3 col-form-label">Tempat Lahir</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan Sesuai KTP" required>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="tanggal_lahir" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-6">
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-6">
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="agama" class="col-sm-3 col-form-label">Agama</label>
                        <div class="col-sm-6">
                            <select name="agama" id="agama" class="form-select" required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Budha">Budha</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="pekerjaan" class="col-sm-3 col-form-label">Pekerjaan</label>
                        <div class="col-sm-6">
                            <select name="pekerjaan" id="pekerjaan" class="form-select" required>
                                <option value="">Pilih Pekerjaan</option>
                                <option value="Tidak Bekerja">Tidak Bekerja</option>
                                <option value="Pelajar">Pelajar</option>
                                <option value="Mahasiswa">Mahasiswa</option>
                                <option value="PNS">PNS</option>
                                <option value="Wirausaha">Wirausaha</option>
                                <option value="Wiraswasta">Wiraswasta</option>
                                <option value="Guru">Guru</option>
                                <option value="Dosen">Dosen</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="pendidikan" class="col-sm-3 col-form-label">Pendidikan</label>
                        <div class="col-sm-6">
                            <select name="pendidikan" id="pendidikan" class="form-select" required>
                                <option value="">Pilih Pendidikan</option>
                                <option value="Tidak/Belum Sekolah">Tidak/Belum Sekolah</option>
                                <option value="Tamat SD/Sederajat">Tamat SD/Sederajat</option>
                                <option value="SLTP/Sederajat">SLTP/Sederajat</option>
                                <option value="SLTA/Sederajat">SLTA/Sederajat</option>
                                <option value="Diploma I/II">Diploma I/II</option>
                                <option value="Diploma III">Diploma III</option>
                                <option value="Strata I">Strata I</option>
                                <option value="Strata II">Strata II</option>
                                <option value="Strata III">Strata III</option>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <?php if ($step === 1): ?>
                    <button type="submit" class="btn btn-primary me-2">Selanjutnya</button>
                <?php elseif ($step === 2): ?>
                    <?php
                    // Tentukan URL tombol kembali
                    if ($anggotaSaatIni > 1) {
                        // Kembali ke anggota keluarga sebelumnya tetap di step 2
                        $urlKembali = "?step=2&anggota=" . ($anggotaSaatIni - 1);
                    } else {
                        // Jika anggota pertama, kembali ke step 1
                        $urlKembali = "?step=1";
                    }
                    ?>
                    <a href="<?php echo htmlspecialchars($urlKembali); ?>" class="btn btn-secondary me-2">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                <?php endif; ?>
                <a href="dashboard.php" class="btn btn-danger ms-2">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php if (isset($_GET['message']) && $_GET['message'] === 'success'): ?>
<script>
    alert('Data berhasil disimpan!');
</script>
<?php endif; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
