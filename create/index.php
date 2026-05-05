<!DOCTYPE html>
<html>
<head>
    <title>Online Quiz System</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Elegant Custom CSS -->
    <style>
        body {
            background-color: #f4f6f9;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .main-card {
            background-color: #ffffff;
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            text-align: center;
        }

        h1 {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        p {
            color: #6c757d;
            margin-bottom: 30px;
        }

        .btn-elegant {
            width: 200px;
            margin: 10px;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-primary {
            background-color: #3a506b;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2b3e56;
        }

        .btn-success {
            background-color: #5bc0be;
            border: none;
        }

        .btn-success:hover {
            background-color: #3aafa9;
        }

        .btn-dark {
            background-color: #1c2541;
            border: none;
        }

        .btn-dark:hover {
            background-color: #0b132b;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="main-card">

                <h1>Online Quiz System</h1>
                <p>Test your knowledge. Track your progress. Earn your certificate.</p>

                <div>
                    <a href="registration.php" class="btn btn-primary btn-lg btn-elegant">Register</a>
                    <a href="login.php" class="btn btn-success btn-lg btn-elegant">Login</a>
                    <a href="admin_login.php" class="btn btn-dark btn-lg btn-elegant">Admin Login</a>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>