<?php

session_start();

require __DIR__ . '/CheckAuth.php';

checkAuthentication();
/*
    if($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            if(isset($_GET['dueDate']) && strtotime($_GET['dueDate']) < time())
                $msg = "Invalid Date";
            else
            {
                header('Location: http://localhost/ToDoListProject/Formats/TaskTables.php');
                exit();
            }
        }
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
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
            max-width: 400px;
            width: 100%;
            /* margin: 20px; */

        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        .required::after {
            content: "*";
            color: red;
            margin-left: 3px;
        }

        input[type="text"],
        input[type="date"],
        select,
        input[type="submit"] {
            width: 100%;
            padding: 8px;
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
    </style>
    <script src = "http://localhost/ToDoListProject/Formats/check.js"></script>
</head>
<body>
    <form action= "http://localhost/ToDoListProject/Formats/" method = "POST" onsubmit = "return checkStuff()">
        <label >Task<span style="color: red;">*</span></label>
        <input type="text" id="task" name = "task" value = "<?php echo isset($_POST['task']) ? $_POST['task'] : ''; ?>"><br><br>
        <label >Description</label>
        <input type="text" id="descrip" name = "descrip"><br><br>
        <label>Due Date<span style="color: red;">*</span></label>
        <input type="date" id="dueDate" name = "dueDate" value = "<?php echo isset($_POST['dueDate']) ? $_POST['dueDate'] : ''; ?>"> <?php echo isset($msg) ? $msg : ''; ?><br>
        <p id = "invalidDate"></p>
        <label>Completion Status</label>
        <select name="status" id="status">
            <option selected value="toDo">Todo</option>
            <option value="InProgress">InProgress</option>
            <option value="Completed">Completed</option>
        </select><br><br>
        <label>Priority</label>
        <select name="priority" id="priority">
            <option value="High">High</option>
            <option value="Medium">Medium</option>
            <option selected value="Low">Low</option>
        </select><Br><Br>
        <input type="submit" value="Add">
    </form>
</body>
</html>