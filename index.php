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

//cek jika tombol login diklik
if(isset($_POST['blogin'])){

  //ambil data dari form
  $username = $_POST['tusername'];
  $password = $_POST['tpassword'];

  //cek jika username dan password benar
  $q = mysqli_query($mysqli, "SELECT * FROM tbl_user WHERE username = '$username' AND password = '$password' ");
  $$data = mysqli_fetch_array($q);

  if($data){
    //jika benar, maka login berhasil
    session_start();
    $_SESSION['username'] = $username;
    header("location:form.php");
  }else{
    //jika salah, maka login gagal
    echo "<script>alert('login gagal');</script>";
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
    <style>
      body {
        background-color: rgba(255, 99, 71, 0.1);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;    
        
      }
    </style>
  </head>
  <body>


    <!--Awal Row-->
        <div class="row">
    <!--Awal col-md-4 -->
        <div class="col-md-50 mx-auto">
    <!--JUDUL-->
    <div class="container" style="font-family: Arial, Helvetica, sans-serif">
      <h3 class="text-center">Inventaris Kantor</h3>
    </div>
    <!--Awal card-->
        <div class="card">
        <div class="card-header text-dark text-center" style="background-color:rgba(255, 99, 71, 0.5)";>
            Login
        </div>
        <div class="card-body" style="background-color:rgba(255, 99, 71, 0.3)";>
            <!--Awal Form-->
            <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="tusername" class="form-control" placeholder="Masukan Username">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="tpassword" class="form-control" placeholder="Masukan Password">
            </div>

            <button class="btn btn-primary" name="blogin" type="submit">Sign In</button>
            </form>
            <!--Akhir Form-->
        </div>
        </div>
    <!--Akhir card-->
        </div>
    <!--Akhir Col-md-4 -->
        </div>
    <!--Akhir Row-->
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
