<?php
// Koneksi Database
$koneksi = mysqli_connect("localhost", "root", "", "phpdasar");

// membuat fungsi query dalam bentuk array
function query($query)
{
    // Koneksi database
    global $koneksi;

    $result = mysqli_query($koneksi, $query);

    // membuat varibale array
    $rows = [];

    // mengambil semua data dalam bentuk array
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

// Membuat fungsi tambah
function tambah($data)
{
    global $koneksi;
    $ID = htmlspecialchars($data['ID']);
    $NIM = htmlspecialchars($data['NIM']);
    $NamaMhs = htmlspecialchars($data['NamaMhs']);
    $jekel = $data['jekel'];
    $Alamat = htmlspecialchars($data['Alamat']);
    $Kota = htmlspecialchars($data['Kota']);
    $email = htmlspecialchars($data['email']);
    $Foto = upload();
    

    if (!$Foto) {
        return false;
    }

    $sql = "INSERT INTO mahasiswa VALUES ('$ID','$NIM','$NamaMhs','$jekel','$Alamat','$Kota','$email','$Foto')";

    mysqli_query($koneksi, $sql);

    return mysqli_affected_rows($koneksi);
}

// Membuat fungsi hapus
function hapus($NIM)
{
    global $koneksi;

    mysqli_query($koneksi, "DELETE FROM mahasiswa WHERE NIM = $NIM");
    return mysqli_affected_rows($koneksi);
}

// Membuat fungsi ubah
function ubah($data)
{
    global $koneksi;

    $ID = htmlspecialchars($data['ID']);
    $NIM = htmlspecialchars($data['NIM']);
    $NamaMhs = htmlspecialchars($data['NamaMhs']);
    $jekel = $data['jekel'];
    $Alamat = htmlspecialchars($data['Alamat']);
    $Kota = htmlspecialchars($data['Kota']);
    $email = htmlspecialchars($data['email']);
    $Foto = upload();
    $FotoLama = $data['Fotolama'];

    if ($_FILES['Foto']['error'] === 4) {
        $Foto = $FotoLama;
    } else { 
        $Foto = upload();
    }

    $sql = "UPDATE mahasiswa SET ID = '$ID',NamaMhs = '$NamaMhs',  jekel = '$jekel',Alamat = '$Alamat', Kota = '$Kota'  email = '$email', Foto = '$Foto',  WHERE NIM = '$NIM'";

    mysqli_query($koneksi, $sql);

    return mysqli_affected_rows($koneksi);
}

// Membuat fungsi upload Foto
function upload()
{
    // Syarat
    $namaFile = $_FILES['Foto']['name'];
    $ukuranFile = $_FILES['Foto']['size'];
    $error = $_FILES['Foto']['error'];
    $tmpName = $_FILES['Foto']['tmp_name'];

    // Jika tidak mengupload Foto atau tidak memenuhi persyaratan diatas maka akan menampilkan alert dibawah
    if ($error === 4) {
        echo "<script>alert('Pilih Foto terlebih dahulu!');</script>";
        return false;
    }

    // format atau ekstensi yang diperbolehkan untuk upload Foto adalah
    $extValid = ['jpg', 'jpeg', 'png'];
    $ext = explode('.', $namaFile);
    $ext = strtolower(end($ext));

    // Jika format atau ekstensi bukan Foto maka akan menampilkan alert dibawah
    if (!in_array($ext, $extValid)) {
        echo "<script>alert('Yang anda upload bukanlah Foto!');</script>";
        return false;
    }

    // Jika ukuran Foto lebih dari 3.000.000 byte maka akan menampilkan alert dibawah
    if ($ukuranFile > 3000000) {
        echo "<script>alert('Ukuran Foto anda terlalu besar!');</script>";
        return false;
    }

    // NamaMhs Foto akan berubah angka acak/unik jika sudah berhasil tersimpan
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ext;

    // memindahkan file ke dalam folde img dengan NamaMhs baru
    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    return $namaFileBaru;
}
