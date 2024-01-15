<?php
session_start();

include_once("functions.php");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the logged-in user has the required permission (ID 529 for admin access)
if ($_SESSION['user_id'] != 529) {
    // Redirect to an unauthorized page if the user does not have permission
    header("Location: unauthorized.php");
    exit();
}

$db = ConnectDB();

// Check if the accessed RID matches the logged-in user's ID and is in the database
$allowed_ids = array(529);
$relatieid = $_GET['RID'];

// Query the database to check if the user ID exists
$sql_check_id = "SELECT COUNT(*) FROM relaties WHERE ID = " . $relatieid;
$count = $db->query($sql_check_id)->fetchColumn();

if ($count == 0 || !in_array($relatieid, $allowed_ids)) {
    // Redirect to an unauthorized page if the user is trying to access another user's admin page
    header("Location: unauthorized.php");
    exit();
}

$sql = "SELECT ID, 
               Naam, 
               Email, 
               Telefoon
          FROM relaties
         WHERE ID = " . $relatieid;

$gegevens = $db->query($sql)->fetch();

echo 
'<!DOCTYPE html>
 <html lang="nl">
      <head>
           <title>Ultima Casa Admin</title>
           <meta charset="utf-8">
           <meta name="viewport" content="width=device-width, initial-scale=1">
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
           <link rel="stylesheet" type="text/css" href="ucstyle.css?' . mt_rand() . '">
      </head>
      <body>
           <div class="container">
                <table id="mijngegevens">
                     <tr>
                          <td><h3>Ultima Casa Admin</h3></td>
                          <td class="text-right">Administrator</td>
                          <td>' . $gegevens["Naam"] . '<br>' . $gegevens["Email"] . '<br>' . $gegevens["Telefoon"] . '</td>
                          <td>
                               <button class="action-button">
                                    <a href="index.html">Uitloggen</a>
                               </button>
                          </td>
                     </tr>
                </table>
                <ul class="nav nav-tabs">
                     <li><a data-toggle="tab" href="#statussen">Statussen</a></li>
                     <li><a data-toggle="tab" href="#rollen">Rollen</a></li>
                     <li><a data-toggle="tab" href="#relaties">Accounts</a></li>
                </ul>
                <div class="tab-content">
                     <div id="statussen" class="tab-pane fade in active">
                          <h3>Statussen</h3>
                          <!-- Statussen Tab Content -->
                          <!-- Add your HTML content here -->
                     </div>

                     <div id="rollen" class="tab-pane fade">
                          <h3>Rollen</h3>
                          <!-- Rollen Tab Content -->
                          <!-- Add your HTML content here -->
                     </div>

                     <div id="relaties" class="tab-pane fade">
                          <h3>Accounts</h3>
                          <!-- Relaties Tab Content -->
                          <!-- Add your HTML content here -->
                     </div>
                </div>
           </div>
      </body>
 </html>';
?>
