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

$score = 0;
$total = 0;

$result = $conn->query("SELECT * FROM questions");

while($row = $result->fetch_assoc()) {
    $total++;
    $qid = "q" . $row['id'];

    if(isset($_POST[$qid])) {
        if($_POST[$qid] == $row['correct_option']) {
            $score++;
        }
    }
}

$percentage = ($total > 0) ? round(($score / $total) * 100, 2) : 0;

$user_id = $_SESSION['user_id'];

$conn->query("INSERT INTO results (user_id, score, total, percentage)
              VALUES ('$user_id', '$score', '$total', '$percentage')");

$pass = $percentage >= 50;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz Result</title>

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

        .result-card {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            text-align: center;
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

<div class="result-card">

    <h2>Quiz Result</h2>

    <p class="mt-4"><strong>Score:</strong> <?php echo "$score / $total"; ?></p>
    <p><strong>Percentage:</strong> <?php echo "$percentage%"; ?></p>

    <?php if($pass) { ?>
        <div class="alert alert-success mt-3">
            Congratulations! You passed the quiz.
        </div>

        <a href="certificate.php?score=<?php echo $score; ?>&percentage=<?php echo $percentage; ?>" 
           class="btn btn-primary mt-3">
           Download Certificate
        </a>

    <?php } else { ?>
        <div class="alert alert-danger mt-3">
            You did not pass. Try again!
        </div>
    <?php } ?>

    <div class="mt-4">
        <a href="quiz.php" class="btn btn-outline-secondary">Retake Quiz</a>
    </div>

</div>

</body>
</html>