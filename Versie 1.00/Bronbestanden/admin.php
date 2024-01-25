<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $relatieid = $_GET['RID'];
     $sql = "   SELECT ID, 
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
                    <div class="tab-content">';
                         
     $sql = "   SELECT ID, StatusCode, Status
                  FROM statussen
              ORDER BY StatusCode";

// Check if the user is logged in
if (!isset($_SESSION['RID'])) {
    // Redirect to the login page if not logged in
    header("Location: unauthorized.php");
    exit();
}

// Check if the logged-in user has the required permission (ID 529 for admin access)
if ($_SESSION['RID'] != 529) {
    // Redirect to an unauthorized page if the user does not have permission
    header("Location: unauthorized.php");
    exit();
}

     $records = $db->query($sql)->fetchAll();    
                         
     echo               '<div id="rollen" class="tab-pane fade">
                              <h3>Rollen</h3>
                              <table id="table_rollen">
                                   <tr>
                                        <th>Rol</th>
                                        <th>Omschrijving</th>
                                        <th>Waarde</th>
                                        <th>Landingspagina</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th class="button-column">
                                             <form action="rolplus.php">                             
                                                  <button type="submit" class="action-button" id="plus" name="plus" 
                                                          title="Een nieuwe rol toevoegen.">&nbsp;+&nbsp;
                                                  </button>
                                                  <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                             </form>
                                        </th>
                                   </tr>';
     foreach ($records as $record) 
     {    $ID = $record['ID'];
          $sql = "SELECT Naam, Email, Telefoon
                    FROM relaties
                   WHERE relaties.FKrollenID = $ID
                ORDER BY relaties.Naam";
          
          $relaties = $db->query($sql)->fetchAll();  
          
          $disabled = "";
          $niet = "Deze rol verwijderen.";
          if ($relaties)
          {    $disabled = " disabled";
               $niet = "Deze rol mag NIET verwijderd worden.";
          }
          echo                    '<tr>
                                        <td>' . $record['Naam'] . '</td>
                                        <td>' . $record['Omschrijving'] . '</td>
                                        <td>' . $record['Waarde'] . '</td>
                                        <td>' . $record['Landingspagina'] . '</td>
                                        <td class="button-column">
                                             <form action="roledit.php">                             
                                                  <button type="submit" class="action-button" id="edit" name="edit" 
                                                          value="' . $record['ID'] . '" title="Deze rol wijzigen.">...
                                                  </button>
                                                  <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                             </form>
                                        </td>
                                        <td class="button-column">
                                             <form action="rolmin.php">                             
                                                  <button type="submit" class="action-button" id="wis" name="wis"' . $disabled . ' 
                                                          value="' . $record['ID'] . '" title="' . $niet . '">&nbsp;-&nbsp;
                                                  </button>
                                                  <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                             </form>
                                        </td>
                                        <td class="button-column">
                                            <button type="button" class="action-button" title="Relaties met deze rol." 
                                                    data-toggle="collapse" data-target="#relaties_' . $record['ID'] . '">&nbsp;&#9660;&nbsp;
                                            </button>
                                       </td>
                                   </tr>
                                   <tr>
                                        <td colspan=5 >
                                             <div id="relaties_' . $record['ID'] . '" class="collapse">
                                                  <table id="table_relaties" class="details">
                                                       <tr>';
          if (!$relaties)
          {    echo                                        '<th colspan=4 class="cell-center">
                                                                 <h4>Er zijn geen relaties met rol ' . $record["Naam"] . ' - ' . $record["Omschrijving"] . '</h4>
                                                           </th>';
          }
          else
          {    echo                                        '<th colspan=4 class="cell-center">
                                                                 <h4>Relaties met rol ' . $record["Naam"] . ' - ' . $record["Omschrijving"] . '</h4>
                                                           </th>
                                                       </tr>
                                                       <tr>
                                                            <th>&nbsp;</th>
                                                            <th>Naam</th>
                                                            <th>Email</th>
                                                            <th>Telefoon</th>
                                                            <th>&nbsp;</th>
                                                       </tr>';
               foreach ($relaties as $record) 
               {    echo                              '<tr>
                                                            <td>&nbsp;</td>                                             
                                                            <td>' . $record['Naam'] . '</td>                                             
                                                            <td>' . $record['Email'] . '</td>
                                                            <td>' . $record['Telefoon'] . '</td>
                                                            <td>&nbsp;</td>                                             
                                                       </tr>';
               }
          };
          echo                                   '</table>
                                             
                                             </div>
                                        </td>
                                   </tr>';
     }
     
     echo                    '</table>
                         </div>';
                         
     $sql = "   SELECT relaties.Naam AS Naam, Email, Telefoon, Omschrijving,
                       relaties.ID AS RID
                  FROM relaties
             LEFT JOIN rollen ON rollen.ID = relaties.FKrollenID
              ORDER BY rollen.Waarde DESC, Naam";

// Check if the accessed RID matches the logged-in user's ID and is in the database
$allowed_ids = array(529);
$relatieid = $_GET['RID'];

// Query the database to check if the RID exists
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
                                    <a href="index.php">Uitloggen</a>
                                   
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

if ($relatieid != 529) {
     // Redirect to makelaar.php if RID is not 529
     header("Location: makelaar.php");
     exit();
}
