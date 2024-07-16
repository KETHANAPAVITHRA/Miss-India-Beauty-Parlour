<?php
session_start(); // Start session


if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32)); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form has not been submitted before
 

        // Database credentials
        $servername = "localhost";
        $username = "root";
        $password = ""; // Assuming no password set for the root user
        $dbname = "form_db";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $address = $_POST['address'];
        $landmark = $_POST['landmark'];
        $pincode = $_POST['pincode'];
        $payment_type = $_POST['payment_type'];

        
        $sql = "INSERT INTO form_data (name, email, phone_number, address, landmark, pincode, payment_type) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $name, $email, $phone_number, $address, $landmark, $pincode, $payment_type);

       


        // Execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to success page
            $stmt->close();
            $conn->close();
            header("Location: success.html");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
} else {
    echo "Invalid request";
}
?>

