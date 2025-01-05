<?php

session_start();
require_once "../config/db.php";
header ("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') die(json_encode([
    "success" => false,
    "error" => "Invalid method!"
]));

try {
    $data = json_decode(file_get_contents("php://input"));
    if (!is_array($data) || count($data) !== 2) throw new Exception("Invalid data format");
    
    list($commentId, $value) = $data;
    $value = $value > 0 ? 1 : -1;

    if ($value === 1) $stmt = $conn->prepare("update comments set upvotes = upvotes + 1 where id = ?");
    else $stmt = $conn->prepare("update comments set upvotes = upvotes - 1 where id = ?");

    $stmt->bind_param("i", $commentId);
    if ($stmt->execute()) echo json_encode(["success" => true]);
    else throw new Exception($conn->error);
} catch (Exception $e) {
    die(json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]));
}

?>