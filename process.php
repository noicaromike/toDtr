<?php
// process.php - Add your logic here for handling the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeName = $_POST["employeeName"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];

    // Perform further processing or send the data to the server for actual printing
    // For demonstration purposes, we'll just log the selected values
    echo 'Employee Name:', $employeeName, '<br>';
    echo 'From Date:', $startDate, '<br>';
    echo 'To Date:', $endDate;
}
?>
