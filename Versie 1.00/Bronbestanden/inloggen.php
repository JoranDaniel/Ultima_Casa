<?php
include_once("functions.php");

// Get user input and sanitize it
$email = filter_input(INPUT_GET, "Email", FILTER_SANITIZE_EMAIL);
$password = md5(filter_input(INPUT_GET, "Wachtwoord", FILTER_SANITIZE_STRING));

// Debugging: Output entered email and hashed password
var_dump("Entered Email: " . $email);
var_dump("Entered Password: " . $password);

$db = ConnectDB();

// Use prepared statement to avoid SQL injection
$sql = "SELECT relaties.ID AS RID, rollen.Waarde AS Rol, Landingspagina, Wachtwoord
        FROM relaties
        LEFT JOIN rollen ON relaties.FKrollenID = rollen.ID
        WHERE BINARY Email = ?";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die('Error preparing statement: ' . $db->error);
}

$stmt->bind_param("s", $email);
if (!$stmt->execute()) {
    die('Error executing statement: ' . $stmt->error);
}

$result = $stmt->get_result();
$inlog = $result->fetch_assoc();
$stmt->close();

// Debugging: Output retrieved password from the database
var_dump("Database Password: " . $inlog['Wachtwoord']);

$redirect_url = 'admin.php?NOAccount';
if ($inlog && md5($password) === $inlog['Wachtwoord']) {
    $redirect_url = 'admin.php?RID=' . $inlog['RID'];
}

// Redirect to the specified page
header("Location: " . $redirect_url);
exit();
?>
