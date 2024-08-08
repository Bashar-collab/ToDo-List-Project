<?php

// Start the session to manage user sessions
session_start();

// Include the authentication check script
require __DIR__ . '/CheckAuth.php';

// Ensure the user is authenticated
checkAuthentication();


// Retrieve the line number from GET
if(isset($_GET['line']))
    $lineNumber = $_GET['line'];
else
{
    // If the line number is not provided, display an error message and a link to go back
    echo "Line Number is not provided, Please go back to Tasks Page <Br>";
    echo "<a href ='http://localhost/ToDoListProject/Formats/'>Go Back</a>";
    die;
}

/**
 * Function to get the specific row from the task table file
 * 
 * @return string|null The task row content if found, null otherwise
 */
function getRow()
{
    global $lineNumber;
    // Open the task table file for reading
    $taskHandle = @fopen(dirname(__DIR__) . "/Formats/TaskTables.txt", "r") or die("Unable to open a file");
    $currentLine = 0;
    // Read the file line by line
    while(!feof($taskHandle)):
        // Check if the current line number matches the requested line number
        $taskRow = fgets($taskHandle);
        if($currentLine == $lineNumber):
            fclose($taskHandle); // Delete this specific line and exit function
            return $taskRow; // Return the specific task row
        endif;
    $currentLine++; // Increment the line counter
    endwhile;
    return null; // Return null if the line is not found
}

// Get the task row content
$task = getRow();
// Get the entire content of the task table file
$content = file_get_contents(dirname(__DIR__) . "/Formats/TaskTables.txt");
// Remove the specific task row from the content
$newContent = str_replace($task, "", $content);
// Write the new content back to the task table file
file_put_contents(dirname(__DIR__) . "/Formats/TaskTables.txt", $newContent);
// Redirect to the tasks page after deletion
header("Location: http://localhost/ToDoListProject/Formats/");
exit; // Ensure the script stops executing after redirection