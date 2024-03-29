<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $id = $_GET["ID"]; 
     $relatieID = $_GET["upd"]; 
          // Check if the user is logged in
if (!isset($_SESSION['RID'])) {
     // Redirect to the login page if not logged in
     header("Location: unauthorized.php");
     exit();
 }
     echo 
    '<!DOCTYPE html>
     <html lang="nl">
          <head>
               <title>Mijn Ultima Casa</title>
               <meta charset="utf-8">
               <meta name="viewport" content="width=device-width, initial-scale=1">
               <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
               <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
               <link rel="stylesheet" type="text/css" href="ucstyle.css?' . mt_rand() . '">
          </head>
          <body>
               <div class="container">
                    <div class="col-sm-5 col-md-7 col-lg-5 col-sm-offset-4 col-md-offset-3 col-lg-offset-4">
                         <h3>Mijn account wijzigen</h3>';
     
     $sql = "UPDATE relaties 
                SET Naam = '" . $_GET['Naam'] . "',
                    Email = '" . $_GET['Email'] . "',
                    Telefoon = '" . $_GET['Telefoon'] . "' ";
     if ($_GET["Wachtwoord"] == "")
     {    $wachtwoord = "Ongewijzigd";
     }
     else
     {    $wachtwoord = $_GET["Wachtwoord"];
          $sql .= 
                 ", Wachtwoord = '" . md5($wachtwoord) . "'";
     } 
     $sql .= "WHERE ID = $relatieID";
     
     if ($db->query($sql) == true) 
     {     if (StuurMail($_GET['Email'], 
                        "Wijziging gegevens Ultima Casa account", 
                        "Uw gegevens zijn als volgt gewijzigd:
                        

include_once("functions.php");

$db = ConnectDB();

$id = $_GET["ID"];
$relatieID = $_GET["upd"];

echo '
<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Mijn Ultima Casa</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="ucstyle.css?' . mt_rand() . '">
</head>
<body>
<div class="container">
    <div class="col-sm-5 col-md-7 col-lg-5 col-sm-offset-4 col-md-offset-3 col-lg-offset-4">
        <h3>Mijn account wijzigen</h3>';

// Hash the password using bcrypt
$hashedPassword = '';
if ($_GET["Wachtwoord"] != "") {
    $hashedPassword = password_hash($_GET["Wachtwoord"], PASSWORD_DEFAULT);
}

// Encrypt sensitive information
$encryptedName = openssl_encrypt($_GET['Naam'], 'aes-256-cbc', 'encryption_key', 0, 'encryption_iv');
$encryptedEmail = openssl_encrypt($_GET['Email'], 'aes-256-cbc', 'encryption_key', 0, 'encryption_iv');
$encryptedTelefoon = openssl_encrypt($_GET['Telefoon'], 'aes-256-cbc', 'encryption_key', 0, 'encryption_iv');

$sql = "UPDATE relaties 
        SET Naam = '" . $encryptedName . "',
            Email = '" . $encryptedEmail . "',
            Telefoon = '" . $encryptedTelefoon . "' ";

if ($hashedPassword != "") {
    $sql .= ", Wachtwoord = '" . $hashedPassword . "'";
}

$sql .= " WHERE ID = $relatieID";

if ($db->query($sql) == true) {
    if (StuurMail($_GET['Email'],
        "Wijziging gegevens Ultima Casa account",
        "Uw gegevens zijn als volgt gewijzigd:


               Naam: " . $_GET["Naam"] . "
               E-mailadres: " . $_GET["Email"] . "
               Telefoon: " . $_GET["Telefoon"] . "
               Wachtwoord: " . ($_GET["Wachtwoord"] != "" ? "Ongewijzigd" : "Gewijzigd") . "

               Bewaar deze gegevens goed!

               Met vriendelijke groet,

               Het Ulima Casa team.",
        "From: noreply@uc.nl")
    ) {
        echo '<p>De gewijzigde gegevens zijn naar uw e-mail adres verstuurd.</p>';
    } else {
        echo '<p>Fout bij het versturen van de e-mail met uw gegevens.</p>';
    }
} else {
    echo '<p>Fout bij het bewaren van uw account gegevens.</p>
                         <p>' . $sql . '</p>';
}
echo '<br><br>
                         <button class="action-button"><a href="relatie.php?RID=' . $relatieID . '" >Ok</a>
                         </button>
                    </div>
               </div>
          </body>
     </html>';
?>
