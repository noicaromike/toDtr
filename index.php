<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors Biometric</title>
    <link rel="icon" href="img/eac.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <div class="center-container">
        <img class="image" src="img/EACMed Complete.png">
        <div class="container">
            <h2>Doctors Biometric DTR Printing</h2>

            <?php
            // Database connection parameters
            $mdbFile = 'C:\\Users\\itd\Desktop\\ATT\\ATT2000.MDB';

            try {
                // Set up the PDO connection
                $pdo = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb, *.accdb)}; DBQ=$mdbFile; Uid=; Pwd=;");

                // Set the PDO error mode to exception
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Fetch data from the Doctors table
                $stmtDoctors = $pdo->query("SELECT EMPNO, EMPNAME, POSITION FROM DOCTORS WHERE EMPNAME IS NOT NULL");
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

            // Close the database connection here or use it as appropriate for your application

            // HTML part
            ?>
            <div class="addRecord">
                <a href="addRecord.php" class="submit" style="padding: 9px;width: 35%;">Employees</a>
            </div>
            <form id="biometricForm" method="post" onchange="fetchCheckInOutData()" onsubmit="return validateForm()">

                <div class="form-group">
                    <label for="employeeName">Doctor Name:</label>
                    <select id="employeeName" name="employeeName">
                        <?php echo $doctorOptions; ?>
                    </select>
                </div>
                <div class="form-group" onchange="fetchCheckInOutData()">
                    <label for="startDate">From Date:</label>
                    <input type="date" id="startDate" name="startDate" required>
                </div>

                <div class="form-group" onchange="fetchCheckInOutData()">
                    <label for="endDate">To Date:</label>
                    <input type="date" id="endDate" name="endDate" required>
                </div>

                <div>
                    <button class="toggle" type="button" onclick="toggleTimeFormat()">Time Format</button>
                    <span id="timeFormatText">24-hour format</span>
                </div>
                <br>

                <button class="submit" type="submit">Print</button>
            </form>

            <footer style="margin-bottom: -10px;">
                <p id="aboutLink">About</p>
            </footer>

            <div id="popup">
                <span id="popupClose">X</span>
                <p>The 'Doctors Biometric DTR Printing' system streamlines attendance tracking for healthcare
                    professionals using biometric data, ensuring accuracy and security in recording doctors' daily work
                    hours.
                </p>
                <p>This was made by an IT intern named Jan Menard Rodriguez in January 2023.</p>
                <p>Modified and fixed by John Levi R. Oroc, Michael F. Oracion & Christian James A. Tabiola in January 2024.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the "About" link element
            var aboutLink = document.getElementById('aboutLink');

            // Get the pop-up element
            var popup = document.getElementById('popup');

            // Get the close button element
            var popupClose = document.getElementById('popupClose');

            // Add click event listener to the "About" link
            aboutLink.addEventListener('click', function() {
                // Toggle the pop-up
                if (popup.style.display === 'block') {
                    // Apply fade-out animation
                    popup.style.opacity = '0';
                    popup.style.transform = 'translate(-50%, -50%) scale(0.8)';
                    // Hide the pop-up after the animation completes
                    setTimeout(function() {
                        popup.style.display = 'none';
                    }, 500);
                } else {
                    // Display the pop-up
                    popup.style.display = 'block';
                    // Apply fade-in animation
                    setTimeout(function() {
                        popup.style.opacity = '1';
                        popup.style.transform = 'translate(-50%, -50%) scale(1)';
                    }, 0);
                }
            });

            // Add click event listener to the close button
            popupClose.addEventListener('click', function() {
                // Apply fade-out animation
                popup.style.opacity = '0';
                popup.style.transform = 'translate(-50%, -50%) scale(0.8)';
                // Hide the pop-up after the animation completes
                setTimeout(function() {
                    popup.style.display = 'none';
                }, 500);
            });

            // Close the pop-up when clicking outside of it
            window.addEventListener('click', function(event) {
                if (event.target !== popup && event.target !== aboutLink) {
                    // Apply fade-out animation
                    popup.style.opacity = '0';
                    popup.style.transform = 'translate(-50%, -50%) scale(0.8)';
                    // Hide the pop-up after the animation completes
                    setTimeout(function() {
                        popup.style.display = 'none';
                    }, 500);
                }
            });

            // Close the pop-up when pressing the Escape key
            window.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    // Apply fade-out animation
                    popup.style.opacity = '0';
                    popup.style.transform = 'translate(-50%, -50%) scale(0.8)';
                    // Hide the pop-up after the animation completes
                    setTimeout(function() {
                        popup.style.display = 'none';
                    }, 500);
                }
            });
        });

        function validateForm() {
            var startDateInput = document.getElementById('startDate').value;
            var endDateInput = document.getElementById('endDate').value;

            // Validate date format
            var dateRegex = /^\d{4}-\d{2}-\d{2}$/;
            if (!dateRegex.test(startDateInput) || !dateRegex.test(endDateInput)) {
                alert("Please enter valid dates in the format YYYY-MM-DD.");
                return false;
            }

            // Extract year, month, and day components
            var startDateComponents = startDateInput.split('-');
            var endDateComponents = endDateInput.split('-');

            // Convert components to integers
            var startYear = parseInt(startDateComponents[0], 10);
            var startMonth = parseInt(startDateComponents[1], 10);
            var startDay = parseInt(startDateComponents[2], 10);

            var endYear = parseInt(endDateComponents[0], 10);
            var endMonth = parseInt(endDateComponents[1], 10);
            var endDay = parseInt(endDateComponents[2], 10);

            // Check if either date is not a valid date
            if (isNaN(startYear) || isNaN(startMonth) || isNaN(startDay) || isNaN(endYear) || isNaN(endMonth) || isNaN(endDay)) {
                alert("Please select valid dates.");
                return false;
            }

            // Check if both dates are in the same month
            if (startMonth !== endMonth || startYear !== endYear) {
                alert("Select 1-15 and 16-31 days only within the same month.");
                return false;
            }

            // Check if dates are within the specified ranges (1-15 and 16-31)
            if (!((startDay >= 1 && endDay <= 15) || (startDay >= 16 && endDay <= 31)) ||
                !((endDay >= 1 && startDay <= 15) || (endDay >= 16 && startDay <= 31))) {
                alert("Select 1-15 and 16-31 days only.");
                return false;
            }

            if (confirm("Print the selected name on paper?")) {
                // Check if globalData is available before calling printSelectedName
                if (globalData && Array.isArray(globalData)) {
                    printSelectedName();
                } else {
                    alert("Unable to print. There's no data to gather.");
                }
            }

            return true;
        }

        var morning1in, morning1out, afternoon1in, afternoon1out, evening1in, evening1out;
        var morning2in, morning2out, afternoon2in, afternoon2out, evening2in, evening2out;
        var morning3in, morning3out, afternoon3in, afternoon3out, evening3in, evening3out;
        var morning4in, morning4out, afternoon4in, afternoon4out, evening4in, evening4out;
        var morning5in, morning5out, afternoon5in, afternoon5out, evening5in, evening5out;
        var morning6in, morning6out, afternoon6in, afternoon6out, evening6in, evening6out;
        var morning7in, morning7out, afternoon7in, afternoon7out, evening7in, evening7out;
        var morning8in, morning8out, afternoon8in, afternoon8out, evening8in, evening8out;
        var morning9in, morning9out, afternoon9in, afternoon9out, evening9in, evening9out;
        var morning10in, morning10out, afternoon10in, afternoon10out, evening10in, evening10out;
        var morning11in, morning11out, afternoon11in, afternoon11out, evening11in, evening11out;
        var morning12in, morning12out, afternoon12in, afternoon12out, evening12in, evening12out;
        var morning13in, morning13out, afternoon13in, afternoon13out, evening13in, evening13out;
        var morning14in, morning14out, afternoon14in, afternoon14out, evening14in, evening14out;
        var morning15in, morning15out, afternoon15in, afternoon15out, evening15in, evening15out;
        var morning16in, morning16out, afternoon16in, afternoon16out, evening16in, evening16out;

        var use24HourFormat = true; // Default to 24-hour format

        function toggleTimeFormat() {
            use24HourFormat = !use24HourFormat;
            getData();
            updateTimeFormatText();
        }

        function updateTimeFormatText() {
            var timeFormatTextElement = document.getElementById('timeFormatText');
            if (use24HourFormat) {
                timeFormatTextElement.textContent = '24-hour format';
            } else {
                timeFormatTextElement.textContent = '12-hour format';
            }

            // Toggle animation class
            timeFormatTextElement.classList.toggle('toggle-animation');

            // Remove the animation class after the animation ends
            setTimeout(() => {
                timeFormatTextElement.classList.remove('toggle-animation');
            }, 1000);
        }

        var formattedTime;

        function getData() {
            // Check if data is an array
            if (Array.isArray(globalData)) {
                // Extract month and year from startDateInput
                var startDateString = document.getElementById('startDate').value;
                var [startYear, startMonth] = startDateString.split('-');

                // Extract month and year from endDateInput
                var endDateString = document.getElementById('endDate').value;
                var [endYear, endMonth] = endDateString.split('-');

                // Filter data based on the specified date range
                var filteredData = globalData.filter(function(item) {
                    // Parse the date string in the format "YYYY-MM-DD HH:mm:ss"
                    var dateString = item.CHECKTIME; // Replace 'CHECKTIME' with the actual field name

                    // Split the date and time parts
                    var [datePart, timePart] = dateString.split(' ');

                    // Extract the year, month, and day
                    var [year, month, dayOfMonth] = datePart.split('-');

                    // Check if the date is within the specified range
                    return (
                        year >= startYear && year <= endYear &&
                        month >= startMonth && month <= endMonth &&
                        dayOfMonth >= startDateString.split('-')[2] && dayOfMonth <= endDateString.split('-')[2]
                    );
                });

                // Process the filtered data
                filteredData.forEach(function(item) {
                    var dateString = item.CHECKTIME;
                    var [datePart, timePart] = dateString.split(' ');
                    var [year, month, dayOfMonth] = datePart.split('-');
                    var formattedTime;

                    // Convert the time to the selected format
                    if (use24HourFormat === true) {
                        formattedTime = timePart.slice(0, 5);
                    } else {
                        formattedTime = new Date(dateString).toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }

                    console.log('formattedTime:', formattedTime);
                    // Process the data for the selected date range
                    if ((dayOfMonth === '16') && parseInt(timePart.split(':')[0]) >= 0 && parseInt(timePart.split(':')[0]) < 12) {
                        // Process morning data
                        if (item.CHECKTYPE === 'I') {
                            console.log('Morning check-in data for day 16:', item);
                            morning16in = formattedTime;
                        } else if (item.CHECKTYPE === 'O') {
                            console.log('Morning check-out data for day 16:', item);
                            morning16out = formattedTime;
                        }
                    } else if ((dayOfMonth === '16') && parseInt(timePart.split(':')[0]) >= 12 && parseInt(timePart.split(':')[0]) <= 17) {
                        // Process afternoon data
                        if (item.CHECKTYPE === 'I') {
                            console.log('Afternoon check-in data for day 16:', item);
                            afternoon16in = formattedTime;
                        } else if (item.CHECKTYPE === 'O') {
                            console.log('Afternoon check-out data for day 16:', item);
                            afternoon16out = formattedTime;
                        }
                    } else if ((dayOfMonth === '16') && parseInt(timePart.split(':')[0]) >= 18 && parseInt(timePart.split(':')[0]) <= 23) {
                        // Process evening data
                        if (item.CHECKTYPE === 'I') {
                            console.log('Evening check-in data for day 16:', item);
                            evening16in = formattedTime;
                        } else if (item.CHECKTYPE === 'O') {
                            console.log('Evening check-out data for day 16:', item);
                            evening16out = formattedTime;
                        }
                    } else if ((dayOfMonth === '01' || dayOfMonth === '17') && parseInt(timePart.split(':')[0]) >= 0 && parseInt(timePart.split(':')[0]) < 12) {
                        // Check the CHECKTYPE for day 1
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the morning check-in on day 1
                            console.log('Morning check-in data for day 1:', item);
                            morning1in = formattedTime;
                            console.log('CHECKTIME:', morning1in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the morning check-out on day 1
                            console.log('Morning check-out data for day 1:', item);
                            morning1out = formattedTime;
                            console.log('CHECKTIME:', morning1out);
                        }
                    } else if ((dayOfMonth === '01' || dayOfMonth === '17') && parseInt(timePart.split(':')[0]) >= 12 && parseInt(timePart.split(':')[0]) <= 17) {
                        // Check the CHECKTYPE for afternoon on day 1
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the afternoon check-in on day 1
                            console.log('Afternoon check-in data for day 1:', item);
                            afternoon1in = formattedTime;
                            console.log('CHECKTIME:', afternoon1in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the afternoon check-out on day 1
                            console.log('Afternoon check-out data for day 1:', item);
                            afternoon1out = formattedTime;
                            console.log('CHECKTIME:', afternoon1out);
                        }
                    } else if ((dayOfMonth === '01' || dayOfMonth === '17') && parseInt(timePart.split(':')[0]) >= 18 && parseInt(timePart.split(':')[0]) <= 23) {
                        // Check the CHECKTYPE for evening on day 1
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the evening check-in on day 1
                            console.log('Evening check-in data for day 1:', item);
                            evening1in = formattedTime;
                            console.log('CHECKTIME:', evening1in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the evening check-out on day 1
                            console.log('Evening check-out data for day 1:', item);
                            evening1out = formattedTime;
                            console.log('CHECKTIME:', evening1out);
                        }
                    } else if ((dayOfMonth === '02' || dayOfMonth === '18') && parseInt(timePart.split(':')[0]) >= 0 && parseInt(timePart.split(':')[0]) < 12) {
                        // Check the CHECKTYPE for morning on day 2
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the morning check-in on day 2
                            console.log('Morning check-in data for day 2:', item);
                            morning2in = formattedTime;
                            console.log('CHECKTIME:', morning2in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the morning check-out on day 2
                            console.log('Morning check-out data for day 2:', item);
                            morning2out = formattedTime;
                            console.log('CHECKTIME:', morning2out);
                        }
                    } else if ((dayOfMonth === '02' || dayOfMonth === '18') && parseInt(timePart.split(':')[0]) >= 12 && parseInt(timePart.split(':')[0]) <= 17) {
                        // Check the CHECKTYPE for afternoon on day 2
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the afternoon check-in on day 2
                            console.log('Afternoon check-in data for day 2:', item);
                            afternoon2in = formattedTime;
                            console.log('CHECKTIME:', afternoon2in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the afternoon check-out on day 2
                            console.log('Afternoon check-out data for day 2:', item);
                            afternoon2out = formattedTime;
                            console.log('CHECKTIME:', afternoon2out);
                        }
                    } else if ((dayOfMonth === '02' || dayOfMonth === '18') && parseInt(timePart.split(':')[0]) >= 18 && parseInt(timePart.split(':')[0]) <= 23) {
                        // Check the CHECKTYPE for evening on day 2
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the evening check-in on day 2
                            console.log('Evening check-in data for day 2:', item);
                            evening2in = formattedTime;
                            console.log('CHECKTIME:', evening2in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the evening check-out on day 2
                            console.log('Evening check-out data for day 2:', item);
                            evening2out = formattedTime;
                            console.log('CHECKTIME:', evening2out);
                        }
                    } else if ((dayOfMonth === '03' || dayOfMonth === '19') && parseInt(timePart.split(':')[0]) >= 0 && parseInt(timePart.split(':')[0]) < 12) {
                        // Check the CHECKTYPE for morning on day 2
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the morning check-in on day 2
                            console.log('Morning check-in data for day 2:', item);
                            morning3in = formattedTime;
                            console.log('CHECKTIME:', morning3in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the morning check-out on day 2
                            console.log('Morning check-out data for day 2:', item);
                            morning3out = formattedTime;
                            console.log('CHECKTIME:', morning3out);
                        }
                    } else if ((dayOfMonth === '03' || dayOfMonth === '19') && parseInt(timePart.split(':')[0]) >= 12 && parseInt(timePart.split(':')[0]) <= 17) {
                        // Check the CHECKTYPE for afternoon on day 3
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the afternoon check-in on day 3
                            console.log('Afternoon check-in data for day 3:', item);
                            afternoon3in = formattedTime;
                            console.log('CHECKTIME:', afternoon3in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the afternoon check-out on day 3
                            console.log('Afternoon check-out data for day 3:', item);
                            afternoon3out = formattedTime;
                            console.log('CHECKTIME:', afternoon3out);
                        }
                    } else if ((dayOfMonth === '03' || dayOfMonth === '19') && parseInt(timePart.split(':')[0]) >= 18 && parseInt(timePart.split(':')[0]) <= 23) {
                        // Check the CHECKTYPE for evening on day 3
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the evening check-in on day 3
                            console.log('Evening check-in data for day 3:', item);
                            evening3in = formattedTime;
                            console.log('CHECKTIME:', evening3in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the evening check-out on day 3
                            console.log('Evening check-out data for day 3:', item);
                            evening3out = formattedTime;
                            console.log('CHECKTIME:', evening3out);
                        }
                    } else if ((dayOfMonth === '04' || dayOfMonth === '20') && parseInt(timePart.split(':')[0]) >= 0 && parseInt(timePart.split(':')[0]) < 12) {
                        // Check the CHECKTYPE for morning on day 4
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the morning check-in on day 4
                            console.log('Morning check-in data for day 4:', item);
                            morning4in = formattedTime;
                            console.log('CHECKTIME:', morning4in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the morning check-out on day 4
                            console.log('Morning check-out data for day 4:', item);
                            morning4out = formattedTime;
                            console.log('CHECKTIME:', morning4out);
                        }
                    } else if ((dayOfMonth === '04' || dayOfMonth === '20') && parseInt(timePart.split(':')[0]) >= 12 && parseInt(timePart.split(':')[0]) <= 17) {
                        // Check the CHECKTYPE for afternoon on day 4
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the afternoon check-in on day 4
                            console.log('Afternoon check-in data for day 4:', item);
                            afternoon4in = formattedTime;
                            console.log('CHECKTIME:', afternoon4in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the afternoon check-out on day 4
                            console.log('Afternoon check-out data for day 4:', item);
                            afternoon4out = formattedTime;
                            console.log('CHECKTIME:', afternoon4out);
                        }
                    } else if ((dayOfMonth === '04' || dayOfMonth === '20') && (parseInt(timePart.split(':')[0]) >= 18 && parseInt(timePart.split(':')[0]) <= 23)) {
                        // Check the CHECKTYPE for evening on day 4
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the evening check-in on day 4
                            console.log('Evening check-in data for day 4:', item);
                            evening4in = formattedTime;
                            console.log('CHECKTIME:', evening4in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the evening check-out on day 4
                            console.log('Evening check-out data for day 4:', item);
                            evening4out = formattedTime;
                            console.log('CHECKTIME:', evening4out);
                        }
                    } else if ((dayOfMonth === '05' || dayOfMonth === '21') && parseInt(timePart.split(':')[0]) >= 0 && parseInt(timePart.split(':')[0]) < 12) {
                        // Check the CHECKTYPE for morning on day 5
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the morning check-in on day 5
                            console.log('Morning check-in data for day 5:', item);
                            morning5in = formattedTime;
                            console.log('CHECKTIME:', morning5in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the morning check-out on day 5
                            console.log('Morning check-out data for day 5:', item);
                            morning5out = formattedTime;
                            console.log('CHECKTIME:', morning5out);
                        }
                    } else if ((dayOfMonth === '05' || dayOfMonth === '21') && parseInt(timePart.split(':')[0]) >= 12 && parseInt(timePart.split(':')[0]) <= 17) {
                        // Check the CHECKTYPE for afternoon on day 5
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the afternoon check-in on day 5
                            console.log('Afternoon check-in data for day 5:', item);
                            afternoon5in = formattedTime;
                            console.log('CHECKTIME:', afternoon5in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the afternoon check-out on day 5
                            console.log('Afternoon check-out data for day 5:', item);
                            afternoon5out = formattedTime;
                            console.log('CHECKTIME:', afternoon5out);
                        }
                    } else if ((dayOfMonth === '05' || dayOfMonth === '21') && parseInt(timePart.split(':')[0]) >= 18 && parseInt(timePart.split(':')[0]) <= 23) {
                        // Check the CHECKTYPE for evening on day 5
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the evening check-in on day 5
                            console.log('Evening check-in data for day 5:', item);
                            evening5in = formattedTime;
                            console.log('CHECKTIME:', evening5in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the evening check-out on day 5
                            console.log('Evening check-out data for day 5:', item);
                            evening5out = formattedTime;
                            console.log('CHECKTIME:', evening5out);
                        }
                    } else if ((dayOfMonth === '06' || dayOfMonth === '22') && parseInt(timePart.split(':')[0]) >= 0 && parseInt(timePart.split(':')[0]) < 12) {
                        // Check the CHECKTYPE for morning on day 6
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the morning check-in on day 6
                            console.log('Morning check-in data for day 6:', item);
                            morning6in = formattedTime;
                            console.log('CHECKTIME:', morning6in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the morning check-out on day 6
                            console.log('Morning check-out data for day 6:', item);
                            morning6out = formattedTime;
                            console.log('CHECKTIME:', morning6out);
                        }
                    } else if ((dayOfMonth === '06' || dayOfMonth === '22') && parseInt(timePart.split(':')[0]) >= 12 && parseInt(timePart.split(':')[0]) <= 17) {
                        // Check the CHECKTYPE for afternoon on day 6
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the afternoon check-in on day 6
                            console.log('Afternoon check-in data for day 6:', item);
                            afternoon6in = formattedTime;
                            console.log('CHECKTIME:', afternoon6in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the afternoon check-out on day 6
                            console.log('Afternoon check-out data for day 6:', item);
                            afternoon6out = formattedTime;
                            console.log('CHECKTIME:', afternoon6out);
                        }
                    } else if ((dayOfMonth === '06' || dayOfMonth === '22') && parseInt(timePart.split(':')[0]) >= 18 && parseInt(timePart.split(':')[0]) <= 23) {
                        // Check the CHECKTYPE for evening on day 6
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the evening check-in on day 6
                            console.log('Evening check-in data for day 6:', item);
                            evening6in = formattedTime;
                            console.log('CHECKTIME:', evening6in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the evening check-out on day 6
                            console.log('Evening check-out data for day 6:', item);
                            evening6out = formattedTime;
                            console.log('CHECKTIME:', evening6out);
                        }
                    } else if ((dayOfMonth === '07' || dayOfMonth === '23') && parseInt(timePart.split(':')[0]) >= 0 && parseInt(timePart.split(':')[0]) < 12) {
                        // Check the CHECKTYPE for morning on day 7
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the morning check-in on day 7
                            console.log('Morning check-in data for day 7:', item);
                            morning7in = formattedTime;
                            console.log('CHECKTIME:', morning7in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the morning check-out on day 7
                            console.log('Morning check-out data for day 7:', item);
                            morning7out = formattedTime;
                            console.log('CHECKTIME:', morning7out);
                        }
                    } else if ((dayOfMonth === '07' || dayOfMonth === '23') && parseInt(timePart.split(':')[0]) >= 12 && parseInt(timePart.split(':')[0]) <= 17) {
                        // Check the CHECKTYPE for afternoon on day 7
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the afternoon check-in on day 7
                            console.log('Afternoon check-in data for day 7:', item);
                            afternoon7in = formattedTime;
                            console.log('CHECKTIME:', afternoon7in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the afternoon check-out on day 7
                            console.log('Afternoon check-out data for day 7:', item);
                            afternoon7out = formattedTime;
                            console.log('CHECKTIME:', afternoon7out);
                        }
                    } else if ((dayOfMonth === '07' || dayOfMonth === '23') && parseInt(timePart.split(':')[0]) >= 18 && parseInt(timePart.split(':')[0]) <= 23) {
                        // Check the CHECKTYPE for evening on day 7
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the evening check-in on day 7
                            console.log('Evening check-in data for day 7:', item);
                            evening7in = formattedTime;
                            console.log('CHECKTIME:', evening7in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the evening check-out on day 7
                            console.log('Evening check-out data for day 7:', item);
                            evening7out = formattedTime;
                            console.log('CHECKTIME:', evening7out);
                        }
                    } else if ((dayOfMonth === '08' || dayOfMonth === '24') && parseInt(timePart.split(':')[0]) >= 0 && parseInt(timePart.split(':')[0]) < 12) {
                        // Check the CHECKTYPE for morning on day 8
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the morning check-in on day 8
                            console.log('Morning check-in data for day 8:', item);
                            morning8in = formattedTime;
                            console.log('CHECKTIME:', morning8in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the morning check-out on day 8
                            console.log('Morning check-out data for day 8:', item);
                            morning8out = formattedTime;
                            console.log('CHECKTIME:', morning8out);
                        }
                    } else if ((dayOfMonth === '08' || dayOfMonth === '24') && parseInt(timePart.split(':')[0]) >= 12 && parseInt(timePart.split(':')[0]) <= 17) {
                        // Check the CHECKTYPE for afternoon on day 8
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the afternoon check-in on day 8
                            console.log('Afternoon check-in data for day 8:', item);
                            afternoon8in = formattedTime;
                            console.log('CHECKTIME:', afternoon8in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the afternoon check-out on day 8
                            console.log('Afternoon check-out data for day 8:', item);
                            afternoon8out = formattedTime;
                            console.log('CHECKTIME:', afternoon8out);
                        }
                    } else if ((dayOfMonth === '08' || dayOfMonth === '24') && parseInt(timePart.split(':')[0]) >= 18 && parseInt(timePart.split(':')[0]) <= 23) {
                        // Check the CHECKTYPE for evening on day 8
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the evening check-in on day 8
                            console.log('Evening check-in data for day 8:', item);
                            evening8in = formattedTime;
                            console.log('CHECKTIME:', evening8in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the evening check-out on day 8
                            console.log('Evening check-out data for day 8:', item);
                            evening8out = formattedTime;
                            console.log('CHECKTIME:', evening8out);
                        }
                    } else if ((dayOfMonth === '09' || dayOfMonth === '25') && parseInt(timePart.split(':')[0]) >= 0 && parseInt(timePart.split(':')[0]) < 12) {
                        // Check the CHECKTYPE for morning on day 9
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the morning check-in on day 9
                            console.log('Morning check-in data for day 9:', item);
                            morning9in = formattedTime;
                            console.log('CHECKTIME:', morning9in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the morning check-out on day 9
                            console.log('Morning check-out data for day 9:', item);
                            morning9out = formattedTime;
                            console.log('CHECKTIME:', morning9out);
                        }
                    } else if ((dayOfMonth === '09' || dayOfMonth === '25') && parseInt(timePart.split(':')[0]) >= 12 && parseInt(timePart.split(':')[0]) <= 17) {
                        // Check the CHECKTYPE for afternoon on day 9
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the afternoon check-in on day 9
                            console.log('Afternoon check-in data for day 9:', item);
                            afternoon9in = formattedTime;
                            console.log('CHECKTIME:', afternoon9in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the afternoon check-out on day 9
                            console.log('Afternoon check-out data for day 9:', item);
                            afternoon9out = formattedTime;
                            console.log('CHECKTIME:', afternoon9out);
                        }
                    } else if ((dayOfMonth === '09' || dayOfMonth === '25') && parseInt(timePart.split(':')[0]) >= 18 && parseInt(timePart.split(':')[0]) <= 23) {
                        // Check the CHECKTYPE for evening on day 9
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the evening check-in on day 9
                            console.log('Evening check-in data for day 9:', item);
                            evening9in = formattedTime;
                            console.log('CHECKTIME:', evening9in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the evening check-out on day 9
                            console.log('Evening check-out data for day 9:', item);
                            evening9out = formattedTime;
                            console.log('CHECKTIME:', evening9out);
                        }
                    } else if ((dayOfMonth === '10' || dayOfMonth === '26') && parseInt(timePart.split(':')[0]) >= 0 && parseInt(timePart.split(':')[0]) < 12) {
                        // Check the CHECKTYPE for morning on day 10
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the morning check-in on day 10
                            console.log('Morning check-in data for day 10:', item);
                            morning10in = formattedTime;
                            console.log('CHECKTIME:', morning10in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the morning check-out on day 10
                            console.log('Morning check-out data for day 10:', item);
                            morning10out = formattedTime;
                            console.log('CHECKTIME:', morning10out);
                        }
                    } else if ((dayOfMonth === '10' || dayOfMonth === '26') && parseInt(timePart.split(':')[0]) >= 12 && parseInt(timePart.split(':')[0]) <= 17) {
                        // Check the CHECKTYPE for afternoon on day 10
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the afternoon check-in on day 10
                            console.log('Afternoon check-in data for day 10:', item);
                            afternoon10in = formattedTime;
                            console.log('CHECKTIME:', afternoon10in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the afternoon check-out on day 10
                            console.log('Afternoon check-out data for day 10:', item);
                            afternoon10out = formattedTime;
                            console.log('CHECKTIME:', afternoon10out);
                        }
                    } else if ((dayOfMonth === '10' || dayOfMonth === '26') && parseInt(timePart.split(':')[0]) >= 18 && parseInt(timePart.split(':')[0]) <= 23) {
                        // Check the CHECKTYPE for evening on day 10
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the evening check-in on day 10
                            console.log('Evening check-in data for day 10:', item);
                            evening10in = formattedTime;
                            console.log('CHECKTIME:', evening10in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the evening check-out on day 10
                            console.log('Evening check-out data for day 10:', item);
                            evening10out = formattedTime;
                            console.log('CHECKTIME:', evening10out);
                        }
                    } else if ((dayOfMonth === '11' || dayOfMonth === '27') && parseInt(timePart.split(':')[0]) >= 0 && parseInt(timePart.split(':')[0]) < 12) {
                        // Check the CHECKTYPE for morning on day 11
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the morning check-in on day 11
                            console.log('Morning check-in data for day 11:', item);
                            morning11in = formattedTime;
                            console.log('CHECKTIME:', morning11in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the morning check-out on day 11
                            console.log('Morning check-out data for day 11:', item);
                            morning11out = formattedTime;
                            console.log('CHECKTIME:', morning11out);
                        }
                    } else if ((dayOfMonth === '11' || dayOfMonth === '27') && parseInt(timePart.split(':')[0]) >= 12 && parseInt(timePart.split(':')[0]) <= 17) {
                        // Check the CHECKTYPE for afternoon on day 11
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the afternoon check-in on day 11
                            console.log('Afternoon check-in data for day 11:', item);
                            afternoon11in = formattedTime;
                            console.log('CHECKTIME:', afternoon11in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the afternoon check-out on day 11
                            console.log('Afternoon check-out data for day 11:', item);
                            afternoon11out = formattedTime;
                            console.log('CHECKTIME:', afternoon11out);
                        }
                    } else if ((dayOfMonth === '11' || dayOfMonth === '27') && parseInt(timePart.split(':')[0]) >= 18 && parseInt(timePart.split(':')[0]) <= 23) {
                        // Check the CHECKTYPE for evening on day 11
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the evening check-in on day 11
                            console.log('Evening check-in data for day 11:', item);
                            evening11in = formattedTime;
                            console.log('CHECKTIME:', evening11in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the evening check-out on day 11
                            console.log('Evening check-out data for day 11:', item);
                            evening11out = formattedTime;
                            console.log('CHECKTIME:', evening11out);
                        }
                    } else if ((dayOfMonth === '12' || dayOfMonth === '28') && parseInt(timePart.split(':')[0]) >= 0 && parseInt(timePart.split(':')[0]) < 12) {
                        // Check the CHECKTYPE for morning on day 12
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the morning check-in on day 12
                            console.log('Morning check-in data for day 12:', item);
                            morning12in = formattedTime;
                            console.log('CHECKTIME:', morning12in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the morning check-out on day 12
                            console.log('Morning check-out data for day 12:', item);
                            morning12out = formattedTime;
                            console.log('CHECKTIME:', morning12out);
                        }
                    } else if ((dayOfMonth === '12' || dayOfMonth === '28') && parseInt(timePart.split(':')[0]) >= 12 && parseInt(timePart.split(':')[0]) <= 17) {
                        // Check the CHECKTYPE for afternoon on day 12
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the afternoon check-in on day 12
                            console.log('Afternoon check-in data for day 12:', item);
                            afternoon12in = formattedTime;
                            console.log('CHECKTIME:', afternoon12in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the afternoon check-out on day 12
                            console.log('Afternoon check-out data for day 12:', item);
                            afternoon12out = formattedTime;
                            console.log('CHECKTIME:', afternoon12out);
                        }
                    } else if ((dayOfMonth === '12' || dayOfMonth === '28') && parseInt(timePart.split(':')[0]) >= 18 && parseInt(timePart.split(':')[0]) <= 23) {
                        // Check the CHECKTYPE for evening on day 12
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the evening check-in on day 12
                            console.log('Evening check-in data for day 12:', item);
                            evening12in = formattedTime;
                            console.log('CHECKTIME:', evening12in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the evening check-out on day 12
                            console.log('Evening check-out data for day 12:', item);
                            evening12out = formattedTime;
                            console.log('CHECKTIME:', evening12out);
                        }
                    } else if ((dayOfMonth === '13' || dayOfMonth === '29') && parseInt(timePart.split(':')[0]) >= 0 && parseInt(timePart.split(':')[0]) < 12) {
                        // Check the CHECKTYPE for morning on day 13
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the morning check-in on day 13
                            console.log('Morning check-in data for day 13:', item);
                            morning13in = formattedTime;
                            console.log('CHECKTIME:', morning13in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the morning check-out on day 13
                            console.log('Morning check-out data for day 13:', item);
                            morning13out = formattedTime;
                            console.log('CHECKTIME:', morning13out);
                        }
                    } else if ((dayOfMonth === '13' || dayOfMonth === '29') && parseInt(timePart.split(':')[0]) >= 12 && parseInt(timePart.split(':')[0]) <= 17) {
                        // Check the CHECKTYPE for afternoon on day 13
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the afternoon check-in on day 13
                            console.log('Afternoon check-in data for day 13:', item);
                            afternoon13in = formattedTime;
                            console.log('CHECKTIME:', afternoon13in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the afternoon check-out on day 13
                            console.log('Afternoon check-out data for day 13:', item);
                            afternoon13out = formattedTime;
                            console.log('CHECKTIME:', afternoon13out);
                        }
                    } else if ((dayOfMonth === '13' || dayOfMonth === '29') && parseInt(timePart.split(':')[0]) >= 18 && parseInt(timePart.split(':')[0]) <= 23) {
                        // Check the CHECKTYPE for evening on day 13
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the evening check-in on day 13
                            console.log('Evening check-in data for day 13:', item);
                            evening13in = formattedTime;
                            console.log('CHECKTIME:', evening13in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the evening check-out on day 13
                            console.log('Evening check-out data for day 13:', item);
                            evening13out = formattedTime;
                            console.log('CHECKTIME:', evening13out);
                        }
                    } else if ((dayOfMonth === '14' || dayOfMonth === '30') && parseInt(timePart.split(':')[0]) >= 0 && parseInt(timePart.split(':')[0]) < 12) {
                        // Check the CHECKTYPE for morning on day 14
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the morning check-in on day 14
                            console.log('Morning check-in data for day 14:', item);
                            morning14in = formattedTime;
                            console.log('CHECKTIME:', morning14in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the morning check-out on day 14
                            console.log('Morning check-out data for day 14:', item);
                            morning14out = formattedTime;
                            console.log('CHECKTIME:', morning14out);
                        }
                    } else if ((dayOfMonth === '14' || dayOfMonth === '30') && parseInt(timePart.split(':')[0]) >= 12 && parseInt(timePart.split(':')[0]) <= 17) {
                        // Check the CHECKTYPE for afternoon on day 14
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the afternoon check-in on day 14
                            console.log('Afternoon check-in data for day 14:', item);
                            afternoon14in = formattedTime;
                            console.log('CHECKTIME:', afternoon14in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the afternoon check-out on day 14
                            console.log('Afternoon check-out data for day 14:', item);
                            afternoon14out = formattedTime;
                            console.log('CHECKTIME:', afternoon14out);
                        }
                    } else if ((dayOfMonth === '14' || dayOfMonth === '30') && parseInt(timePart.split(':')[0]) >= 18 && parseInt(timePart.split(':')[0]) <= 23) {
                        // Check the CHECKTYPE for evening on day 14
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the evening check-in on day 14
                            console.log('Evening check-in data for day 14:', item);
                            evening14in = formattedTime;
                            console.log('CHECKTIME:', evening14in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the evening check-out on day 14
                            console.log('Evening check-out data for day 14:', item);
                            evening14out = formattedTime;
                            console.log('CHECKTIME:', evening14out);
                        }
                    } else if ((dayOfMonth === '15' || dayOfMonth === '31') && parseInt(timePart.split(':')[0]) >= 0 && parseInt(timePart.split(':')[0]) < 12) {
                        // Check the CHECKTYPE for morning on day 15
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the morning check-in on day 15
                            console.log('Morning check-in data for day 15:', item);
                            morning15in = formattedTime;
                            console.log('CHECKTIME:', morning15in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the morning check-out on day 15
                            console.log('Morning check-out data for day 15:', item);
                            morning15out = formattedTime;
                            console.log('CHECKTIME:', morning15out);
                        }
                    } else if ((dayOfMonth === '15' || dayOfMonth === '31') && parseInt(timePart.split(':')[0]) >= 12 && parseInt(timePart.split(':')[0]) <= 17) {
                        // Check the CHECKTYPE for afternoon on day 15
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the afternoon check-in on day 15
                            console.log('Afternoon check-in data for day 15:', item);
                            afternoon15in = formattedTime;
                            console.log('CHECKTIME:', afternoon15in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the afternoon check-out on day 15
                            console.log('Afternoon check-out data for day 15:', item);
                            afternoon15out = formattedTime;
                            console.log('CHECKTIME:', afternoon15out);
                        }
                    } else if ((dayOfMonth === '15' || dayOfMonth === '31') && parseInt(timePart.split(':')[0]) >= 18 && parseInt(timePart.split(':')[0]) <= 23) {
                        // Check the CHECKTYPE for evening on day 15
                        if (item.CHECKTYPE === 'I') {
                            // Log or process the data for the evening check-in on day 15
                            console.log('Evening check-in data for day 15:', item);
                            evening15in = formattedTime;
                            console.log('CHECKTIME:', evening15in);
                        } else if (item.CHECKTYPE === 'O') {
                            // Log or process the data for the evening check-out on day 15
                            console.log('Evening check-out data for day 15:', item);
                            evening15out = formattedTime;
                            console.log('CHECKTIME:', evening15out);
                        }
                    }
                });
            } else {
                console.error("Invalid data format");
            }
        }

        var empNO, empNAME, empPOSITION;
        var globalData;

        function fetchCheckInOutData() {
            var selectedDoctorElement = document.getElementById("employeeName");
            var selectedDoctorOption = selectedDoctorElement.options[selectedDoctorElement.selectedIndex];

            // Check if a doctor is selected
            if (selectedDoctorOption) {
                // Extract empNo, empName, and empPosition from the selected option's text
                var selectedDoctorText = selectedDoctorOption.text;

                // Split by the first space to get empNo
                var empNo = selectedDoctorText.split(' ')[0];
                empNO = empNo;

                // Join the remaining parts to get empName and empPosition
                var remainingParts = selectedDoctorText.split(' ').slice(1);
                var empNameAndPosition = remainingParts.join(' ');

                // Split empNameAndPosition by the last space to get empName and empPosition
                var lastSpaceIndex = empNameAndPosition.lastIndexOf(' ');
                var empName = empNameAndPosition.substring(0, lastSpaceIndex);
                var empPosition = empNameAndPosition.substring(lastSpaceIndex + 1);
                empNAME = empName;
                empPOSITION = empPosition;

                var startDate = document.getElementById("startDate").value;
                var endDate = document.getElementById("endDate").value;

                // Use AJAX to fetch CHECKINOUT data for the selected doctor
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            // Log the raw response to the console
                            console.log('Raw Response:', xhr.responseText);

                            // Parse the JSON response
                            try {
                                globalData = JSON.parse(xhr.responseText);
                                console.log(globalData);
                                console.log("3bm60");

                                // Log CHECKINOUT data for the selected user to the console
                                console.log('Fetching CHECKINOUT data for EMPNO: ' + empNo + ' ' + empName + ' ' + empPosition);
                                for (var i = 0; i < globalData.length; i++) {
                                    var checkTime = globalData[i].CHECKTIME;
                                    var checkType = globalData[i].CHECKTYPE;
                                    console.log('CHECKTIME: ' + checkTime + ', CHECKTYPE: ' + checkType);
                                }

                                getData();

                            } catch (error) {
                                console.error('Error parsing JSON response:', error);
                            }
                        } else {
                            console.error('Error in AJAX request. Status:', xhr.status);
                        }
                    }
                };

                // Send an asynchronous request to fetch CHECKINOUT data
                xhr.open("GET", "fetchCheckInOutData.php?employeeName=" + empNo + "&startDate=" + startDate + "&endDate=" + endDate, true);
                xhr.send();
            } else {
                console.error('No doctor selected.');
            }
        }

        var printContent = "";

        function printSelectedName() {
            var startDateString = document.getElementById("startDate").value;
            var endDateString = document.getElementById("endDate").value;

            // Convert date strings to Date objects
            var startDate = new Date(startDateString);
            var endDate = new Date(endDateString);

            var monthNames = [
                "January", "February", "March",
                "April", "May", "June", "July",
                "August", "September", "October",
                "November", "December"
            ];

            // Extract day, month, and year
            var startDay = startDate.getDate();
            var startMonthIndex = startDate.getMonth();
            var startYear = startDate.getFullYear();

            var endDay = endDate.getDate();
            var endMonthIndex = endDate.getMonth();
            var endYear = endDate.getFullYear();

            // Format the start and end dates
            var formattedStartDate = monthNames[startMonthIndex] + " " + startDay + " - " + endDay + ", " + startYear;

            // If the month is the same, only display it once
            if (startMonthIndex !== endMonthIndex) {
                formattedStartDate = monthNames[startMonthIndex] + " " + startDay + " - " + monthNames[endMonthIndex] + " " + endDay + ", " + startYear;
            }

            // If the year is different, display it for the end date
            else if (startYear !== endYear) {
                formattedStartDate = monthNames[startMonthIndex] + " " + startDay + " - " + monthNames[endMonthIndex] + " " + endDay + ", " + startYear + " - " + endYear;
            }

            // Log or use the formatted date as needed
            console.log("Formatted Date Range:", formattedStartDate);
            console.log("EMPNO:", empNO);
            console.log("EMPNAME:", empNAME);
            console.log("EMPPOSITION:", empPOSITION);

            morning1in = morning1in ?? "";
            morning1out = morning1out ?? "";
            afternoon1in = afternoon1in ?? "";
            afternoon1out = afternoon1out ?? "";
            evening1in = evening1in ?? "";
            evening1out = evening1out ?? "";
            morning2in = morning2in ?? "";
            morning2out = morning2out ?? "";
            afternoon2in = afternoon2in ?? "";
            afternoon2out = afternoon2out ?? "";
            evening2in = evening2in ?? "";
            evening2out = evening2out ?? "";
            morning3in = morning3in ?? "";
            morning3out = morning3out ?? "";
            afternoon3in = afternoon3in ?? "";
            afternoon3out = afternoon3out ?? "";
            evening3in = evening3in ?? "";
            evening3out = evening3out ?? "";
            morning4in = morning4in ?? "";
            morning4out = morning4out ?? "";
            afternoon4in = afternoon4in ?? "";
            afternoon4out = afternoon4out ?? "";
            evening4in = evening4in ?? "";
            evening4out = evening4out ?? "";
            morning5in = morning5in ?? "";
            morning5out = morning5out ?? "";
            afternoon5in = afternoon5in ?? "";
            afternoon5out = afternoon5out ?? "";
            evening5in = evening5in ?? "";
            evening5out = evening5out ?? "";
            morning6in = morning6in ?? "";
            morning6out = morning6out ?? "";
            afternoon6in = afternoon6in ?? "";
            afternoon6out = afternoon6out ?? "";
            evening6in = evening6in ?? "";
            evening6out = evening6out ?? "";
            morning7in = morning7in ?? "";
            morning7out = morning7out ?? "";
            afternoon7in = afternoon7in ?? "";
            afternoon7out = afternoon7out ?? "";
            evening7in = evening7in ?? "";
            evening7out = evening7out ?? "";
            morning8in = morning8in ?? "";
            morning8out = morning8out ?? "";
            afternoon8in = afternoon8in ?? "";
            afternoon8out = afternoon8out ?? "";
            evening8in = evening8in ?? "";
            evening8out = evening8out ?? "";
            morning9in = morning9in ?? "";
            morning9out = morning9out ?? "";
            afternoon9in = afternoon9in ?? "";
            afternoon9out = afternoon9out ?? "";
            evening9in = evening9in ?? "";
            evening9out = evening9out ?? "";
            morning10in = morning10in ?? "";
            morning10out = morning10out ?? "";
            afternoon10in = afternoon10in ?? "";
            afternoon10out = afternoon10out ?? "";
            evening10in = evening10in ?? "";
            evening10out = evening10out ?? "";
            morning11in = morning11in ?? "";
            morning11out = morning11out ?? "";
            afternoon11in = afternoon11in ?? "";
            afternoon11out = afternoon11out ?? "";
            evening11in = evening11in ?? "";
            evening11out = evening11out ?? "";
            morning12in = morning12in ?? "";
            morning12out = morning12out ?? "";
            afternoon12in = afternoon12in ?? "";
            afternoon12out = afternoon12out ?? "";
            evening12in = evening12in ?? "";
            evening12out = evening12out ?? "";
            morning13in = morning13in ?? "";
            morning13out = morning13out ?? "";
            afternoon13in = afternoon13in ?? "";
            afternoon13out = afternoon13out ?? "";
            evening13in = evening13in ?? "";
            evening13out = evening13out ?? "";
            morning14in = morning14in ?? "";
            morning14out = morning14out ?? "";
            afternoon14in = afternoon14in ?? "";
            afternoon14out = afternoon14out ?? "";
            evening14in = evening14in ?? "";
            evening14out = evening14out ?? "";
            morning15in = morning15in ?? "";
            morning15out = morning15out ?? "";
            afternoon15in = afternoon15in ?? "";
            afternoon15out = afternoon15out ?? "";
            evening15in = evening15in ?? "";
            evening15out = evening15out ?? "";
            morning16in = morning16in ?? "";
            morning16out = morning16out ?? "";
            afternoon16in = afternoon16in ?? "";
            afternoon16out = afternoon16out ?? "";
            evening16in = evening16in ?? "";
            evening16out = evening16out ?? "";


            printContent += "<br>";
            printContent += "<div style='justify-content: center; align-items: center; display: flex;flex-direction: column;';>"
            printContent += "<img src='img/eac.png' style='position: absolute; top: -185px; left: -3rem; scale: 0.15; filter: grayscale(100%);'><p style='margin-left: 95px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;'>Emilio Aguinaldo College Medical Center - Cavite</p>";
            printContent += "<p style=' font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif;'>Automated Monitoring System</p>";
            printContent += "<p style='margin-top: -5px; font-weight: bold; font-size: 16px; font-family: Arial, Helvetica, sans-serif;'>EMPLOYEE DETAILED TIME IN/OUT TRAILS</p>";
            printContent += "<p style=' margin-top: -5px; font-weight: bold; font-size: 14px; font-family: Arial, Helvetica, sans-serif;'>Department</p>";
            printContent += "<p style=' margin-top: -8px; font-weight: bold; font-size: 14px; font-family: Arial, Helvetica, sans-serif;'>Period <span style='margin-left: 100px; font-size: 14px; font-weight: normal; font-family: Arial, Helvetica, sans-serif;'>" + formattedStartDate + "</span></p>";
            printContent += "<table style='margin-left: -9px; margin-top: 5px; width: 50%; border-collapse: collapse; border: 1px solid #ddd;'>";
            printContent += "<tr style='font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='font-weight: normal; font-size: 14px; width: 18%; padding: 3px; border: 1px solid black;'>EMPLOYEE NAME</td><td style='width: 50%; padding: 3px; border: 1px solid black;'>" + empNAME + "</td></tr>";
            printContent += "<tr style='font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='font-weight: normal; font-size: 14px; padding: 3px; border: 1px solid black;'>EMPLOYEE ID</td><td style='padding: 3px; border: 1px solid black;'>" + empNO + "</td></tr>";
            printContent += "<tr style='font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='font-weight: normal; font-size: 14px; padding: 3px; border: 1px solid black;'>POSITION</td><td style='padding: 3px; border: 1px solid black;'>" + empPOSITION + "</td></tr>";
            printContent += "<tr style='font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='font-weight: normal; font-size: 14px; padding: 3px; border: 1px solid black;'>REG. SCHEDULE</td><td style='padding: 3px; border: 1px solid black;'></td></tr>";
            printContent += "</table>";
            printContent += "<table style='margin-left: -9px; margin-top: 5px; width: 50%; font-weight: bold; border-collapse: collapse; border: 1px solid #ddd;'>";
            printContent += "<tr style='font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'>";
            printContent += "<td style='width: 6%; font-size: 13px; text-align:center; padding: 3px; border: 1px solid black;'>DAY</td>";
            printContent += "<td style='width: 15.5%; font-size: 13px; text-align:center; padding: 3px; border: 1px solid black;'>MORNING</td>";
            printContent += "<td style='width: 13%; font-size: 13px; text-align:center; padding: 3px; border: 1px solid black;'>AFTERNOON</td>";
            printContent += "<td style='width: 15%; font-size: 13px; text-align:center; padding: 3px; border: 1px solid black;'>EVENING</td>";
            printContent += "</tr>";
            printContent += "<table style='margin-left: -9px; margin-top: -1px; width: 50%; font-weight: normal; border-collapse: collapse; border: 1px solid #ddd;'>";
            printContent += "<tr style='padding: 3px; text-align:center; font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='padding: 3px; text-align:center; font-size: 13px; width: 5%; border: 1px solid black;'>16</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning16in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning16out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon16in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon16out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening16in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening16out + "</td>";
            printContent += "<tr style='padding: 3px; text-align:center; font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='padding: 3px; text-align:center; font-size: 13px; width: 5%; border: 1px solid black;'>1/17</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning1in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning1out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon1in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon1out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening1in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening1out + "</td>";
            printContent += "<tr style='padding: 3px; text-align:center; font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='padding: 3px; text-align:center; font-size: 13px; width: 5%; border: 1px solid black;'>2/18</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning2in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning2out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon2in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon2out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening2in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening2out + "</td>";
            printContent += "<tr style='padding: 3px; text-align:center; font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='padding: 3px; text-align:center; font-size: 13px; width: 5%; border: 1px solid black;'>3/19</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning3in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning3out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon3in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon3out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening3in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening3out + "</td>";
            printContent += "<tr style='padding: 3px; text-align:center; font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='padding: 3px; text-align:center; font-size: 13px; width: 5%; border: 1px solid black;'>4/20</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning4in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning4out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon4in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon4out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening4in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening4out + "</td>";
            printContent += "<tr style='padding: 3px; text-align:center; font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='padding: 3px; text-align:center; font-size: 13px; width: 5%; border: 1px solid black;'>5/21</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning5in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning5out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon5in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon5out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening5in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening5out + "</td>";
            printContent += "<tr style='padding: 3px; text-align:center; font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='padding: 3px; text-align:center; font-size: 13px; width: 5%; border: 1px solid black;'>6/22</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning6in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning6out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon6in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon6out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening6in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening6out + "</td>";
            printContent += "<tr style='padding: 3px; text-align:center; font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='padding: 3px; text-align:center; font-size: 13px; width: 5%; border: 1px solid black;'>7/23</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning7in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning7out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon7in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon7out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening7in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening7out + "</td>";
            printContent += "<tr style='padding: 3px; text-align:center; font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='padding: 3px; text-align:center; font-size: 13px; width: 5%; border: 1px solid black;'>8/24</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning8in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning8out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon8in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon8out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening8in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening8out + "</td>";
            printContent += "<tr style='padding: 3px; text-align:center; font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='padding: 3px; text-align:center; font-size: 13px; width: 5%; border: 1px solid black;'>9/25</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning9in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning9out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon9in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon9out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening9in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening9out + "</td>";
            printContent += "<tr style='padding: 3px; text-align:center; font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='padding: 3px; text-align:center; font-size: 13px; width: 5%; border: 1px solid black;'>10/26</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning10in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning10out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon10in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon10out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening10in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening10out + "</td>";
            printContent += "<tr style='padding: 3px; text-align:center; font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='padding: 3px; text-align:center; font-size: 13px; width: 5%; border: 1px solid black;'>11/27</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning11in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning11out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon11in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon11out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening11in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening11out + "</td>";
            printContent += "<tr style='padding: 3px; text-align:center; font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='padding: 3px; text-align:center; font-size: 13px; width: 5%; border: 1px solid black;'>12/28</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning12in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning12out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon12in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon12out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening12in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening12out + "</td>";
            printContent += "<tr style='padding: 3px; text-align:center; font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='padding: 3px; text-align:center; font-size: 13px; width: 5%; border: 1px solid black;'>13/29</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning13in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning13out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon13in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon13out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening13in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening13out + "</td>";
            printContent += "<tr style='padding: 3px; text-align:center; font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='padding: 3px; text-align:center; font-size: 13px; width: 5%; border: 1px solid black;'>14/30</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning14in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning14out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon14in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon14out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening14in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening14out + "</td>";
            printContent += "<tr style='padding: 3px; text-align:center; font-family: Arial, Helvetica, sans-serif; background-color: #f2f2f2;'><td style='padding: 3px; text-align:center; font-size: 13px; width: 5%; border: 1px solid black;'>15/31</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning15in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + morning15out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon15in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + afternoon15out + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening15in + "</td><td style='padding: 3px; text-align:center; width: 7.5%; border: 1px solid black; font-size: 13px'>" + evening15out + "</td>";
            printContent += "</table>";
            printContent += "<p style='margin-left: -10px; margin-top: 47px; font-weight: normal; font-size: 14px; font-family: Arial, Helvetica, sans-serif;'>__________________<span style='margin-left: 205px; font-size: 14px; font-weight: normal; font-family: Arial, Helvetica, sans-serif;'>_____________________</span></p>";
            printContent += "<p style='positon: absolute; margin-left: -10px; margin-top: -10px; font-weight: normal; font-size: 14px; font-family: Arial, Helvetica, sans-serif;'>DEPARTMENT HEAD <span style='margin-left: 205px; font-size: 14px; font-weight: normal; font-family: Arial, Helvetica, sans-serif;'>EMPLOYEE SIGNATURE</span></p>";
            printContent += "</div>"
            // Get the selected name
            var selectedName = document.getElementById('employeeName').value;

            // Create a new window or iframe for printing
            var printWindow = window.open('', '_blank');
            //open a new window for printing
            printWindow.document.clear();
            printWindow.document.open();

            // Add content to the print window or iframe
            printWindow.document.write('<html><head><style>@media print { @page { margin: 0; } body { margin: 20px; } @page :first { margin: 0; } } </style></head><body>' + printContent + '</body></html>');

            // Close the document stream
            printWindow.document.close();

            // Trigger the print dialog; added delay for the icon to load within the page
            printWindow.onload = function() {
                printWindow.print();
                printWindow.close();
            };
        }
    </script>


</body>

</html>