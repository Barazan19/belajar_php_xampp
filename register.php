<?php
    include "service/database.php";
    session_start();

    $register_message = "";
    
    if(isset($_SESSION["is_login"])) {
        header("location: dashboard.php");
    }

    if(isset($_POST["register"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        //meng encrypt password database
        $hash_password = hash("sha256", $password);
        // mitigasi kalo username nya udah ada
        try {
            $sql = "INSERT INTO users (username, password) VALUES ('$username','$hash_password')";

            if($db->query($sql)) {
                $register_message = "Daftar Akun berhasil, silahkan login";
            }else {
                $register_message = "Daftar Akun gagal, silahkan coba lagi";
            }
        } //untuk ngabarin klo username exist
        catch (mysqli_sql_exception) {
            $register_message = "username sudah digunakan, silahkan masukkan yg baru";
        }
        $db->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include "layout/header.html"?>
    <h3>DAPTAR AKUN</h3>
    <i><?= $register_message ?></i>
    <form action="register.php" method="POST">
        <input type="text" placeholder="username" name="username"/>
        <input type="password" placeholder="password" name="password"/>
        <button type="submit" name="register">daftar sekarang</button>
    </form>
    <?php include "layout/footer.html"?>
</body>
</html>