<?php
session_start();
require_once 'config/db.php';
header ("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) exit(json_encode(["success" => false, "error" => "Unauthorized!"]));

function genEmbedCode() { return bin2hex(random_bytes(8)); }

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $userId = $_SESSION["user_id"];
    $siteUrl = filter_var($_POST["site_url"], FILTER_SANITIZE_URL);

    if (!filter_var($siteUrl, FILTER_VALIDATE_URL)) exit(json_encode(["success" => false,"error" => "Not a URL!"]));

    $theme = "light";
    $embedCode = genEmbedCode();

    $stmt = $conn->prepare("insert into sites (user_id, embed_code, site_url, theme) values (?, ?, ?, ?)");
    $stmt->bind_param("isss", $userId, $embedCode, $siteUrl, $theme);

    if ($stmt->execute()) echo json_encode(["success" => true, "embed_code" => $embedCode]);
    else echo json_encode(["success" => false, "error" => $conn->error]);
}

exit(json_encode([
    "success" => false,
    "error" => "Invalid Request Method!",
]));

?>
