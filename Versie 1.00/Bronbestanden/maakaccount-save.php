<?php
     include_once("functions.php");

     $db = ConnectDB();
          // Check if the user is logged in
if (!isset($_SESSION['RID'])) {
     // Redirect to the login page if not logged in
     header("Location: unauthorized.php");
     exit();
 }
     $naam = $_GET['Naam'];
     $email = $_GET['Email'];
     $telefoon = $_GET['Telefoon'];
     $wachtwoord = $_GET['Wachtwoord'];
     
<<<<<<< Updated upstream
     $sql = "INSERT INTO relaties (Naam, Email, Telefoon, Wachtwoord)
                  VALUES ('" . $naam . "', '" . 
                               $email . "', '" .
                               $telefoon . "', '" . 
                               md5($wachtwoord) . "')";
=======
     $sql = "INSERT INTO relaties (Naam, Email, Telefoon, Wachtwoord, FKrollenID)
                  VALUES ('" . $naam . "', '" . 
                               $email . "', '" .
                               $telefoon . "', '" . 
                               md5($wachtwoord) . "', '" . 
                               10 . "')";
     
>>>>>>> Stashed changes
     
     if ($db->query($sql) == true) 
     {    if (StuurMail($email, 
                        "Account gegevens Ultima Casa", 
                        "Uw inlog gegevens zijn:
                        
               Naam: " . $naam . "
               E-mailadres: " . $email . "
               Telefoon: " . $telefoon . "
               Wachtwoord: " . $wachtwoord . "
               
               Bewaar deze gegevens goed!
               
               Met vriendelijke groet,
               
               Het Ultima Casa team.",
                        "From: noreply@uc.nl"))
          {    $result = 'De gegkevens zijn naar uw e-mail adres verstuurd.';
          }
          else
          {    $result = 'Fout bij het versturen van de e-mail met uw gegevens.';
          }
     }
     else
     {    $result .= 'Fout bij het bewaren van uw gegevens.<br><br>' . $sql;
     }
     echo $result . '<br><br>
          <button class="action-button"><a href="index.html">Ok</a></button>';
?>