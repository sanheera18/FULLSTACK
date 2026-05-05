<?php
$conn = new mysqli(
    "sql100.infinityfree.com",
    "if0_41293517",
    "GKMECzs3gnUs8I0",
    "if0_41293517_user"
);
$message = "";

if(isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password_input = $_POST['password'];

    if(empty($name) || empty($email) || empty($password_input)) {
        $message = "All fields are required!";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
    }
    elseif(strlen($password_input) < 6) {
        $message = "Password must be at least 6 characters!";
    }
    else {

        $check = $conn->query("SELECT id FROM users WHERE email='$email'");
        if($check->num_rows > 0) {
            $message = "Email already registered!";
        } else {

            $password = password_hash($password_input, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (name, email, password)
                    VALUES ('$name', '$email', '$password')";

            if($conn->query($sql)) {
                $message = "Registered Successfully!";
            } else {
                $message = "Something went wrong!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>

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

        .register-card {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        h3 {
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
            <div class="register-card">

                <h3 class="text-center mb-4">User Registration</h3>

                <?php if(!empty($message)) echo "<div class='alert alert-info'>$message</div>"; ?>

                <form method="post">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" name="register" class="btn btn-primary w-100">Register</button>

                </form>

                <div class="text-center mt-3">
                    <a href="login.php">Already have an account? Login</a>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>