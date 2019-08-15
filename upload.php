<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('function/koneksi.php');    
$tanggal = date('d-m-Y');
$jam = date('H:i:s');
$img = $_POST['image'];
$folderPath = "upload/";
$image_parts = explode(";base64,", $img);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);
$fileName = uniqid() . '.png';
$file = $folderPath . $fileName;
file_put_contents($file, $image_base64);
//print_r($fileName);


$final_url = URL."/".$folderPath.$fileName;
$action = mysqli_real_escape_string($koneksi, $_GET['action']);

if($action == "train"){
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);

    $data = [
        'name' => $nama
    ];
    
    $new_person = sendAPI("https://".LOCATION.".api.cognitive.microsoft.com/face/v1.0/largepersongroups/face-reco/persons", $data);

    $person_id = $new_person->personId;
    
    if($person_id){
        $data2 = [
            'url' => $final_url
        ];
        $add_face = sendAPI("https://".LOCATION.".api.cognitive.microsoft.com/face/v1.0/largepersongroups/face-reco/persons/".$person_id."/persistedfaces", $data2);
        $face_id = $add_face->persistedFaceId;
        
        if($face_id == ""){
            echo '
            <script>
            alert("Wajah Tidak Terdeteksi");
            window.location.href = "index.php";
            </script>';
            exit();
        }
        
        
        mysqli_query($koneksi, "INSERT INTO reco_user(nama, person_id, face_id, wajah) VALUES ('$nama', '$person_id', '$face_id', '$final_url')");
        train();
        
        echo '
        <script>
        alert("Berhasil Menambahkan Wajah, Silahkan Absen");
        window.location.href = "index.php";
        </script>';
    }else{
        echo '
        <script>
        alert("Wajah Tidak Terdeteksi");
        window.location.href = "train.php";
        </script>';
        exit();
    }
    
}

if($action == "verify"){
    $data = [
        "url" => $final_url
        ];
        
    $detect = sendAPI("https://".LOCATION.".api.cognitive.microsoft.com/face/v1.0/detect", $data);
    
    $face_id = $detect[0]->faceId;
    
    if(!$face_id){
        echo '
        <script>
        alert("Wajah Tidak Terdeteksi");
        window.location.href = "index.php";
        </script>';
        exit();
    }

    
    if($face_id == ""){
        echo '
        <script>
        alert("Wajah Tidak Terdeteksi");
        window.location.href = "index.php";
        </script>';
        exit();
    }else{
    
    
    $data2 = [
        "faceIds" => array($face_id),
        "largePersonGroupId" => "face-reco",
        "maxNumOfCandidatesReturned" => 1,
        "confidenceThreshold" => 0.5
        ];
    $verify = sendAPI("https://".LOCATION.".api.cognitive.microsoft.com/face/v1.0/identify", $data2);
    //print_r($verify);
    //exit();
    $person_id_final = $verify[0]->candidates[0]->personId;
    if($person_id_final){
        $user = get_detail_user($person_id_final);
        $nama = $user['nama'];
        if(!$nama){
            echo '
            <script>
            alert("GAGAL MENDETEKSI :(");
            window.location.href = "index.php";
            </script>';
            exit();
        }
        $id = $user['id'];
        cek_absen($id);
        $status = cek_status_absen($id);
        if($status == "BELUM"){
            mysqli_query($koneksi, "INSERT INTO reco_kehadiran (id_user, nama, jam_in, foto_in, tanggal) VALUES ('$id', '$nama', '$jam', '$final_url', '$tanggal')");
            echo '
            <script>
            alert("Berhasil Check In! Selamat Datang '.$nama.' :)");
            window.location.href = "index.php";
            </script>';
            exit();
        }else{
            mysqli_query($koneksi, "UPDATE reco_kehadiran SET jam_out = '$jam' , foto_out = '$final_url' WHERE tanggal = '$tanggal' AND id_user = '$id'");
            echo '
            <script>
            alert("Berhasil Check Out! Terimakasih '.$nama.' :)");
            window.location.href = "index.php";
            </script>';
            exit();
        }
    }else{
        echo '
        <script>
        alert("Data Wajah Tidak Ditemukan");
        window.location.href = "index.php";
        </script>';
        exit();
    }
    }
    
}
?>