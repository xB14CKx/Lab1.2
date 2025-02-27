<?php
include '../database.php';

$id = $_GET['id'];

$sql = "SELECT fname, mname, lname, email, city, bgry FROM persons WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode([]);
}

$stmt->close();
$conn->close();
?>