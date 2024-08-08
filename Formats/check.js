function checkStuff()
{
    if (document.getElementById('task').value == '' || document.getElementById('dueDate').value == '')
    {
        alert('fill out everything, ya goof!');
        return false;
    }
    // Get the current date and time
    let now = new Date();   

    // Define date choosen by user
    let anotherDate = new Date(document.getElementById('dueDate').value);
    // Compare the dates
    if (now > anotherDate) 
    {    
        // console.log("invalid date");
        document.getElementById("invalidDate").innerHTML = "Invalid Date, Please choose another date";
        return false;  
    }
    return true;
}