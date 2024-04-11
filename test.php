<?php
$mdbFile = 'C:\\Users\\itd\\Desktop\\ATT\\ATT2000.mdb';

try {
    // Set up the PDO connection
    $pdo = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb, *.accdb)}; DBQ=$mdbFile; Uid=; Pwd=;");

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch data from the CHECKINOUT table for the user with EMPNO = 4
    $stmtCheckInOut = $pdo->prepare("SELECT CHECKTIME, CHECKTYPE FROM CHECKINOUT WHERE USERID = :EMPNO;");




    // Use bindValue for the EMPNO parameter
    $stmtCheckInOut->bindValue(':EMPNO', 04, PDO::PARAM_INT);

    // Get the SQL query as a string
    $sqlQuery = $stmtCheckInOut->queryString;

    // Log the SQL query to the console
    echo "<script>";
    echo "console.log('SQL Query:', " . json_encode($sqlQuery) . ");";
    echo "</script>";

    $stmtCheckInOut->execute();

    // Log CHECKINOUT data for the selected user to the console
    echo "<script>";
    echo "console.log('Fetching CHECKINOUT data for EMPNO: 4');";
    while ($rowCheckInOut = $stmtCheckInOut->fetch(PDO::FETCH_ASSOC)) {
        if (isset($rowCheckInOut['CHECKTIME']) && isset($rowCheckInOut['CHECKTYPE'])) {
            echo "console.log('CHECKTIME: " . $rowCheckInOut['CHECKTIME'] . ", CHECKTYPE: " . $rowCheckInOut['CHECKTYPE'] . "');";
        } else {
            echo "console.log('CHECKTIME or CHECKTYPE is not set in the result.');";
        }
    }
    echo "</script>";

} catch (PDOException $e) {
    // Enhance error handling to log detailed information
    echo "Error: " . $e->getMessage();
    // Log additional information like SQL query, error code, etc.
}
?>