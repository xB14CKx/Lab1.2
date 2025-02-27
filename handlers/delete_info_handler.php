<?php

include "../database/database.php";

try {

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $deleteName = $_POST['deleteName'];

        $stmt = $conn->prepare("DELETE FROM information WHERE fname = ? OR lname = ?");
        $stmt->bind_param("ss", $deleteName, $deleteName);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                header("Location: ../index.php");
                exit;
            } else {
                header("Location: ../index.php?error=No record found");
                exit;
            }
        } else {
            echo "operation failed";
        }

    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>