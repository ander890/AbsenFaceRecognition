<?php

$host = "localhost";
$username = "root";
$password = "";
$db = "db_name";

define("URL", "https://url_web.com");
define("API_KEY", "api_key");
define("LOCATION", "eastasia");

$koneksi = mysqli_connect($host, $username, $password, $db) or die("Gagal Konek Database");

function sendAPI($url, $data){
    $data = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Ocp-Apim-Subscription-Key: '.API_KEY
    ));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    $server_output = curl_exec($ch);
    curl_close ($ch);
    
    return json_decode($server_output);
}

function train(){
    $data = [];
    $data = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://".LOCATION.".api.cognitive.microsoft.com/face/v1.0/largepersongroups/face-reco/train");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Ocp-Apim-Subscription-Key: '.API_KEY
    ));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    $server_output = curl_exec($ch);
    curl_close ($ch);
    return json_decode($server_output);
}

function cek_absen($id){
    global $koneksi;
    $tanggal = date('d-m-Y');
    $query = mysqli_query($koneksi , "SELECT * FROM reco_kehadiran WHERE tanggal='$tanggal' AND id_user='$id' LIMIT 1");
    $row = mysqli_fetch_assoc($query);
    if($row['jam_out'] != ""){
        echo '
        <script>
        alert("Sudah Absen Hari Ini");
        window.location.href = "index.php";
        </script>';
        exit();
    }
}

function cek_status_absen($id){
    global $koneksi;
    $tanggal = date('d-m-Y');
    $query = mysqli_query($koneksi, "SELECT * FROM reco_kehadiran WHERE tanggal='$tanggal' AND id_user='$id' LIMIT 1");
    $jumlah = mysqli_num_rows($query);
    if($jumlah == 0){
        return "BELUM";
    }else{
        return "IN";
    }
}

function get_detail_user($person_id){
    global $koneksi;
    $query = mysqli_query($koneksi, "SELECT * FROM reco_user WHERE person_id='$person_id' LIMIT 1");
    $row = mysqli_fetch_assoc($query);
    $return['nama'] = $row['nama'];
    $return['id'] = $row['id'];
    return $return;
}