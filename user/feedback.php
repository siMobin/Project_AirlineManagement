<?php require("./nav.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/feedback.css">
</head>

<body>

    <header>
        <h1>Reach out to us at any time!</h1>
        <div>
            <a href="./">Home</a>
            <span>&bull;</span>
            <a href="./ticket.php">Book a ticket</a>
        </div>
    </header>

    <?php
    $successful = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Establish a database connection
        require("./conn.php");

        $category = $_POST['category'];
        $subject = $_POST['subject'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $country = $_POST['country'];
        $message = $_POST['message'];
        $ticket_number = !empty($_POST['ticket_number']) ? $_POST['ticket_number'] : null;
        $journey_date = !empty($_POST['journey_date']) ? $_POST['journey_date'] : null;


        // Set the time zone to Asia/Dhaka
        date_default_timezone_set('Asia/Dhaka');
        // Capture the current timestamp
        $submission_time = date("Y-m-d H:i:s");
        $file_size = 8 * 1024 * 1024; // 8388608 = 8MB

        // Check if a file was uploaded and not empty
        if (!empty($_FILES['ticket_file']['tmp_name'])) {
            $ticket_file = file_get_contents($_FILES['ticket_file']['tmp_name']);

            if ($_FILES['ticket_file']['size'] > $file_size) {
                echo "File size exceeds the limit ($file_size" . "MB).";
            }
        } else {
            $ticket_file = null; // Set to null if no file was uploaded
        }

        $sql = "INSERT INTO feedback (category, subject, name, email, phone, country, message, ticket_number, journey_date, ticket_file, submission_time)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CONVERT(VARBINARY(MAX), ?), ?)";

        $params = array($category, $subject, $name, $email, $phone, $country, $message, $ticket_number, $journey_date, $ticket_file, $submission_time);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            header("Location: ./feedback.php#submit");
            $successful = "Feedback submitted successfully.";
        }

        sqlsrv_close($conn);
    }
    ?>

    <!--  -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <div class="feedback">
            <div class="title">
                <h4>We'd love to hear from you</h4>
                <p>Send us a message and we'll respond as soon as possible.</p>
                <p class="mail_us">You can also send us a Direct Mail to <a href="mailto:privatejet@gmail.com">privatejet@gmail.com</a>. We will reply you as soon as possible.</p>
            </div>
            <span class="box box-1 category">
                <label class="required" for="category">Category</label>
                <div class="bullet-options">
                    <input type="radio" name="category" id="general" value="General" checked required>
                    <label for="general">General</label>

                    <input type="radio" name="category" id="technical" value="Technical">
                    <label for="technical">Technical</label>

                    <input type="radio" name="category" id="customer-service" value="Customer Service">
                    <label for="customer-service">Customer Service</label>
                </div>
            </span>

            <span class="box box-2 subject">
                <label class="required" for="subject">Subject</label>
                <input type="text" name="subject" required placeholder="🕮 What is your feedback about?">
            </span>

            <span class="box box-3">
                <label class="required" for="name">Name</label>
                <input type="text" name="name" required placeholder="☹ Your name">
            </span>

            <span class="box box-4">
                <label class="required" for="email">Email</label>
                <input type="email" name="email" required placeholder="✉ Email address">
            </span>

            <span class="box box-5">
                <label class="required" for="phone">Phone Number</label>
                <input type="tel" name="phone" required placeholder="☏ Contact number">
            </span>

            <span class="box box-6">
                <?php
                // Establish a database connection
                require("./conn.php");

                // Query to retrieve countries from the 'locations' table
                $sql = "SELECT destination FROM locations order by destination";
                $result = sqlsrv_query($conn, $sql);

                if (!$result) {
                    die(print_r(sqlsrv_errors(), true));
                }
                ?>
                <label class="required" for="country">Country/Airport</label>
                <select name="country" required>
                    <?php
                    // Dynamically populate the <select> with country options from the database
                    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        echo "<option value='" . $row['destination'] . "'>" . $row['destination'] . "</option>";
                    }
                    ?>
                </select>
            </span>

            <span class="box box-7 message">
                <label class="required" for="message">Message</label>
                <textarea id="resizableTextarea" name="message" rows="5" required placeholder="✎ Write message"></textarea>
            </span>

            <!--  -->
            <span class="box optional">
                <p><strong>(Optional Section) </strong>Enter details of your booking so that we can be more specific about your feedback.</p>
            </span>

            <span class="box box-8">
                <label for="ticket_number">FID/Ticket Number (8 Digit)</label>
                <input type="number" name="ticket_number" placeholder="🁖 FID / Ticker number">
            </span>

            <span class="box box-9">
                <label for="journey_date">Journey Date</label>
                <input type="text" id="journey_date" name="journey_date" placeholder="&#128467; <?php echo date('Y-m-d'); ?>">
            </span>

            <span class="box box-10">
                <label for="ticket_file">Ticket (Image/PDF)</label>
                <input type="file" name="ticket_file" accept=".jpg, .jpeg, .png, .pdf, .webp">
            </span>

            <input class="submit" id="submit" type="submit" value="Submit Feedback">
            <?php
            echo "<p class='successful'> $successful</p>";
            ?>
        </div>


    </form>
    <?php include("./footer.html"); ?>

    <script>
        // make textarea resizable only top-to-bottom
        // see feedback.scss L78
        document.getElementById("resizableTextarea").addEventListener("input", function() {
            this.style.height = "auto";
            this.style.height = (this.scrollHeight) + "px";
        });

        // show current-date as a placeholder
        document.getElementById('journey_date').addEventListener('focus', function() {
            this.type = 'date'; // convert as date input
            this.value = '<?php echo date('Y-m-d'); ?>' // set current date as default value
            this.click();
        });
    </script>

</body>

</html>