<?php

session_start();
require_once "config/db.php";

if (!isset($_SESSION["user_id"])) die(json_encode(["success" => false, "error" => "Unauthorized!"]));
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $css = $POST["css"];

    $stmt = $conn->prepare("insert into themes (user_id, name, css) values (?, ?, ?)");
    $stmt->bind_param("iss", $_SESSION["user_id"], $name, $css);

    if ($stmt->execute()) echo json_encode(["success" => true,"id" => $stmt->insert_id]);
    else echo json_encode(["success "=> false, "error" => $conn->error]);
}

?>
