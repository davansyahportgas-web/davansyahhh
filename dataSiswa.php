<?php
session_start();

// bikin array kosong kalau belum ada
if(!isset($_SESSION['biodata'])){
    $_SESSION['biodata'] = [];
}

// simpan data baru
if(isset($_POST['simpan'])){
    foreach($_POST['data'] as $d){
        $_SESSION['biodata'][] = $d;
    }
}

// kalau selesai
if(isset($_POST['selesai'])){
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Selesai</title>
        <style>
            body{font-family:Arial; text-align:center; margin-top:100px; background:#f5f5f5;}
            .box{background:white; padding:30px; border-radius:8px; display:inline-block; box-shadow:0 0 5px #aaa;}
            h2{margin-bottom:20px;}
            .btn{padding:10px 20px; border:none; background:#007bff; color:white; border-radius:4px; cursor:pointer;}
            .btn:hover{background:#0056b3;}
        </style>
    </head>
    <body>
        <div class='box'>
            <h2>Terima kasih, data sudah disubmit</h2>
            <form method='post'>
                <input type='submit' class='btn' name='reset' value='Kembali ke Awal'>
            </form>
        </div>
    </body>
    </html>";
    exit;
}

// reset session
if(isset($_POST['reset'])){
    session_destroy();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Form Biodata</title>
    <style>
        body{font-family: Arial, sans-serif; margin:20px; background:#f9f9f9;}
        h2{margin-bottom:10px;}
        .form-box{background:#fff; padding:15px; border-radius:6px; box-shadow:0 0 5px #ccc; width:fit-content;}
        table{border-collapse: collapse; margin-top:15px; background:white; box-shadow:0 0 5px #ddd;}
        table, th, td{border:1px solid #000; padding:8px;}
        th{background:#007bff; color:white;}
        input[type=text], input[type=number]{width:95%; padding:5px; border:1px solid #ccc; border-radius:3px;}
        
        /* Tambahan biar tombol Lanjut gak nempel sama input */
        form input[type=number] {
            margin-bottom: 10px;
        }
        
        .btn{margin-top:8px; padding:7px 15px; border:none; background:#28a745; color:white; border-radius:3px; cursor:pointer;}
        .btn:hover{background:#218838;}
        .btn-danger{background:#dc3545;}
        .btn-danger:hover{background:#b52a37;}
    </style>
</head>
<body>

<h2>Form Biodata Dinamis</h2>

<div class="form-box">
<?php
// form jumlah data
if(!isset($_POST['lanjut']) && !isset($_POST['simpan'])){ ?>
    <form method="post">
        Masukkan jumlah data: <input type="number" name="jumlah" min="1" required><br>
        <input type="submit" name="lanjut" class="btn" value="Lanjut">
    </form>
<?php }

// form input data
if(isset($_POST['lanjut'])){
    $jumlah = $_POST['jumlah'];
    echo "<form method='post'>";
    echo "<table>";
    echo "<tr><th>No</th><th>NIS</th><th>Nama Lengkap</th><th>Usia</th></tr>";
    for($i=1; $i<=$jumlah; $i++){
        echo "<tr>";
        echo "<td style='text-align:center;'>$i</td>";
        echo "<td><input type='text' name='data[$i][nis]' required></td>";
        echo "<td><input type='text' name='data[$i][lengkap]' required></td>";
        echo "<td><input type='number' name='data[$i][usia]' required></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<br><input type='submit' name='simpan' class='btn' value='Simpan Data'>";
    echo "</form>";
}

// tampilkan tabel hasil
if(!empty($_SESSION['biodata'])){
    echo "<h3>Data Tersimpan</h3>";
    echo "<table>";
    echo "<tr><th>No</th><th>NIS</th><th>Nama Lengkap</th><th>Usia</th></tr>";
    $no=1;
    foreach($_SESSION['biodata'] as $row){
        echo "<tr>";
        echo "<td style='text-align:center;'>".$no++."</td>";
        echo "<td>".$row['nis']."</td>";
        echo "<td>".$row['lengkap']."</td>";
        echo "<td>".$row['usia']."</td>";
        echo "</tr>";
    }
    echo "</table>";

    echo "<br><form method='post'>";
    echo "Tambah data lagi: <input type='number' name='jumlah' min='1'> ";
    echo "<input type='submit' name='lanjut' class='btn' value='Tambah'>";
    echo "</form>";

    echo "<form method='post'><input type='submit' name='selesai' class='btn btn-danger' value='Selesai'></form>";
}
?>
</div>

</body>
</html>>