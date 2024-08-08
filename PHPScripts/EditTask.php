<?php

// Start the session to manage user sessions
session_start();

// Include the authentication check script
require __DIR__ . '/CheckAuth.php';

// Ensure the user is authenticated
checkAuthentication();

// Retrieve the line number from GET or POST request, or terminate the script if not provided
if (isset($_GET['line']))
    $lineNumber = $_GET['line'];
elseif (isset($_POST['line']))
    $lineNumber = $_POST['line'];
else
{
    echo "Line Number is not provided, Please go back to Tasks Page <Br>";
    echo "<a href ='http://localhost/ToDoListProject/Formats/index.php'>Go Back</a>";
    die;
}
// echo $lineNumber;
// Function to fetch a specific row from the task table based on the provided line number
function getRow() : array 
{
    global $lineNumber;
    // Open the task table file for reading
    $taskHandle = @fopen(dirname(__DIR__) . "/Formats/TaskTables.txt", "r") or die("Unable to open a file");
    $currentLine = 0;
    $task = [];
    // Read the file line by line
    while(!feof($taskHandle)):
        $taskRow = fgets($taskHandle);
        // Check if the current line is the one we're interested in
        // $currentLine and $lineNumber is not the same type ;)
        if($currentLine == $lineNumber):
            $task = explode('|', $taskRow); // Split the line into an array
            break;
        endif;
    $currentLine++;
    endwhile;
    // Close the file
    fclose($taskHandle);
    return $task;
}

// Handle form submission to update taskRow
if($_SERVER['REQUEST_METHOD'] === "POST")
{
    // Create an array with the updated task information from the form
    $updatedTask = 
    array(
        'Task'        => $_POST['task'],
        'Description' => $_POST['descrip'],
        'dueDate'     => $_POST['dueDate'],
        'status'      => $_POST['status'],
        'prority'     => $_POST['priority'],
    );
    
    // Open the task table file for reading
    $taskHandle = @fopen(dirname(__DIR__) . "/Formats/TaskTables.txt", "r") or die("Unable to open a file");
    $currentLine = 0;
    $updatedTasks = [];
    // Read the file line by line and update the specific line
    while(!feof($taskHandle)):
        $taskRow = fgets($taskHandle);
        if($currentLine == $lineNumber)
            $updatedTasks[] = implode('|', $updatedTask) . "\n";
        else
            $updatedTasks[] = $taskRow;
        $currentLine++;
    endwhile;
    fclose($taskHandle);

    // Open the task table file for writing and save the updated tasks
    $taskHandle = @fopen(dirname(__DIR__) . "/Formats/TaskTables.txt", "w+") or die("Unable to open a file");
    foreach ($updatedTasks as $taskRow) {
        // Remove the '\n' new line from last task row
        if (($updatedTasks[count($updatedTasks) - 1]) === $taskRow)
            $taskRow = rtrim($taskRow);
        fwrite($taskHandle, $taskRow);
        // break;
    }
    fclose($taskHandle);
    // echo "Tasks is Updated";
    // Redirect to the task tables page after updating
    header('Location: http://localhost/ToDoListProject/Formats/');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks Table</title>
    <style>
        /* Styling for the page */
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
    </style>
    <script src = "http://localhost/ToDoListProject/Formats/check.js"></script>
</head>
<body>
    <Table>
        <thead>
            <tr>
                <th>Task</th>
                <th>Description</th>
                <th>Due date</th>
                <th>Completion status</th>
                <th>Priority</th>
            </tr>
        </thead>
        <tbody>
            <!-- // Retrieve the specific row to be edited -->
            <?php $taskRow = getRow(); ?>
            <tr>
                <!-- Form for editing the task -->
                <form action = "<?= $_SERVER['PHP_SELF'] ?>" method = "POST" >
                <input type="hidden" name="line" value="<?= htmlspecialchars($lineNumber); ?>">
                    <td><input type = 'text' id = 'task' name = 'task' value = '<?= htmlspecialchars($taskRow[0])?>'></td>
                    <td><input type = 'text' name = 'descrip' value = '<?= $taskRow[1]?>'></td>
                    <td><input type = 'date' name = 'dueDate' id = 'dueDate' value = '<?= $taskRow[2]?>'>
                    <p style = "color: red" id = "invalidDate"></p></td> 
                    <td><select name = 'status' id = 'status'>
                        <?php
                        $statusOptions = ['toDo', 'InProgress', 'Completed'];
                        // Populate status options in the dropdown
                        foreach($statusOptions as $option)
                        {
                            // check from which option is selected to display it
                            $selected = $taskRow[3] == $option ? "selected" : "";
                            echo "<option value'" . $option . "' $selected>" . $option . "</option>";
                        } 
                        ?>
                        </select>
                    </td> 
                    <td><select name = 'priority' id = 'priority'>
                        <?php
                        $priorityOptions = ['Low', 'Medium', 'High'];
                        // Populate priority options in the dropdown
                        foreach($priorityOptions as $option)
                        {
                            // check from which option is selected to display it
                            $selected = $taskRow[4] == $option ? "selected" : "";
                            echo "<option value'" . $option . "' $selected>" . $option . "</option>";
                        } 
                        ?>
                        </select>
                    </td>
            </tr> 
        </tbody>
    </Table>
    <!-- Save button to submit the form -->
<button type = "submit" onclick = "return checkStuff()">Save</button>
</form>
</body>
</html>
