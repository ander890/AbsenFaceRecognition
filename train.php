<!DOCTYPE html>
<html>
<head>
    <title>Absen Face Reco</title>
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
    <h1 class="display-8">Absensi Face Recognition</h1>
    <p class="lead" id="jam"></p>

  </div>
</div>
  
<div class="container">   
    <form method="POST" action="upload.php?action=train">
        <div class="row">
            <div class="col-md-6">
                <div id="my_camera"></div>
                <br/>
                <input type="hidden" name="image" class="image-tag">
            </div>
            <div class="col-md-6">
                <br/>
                <input type="text" name="nama" placeholder="Nama" class="form-control">
                <br>
                <button type="submit" onClick="take_snapshot()" class="btn btn-success btn-block">SUBMIT</button>
                <a href="index.php" class="btn btn-warning btn-block text-white">ABSEN</a>

            </div>
        </div>
    </form>
</div>

<script>
var myVar=setInterval(function(){myTimer()},1000);

function myTimer() {
    var d = new Date();
    document.getElementById("jam").innerHTML = "Selamat Datang !, Waktu Sekarang : "+d.toLocaleTimeString();
}
</script>
  
<script language="JavaScript">
    Webcam.set({
        width: 490,
        height: 390,
        image_format: 'jpeg',
        jpeg_quality: 100
    });
  
    Webcam.attach( '#my_camera' );
  
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
</script>
 
</body>
</html>