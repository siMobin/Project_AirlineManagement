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

                    $pdf = new FPDF('p', 'mm', 'A4');
                    $pdf->AddPage();
                    // ticket background
                    $pdf->Image('../image/ticket.png', -10, -5, 230);
                    $pdf->SetFont('Arial', 'BU', 24);
                    $pdf->Cell(71, 10, '', 0, 0);
                    $pdf->Cell(59, 5, 'Privet Jet!', 0, 0);
                    $pdf->Cell(59, 10, '', 0, 0);
                    // $pdf->Ln();
                    $pdf->SetFont('Arial', 'B', 12);

                    // Display ID
                    if (isset($id)) {
                        // Display ID
                        $pdf->Ln();
                        $pdf->Cell(10, 10, 'SID: ');
                        $pdf->SetFont('Arial', 'I', 12);
                        $pdf->Cell(140, 10, ' ' . $id);
                    }
                    $pdf->Ln();


                    // from
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(10, 10, 'From:');
                    $pdf->SetFont('Arial', 'I', 12);
                    $pdf->Cell(1, 10, '   ' . htmlspecialchars($fromName));
                    $pdf->Ln();
                    // to
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(10, 10, 'To:');
                    $pdf->SetFont('Arial', 'I', 12);
                    $pdf->Cell(1, 10, '   ' . htmlspecialchars($toName));

                    $pdf->Ln();
                    // $pdf->Ln();          
                    $pdf->Cell(95, 10, 'Travel Date: ' . htmlspecialchars($date->format('Y-m-d')), 1, 0, 'C');
                    // Display return date
                    if ($trip == 'round-trip') {
                        $pdf->Cell(95, 10, 'Return Date: ' . htmlspecialchars($returnDate->format('Y-m-d')), 1, 0, 'C');
                    }

                    // Display class and cost
                    if (isset($class)) {
                        // Display class
                        $pdf->Ln();
                        // Display class
                        $pdf->SetFont('Arial', 'B', 12);
                        $pdf->Cell(15, 10, 'Class:');
                        $pdf->SetFont('Arial', 'I', 12);
                        $pdf->Cell(40, 10, ' ' . htmlspecialchars($class));
                    }

                    // Display passengers
                    if (isset($passengers)) {
                        // Display passengers
                        // $pdf->Ln();
                        $pdf->SetFont('Arial', 'B', 12);
                        $pdf->Cell(25, 10, 'Passengers: ');
                        $pdf->SetFont('Arial', 'I', 12);
                        $pdf->Cell(40, 10, ' ' . htmlspecialchars($passengers));
                    }

                    // Display phone
                    if (isset($phone)) {
                        // Display phone
                        $pdf->Ln();
                        $pdf->SetFont('Arial', 'B', 12);
                        $pdf->Cell(15, 10, 'Phone: ');
                        $pdf->SetFont('Arial', 'I', 12);
                        $pdf->Cell(40, 10, ' ' . htmlspecialchars($phone));
                    }

                    // Display cost
                    if (isset($cost)) {
                        $pdf->SetTextColor(255, 0, 0);
                        // Display cost
                        $pdf->Ln();
                        $pdf->SetFont('Arial', 'B', 12);
                        $pdf->Cell(175, 10, 'Cost:  ', 0, 0, 'R');
                        $pdf->SetFont('Arial', 'I', 12);
                        $pdf->Cell(10, 10, '  $' . htmlspecialchars($cost), 0, 1, 'R');
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
                $pdf = new FPDF('p', 'mm', 'A4');
                $pdf->AddPage();
                // ticket background
                $pdf->Image('../image/ticket.png', -10, -5, 230);
                $pdf->SetFont('Arial', 'BU', 24);
                $pdf->Cell(71, 10, '', 0, 0);
                $pdf->Cell(59, 5, 'Privet Jet!', 0, 0);
                $pdf->Cell(59, 10, '', 0, 0);
                $pdf->Ln();
                $pdf->SetFont('Arial', 'B', 12);

                // Display ID
                if (isset($id)) {
                    // Display ID
                    $pdf->Ln();
                    $pdf->Cell(10, 10, 'SID: ');
                    $pdf->SetFont('Arial', 'I', 12);
                    $pdf->Cell(140, 10, ' ' . $id);
                    $pdf->Cell(40, 10, 'Travel Date: ' . htmlspecialchars($date->format('Y-m-d')));
                }

                $pdf->Ln();
                // from
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(10, 10, 'From:');
                $pdf->SetFont('Arial', 'I', 12);
                $pdf->Cell(1, 10, '   ' . htmlspecialchars($fromName));
                $pdf->Ln();
                // to
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(10, 10, 'To:');
                $pdf->SetFont('Arial', 'I', 12);
                $pdf->Cell(1, 10, '   ' . htmlspecialchars($toName));

                $pdf->Ln();

                // Display class and cost
                if (isset($class)) {
                    // Display class
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(15, 10, 'Class:');
                    $pdf->SetFont('Arial', 'I', 12);
                    $pdf->Cell(40, 10, ' ' . htmlspecialchars($class));
                }

                // Display passengers
                if (isset($passengers)) {
                    // Display passengers
                    // $pdf->Ln();
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(25, 10, 'Passengers: ');
                    $pdf->SetFont('Arial', 'I', 12);
                    $pdf->Cell(40, 10, ' ' . htmlspecialchars($passengers));
                }
                // Display phone
                if (isset($phone)) {
                    // Display phone
                    $pdf->Ln();
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(15, 10, 'Phone: ');
                    $pdf->SetFont('Arial', 'I', 12);
                    $pdf->Cell(40, 10, ' ' . htmlspecialchars($phone));
                }

                // Display cost
                if (isset($cost)) {
                    $pdf->SetTextColor(255, 0, 0);
                    // Display cost
                    $pdf->Ln();
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(175, 10, 'Cost:  ', 0, 0, 'R');
                    $pdf->SetFont('Arial', 'I', 12);
                    $pdf->Cell(10, 10, '  $' . htmlspecialchars($cost), 0, 1, 'R');
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
    <!-- include nav bar!!!!! -->
    <?php include '../partials/nav.php'; ?>
    <header>
        <div>
            <h1>YOUR PRIVET AIRLINE!</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam culpa iste consectetur aliquid debitis esse asperiores inventore hic? Nam, veritatis!</p>
        </div>
    </header>
    <form method="post">
        <div class="border">
            <!-- //////////////////////// -->
            <div class="destination">
                <div class="box">
                    <label for="from">From:</label>
                    <select id="from" name="from">
                        <?php foreach ($locations as $id => $destination) : ?>
                            <option value="<?php echo htmlspecialchars($id); ?>"><?php echo htmlspecialchars($destination); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="box">
                    <label for="to">To:</label>
                    <select id="to" name="to">
                        <?php foreach ($locations as $id => $destination) : ?>
                            <option value="<?php echo htmlspecialchars($id); ?>"><?php echo htmlspecialchars($destination); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- /////////// -->

                <div class="date">
                    <div class="box">
                        <label for="trip">Trip:</label>
                        <select id="trip" name="trip">
                            <option value="one-way">One-way</option>
                            <option value="round-trip">Round-trip</option>
                        </select>
                    </div>
                    <div class="travel_date box">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date">
                    </div>

                    <!-- Add return date input -->
                    <div class="box" id="return-date-input" style="display: none;">
                        <label for="return-date">Return Date:</label><br>
                        <input type="date" id="return-date" name="return-date">
                    </div>
                </div>
            </div>

            <div class="more_info">

                <!-- <div class="seat"> -->
                <div class="quality box_2">
                    <label for="class">Class:</label>
                    <select id="class" name="class">
                        <option value="economy">Economy</option>
                        <option value="business">Business</option>
                        <option value="first">First</option>
                    </select>
                </div>

                <div class="box_2">
                    <label for="passengers">Passengers:</label>
                    <input type="number" id="passengers" name="passengers">
                </div>
                <!-- </div> -->

                <!-- Add email and phone inputs -->
                <!-- <div class="contact"> -->
                <div class="box_2">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                </div>

                <div class="box_2">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone">
                </div>
            </div>
        </div>
        <!-- </div> -->

        <input class="submit" type="submit" name="submit" value="Submit">
    </form>

    <script>
        // Show/hide return date input based on trip selection
        document.getElementById('trip').addEventListener('change', function() {
            if (this.value === 'round-trip') {
                document.getElementById('return-date-input').style.display = 'block';
            } else {
                document.getElementById('return-date-input').style.display = 'none';
            }
        });
    </script>
</body>

</html>