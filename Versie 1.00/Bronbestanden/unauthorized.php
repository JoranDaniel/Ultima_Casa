<?php
header("HTTP/1.1 401 Unauthorized");
echo "Geen toegang";
exit;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Unauthorized Access</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h1 {
            color: #333;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Unauthorized Access</h1>
        <p>Sorry, you don't have permission to access this page.</p>
    </div>
</body>
</html>
