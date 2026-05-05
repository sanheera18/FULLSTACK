<?php
session_start();
$conn = new mysqli(
    "sql100.infinityfree.com",
    "if0_41293517",
    "GKMECzs3gnUs8I0",
    "if0_41293517_user"
);m");

$message = "";

if(isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if(empty($username) || empty($password)) {
        $message = "All fields are required!";
    } else {

        $result = $conn->query("SELECT * FROM admin WHERE username='$username'");

        if($result->num_rows > 0) {
            $admin = $result->fetch_assoc();

            // If password is hashed (recommended)
            if(password_verify($password, $admin['password'])) {
                $_SESSION['admin'] = $username;
                header("Location: admin_dashboard.php");
                exit();
            } else {
                $message = "Incorrect password!";
            }

        } else {
            $message = "Admin not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>

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

        .admin-card {
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
    </style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="admin-card">

                <h3 class="text-center mb-4">Admin Login</h3>

                <?php if(!empty($message)) echo "<div class='alert alert-danger'>$message</div>"; ?>

                <form method="post">

                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" name="login" class="btn btn-primary w-100">
                        Login
                    </button>

                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>