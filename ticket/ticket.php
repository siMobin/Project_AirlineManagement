<?php
$serverName = "ACER_LAPTOP\SQLEXPRESS";
$connectionInfo = array("Database" => "airTest");
$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (isset($_POST['submit'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];

    // Convert $from and $to to integers
    $from = intval($from);
    $to = intval($to);

    $date = new DateTime($_POST['date']);
    $today = new DateTime();
    $class = $_POST['class'];
    $passengers = $_POST['passengers'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $trip = $_POST['trip'];

    // Validate date
    if ($date < $today) {
        // Date is in the past
        echo "<script>alert('Please select a valid date');</script>";
    } else {
        // Date is valid

        // Calculate cost
        $cost = abs($from - $to) * 150;
        if ($class == 'economy') {
            $cost *= 1;
        } elseif ($class == 'business') {
            $cost *= 1.5;
        } elseif ($class == 'first') {
            $cost *= 2;
        }

        // Multiply cost by number of passengers
        $cost *= $passengers;

        // Check if round trip
        if ($trip == 'round-trip') {
            // Get return date
            $returnDate = new DateTime($_POST['return-date']);

            // Validate return date
            if ($returnDate < $date) {
                // Return date is before departure date
                echo "<script>alert('Please select a valid return date');</script>";
            } else {
                // Return date is valid

                // Double cost and subtract 10%
                $cost *= 2;
                $cost *= 0.9;

                // Query locations from database to get airport names
                $sql = "SELECT id, destination FROM locations";
                $stmt = sqlsrv_query($conn, $sql);
                $locations = [];
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $locations[$row['id']] = $row['destination'];
                }

                // Convert airport IDs to names
                $fromName = $locations[$from];
                $toName = $locations[$to];

                // Generate a random 8-digit ID
                $id = mt_rand(10000000, 99999999);

                // Insert into database with the generated ID
                $sql = "INSERT INTO bookings (id, [from], [to], date, class, passengers, email, phone, trip, return_date, cost) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $params = array($id, $fromName, $toName, $date->format('Y-m-d'), $class, $passengers, $email, $phone, $trip, $returnDate->format('Y-m-d'), $cost);
                $stmt = sqlsrv_query($conn, $sql, $params);

                if ($stmt === false) {
                    die(print_r(sqlsrv_errors(), true));
                } else {
                    // Generate PDF
                    require('./fpdf/fpdf.php');

                    $pdf = new FPDF();
                    $pdf->AddPage();
                    $pdf->SetFont('Arial', 'B', 16);
                    $pdf->Cell(40, 10, 'Airline Ticket');
                    $pdf->Ln();
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Cell(40, 10, 'From: ' . htmlspecialchars($fromName));
                    $pdf->Ln();
                    $pdf->Cell(40, 10, 'To: ' . htmlspecialchars($toName));
                    $pdf->Ln();
                    $pdf->Cell(40, 10, 'Date: ' . htmlspecialchars($date->format('Y-m-d')));
                    // Display return date
                    if ($trip == 'round-trip') {
                        // Display return date
                        $pdf->Ln();
                        $pdf->Cell(40, 10, 'Return Date: ' . htmlspecialchars($returnDate->format('Y-m-d')));
                    }
                    // Display class and cost
                    if (isset($class)) {
                        // Display class
                        $pdf->Ln();
                        $pdf->Cell(40, 10, 'Class: ' . htmlspecialchars($class));
                    }

                    // Display cost
                    if (isset($cost)) {
                        // Display cost
                        $pdf->Ln();
                        $pdf->Cell(40, 10, 'Cost: ' . htmlspecialchars($cost));
                    }

                    // Display passengers
                    if (isset($passengers)) {
                        // Display passengers
                        $pdf->Ln();
                        $pdf->Cell(40, 10, 'Passengers: ' . htmlspecialchars($passengers));
                    }

                    // Display ID
                    if (isset($id)) {
                        // Display ID
                        $pdf->Ln();
                        $pdf->Cell(40, 10, 'ID: ' . $id);
                    }

                    // Display phone
                    if (isset($phone)) {
                        // Display phone
                        $pdf->Ln();
                        $pdf->Cell(40, 10, 'Phone: ' . htmlspecialchars($phone));
                    }

                    // Output PDF
                    if (isset($pdf)) {
                        // Output PDF
                        ob_end_clean();
                        header("Content-type:application/pdf");
                        header("Content-Disposition:inline;filename='ticket.pdf'");
                        echo base64_encode($pdf->Output());
                        exit;
                    }

                    // Display success message
                    echo "<script>alert('Booking successful!');</script>";
                }
            }
        } else {
            // One-way trip

            // Query locations from database to get airport names
            $sql = "SELECT id, destination FROM locations";
            $stmt = sqlsrv_query($conn, $sql);
            $locations = [];
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $locations[$row['id']] = $row['destination'];
            }

            // Convert airport IDs to names
            $fromName = $locations[$from];
            $toName = $locations[$to];

            // Generate a random 8-digit ID
            $id = mt_rand(10000000, 99999999);

            // Insert into database with the generated ID
            $sql = "INSERT INTO bookings (id, [from], [to], date, class, passengers, email, phone, trip, cost) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $params = array($id, $fromName, $toName, $date->format('Y-m-d'), $class, $passengers, $email, $phone, $trip, $cost);
            $stmt = sqlsrv_query($conn, $sql, $params);

            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            } else {
                // Generate PDF
                require('./fpdf/fpdf.php');

                $pdf = new FPDF();
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Cell(40, 10, 'Airline Ticket');
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 12);

// Display ID
if (isset($id)) {
    // Display ID
    $pdf->Ln();
    $pdf->Cell(40, 10, 'ID: ' . $id);
}
$pdf->Ln();
                $pdf->Cell(40, 10, 'From: ' . htmlspecialchars($fromName));
                $pdf->Ln();
                $pdf->Cell(40, 10, 'To: ' . htmlspecialchars($toName));
                // ...
                $pdf->Ln();
                $pdf->Cell(40, 10, 'Date: ' . htmlspecialchars($date->format('Y-m-d')));
                // Display class and cost
                if (isset($class)) {
                    // Display class
                    $pdf->Ln();
                    $pdf->Cell(40, 10, 'Class: ' . htmlspecialchars($class));
                }

                // Display cost
                if (isset($cost)) {
                    // Display cost
                    $pdf->Ln();
                    $pdf->Cell(40, 10, 'Cost: ' . htmlspecialchars($cost));
                }

                // Display passengers
                if (isset($passengers)) {
                    // Display passengers
                    $pdf->Ln();
                    $pdf->Cell(40, 10, 'Passengers: ' . htmlspecialchars($passengers));
                }

                // Display ID
                // if (isset($id)) {
                //     // Display ID
                //     $pdf->Ln();
                //     $pdf->Cell(40, 10, 'ID: ' . $id);
                // }

                // Display phone
                if (isset($phone)) {
                    // Display phone
                    $pdf->Ln();
                    $pdf->Cell(40, 10, 'Phone: ' . htmlspecialchars($phone));
                }

                // Output PDF
                if (isset($pdf)) {
                    // Output PDF
                    ob_end_clean();
                    header("Content-type:application/pdf");
                    header("Content-Disposition:inline;filename='ticket.pdf'");
                    echo base64_encode($pdf->Output());
                    exit;
                }

                // Display success message
                echo "<script>alert('Booking successful!');</script>";
            }
        }
    }
}

