<?php 
require 'function.php'; 

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $cekdatabase = mysqli_query($conn, "SELECT * FROM login WHERE email='$email' and password='$password'");

    if (mysqli_num_rows($cekdatabase) > 0) {
        $data = mysqli_fetch_assoc($cekdatabase);
        
        if ($password == $data['password']) {
            $_SESSION['log'] = true; // Set session to true
            header('Location: index.php'); // Redirect to index.php
        } else {
            header('Location: login.php?error=incorrect_password');
        }
    } else {
        header('Location: login.php?error=email_not_found');
    };
};

if(!isset($_SESSION['log'])){
} else{
    header('Location: index.php'); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: url('imgLogin/buah.png') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Arial', sans-serif;
        overflow: hidden;
    }
</style>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-floating mb-3">
                                            <i class="fas fa-envelope"></i>
                                            <input class="form-control" name="email" id="inputEmail" type="email" placeholder="name@example.com" />
                                            <label for="inputEmail"></label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <i class="fas fa-lock"></i>
                                            <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Password" />
                                            <label for="inputPassword"></label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary" name="login">Login</button>
                                        </div>
                                    </form>
                                </div>                                   
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="js/login.js"></script>
</body>
</html>
