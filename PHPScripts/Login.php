
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src = "http://localhost/ToDoListProject/Formats/check.js"> </script>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            width: 100%;
        }

        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        label {
            font-weight: bold;
        }

        p.error-message {
            color: red;
            text-align: center;
            margin-top: 10px;

        }
    </style>
</head>
<body>
    <?php
    session_start();
    // check if credentials are valid
    $msg = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $valid_username = 'bashar';
        $valid_password = 'password123';

        $username = $_POST['username'];
        $password = $_POST['pass'];

        if ($username === $valid_username && $password === $valid_password) {
            // if valid, redirect to tasks page
            $_SESSION['authenticated'] = true;
            header('Location: http://localhost/ToDoListProject/Formats/');
            // Destroying Session after certain time
            $_SESSION['expire'] = time() + 60 * 60;
            exit;
        } else {
            $msg = 'Invalid username or password.';
        }
    }
    ?>
    <form action="" method = "POST" onsubmit = "">
        <label for="Uname">User name:</label>
        <input type="text" id="username" name = "username"><br><br>
        <label for="pass">Password:</label>
        <input type="password" id="pass" name = "pass"><br><br>
        <input type="submit" value="Login">
        <p class = "error-message"><?php echo isset($msg) ? $msg : ''; ?></p>
    </form>
    

</body>
</html>