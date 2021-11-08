<?php

// Memanggil atau membutuhkan file function.php
require 'function.php';

// Mengambil data dari NIM dengan fungsi get
$NIM = $_GET['NIM'];

// Jika fungsi hapus lebih dari 0/data terhapus, maka munculkan alert dibawah
if (hapus($NIM) > 0) {
    echo "<script>
                alert('Data mahasiswa berhasil dihapus!');
                document.location.href = 'index.php';
            </script>";
} else {
    // Jika fungsi hapus dibawah dari 0/data tidak terhapus, maka munculkan alert dibawah
    echo "<script>
            alert('Data mahasiswa gagal dihapus!');
        </script>";
}
