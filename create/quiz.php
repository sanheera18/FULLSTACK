<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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
    <title>Quiz</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .quiz-container {
            margin-top: 40px;
        }

        .question-card {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        h2 {
            font-weight: 600;
            color: #2c3e50;
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

<div class="container quiz-container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Welcome, <?php echo $_SESSION['user_name']; ?></h2>
        <a href="logout.php" class="btn btn-outline-secondary btn-sm">Logout</a>
    </div>

    <form action="submit_quiz.php" method="post">

    <?php 
    $question_number = 1;
    while($row = $result->fetch_assoc()) { 
    ?>

        <div class="question-card">

            <h5>Question <?php echo $question_number++; ?>:</h5>
            <p><?php echo $row['question']; ?></p>

            <div class="form-check">
                <input class="form-check-input" type="radio" 
                       name="q<?php echo $row['id']; ?>" value="1">
                <label class="form-check-label">
                    <?php echo $row['option1']; ?>
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" 
                       name="q<?php echo $row['id']; ?>" value="2">
                <label class="form-check-label">
                    <?php echo $row['option2']; ?>
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" 
                       name="q<?php echo $row['id']; ?>" value="3">
                <label class="form-check-label">
                    <?php echo $row['option3']; ?>
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" 
                       name="q<?php echo $row['id']; ?>" value="4">
                <label class="form-check-label">
                    <?php echo $row['option4']; ?>
                </label>
            </div>

        </div>

    <?php } ?>

        <div class="text-center mb-5">
            <button type="submit" class="btn btn-primary px-5">Submit Quiz</button>
        </div>

    </form>

</div>

</body>
</html>