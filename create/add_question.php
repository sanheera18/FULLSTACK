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
$message = "";

if(isset($_POST['submit'])) {

    $question = trim($_POST['question']);
    $option1 = trim($_POST['option1']);
    $option2 = trim($_POST['option2']);
    $option3 = trim($_POST['option3']);
    $option4 = trim($_POST['option4']);
    $correct = $_POST['correct'];

    if(empty($question) || empty($option1) || empty($option2) || 
       empty($option3) || empty($option4) || empty($correct)) {

        $message = "<div class='alert alert-danger'>All fields are required!</div>";

    } elseif($correct < 1 || $correct > 4) {

        $message = "<div class='alert alert-danger'>Correct option must be between 1 and 4.</div>";

    } else {

        $sql = "INSERT INTO questions 
                (question, option1, option2, option3, option4, correct_option)
                VALUES 
                ('$question','$option1','$option2','$option3','$option4','$correct')";

        if($conn->query($sql)) {
            $message = "<div class='alert alert-success'>Question Added Successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error adding question!</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Question</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .form-card {
            margin-top: 40px;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        h2 {
            color: #2c3e50;
            font-weight: 600;
        }

        .btn-primary {
            background-color: #3a506b;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2b3e56;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="d-flex justify-content-between align-items-center mt-4">
        <h2>Add New Question</h2>
        <a href="admin_dashboard.php" class="btn btn-outline-secondary btn-sm">Back</a>
    </div>

    <div class="form-card">

        <?php echo $message; ?>

        <form method="post">

            <div class="mb-3">
                <label class="form-label">Question</label>
                <input type="text" name="question" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Option 1</label>
                <input type="text" name="option1" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Option 2</label>
                <input type="text" name="option2" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Option 3</label>
                <input type="text" name="option3" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Option 4</label>
                <input type="text" name="option4" class="form-control" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Correct Option (1-4)</label>
                <input type="number" name="correct" min="1" max="4" class="form-control" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary w-100">
                Add Question
            </button>

        </form>

    </div>

</div>

</body>
</html>