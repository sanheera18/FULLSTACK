<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli(
    "sql100.infinityfree.com",
    "if0_41293517",
    "GKMECzs3gnUs8I0",
    "if0_41293517_user"
);
$result = $conn->query("SELECT * FROM questions");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Questions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .container-box {
            margin-top: 40px;
        }

        h2 {
            color: #2c3e50;
            font-weight: 600;
        }
    </style>
</head>

<body>

<div class="container container-box">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>All Questions</h2>
        <a href="admin_dashboard.php" class="btn btn-outline-secondary btn-sm">Back</a>
    </div>

    <div class="card shadow-sm p-3">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Question</th>
                    <th>Correct Option</th>
                </tr>
            </thead>
            <tbody>

            <?php while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['question']; ?></td>
                    <td><?php echo $row['correct_option']; ?></td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>

</div>

</body>
</html>