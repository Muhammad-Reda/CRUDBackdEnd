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


    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $isbn = $_POST["isbn"];
        $judul = $_POST["judul"];
        $pengarang= $_POST["pengarang"];
        $abstrak = $_POST["abstrak"];
        $tanggal_terbit = $_POST["tanggal_terbit"];
        $penerbit = $_POST["penerbit"];
        $sql = $connect->prepare("SELECT *  FROM buku WHERE isbn =:isbn");
        $array_execute[":isbn"] = $isbn;
        $sql -> execute($array_execute);
        $sqlNumOfRows = $sql->rowCount();

        if ($sqlNumOfRows > 0){
            $sql2 = $connect->prepare("UPDATE buku 
                                                            SET 
                                                                isbn = :isbn,
                                                                judul = :judul,
                                                                pengarang = :pengarang,
                                                                abstrak = :abstrak,
                                                                tanggal_terbit = :tanggal_terbit,
                                                                penerbit = :penerbit
                                                            WHERE 
                                                                isbn =:isbn");
            $array_execute[":isbn"] = $isbn;
            $array_execute[":judul"] = $judul;
            $array_execute[":pengarang"] = $pengarang;
            $array_execute[":abstrak"] = $abstrak;
            $array_execute[":tanggal_terbit"] = $tanggal_terbit;
            $array_execute[":penerbit"] = $penerbit;
            if ($sql2 -> execute($array_execute)){
                $result['message'] = "Berhasil update buku ($isbn)!";
            }else{
                $result["error"] = true;
                $result["message"] = "Gagal update buku";
            }
        }else{
            $result["error"] = true;
            $result['message'] = "TISBN ($isbn) tidak ditemukan! ";
        }
    }else{
        $result['message'] = "POST method needed";
    }

    echo json_encode($result,JSON_PRETTY_PRINT);
