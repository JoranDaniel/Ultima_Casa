<?php

      include_once("functions.php");

      $email = '"' . $_GET["Email"] . '"'; 
      $ww = '"' . md5($_GET["Wachtwoord"]) . '"'; 

      $db = ConnectDB();
      $sql = "   SELECT relaties.ID as RID,
                            rollen.Waarde as Rol,
                            Landingspagina 
                      FROM relaties
                LEFT JOIN rollen
                         ON relaties.FKrollenID = rollen.ID
                     WHERE (Email = $email) 
                       AND (Wachtwoord = $ww)";

      $inlog = $db->query($sql)->fetch();

      if ($inlog)
      {    
           session_start();
           $_SESSION['RID'] = $inlog['RID'];
           setcookie('RID', $inlog['RID'], time() + (86400 * 30), '/'); // Store RID in cookie for 30 days
           $redirect_url = $inlog['Landingspagina'] . '?RID=' . $inlog['RID'];
      }
      else
      {
           $redirect_url = 'index.php?NOAccount';
      }

      echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '. $redirect_url . '">';

?>