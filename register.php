<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'webtest');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);;

    // Check if the username already exists
    $check_sql = "SELECT * FROM user WHERE username='$username'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists. Please choose a different one.');</script>";
    } else {
        // If username does not exist, proceed with the insert
        $sql = "INSERT INTO user (nama, username, password) VALUES ('$nama', '$username', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful!');</script>";
        } else {
            $error_message = $conn->error;
            echo "<script>alert('Error: " . addslashes($error_message) . "');</script>";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            box-sizing: border-box;
        }

        body {
            background: rgb(84, 84, 243);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            width: 500px;
            border: 2px solid #ccc;
            padding: 30px;
            background: white;
            border-radius: 20px;
        }

        h2 {
            color: rgb(7, 7, 81);
            text-align: center;
            margin-bottom: 40px;
        }

        input {
            display: block;
            border: 2px solid #ccc;
            width: 95%;
            padding: 10px;
            margin: 10px auto;
            border-radius: 10px;
        }

        label {
            color: rgb(7, 7, 81);
            font-size: 18px;
            padding: 10px;
        }

        button {
            display: block;
            width: 95%;
            padding: 10px;
            margin: 10px auto;
            border-radius: 10px;
            background: rgb(90, 90, 206);
            color: white;
            font-size: 15px;
        }

        button:hover {
            opacity: .7;
        }

        .error {
            margin: 20px auto;
            background: rgb(255, 212, 212);
            color: red;
            padding: 10px;
            width: 95%;
            border-radius: 5px;
        }

        .success {
            margin: 20px auto;
            background: rgb(212, 255, 212);
            color: green;
            padding: 10px;
            width: 95%;
            border-radius: 5px;
        }

        .DirectLogin {
            text-align: center;
            margin-top: 20px;
        }

        .DirectLogin a {
            color: rgb(90, 90, 206);
            text-decoration: none;
            font-weight: bold;
        }

        .DirectLogin a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <form action="register.php" method="post">
        <h2>Register</h2>

        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>

        <label for="nama">Nama</label>
        <input type="text" name="nama" placeholder="Nama" required><br>

        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Username" required><br>

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password" required autocomplete="off"><br>

        <button type="submit">Register</button>

        <div class="DirectLogin">
            <p>Already have an account? <a href="index.php">Login here</a></p>
        </div>
    </form>
</body>

</html>