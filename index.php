<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .register-link {
            text-align: center;
            margin-top: 20px;
        }

        .register-link a {
            color: rgb(90, 90, 206);
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <form action="login.php" method="post">
        <h2>Login</h2>

        <?php if (isset($_GET['error'])) { ?>
            <p class="error"> <?php echo $_GET['error'];  ?> </p>
        <?php } ?>

        <label>Username</label>
        <input type="text" name="username" placeholder="username"><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="password" autocomplete="off"><br>

        <button type="submit">Login</button>

        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </form>
</body>

</html>