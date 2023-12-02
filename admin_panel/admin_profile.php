<?php

@include '../config/config.php';

session_start();

if (!isset($_SESSION['admin_name']) && ($_SESSION['admin_email'])) {
    header('location: /login/login_form.php');
}

// Update admin profile
if (isset($_POST['submit-info'])) {

    $admin_name = mysqli_real_escape_string($conn, $_POST['fullName']);
    $admin_address = mysqli_real_escape_string($conn, $_POST['address']);
    $admin_contact_number = $_POST['contact_number'];
    $admin_email = $_SESSION['admin_email'];

    $admin_profile_update = $conn->prepare("UPDATE login_and_register SET name=?, address=?, contact_number=? WHERE email=?");
    $admin_profile_update->bind_param("ssss", $admin_name, $admin_address, $admin_contact_number, $admin_email);
    $admin_profile_update->execute();

    if ($admin_profile_update) {
        header('location: ./admin_profile.php');
        alert("Admin Profile Update Successfully.");
        exit();
    } else {
        header('location: ./admin_profile.php');
        alert("Something Went Wrong.");
        exit();
    }
}

// Change admin password
if (isset($_POST['admin-current-password']) && isset($_POST['admin-new-password']) && isset($_POST['admin-confirm-new-password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $admin_current_password = validate($_POST['admin-current-password']);
    $admin_new_password = validate($_POST['admin-new-password']);
    $admin_confirm_password = validate($_POST['admin-confirm-new-password']);

    if (empty($admin_current_password)) {

        header('location: ./admin_profile.php');
        alert("Current password is required");
        exit();
    } elseif (empty($admin_new_password)) {

        header('location: ./admin_profile.php');
        alert("New password is required");
        exit();
    } elseif ($admin_new_password !== $admin_confirm_password) {

        header('location: ./admin_profile.php');
        alert("Password does not match.");
        exit();
    } else {

        $admin_current_password = md5($admin_current_password);
        $admin_new_password = md5($admin_new_password);
        $admin_email = $_SESSION['admin_email'];

        $check_admin_password = "SELECT password FROM login_and_register WHERE email = '$admin_email' && password = '$admin_current_password' ";

        $check_admin_password_result = mysqli_query($conn, $check_admin_password);

        if (mysqli_num_rows($check_admin_password_result) === 1) {

            $change_admin_password = "UPDATE login_and_register SET password = '$admin_new_password' WHERE email = '$admin_email' ";

            $change_admin_password_result = mysqli_query($conn, $change_admin_password);

            if ($change_admin_password_result) {

                header('location: ./admin_profile.php');
                alert("Password changed successfully.");
                exit();
            } else {

                header('location: ./admin_profile.php');
                alert("Something went wrong.");
                exit();
            }
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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />

    <link rel="stylesheet" href="../assets/css/admin_and_user.css">

    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <title>E Learning - Admin Profile</title>
</head>

<body>

    <section class="admin-profile">

        <?php include('./includes/sidebar.php'); ?>

        <!-- CONTENT -->
        <section id="content">

            <?php include('./includes/header.php'); ?>

            <!-- MAIN -->
            <main>
                <div class="head-title">
                    <div class="left">
                        <h1>Admin Profile</h1>
                    </div>
                </div>

                <div class="profile-card">

                    <img src="../assets/images/profile.png" alt="Profile" class="rounded-circle">
                    <h2><?php echo $_SESSION['admin_name'] ?></h2>
                    <h3>E Learning Admin</h3>
                    <div class="social-links mt-2">
                        <a href="#" class="twitter"><i class='bx bxl-twitter'></i></a>
                        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                    </div>

                </div>
            </main>

            <div class="admin-info-card">

                <ul class="info-card-header">

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab">Overview</button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab">Edit Profile</button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab">Change Password</button>
                    </li>

                </ul>
                <div class="info-card-content">

                    <?php
                    $admin_email = $_SESSION['admin_email'];
                    $query = "SELECT * FROM login_and_register WHERE email='$admin_email'";
                    $result = mysqli_query($conn, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                    ?>

                        <div class="profile-overview" id="profile-overview">

                            <h5 class="card-title">Profile Details</h5>

                            <div class="row">
                                <div class="info-title">Full Name:</div>
                                <div class="info-content"><?php echo $row['name']; ?></div>
                            </div>

                            <div class="row">
                                <div class="info-title">Email:</div>
                                <div class="info-content"><?php echo $row['email']; ?></div>
                            </div>

                            <div class="row">
                                <div class="info-title">Address:</div>
                                <div class="info-content"><?php echo $row['address']; ?></div>
                            </div>

                            <div class="row">
                                <div class="info-title">Phone:</div>
                                <div class="info-content"><?php echo $row['contact_number']; ?></div>
                            </div>

                        </div>

                    <?php
                    } else {
                        echo "No user found.";
                    }
                    ?>

                    <div class="profile-edit" id="profile-edit">


                        <form action="" method="POST">

                            <div class="info-edit">
                                <label for="fullName" class="info-social-links">Full Name</label>
                                <div class="info-description">
                                    <input name="fullName" type="text" class="form-control" id="fullName" value="">
                                </div>
                            </div>

                            <div class="info-edit">
                                <label for="Address" class="info-social-links">Address</label>
                                <div class="info-description">
                                    <input name="address" type="text" class="form-control" id="Address">
                                </div>
                            </div>

                            <div class="info-edit">
                                <label for="Phone" class="info-social-links">Contact Number</label>
                                <div class="info-description">
                                    <input name="contact_number" type="text" class="form-control" id="Phone">
                                </div>
                            </div>

                            <input type="submit" value="Save Changes" name="submit-info" class="submit-btn btn-primary">

                        </form>

                    </div>

                    <div class="profile-change-password" id="profile-change-password">

                        <form method="POST">

                            <div class="change-password">
                                <label for="currentPassword" class="change-password-content">Current Password</label>
                                <div class="change-password-content-input">
                                    <input name="admin-current-password" type="password" class="form-control" id="currentPassword">
                                </div>
                            </div>

                            <div class="change-password">
                                <label for="newPassword" class="change-password-content">New Password</label>
                                <div class="change-password-content-input">
                                    <input name="admin-new-password" type="password" class="form-control" id="newPassword">
                                </div>
                            </div>

                            <div class="change-password">
                                <label for="renewPassword" class="change-password-content">Re-enter New Password</label>
                                <div class="change-password-content-input">
                                    <input name="admin-confirm-new-password" type="password" class="form-control" id="renewPassword">
                                </div>
                            </div>

                            <input type="submit" value="Change Password" name="change-password" class="submit-btn btn-primary">

                        </form>

                    </div>

                </div>
            </div>

            <?php include('./includes/footer.php'); ?>
            </div>
            </main>
            <!-- MAIN -->

        </section>
    </section>

    <script src="../assets/js/admin.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
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