<?php

session_start();
require_once 'config/db.php';

function genEmbedCode() {
    return bin2hex(random_bytes(8));
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $userId = $_SESSION["user_id"];
    $siteUrl = $POST["site_url"];
    $embedCode = genEmbedCode();

    $stmt = $conn->prepare("insert into sites (user_id, embed_code, site_url) values (?, ?, ?)");
    $stmt->bind_param("iss", $userId, $embedCode, $siteUrl);

    if ($stmt->execute()) echo json_encode(["success" => true, "embed_code" => $embedCode]);
    else echo json_encode(["success" => false, "error" => $conn->error]);
}

?>
