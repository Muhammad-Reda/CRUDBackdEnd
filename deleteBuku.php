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
        $isbn = $_POST["isbn"];
        $sql = $connect->prepare("SELECT *  FROM buku WHERE isbn =:isbn");
        $array_execute[":isbn"] = $isbn;
        $sql->execute($array_execute);
        $sqlNumOfRows = $sql->rowCount();
        if ($sqlNumOfRows >= 1) {
            $sql2 = $connect->prepare("DELETE FROM buku WHERE isbn =:isbn");
            $array_executes[":isbn"] = $isbn;
            if ($sql2 -> execute($array_executes)) {
                $result['message'] = "Berhasil menghapus buku!";
            } else {
                $result["error"] = true;
                $result["message"] = "Gagal menghapus Buku!";
            }
        } else {
            $result["error"] = true;
            $result['message'] = "ISBN ($isbn) tidak ditemukan!";
        }
    }else{
        $result['message'] = "POST method needed";
    }

    echo json_encode($result,JSON_PRETTY_PRINT);