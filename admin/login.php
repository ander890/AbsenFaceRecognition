<?php
include_once('../function/koneksi.php');
session_start();
if(isset($_SESSION['login'])){
    header("location:index.php");    
}

if(isset($_POST['username'])){
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = hash('sha256', mysqli_real_escape_string($koneksi, $_POST['password']));
    
    $query = mysqli_query($koneksi, "SELECT * FROM reco_admin WHERE username='$username' AND password='$password'");
    if(mysqli_num_rows($query) != 0){
        echo '
        <script>
        alert("Berhasil Login");
        window.location.href = "index.php";
        </script>';
        $_SESSION['login'] = "yes";
    }else{
        echo '
        <script>
        alert("Username / Password Salah");
        </script>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <style type="text/css">
        #results { padding:20px; border:1px solid; background:#ccc; }
    </style>
    <meta name="viewport" content="initial-scale=1">
</head>
<body>

<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-8">Admin Login</h1>
  </div>
</div>
  
<div class="container">   
    <form method="POST">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <label> Username </label>
                <input type="text" name="username" class="form-control">
                <label> Password </label>
                <input type="password" name="password" class="form-control">
                <br>
                <button type="submit" class="btn btn-success btn-block">Login</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>