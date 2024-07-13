<?php

//koneksi database
$host = "localhost";
$user = "root";
$password = "";
$db = "db_crud";
$port = "3307";

//buat koneksi
$mysqli = new mysqli($host,$user,$password,$db,$port);

// Check connection
if ($mysqli -> connect_error) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

//kode otomatis
$q = mysqli_query($mysqli, "SELECT kode FROM tbarang ORDER BY kode DESC LIMIT 1"); 
$datax = mysqli_fetch_array($q);
if($datax){
  $no_terakhir = substr($datax['kode'], -3);
  $no = $no_terakhir + 1;

  if($no > 0 and $no < 10 ){
    $kode = "00".$no;
  }else if($no > 10 and $no < 100 ){
    $kode = "0".$no;
  }else if($no > 100){
    $kode = $no;
  }
}else{
  $kode = "001";
}
$tahun = date('Y');
$vkode = "INV-".$tahun.'-'.$kode;
//INV-2024-001

//LOGIN
session_start();

if(!isset($_SESSION['username'])){
  header("location:index.php");
  exit();
}

//jika tombol simpan di klik
if(isset($_POST['bsimpan'])){
  
//pengujian apakah data akan diedit atau disimpan baru
if(isset($_GET['hal']) == "edit"){
//data akan diedit
$edit = mysqli_query($mysqli, "UPDATE tbarang SET
                              nama = '$_POST[tnama]',
                              asal = '$_POST[tasal]',
                              nama = '$_POST[tnama]',
                              jumlah = '$_POST[tjumlah]',
                              satuan = '$_POST[tsatuan]',
                              tanggal_diterima = '$_POST[ttanggal_diterima]'
                              WHERE id_barang = '$_GET[id]'");
  //pengujian
 if($edit){
 echo "<script>
 alert('Edit Data Sukses');
  document.location='form.php';
  </script>";
 }else{
 echo "<script>
 alert('Edit Data Gagal');
 document.location='form.php';
 </script>";
      }
    }else{
      //data akan disimpan baru
      $simpan = mysqli_query($mysqli, " INSERT INTO tbarang (kode, nama, asal, jumlah, satuan, tanggal_diterima)
                                       VALUE ( '$_POST[tkode]',
                                               '$_POST[tnama]',
                                               '$_POST[tasal]',
                                               '$_POST[tjumlah]',
                                               '$_POST[tsatuan]',
                                               '$_POST[ttanggal_diterima]')
                                     ");
      //uji jika simpan data sukses
      if($simpan){
        echo "<script>
                  alert('Simpan Data Sukses');
                  document.location='form.php';
              </script>";
      }else{
        echo "<script>
                  alert('Simpan Data Gagal');
                  document.location='form.php';
              </script>";
      }
    }   
}


//deklarasi variabel utk menampung data yg akan diedit
$vnama = "";
$vasal = "";
$vjumlah = "";
$vsatuan = "";
$vtanggal_diterima = "";


//pengujian jika tombol edit/hapus diklik
if(isset($_GET['hal'])){

    //pengujian jika edit data
    if($_GET['hal'] == "edit"){

      //tampilkan data yg akan diedit
      $tampil = mysqli_query($mysqli, "SELECT*FROM tbarang WHERE id_barang = '$_GET[id]' ");
      $data = mysqli_fetch_array($tampil);
      if($data){
        //jika data ditemukan, maka ditampung ke dlm variabel
        $vkode = $data['kode'];
        $vnama = $data['nama'];
        $vasal = $data['asal'];
        $vjumlah = $data['jumlah'];
        $vsatuan = $data['satuan'];
        $vtanggal_diterima = $data['tanggal_diterima'];
      }
    }else if($_GET['hal'] == "hapus"){
      //persiapan hapus data
       $hapus = mysqli_query($mysqli, "DELETE FROM tbarang WHERE id_barang = '$_GET[id]' ");
       //uji jika hapus data sukses
      if($hapus){
        echo "<script>
                  alert('Hapus Data Sukse');
                  document.location='form.php';
              </script>";
      }else{
        echo "<script>
                  alert('Hapus Data Gagal');
                  document.location='form.php';
              </script>";
      }
    }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>

<!-- Awal container-->  
    <div class="container">

    <h3 class="text-center">Data Inventaris</h3>
    <h3 class="text-center">Kantor</h3>
<!--Awal Row-->
    <div class="row">
<!--Awal col-md-8 -->
      <div class="col-md-8 mx-auto">
<!--Awal card-->
      <div class="card">
       <div class="card-header text-dark" style="background-color:rgba(255, 99, 71, 0.5)";>
         Form Input Data Barang
       </div>
       <div class="card-body">
        <!--Awal Form-->
          <form method="POST">
          <div class="mb-3">
            <label class="form-label">Kode Barang</label>
            <input type="text" name="tkode" value="<?=$vkode?>" class="form-control" placeholder="Masukan Kode Barang">
          </div>

          <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="tnama" value="<?=$vnama?>" class="form-control" placeholder="Masukan Nama Barang">
          </div>

          <div class="mb-3">
            <label class="form-label">Asal Barang</label>
            <select class="form-select" name="tasal">
              <option value="<?=$vasal?>"><?=$vasal?></option>
              <option value="Pembelian">Pembelian</option>
              <option value="Hibah">Hibah</option>
              <option value="Sumbangan">sumbangan</option>
              <option value="Bantuan">bantuan</option>
            </select>
          </div>

          <div class="row">
            <div calss="col">
              <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" name="tjumlah" value="<?=$vjumlah?>" class="form-control" placeholder="Jumlah Barang">
              </div>
            </div>

            <div class="col">
              <div class="mb-3">
                <label class="form-label">Satuan</label>
                <select class="form-select" name="tsatuan">
                  <option value="<?=$vsatuan?>"><?=$vsatuan?></option>
                  <option value="Unit">Unit</option>
                  <option value="Kotak">Kotak</option>
                  <option value="Pieces">Pieces</option>
                  <option value="Box">Box</option>
                </select>
              </div>
            </div>

            <div class="col">
              <div class="mb-3">
                <label class="form-label">Tanggal Diterima</label>
                <input type="date" name="ttanggal_diterim" value="<?=$vtanggal_diterima?>" class="form-control" placeholder="Jumlah Barang">
              </div>
            </div>

            <div class="text-center">
              <hr>
              <button class="btn btn-primary" name="bsimpan" type="submit">Simpan</button>
              <button class="btn btn-danger" name="bkosongkan" type="reset">Kosongkan</button>
            </div>

          </div>
          </form>
</div>
        <!--Akhir Form-->
       </div>
      </div>
<!--Akhir card-->
      </div>
<!--Akhir Col-md-8 -->
    </div>
<!--Akhir Row-->

<!--Awal card-->
<div class="card mt-4 col-md-8 mx-auto">
       <div class="card-header text-dark" style="background-color:rgba(255, 99, 71, 0.5)";>
         Data Barang
       </div>
       <div class="card-body">
        <div class="col-md-6 mx-auto">
          <form method="POST">
            <div class="input-group mb-3">
              <input type="text" name="tcari" value="<?=@$_POST['tcari']?>" class="form-control" placeholder="Masukan kata kunci !">
              <button class="btn btn-primary" name="bcari" type="submit">Cari</button>
              <button class="btn btn-danger" name="breset" type="submit">Reset</button>
            </div>
          </form>
        </div>
         <table class="table table-striped table-hover table-bordered">
          <tr>
            <th>No.</th>th>
            <th>Kode Barang</th>th>
            <th>Nama Barang</th>
            <th>Asal Barang</th>
            <th>jumlah</th>
            <th>Tanggal Diterima</th>
            <th>Aksi</th>
          </tr>

          <?php
            //persiapan menampilkan data
            $no = 1;

            //untuk pencarian data
              //jika tombol cari diklik
              if(isset($_POST['bcari'])){
                //tampilkan data yg dicari
                $keyword = $_POST['tcari'];
                $q = "SELECT * FROM tbarang WHERE kode like '%$keyword%' or nama like '%$keyword%' or asal like '%$keyword%' ORDER BY id_barang DESC";
              }else{
                $q = "SELECT * FROM tbarang order by id_barang desc";
              }

            $tampil = mysqli_query($mysqli, $q);
            while($data = mysqli_fetch_array($tampil)) : 
          ?>

          <tr>
            <td><?=$no++ ?></td>
            <td><?=$data['kode']?></td>
            <td><?=$data['nama']?></td>
            <td><?=$data['asal']?></td>
            <td><?=$data['jumlah']?> <?=$data['satuan']?></td>
            <td><?=$data['tanggal_diterima']?></td>
            <td>
              <a href="form.php?hal=edit&id=<?=$data['id_barang']?>" class="btn btn-warning">Edit</a>
              <a href="form.php?hal=hapus&id=<?=$data['id_barang']?>" 
              class="btn btn-danger" onclick="return confirm ('Apakah Anda yakin akan hapus data ini ?')">Hapus</a>
            </td>
          </tr>

          <?php endwhile; ?>

         </table>
       </div>
       <div class="card-footer text-dark" style="background-color:rgba(255, 99, 71, 0.5)">
         <!--LOGOUT-->
          <div calss="d-grid gap-5 d-md-flex justify-content-md-end">
            <button style="background-color:rgba(240, 50, 50, 0.5)" class="me-md-5";><a href="logout.php">Logout</a></button>
          </div>
       </div>
      </div>
<!--Akhir card-->
    </div>
<!-- Akhir container-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
