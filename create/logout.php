<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logging Out...</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <meta http-equiv="refresh" content="2;url=admin_login.php">

    <style>
        body {
            background-color: #f4f6f9;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .logout-card {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            text-align: center;
        }

        h3 {
            color: #2c3e50;
            font-weight: 600;
        }

        p {
            color: #6c757d;
        }
    </style>
</head>

<body>

<div class="logout-card">
    <h3>You have been logged out</h3>
    <p>Redirecting to login page...</p>

    <div class="spinner-border text-secondary mt-3" role="status"></div>
</div>

</body>
</html>