// Query locations from database to populate the dropdowns
$sql = "SELECT id, destination FROM locations";
$stmt = sqlsrv_query($conn, $sql);
$locations = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $locations[$row['id']] = $row['destination'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ticket.css">
    <title>ticket</title>
</head>
<body>

<header>
    <h1>YOUR PRIVET AIRLINE!</h1>
</header>
<form method="post">
<div class="border">
    <!-- //////////////////////// -->
    <div class="destination">
    <div>
    <label for="from">From:</label>
    <select id="from" name="from">
        <?php foreach ($locations as $id => $destination): ?>
            <option value="<?php echo htmlspecialchars($id); ?>"><?php echo htmlspecialchars($destination); ?></option>
        <?php endforeach; ?>
    </select>
    </div>

<div>
    <label for="to">To:</label>
    <select id="to" name="to">
        <?php foreach ($locations as $id => $destination): ?>
            <option value="<?php echo htmlspecialchars($id); ?>"><?php echo htmlspecialchars($destination); ?></option>
        <?php endforeach; ?>
    </select>
    </div>
    </div>
    <!-- /////////// -->

    <div class="date">
    <div>
    <label for="trip">Trip:</label>
    <select id="trip" name="trip">
        <option value="one-way">One-way</option>
        <option value="round-trip">Round-trip</option>
    </select>
    </div>
    <div class="travel_date">
    <label for="date">Date:</label>
    <input type="date" id="date" name="date">
    </div>

    <!-- Add return date input -->
    <div id="return-date-input" style="display: none;">
        <label for="return-date">Return Date:</label>
        <input type="date" id="return-date" name="return-date"> 
    </div>
    </div>

    <div class="seat">
    <div class="quality">
    <label for="class">Class:</label>
    <select id="class" name="class">
        <option value="economy">Economy</option>
        <option value="business">Business</option>
        <option value="first">First</option>
    </select> 
    </div>
    <div>
    <label for="passengers">Passengers:</label>
    <input type="number" id="passengers" name="passengers"> 
    </div>
    </div>

    <!-- Add email and phone inputs -->
    <div class="contact">
    <div>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email"> 
    </div>

    <div>
    <label for="phone">Phone:</label>
    <input type="tel" id="phone" name="phone">
    </div>
    </div>
    </div>

    <input class="submit" type="submit" name="submit" value="Submit">
</form>

<script>
    // Show/hide return date input based on trip selection
    document.getElementById('trip').addEventListener('change', function () {
        if (this.value === 'round-trip') {
            document.getElementById('return-date-input').style.display = 'block';
        } else {
            document.getElementById('return-date-input').style.display = 'none';
        }
    });
</script>
</body>
</html>
