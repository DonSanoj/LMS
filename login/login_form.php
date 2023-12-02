<?php

session_start();

if (isset($_SESSION['admin_name']) || isset($_SESSION['user_name'])) {
    if (isset($_SESSION['admin_name'])) {
        header('location: /admin_panel/dashboard.php');
    } elseif (isset($_SESSION['user_name'])) {
        header('location: /user_panel/user_dashboard.php');
    }
} else {
    include '../config/config.php';

    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = md5($_POST['password']);
        // $cpassword = md5($_POST['cpassword']);
        // $user_type = $_POST['user-type'];

        $select_from_register = "SELECT * FROM login_and_register WHERE email = '$email' && password = '$password' && account_status = 'Active' ";

        $result_for_register = mysqli_query($conn, $select_from_register);

        if (mysqli_num_rows($result_for_register) > 0) {
            $row = mysqli_fetch_array($result_for_register);

            if ($row['user_type'] == 'admin') {

                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_email'] = $row['email'];
                header('location: /admin_panel/dashboard.php');
            } elseif ($row['user_type'] == 'user') {

                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                header('location: /user_panel/user_dashboard.php');
            }
        } else {
            $error[] = 'Incorrect email or password.';
        }
    }
}

function alert($message)
{
    $_SESSION['message'] = $message;
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="E Learning">
    <meta name="keywords" content="HTML,CSS,JavaScript,PHP">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/c4254e24a8.js"></script>

    <title>E-Learning - Login</title>
</head>

<body>

    <?php include('../includes/header.php'); ?>

    <!-- Sign in form section start -->
    <section class="signin-form-container">

        <form action="" method="post">

            <h3>Welcome Back!</h3>

            <div class="email">
                <input type="email" name="email" placeholder="Email" required>
                <span><i class='bx bxs-envelope'></i></span>
            </div>

            <div class="password">
                <input type="password" name="password" id="password-input" placeholder="Password">
                <span id="toggle-password" onclick="togglePassword()"><i class="fas fa-eye"></i></span>
            </div>

            <input type="submit" name="submit" value="Sign in" class="form-btn">

        </form>

    </section>
    <!-- Sign in form section end -->

    <!-- Footer section start -->
    <footer class="footer">
        <div class="footer_wrapper">

            <div class="footer-copyright">
                <p>Copyright © E Learning 2023</p>
            </div>

        </div>
    </footer>
    <!-- Footer section end -->

    <script src="/assets/js/index.js"></script>
    <script src="/assets/js/login_form.js"></script>
    <script>
        <?php
        if (isset($_SESSION['message'])) {
        ?>
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('<?= $_SESSION['message'] ?>');
        <?php
            unset($_SESSION['message']);
        }
        ?>
    </script>

</body>

</html>