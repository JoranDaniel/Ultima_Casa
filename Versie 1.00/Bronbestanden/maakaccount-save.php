<?php
include_once("functions.php");
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Ultima Casa account aanvragen</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="ucstyle.css?<?php echo mt_rand(); ?>">
</head>
<body>
<div class="container">
    <div class="col-sm-4 col-md-6 col-lg-4 col-sm-offset-4 col-md-offset-3 col-lg-offset-4">
        <h4 class="text-center">Ultima Casa account aanvragen</h4>
        <table>
            <tr>
                <th>&nbsp;</th>
                <th class="text-center">Account</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <?php echo '
                    <form id="accountForm" action="maakaccount-save.php" method="GET">
                        <div class="form-group">
                            <label for="Naam">Naam:</label>
                            <input type="text" class="form-control" id="Naam" name="Naam" placeholder="Naam" required>
                        </div>
                        <div class="form-group">
                            <label for="Email">E-mailadres:</label>
                            <input type="email" class="form-control" id="Email" name="Email" placeholder="E-mailadres" required
                                   pattern="' . $emailpattern . '">
                        </div>
                        <div class="form-group">
                            <label for="Wachtwoord">Wachtwoord:</label>
                            <input type="password" class="form-control" id="Wachtwoord" name="Wachtwoord" placeholder="Wachtwoord"
                                   pattern="(?=.\d)(?=.[a-z])(?=.[A-Z]).{8,}" 
                                   title="Password must contain at least 8 characters, including at least one number, one lowercase letter, and one uppercase letter."
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="Telefoon">Mobiel telefoonnummer:</label>
                            <input type="tel" class="form-control" id="Telefoon" name="Telefoon"
                                   placeholder="Telefoonnummer"
                                   pattern="' . $telefoonpattern . '" required>
                        </div>
                        <div class="form-group"><br><br>
                            <button type="button" class="action-button" onclick="validateForm()" title="Uw account aanmaken">Maak account</button>
                            <button class="action-button"><a href="index.html">Annuleren</a></button>
                        </div>
                    </form>';
                    ?>
                </td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
</div>
<script>
    function validateForm() {
        var password = $("#Wachtwoord").val();
        if (!/^(?=.\d)(?=.[a-z])(?=.[A-Z]).{8,}$/.test(password)) {
            alert("Password must contain at least 8 characters, including at least one number, one lowercase letter, and one uppercase letter.");
        } else {
            $("#accountForm").submit();
        }
    }
</script>
</body>
</html>