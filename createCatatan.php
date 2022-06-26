<?php

    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Headers:*');
    $host = "localhost";
    $user = "id19120180_cruds";
    $pass = "r%?>xO6FNtIzm+xM";
    $database = "id19120180_crud";

    $connect = new PDO("mysql:host=$host;dbname=$database",$user,$pass);
    $result = array();
    $result["error"] = false;
    $result['message'] = "";
    if ($connect){
        $result["is_db_connected"] = true;
        $result["connection_msg"] = "Berhasil terhubung!";
    }else{
        $result["is_db_connected"] = false;
        $result["connection_msg"] = "Gagal terhubung!";
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $kode = $_POST["kode"];
        $nama_peminjam = $_POST["nama_peminjam"];
        $nis = $_POST["nis"];
        $judul = $_POST["judul"];
        $isbn = $_POST["isbn"];
        $tanggal_peminjaman = $_POST["tanggal_peminjaman"];
        $sql = $connect->prepare("SELECT *  FROM peminjaman WHERE kode =:kode");
        $array_execute[":kode"] = $kode;
        $sql -> execute($array_execute);
        $sqlNumOfRows = $sql->rowCount();

        if ($sqlNumOfRows < 1){
            $sql2 = $connect->prepare("INSERT INTO peminjaman (kode, nama_peminjam, nis, judul, isbn, tanggal_peminjaman)
                                                        VALUES(:kode,:nama_peminjam,:nis,:judul,:isbn,:tanggal_peminjaman)");
            $array_execute[":kode"] = $kode;
            $array_execute[":nama_peminjam"] = $nama_peminjam;
            $array_execute[":nis"] = $nis;
            $array_execute[":judul"] = $judul;
            $array_execute[":isbn"] = $isbn;
            $array_execute[":tanggal_peminjaman"] = $tanggal_peminjaman;
            if ($sql2 -> execute($array_execute)){
                $result['message'] = "Berhasil membuat catatan!";
            }else{
                $result["error"] = true;
                $result["message"] = "Gagal membuat catatan!";
            }
        }else{
            $result["error"] = true;
            $result['message'] = "kode ($kode) sudah ada! ";
        }
    }else{
        $result["error"] = true;
        $result["message"] = "post method needed";
    }


    echo json_encode($result, JSON_PRETTY_PRINT);
