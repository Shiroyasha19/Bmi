<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "bmi";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$nomorhp = "";
$nama = "";
$tinggi = "";
$berat = "";
$imt    = "";
$ket    = "";
$sukses = "";
$error = "";


if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from bmi where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from bmi where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $nomorhp        = $r1['nomorhp'];
    $nama           = $r1['nama'];
    $tinggi         = $r1['tinggi'];
    $berat          = $r1['berat'];

    if ($nomorhp == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['hitung'])) { //untuk create
    $nomorhp        = $_POST['nomorhp'];
    $nama           = $_POST['nama'];
    $tinggi         = $_POST['tinggi'];
    $berat          = $_POST['berat'];
    

    if ($nomorhp && $nama && $tinggi && $berat) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update bmi set nomorhp = '$nomorhp',nama='$nama',tinggi = '$tinggi',berat='$berat' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into bmi(nomorhp,nama,tinggi,berat) values ('$nomorhp','$nama','$tinggi','$berat')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data bmi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

<title>Kalkulator BMI!</title>
</head>
<body>    
    <Style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </Style>
</head>

<body>
    <div class="mx-auto">
        <!--untuk memasukkan data !-->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ($sukses) {
                    ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                    <?php
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nomorhp" class="col-sm-2 col-form-label">Nomor HP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nomorhp" name="nomorhp" value="<?php echo $nomorhp ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tinggi" class="col-sm-2 col-form-label">Tinggi Badan</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="tinggi" name="tinggi"
                                value="<?php echo $tinggi ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="berat" class="col-sm-2 col-form-label">Berat Badan</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="berat" name="berat"
                                value="<?php echo $berat ?>">
                        </div>
                    </div>
                
                        <div class="col-12">
                            <input type="submit" name="hitung" value="hitung" class="btn btn-primary" />
                        </div>
                    </form>
                    <?php 
                if(isset($_POST['hitung'])){
                    $tinggi = $_POST['tinggi'];
                    $berat = $_POST['berat'];

                    $tinggi = $tinggi/100;
                    $hitung = $berat / ($tinggi * $tinggi);
                    if($hitung < 17){
                        echo'
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Tinggi Badan: '.$tinggi.' m<br>
                            Berat Badan : '.$berat.' Kg<br>
                            BMI         : '.number_format($hitung,1).'<br>
                            Keterangan : Sangat Kurus
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        ';
                    }elseif( ($hitung) >= 17 && ($hitung <18.5) ){
                        echo'
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Tinggi Badan: '.$tinggi.' m<br>
                            Berat Badan : '.$berat.' Kg<br>
                            BMI         : '.number_format($hitung,1).'<br>
                            Keterangan : Kurus
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        ';
                    }elseif( ($hitung) >= 18.5 && ($hitung <25) ){
                        echo'
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Tinggi Badan: '.$tinggi.' m<br>
                            Berat Badan : '.$berat.' Kg<br>
                            BMI         : '.number_format($hitung,1).'<br>
                            Keterangan : Normal
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        ';
                    }elseif( ($hitung) >25 && ($hitung <=27) ){
                        echo'
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Tinggi Badan: '.$tinggi.' m<br>
                            Berat Badan : '.$berat.' Kg<br>
                            BMI         : '.number_format($hitung,1).'<br>
                            Keterangan : Gemuk
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        ';
                    }elseif( $hitung > 27 ){
                        echo'
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Tinggi Badan: '.$tinggi.' m<br>
                            Berat Badan : '.$berat.' Kg<br>
                            BMI         : '.number_format($hitung,1).'<br>
                            Keterangan : Obesitas
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        ';
                    }
                }
            ?>
       
                </div>
            </div>

            <!-- untuk mengeluarkan data !-->
            <div class="card">
                <div class="card-header text-white bg-secondary">
                    Data bmi
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nomor HP</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Tinggi Badan</th>
                                <th scope="col">Berat Badan</th>
                                <th scope="col">IMT Anda</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        <tinggiody>
                        <?php
                                $sql2 = "select * from bmi order by id desc";
                                $q2 = mysqli_query($koneksi, $sql2);
                                $urut = 1;
                                while ($r2 = mysqli_fetch_array($q2)) {
                                    $id         = $r2['id'];
                                    $nomorhp    = $r2['nomorhp'];
                                    $nama       = $r2['nama'];
                                    $tinggi     = $r2['tinggi'];
                                    $berat      = $r2['berat'];
                                    ?>
                            <tr>
                                <th scope="row">
                                    <?php echo $urut++ ?>
                                </th>
                                <td scope="row">
                                    <?php echo $nomorhp ?>
                                </td>
                                <td scope="row">
                                    <?php echo $nama ?>
                                </td>
                                <td scope="row">
                                    <?php echo $tinggi ?>
                                </td>
                                <td scope="row">
                                    <?php echo $berat ?>
                                </td>
                                <td scope="row">
                                    <?php echo $imt ?>
                                </td>
                                <td scope="row">
                                    <?php echo $ket ?>
                                </td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                            <?php
                                }
                                ?>
                    </tinggiody>
                    </thead>
                </table>
                     </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>

</html>