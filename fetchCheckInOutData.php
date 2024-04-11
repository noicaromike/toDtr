<?php
// Database connection parameters
$mdbFile = 'C:\\Users\\itd\Desktop\\ATT\\ATT2000.mdb';

try {
    // Set up the PDO connection
    $pdo = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb, *.accdb)}; DBQ=$mdbFile; Uid=; Pwd=;");

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ensure 'employeeName' is set in the request
    if (isset($_GET['employeeName'], $_GET['startDate'], $_GET['endDate'])) {
        $selectedDoctor = $_GET['employeeName'];
        $startDate = $_GET['startDate'];
        $endDate = $_GET['endDate'];

        try {
            // Convert the date format to match the database (Month, day, year)
            $startDate = date('F j, Y', strtotime($startDate));
            $endDate = date('F j, Y', strtotime($endDate));

            // Fetch CHECKINOUT data for the selected doctor and date range
            // Fetch CHECKINOUT data for the selected doctor and date range
            $stmtCheckInOut = $pdo->prepare("SELECT CHECKTIME, CHECKTYPE FROM CHECKINOUT WHERE USERID = :EMPNO AND CHECKTIME BETWEEN :startDate AND :endDate;");
            $stmtCheckInOut->bindValue(':EMPNO', $selectedDoctor, PDO::PARAM_INT);
            $stmtCheckInOut->bindValue(':startDate', $startDate . ' 00:00:00', PDO::PARAM_STR); // Add start time for the beginning of the day
            $stmtCheckInOut->bindValue(':endDate', $endDate . ' 23:59:59', PDO::PARAM_STR);     // Add end time for the end of the day
            $stmtCheckInOut->execute();


            // Fetch the data as an associative array
            $checkInOutData = $stmtCheckInOut->fetchAll(PDO::FETCH_ASSOC);

            // Return the data as JSON
            header('Content-Type: application/json');
            echo json_encode($checkInOutData);
        } catch (PDOException $e) {
            // Handle PDO exceptions here
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        // Return an error message if 'employeeName', 'startDate', or 'endDate' is not set
        echo json_encode(['error' => 'employeeName, startDate, or endDate not set']);
    }
} catch (PDOException $e) {
    // Handle PDO exceptions here
    echo json_encode(['error' => 'Database connection error: ' . $e->getMessage()]);
}
?>