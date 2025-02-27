<?php

include "../database/database.php";

try {

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $bgry = $_POST['bgry'];

        $stmt = $conn->prepare("INSERT INTO information (fname, mname, lname, email, city, bgry) VALUES (?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssss", $fname, $mname, $lname, $email, $city, $bgry);

        if ($stmt->execute()) {
            header("Location: ../index.php");
            exit;
        } else {
            echo "operation failed";
        }

    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>