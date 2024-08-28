<?php
// Koneksi ke database 'crud'
$host   = "localhost";
$user   = "root";
$pass   = "";
$db     = "crud";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Cannot connect to database");
}

// Koneksi ke database 'webtest' untuk mendapatkan nama pengguna
$host_webtest = "localhost";
$user_webtest = "root";
$pass_webtest = "";
$db_webtest   = "webtest";

$koneksi_webtest = mysqli_connect($host_webtest, $user_webtest, $pass_webtest, $db_webtest);

if (!$koneksi_webtest) {
    die("Cannot connect to webtest database");
}

session_start(); // Mulai sesi untuk menggunakan $_SESSION

// Pastikan NIM ada di session
if (isset($_SESSION['nim'])) {
    $nim_session = $_SESSION['nim'];

    // Ambil data nama dari database 'webtest' berdasarkan NIM
    $sql_user = "SELECT nama FROM users WHERE nim = '$nim_session'";
    $query_user = mysqli_query($koneksi_webtest, $sql_user);
    $data_user = mysqli_fetch_array($query_user);

    // Jika data ditemukan
    if ($data_user) {
        $nama_session = $data_user['nama'];
    } else {
        $nama_session = "Pengguna"; // Default jika data tidak ditemukan
    }
} else {
    $nama_session = "Pengguna"; // Default jika tidak ada session NIM
}

$nim        = "";
$nama       = "";
$jurusan    = "";
$prodi      = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'hapus') {
    $id     = $_GET['id'];
    $sql1   = "DELETE FROM mahasiswa WHERE id = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);

    if ($q1) {
        $sukses = "Data berhasil dihapus";
    } else {
        $error  = "Data gagal dihapus";
    }
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM mahasiswa WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $nim = $r1['nim'];
    $nama = $r1['nama'];
    $jurusan = $r1['jurusan'];
    $prodi = $r1['prodi'];

    if ($nim == '') {
        $error = "Data tidak ditemukan!";
    }
}

if (isset($_POST['simpan'])) {
    $nim        = $_POST['nim'];
    $nama       = $_POST['nama'];
    $jurusan    = $_POST['jurusan'];
    $prodi      = $_POST['prodi'];

    if ($nim && $nama && $jurusan && $prodi) {
        if ($op == 'edit') { // for update data 
            $sql1   = "update mahasiswa set nim = '$nim', nama = '$nama', jurusan = '$jurusan', prodi = '$prodi' where id = '$id'";
            $q1     = mysqli_query($koneksi, $sql1);

            if ($q1) {
                $sukses     = "Data berhasil diupdate";
            } else {
                $error      = "Data gagal diupdate";
            }
        } else { // for insert data
            $sql1 = "INSERT INTO mahasiswa(id, nim, nama, jurusan, prodi) VALUES (NULL, '$nim', '$nama', '$jurusan', '$prodi')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses =  "Data berhasil disimpan";
            } else {
                $error = "Gagal input data";
            }
        }
    } else {
        $error = "Silakan isi semua form";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>web crud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px;
            margin: 0 auto;
            /* Pastikan konten di tengah secara horizontal */
        }

        .card {
            margin-top: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Menambahkan bayangan agar terlihat lebih menonjol */
            border-radius: 10px;
            /* Membuat sudut kartu lebih lembut */
        }

        .logut {
            text-align: center;
            display: block;
            width: 50%;
            /* Mengubah dari 20% agar lebih responsif */
            padding: 10px;
            margin: 10px auto;
            border-radius: 10px;
            background-color: rgb(90, 90, 206);
            color: white;
            font-size: 1rem;
            /* Menggunakan rem untuk konsistensi */
            font-weight: bold;
            /* Menambahkan ketebalan teks */
            text-decoration: none;
            transition: opacity 0.3s ease;
            /* Transisi yang halus saat hover */
        }

        .logut:hover {
            opacity: 0.7;
        }
    </style>
</head>

<body>
    <div class="sapa">
        <h1 class="text-center">
            Hai, <span style="color: blue;"><?php echo htmlspecialchars($_SESSION['nama']); ?></span> Selamat Datang di Web CRUD
        </h1>
    </div>

    <div class="mx-auto">
        <!---input or create data --->
        <div class="card">
            <div class="card-header">
                create / edit data
            </div>
            <div class="card-body">
                <!--error danger -->
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                }
                ?>

                <!--success alert-->
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                }
                ?>
                <form action="" method="post">
                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-2 col-form-label">nim</label>
                        <div class="col-sm-10">
                            <input type="text" id="nim" name="nim" class="form-control" value="<?php echo $nim; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">nama</label>
                        <div class="col-sm-10">
                            <input type="text" id="nama" name="nama" class="form-control" value="<?php echo $nama; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jurusan" class="col-sm-2 col-form-label">jurusan</label>
                        <div class="col-sm-10">
                            <input type="text" id="jurusan" name="jurusan" class="form-control" value="<?php echo $jurusan; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="prodi" class="col-sm-2 col-form-label">prodi</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="prodi" id="prodi">
                                <option value="">Pilih</option>
                                <option value="Teknik Komputer" <?php if ($prodi == "Teknik Komputer") echo "selected" ?>>Teknik Komputer</option>
                                <option value="Manajemen Informatika" <?php if ($prodi == "Manajemen Informatika") echo "selected" ?>>Manajemen Informatika</option>
                                <option value="Teknologi Rekayasa Perangkat Lunak" <?php if ($prodi == "Teknologi Rekayasa Perangkat Lunak") echo "selected" ?>>Teknologi Rekayasa Perangkat Lunak</option>
                                <option value="Animasi" <?php if ($prodi == "Animasi") echo "selected" ?>>Animasi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="simpan data" class="btn btn-primary">
                    </div>
                </form>

            </div>
        </div>

        <!---output data --->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                data mahasiswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nim</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jurusan</th>
                            <th scope="col">Prodi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2 = "select * from mahasiswa order by id desc";
                        $q2 = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 =  mysqli_fetch_array($q2)) {
                            $id         = $r2['id'];
                            $nim        = $r2['nim'];
                            $nama       = $r2['nama'];
                            $jurusan    = $r2['jurusan'];
                            $prodi      = $r2['prodi'];

                        ?>
                            <tr>
                                <th scope="row"> <?php echo $urut++ ?> </th>
                                <td scope="row"> <?php echo $nim ?> </td>
                                <td scope="row"> <?php echo $nama ?> </td>
                                <td scope="row"> <?php echo $jurusan ?> </td>
                                <td scope="row"> <?php echo $prodi ?> </td>
                                <td scope="row">
                                    <a href="home.php?op=edit&id=<?php echo $id ?>"> <button type="button" class="btn btn-warning">Edit</button> </a>
                                    <a href="home.php?op=hapus&id=<?php echo $id ?>" onclick="return confirm('Yakin mau delete data?')">
                                        <button type="button" class="btn btn-danger">Hapus</button> </a>

                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    </thead>
                </table>


            </div>
        </div>
    </div>
    <a class="logut" href="logout.php">Logout</a>
</body>

</html>