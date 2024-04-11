<?php


$mdbFile = 'C:\\Users\\itd\Desktop\\ATT\\ATT2000.MDB';


try {
    // Set up the PDO connection
    $pdo = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb, *.accdb)}; DBQ=$mdbFile; Uid=; Pwd=;");

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch data from the Doctors table
    $stmtDoctors = $pdo->query("INSERT INTO Doctors (BNo,EMPNAME,POSITION,Active) VALUES (:BNo,:EMPNAME,:POSITION,:Active) ");
    
    $doctorOptions = '';
    while ($rowDoctor = $stmtDoctors->fetch(PDO::FETCH_ASSOC)) {
        $empNo = $rowDoctor['EMPNO'];
        $empName = $rowDoctor['EMPNAME'];
        $empPosition = $rowDoctor['POSITION'];
        $doctorOptions .= "<option value='$empNo'>$empNo $empName $empPosition</option>";
    }
} catch (PDOException $e) {
    // Handle PDO exceptions here
    echo "Error: " . $e->getMessage();
}