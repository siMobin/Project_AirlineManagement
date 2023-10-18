<?php


/*/////////////////////////////////////////////////
// only for download items => feedback_user.php ///
*/ ////////////////////////////////////////////////


// Establish a database connection
require("./conn.php");

// Retrieve the PDF file data based on the provided ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT ticket_file FROM feedback WHERE id = ?";
    $params = array($id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $pdfData = $row['ticket_file'];

        // Set the headers to force the browser to download the file
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=$id.pdf");
        header("Content-Length: " . strlen($pdfData));

        // Output the PDF data
        echo $pdfData;
        exit;
    } else {
        echo "Error retrieving PDF file from the database.";
        exit;
    }
}

sqlsrv_close($conn);

// download the long message
if (isset($_GET['message'])) {
    $message = urldecode($_GET['message']);
    // Limit the file name size
    $fileName = substr($message, 0, 16);

    // Set the content type to plain text and specify the file name.
    header("Content-Type: text/plain");
    header("Content-Disposition: attachment; filename=$fileName.txt");

    // Output the message for download.
    echo $message;
    exit;
}
