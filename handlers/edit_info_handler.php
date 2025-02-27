<?php

include "../database/database.php";

try {

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $editName = $_POST['editName'];

        $stmt = $conn->prepare("SELECT * FROM information WHERE fname = ? OR lname = ?");
        $stmt->bind_param("ss", $editName, $editName);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if ($data) {
            echo "<script>
                document.getElementById('fname').value = '{$data['fname']}';
                document.getElementById('mname').value = '{$data['mname']}';
                document.getElementById('lname').value = '{$data['lname']}';
                document.getElementById('email').value = '{$data['email']}';
                document.getElementById('city').value = '{$data['city']}';
                document.getElementById('bgry').value = '{$data['bgry']}';
            </script>";
        } else {
            header("Location: ../index.php?error=No record found");
            exit;
        }

    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>