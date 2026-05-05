<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .dashboard-card {
            background-color: #ffffff;
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            text-align: center;
            width: 400px;
        }

        h2 {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .btn-primary {
            background-color: #3a506b;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2b3e56;
        }

        .btn-outline-secondary {
            border-color: #3a506b;
            color: #3a506b;
        }

        .btn-outline-secondary:hover {
            background-color: #3a506b;
            color: white;
        }
    </style>
</head>

<body>

<div class="dashboard-card">

    <h2>Welcome, Admin</h2>

    <div class="d-grid gap-3">

        <a href="add_question.php" class="btn btn-primary">
            Add Question
        </a>

        <a href="view_questions.php" class="btn btn-outline-secondary">
            View Questions
        </a>

        <a href="logout.php" class="btn btn-outline-danger">
            Logout
        </a>

    </div>

</div>

</body>
</html>