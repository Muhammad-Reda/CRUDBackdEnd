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
        $sql = $connect->prepare("SELECT *  FROM peminjaman WHERE kode =:kode");
        $array_execute[":kode"] = $kode;
        $sql->execute($array_execute);
        $sqlNumOfRows = $sql->rowCount();
        if ($sqlNumOfRows >= 1) {
            $sql2 = $connect->prepare("DELETE FROM peminjaman WHERE kode =:kode");
            $array_executes[":kode"] = $kode;
            if ($sql2 -> execute($array_executes)) {
                $result['message'] = "Berhasil menghapus catatan!";
            } else {
                $result["error"] = true;
                $result["message"] = "Gagal menghapus catatan!";
            }
        } else {
            $result["error"] = true;
            $result['message'] = "Catatan ($kode) tidak ditemukan! ";
        }
    }else{
        $result['message'] = "POST method needed";
    }

    echo json_encode($result,JSON_PRETTY_PRINT);