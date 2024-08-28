<?php

include "connect.php";

if (isset($_POST['username']) && isset($_POST['password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    if (empty($username)) {
        header("Location: index.php?error=Username is required");
        exit();
    } elseif (empty($password)) {
        header("Location: index.php?error=Password is required");
        exit();
    } else {
        // Gunakan prepared statement untuk keamanan yang lebih baik
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = mysqli_prepare($connect, $sql);

        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // Periksa apakah ada satu baris yang ditemukan
            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);

                // Verifikasi password yang di-hash
                if (password_verify($password, $row['password'])) {
                    // Pastikan $_SESSION ditulis dengan benar
                    session_start();
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['nama'] = $row['nama'];
                    $_SESSION['id'] = $row['id'];
                    header("Location: home.php");
                    exit();
                } else {
                    header("Location: index.php?error=Incorrect username or password");
                    exit();
                }
            } else {
                header("Location: index.php?error=Incorrect username or password");
                exit();
            }
        } else {
            header("Location: index.php?error=SQL error");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
