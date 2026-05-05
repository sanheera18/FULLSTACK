<?php
session_start();
$conn = new mysqli(
    "sql100.infinityfree.com",
    "if0_41293517",
    "GKMECzs3gnUs8I0",
    "if0_41293517_user"
);

$message = "";

if(isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if(empty($email) || empty($password)) {
        $message = "All fields are required!";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
    }
    else {
        $result = $conn->query("SELECT * FROM users WHERE email='$email'");

        if($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if(password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header("Location: quiz.php");
                exit();
            } else {
                $message = "Incorrect password!";
            }
        } else {
            $message = "Email not registered!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>

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

        .login-card {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        h3 {
            font-weight: 600;
            color: #2c3e50;
        }

        label {
            color: #495057;
            font-weight: 500;
        }

        .btn-primary {
            background-color: #3a506b;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2b3e56;
        }

        a {
            color: #3a506b;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="login-card">

                <h3 class="text-center mb-4">User Login</h3>

                <?php if(!empty($message)) echo "<div class='alert alert-danger'>$message</div>"; ?>

                <form method="post">

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>

                </form>

                <div class="text-center mt-3">
                    <a href="registration.php">Don't have an account? Register</a>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>