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
            $sql = $connect->prepare("DELETE FROM siswa");
            if ($sql -> execute()){
                $result["message"] = "Berhasil menghapus seluruh data!";
            }else{
                $result["message"] = "Gagal menghapus seluruh data!";
                $result["error"] = true;
            }
        }else{
            $result['messages'] = "POST method needed";
        }

        echo json_encode($result,JSON_PRETTY_PRINT);