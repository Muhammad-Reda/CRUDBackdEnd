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
                $nama = $_POST["nama"];
                $sql = $connect->prepare("SELECT *  FROM siswa WHERE nis =:nis");
                $array_execute[":nis"] = $nis;
                $sql->execute($array_execute);
                $sqlNumOfRows = $sql->rowCount();
                if ($sqlNumOfRows >= 1) {
                    $sql2 = $connect->prepare("DELETE FROM siswa WHERE nis =:nis");
                    $array_executes[":nis"] = $nis;
                    if ($sql2 -> execute($array_executes)) {
                        $result['message'] = "Berhasil menghapus ($nama) !";
                    } else {
                        $result["error"] = true;
                        $result["message"] = "Gagal menghapus";
                    }
                } else {
                    $result["error"] = true;
                    $result['message'] = "NIS ($nis) tidak ditemukan!";
                }
            }else{
                $result['message'] = "POST method needed";
            }

            echo json_encode($result,JSON_PRETTY_PRINT);