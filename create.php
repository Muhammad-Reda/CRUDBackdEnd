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
                $nis = $_POST["nis"];
                $nisn = $_POST["nisn"];
                $nama = $_POST["nama"];
                $tanggal_lahir = $_POST["tanggal_lahir"];
                $agama = $_POST["agama"];
                $alamat = $_POST["alamat"];
                $sql = $connect->prepare("SELECT *  FROM siswa WHERE nis =:nis");
                $array_execute[":nis"] = $nis;
                $sql -> execute($array_execute);
                $sqlNumOfRows = $sql->rowCount();

                if ($sqlNumOfRows < 1){
                    $sql2 = $connect->prepare("INSERT INTO siswa (nis,nisn,nama,tanggal_lahir,agama,alamat)
                                                    VALUES(:nis,:nisn,:nama,:tanggal_lahir,:agama,:alamat)");

                    $array_execute[":nis"] = $nis;
                    $array_execute[":nisn"] = $nisn;
                    $array_execute[":nama"] = $nama;
                    $array_execute[":tanggal_lahir"] = $tanggal_lahir;
                    $array_execute[":agama"] = $agama;
                    $array_execute[":alamat"] = $alamat;
                    if ($sql2 -> execute($array_execute)){
                        $result['message'] = "Berhasil menambah siswa ($nama) !";
                    }else{
                        $result["error"] = true;
                        $result["message"] = "Gagal menambah siswa";
                    }
                }else{
                    $result["error"] = true;
                    $result['message'] = "Nis ($nis) sudah ada ";
                }
        }else{
            $result["error"] = true;
            $result["message"] = "post method needed";
        }


        echo json_encode($result, JSON_PRETTY_PRINT);
