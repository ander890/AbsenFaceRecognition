<?php
include_once('../function/koneksi.php');
session_start();
if(!isset($_SESSION['login'])){
    header("location:login.php");    
}

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <!-- Load File bootstrap.min.css yang ada difolder css -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">    
    <style>
    .align-middle{
      vertical-align: middle !important;
    }
    </style>
  </head>
  <body>
      <div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-8">Admin Login</h1>
    <a class="btn btn-success float-right text-white" href="logout.php">Logout</a>
  </div>
</div>

    
    <div style="padding: 0 15px;">
      <div class="table-responsive">
        <table class="table table-bordered">
          <tr>
            <th class="text-center">NO</th>
            <th>Nama</th>
            <th>Jam In</th>
            <th>Foto In</th>
            <th>Jam Out</th>
            <th>Foto Out</th>
            <th>Tanggal</th>
          </tr>
          <?php
          
          // Cek apakah terdapat data page pada URL
          $page = (isset($_GET['page']))? $_GET['page'] : 1;
          
          $limit = 5; // Jumlah data per halamannya
          
          // Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
          $limit_start = ($page - 1) * $limit;
          
          // Buat query untuk menampilkan data siswa sesuai limit yang ditentukan
          //$sql = $pdo->prepare("SELECT * FROM siswa LIMIT ".$limit_start.",".$limit);
          //$sql->execute(); // Eksekusi querynya
          $sql = mysqli_query($koneksi, "SELECT * FROM reco_kehadiran LIMIT ".$limit_start.",".$limit);
          
          $no = $limit_start + 1; // Untuk penomoran tabel
          while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
          ?>
            <tr>
              <td class="align-middle text-center"><?php echo $no; ?></td>
              <td class="align-middle"><?php echo $data['nama']; ?></td>
              <td class="align-middle"><?php echo $data['jam_in']; ?></td>
              <td class="align-middle"><img width="100px" src="<?php echo $data['foto_in']; ?>" alt="Privacy"></td>
              <td class="align-middle"><?php echo $data['jam_out']; ?></td>
              <td class="align-middle"><img width="100px" src="<?php echo $data['foto_out']; ?>" alt="Privacy"></td>
              <td class="align-middle"><?php echo $data['tanggal']; ?></td>
            </tr>
          <?php
            $no++; // Tambah 1 setiap kali looping
          }
          ?>
        </table>
      </div>

      <ul class="pagination">
        <!-- LINK FIRST AND PREV -->
        <?php
        if($page == 1){ // Jika page adalah page ke 1, maka disable link PREV
        ?>
          <li class="disabled"><a href="#">First</a></li>
          <li class="disabled"><a href="#">&laquo;</a></li>
        <?php
        }else{ // Jika page bukan page ke 1
          $link_prev = ($page > 1)? $page - 1 : 1;
        ?>
          <li><a href="index.php?page=1">First</a></li>
          <li><a href="index.php?page=<?php echo $link_prev; ?>">&laquo;</a></li>
        <?php
        }
        ?>
        
        <?php
        //$sql2 = $pdo->prepare("SELECT COUNT(*) AS jumlah FROM siswa");
        //$sql2->execute(); // Eksekusi querynya
        $sql2 = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM reco_kehadiran");
        $get_jumlah = mysqli_fetch_array($sql2);
        
        $jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamannya
        $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
        $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1; // Untuk awal link number
        $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number
        
        for($i = $start_number; $i <= $end_number; $i++){
          $link_active = ($page == $i)? ' class="active"' : '';
        ?>
          <li<?php echo $link_active; ?>><a href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php
        }
        ?>
        
        <!-- LINK NEXT AND LAST -->
        <?php
        // Jika page sama dengan jumlah page, maka disable link NEXT nya
        // Artinya page tersebut adalah page terakhir 
        if($page == $jumlah_page){ // Jika page terakhir
        ?>
          <li class="disabled"><a href="#">&raquo;</a></li>
          <li class="disabled"><a href="#">Last</a></li>
        <?php
        }else{ // Jika Bukan page terakhir
          $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
        ?>
          <li><a href="index.php?page=<?php echo $link_next; ?>">&raquo;</a></li>
          <li><a href="index.php?page=<?php echo $jumlah_page; ?>">Last</a></li>
        <?php
        }
        ?>
      </ul>
    </div>
  </body>
</html>