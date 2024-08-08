<?php

session_start();

require dirname(__DIR__, 1) . '/PHPScripts/CheckAuth.php';

checkAuthentication();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $Task = array(
        'Task'        => $_POST['task'],
        'Description' => $_POST['descrip'],
        'dueDate'     => $_POST['dueDate'],
        'status'      => $_POST['status'],
        'priority'    => $_POST['priority'],
    );
$taskRow = implode('|', $Task);
file_put_contents( __DIR__ . "/TaskTables.txt", "\n" . $taskRow , FILE_APPEND);
// echo "POST IS CAme";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks Table</title>
    <script>
    function confirmDelete(index) {
        if (confirm("Are you sure you want to delete this task?")) {
            window.location.href = "http://localhost/ToDoListProject/PHPScripts/DeleteTask.php?line=" + index;
        }
    }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        thead {
            background-color: #f0f0f0;
        }

        button {
            padding: 10px 20px;
            margin-right: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
        a.button {
            display: inline-block;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }

        a.button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <Table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Task</th>
                <th>Description</th>
                <th>Due date</th>
                <th>Completion status</th>
                <th>Priority</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $taskHandle = @fopen(__DIR__ . "/TaskTables.txt", "r") or die("Unable to open a file");
            fgets($taskHandle);  // Skip the header row 
            $index = 0;       
            while(!feof($taskHandle)):
            $taskRow = explode('|', fgets($taskHandle));
            // echo "<pre>";
            // print_r($taskRow);
            // echo "</pre>";
            // echo count($taskRow) . "<BR>";
            if (count($taskRow) === 1) // Delete the last array if it is empty
            {
                unset($taskRow);
                break;
            }
            echo "<tr>";
                echo "<td>" . ++$index . "</td>";
                foreach($taskRow as $task):
                    // if(time() > strtotime($task[2])):
                        // echo ""
                    
                    echo "<td>" . $task . "</td>";
                endforeach; 
                echo "<td><a href ='http://localhost/ToDoListProject/PHPScripts/EditTask.php?line=" . $index . "' class = 'button'>Edit</a>\t";
                echo "<a href ='#' onclick='confirmDelete($index)' class = 'button' style='background-color: #dc3545;'>Delete</a></td>";
            endwhile; 
            echo "</tr>"; 
            fclose($taskHandle);
            ?>
        </tbody>
    </Table>
<button type = "button" onclick = "document.location.href = 'http://localhost/ToDoListProject/PHPScripts/AddTask.php'">Add Task</button>
</body>
</html>

<!-- // -->
<!-- else -->
    <!-- echo "You can't Access this page directly"; -->