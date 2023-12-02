<?php

@include('../config/config.php');

session_start();

if (!isset($_SESSION['user_name']) && ($_SESSION['user_email'])) {
    header('location: ../login/login_form.php');
}

// Update User Profile
if (isset($_POST['submit-info'])) {

    $user_name = mysqli_real_escape_string($conn, $_POST['fullName']);
    $user_country = mysqli_real_escape_string($conn, $_POST['country']);
    $user_address = mysqli_real_escape_string($conn, $_POST['address']);
    $user_contact_number = $_POST['contact_number'];
    $user_email = $_SESSION['user_email'];

    $user_profile_update = $conn->prepare("UPDATE login_and_register SET name = ?, country = ?, address = ?, contact_number = ? WHERE email = ?");
    $user_profile_update->bind_param("ssssss", $user_name, $user_country, $user_address, $user_contact_number, $user_email);
    $user_profile_update->execute();

    if ($user_profile_update) {
        header('location: ./user_dashboard.php');
        alert("User Profile Update Successfully.");
        exit();
    } else {
        header('location: ./user_dashboard.php');
        alert("Something Went Wrong.");
        exit();
    }
}

// Change User Password
if (isset($_POST['user-current-password']) && isset($_POST['user-new-password']) && isset($_POST['user-confirm-new-password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $user_current_password = validate($_POST['user-current-password']);
    $user_new_password = validate($_POST['user-new-password']);
    $user_confirm_password = validate($_POST['user-confirm-new-password']);

    if (empty($user_current_password)) {

        header('location: ./user_dashboard.php');
        alert("Current password is required");
        exit();
    } elseif (empty($user_new_password)) {

        header('location: ./user_dashboard.php');
        alert("New password is required");
        exit();
    } elseif ($user_new_password !== $user_confirm_password) {

        header('location: ./user_dashboard.php');
        alert("Password does not match.");
        exit();
    } else {

        $user_current_password = md5($user_current_password);
        $user_new_password = md5($user_new_password);
        $user_email = $_SESSION['user_email'];

        $user_check_password = "SELECT password FROM login_and_register WHERE email = '$user_email' && password = '$user_current_password' ";

        $user_check_password_result = mysqli_query($conn, $user_check_password);

        if (mysqli_num_rows($user_check_password_result) === 1) {

            $user_change_password = "UPDATE login_and_register SET password = '$user_new_password' WHERE email = '$user_email' ";

            $user_change_password_result = mysqli_query($conn, $user_change_password);

            if ($user_change_password_result) {

                header('location: ./user_dashboard.php');
                alert("Password changed successfully.");
                exit();
            } else {

                header('location: ./user_dashboard.php');
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

    <title>WEBXEL - User</title>
    <link rel="icon" type="image/png" href="../assets/images/logo2.jpg">

</head>

<body>

    <section class="admin-profile">

        <?php include('./includes/sidebar.php'); ?>

        <!-- CONTENT -->
        <section id="content">

            <?php include('./includes/navbar.php'); ?>

            <!-- MAIN -->
            <main class="profile" id="profile">
                <div class="head-title">
                    <div class="left">
                        <h1>User Profile</h1>
                    </div>
                </div>

                <div class="profile-card">

                    <img src="../assets/images/profile.png" alt="Profile" class="rounded-circle">
                    <h2><?php echo $_SESSION['user_name'] ?></h2>
                    <h3>W&#x039E;&#x042;X&#x039E;L User</h3>

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
                    $user_email = $_SESSION['user_email'];
                    $query = "SELECT * FROM login_and_register WHERE email='$user_email'";
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
                                <div class="info-title">Country:</div>
                                <div class="info-content"><?php echo $row['country']; ?></div>
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
                                <label for="about" class="info-social-links">About</label>
                                <div class="info-description">
                                    <textarea name="about" class="form-control" id="about" style="height: 100px"></textarea>
                                </div>
                            </div>

                            <div class="info-edit">
                                <label for="Country" class="info-social-links">Country</label>
                                <div class="info-description">
                                    <input name="country" type="text" class="form-control" id="Country">
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

                        <form method="POST" action="">

                            <div class="change-password">
                                <label for="currentPassword" class="change-password-content">Current Password</label>
                                <div class="change-password-content-input">
                                    <input name="user-current-password" type="password" class="form-control" id="currentPassword">
                                </div>
                            </div>

                            <div class="change-password">
                                <label for="newPassword" class="change-password-content">New Password</label>
                                <div class="change-password-content-input">
                                    <input name="user-new-password" type="password" class="form-control" id="newPassword">
                                </div>
                            </div>

                            <div class="change-password">
                                <label for="renewPassword" class="change-password-content">Re-enter New Password</label>
                                <div class="change-password-content-input">
                                    <input name="user-confirm-new-password" type="password" class="form-control" id="renewPassword">
                                </div>
                            </div>

                            <input type="submit" value="Change Password" name="change-password" class="submit-btn btn-primary">

                        </form>

                    </div>

                </div>
            </div>

            <main class="notification" id="notification">
                <div class="head-title">
                    <div class="left">
                        <h1>Notification</h1>
                    </div>
                </div>

                <section class="orders" id="orders">
                    <h1>Orders</h1>

                    <div class="order-card">

                        <?php
                        // function getAllOrders($table, $user_email)
                        // {
                        //     global $conn;
                        //     $query = "SELECT * FROM $table WHERE email = '$user_email' ";
                        //     return mysqli_query($conn, $query);
                        // }

                        // if ($_SESSION['user_email']) {
                        //     $user_email = $_SESSION['user_email'];
                        //     $orders = getAllOrders("orders", $user_email);

                        //     if ($orders) {
                        //         if (mysqli_num_rows($orders) > 0) {
                        //             while ($record = mysqli_fetch_assoc($orders)) {
                        ?>

                                        <div class="order-overview" id="order-overview" style="background-color: <?php echo ($record['order_status'] === 'Accepted!') ? '#06c258' : (($record['order_status'] === 'Pending...') ? '#F58216' : 'inherit'); ?>">

                                            <div class="row">
                                                <div class="order-title">Order ID:</div>
                                                <div class="order-content"><?= $record['order_id'] ?></div>
                                            </div>

                                            <div class="row">
                                                <div class="order-title">Name:</div>
                                                <div class="order-content"><?= $record['name'] ?></div>
                                            </div>

                                            <div class="row">
                                                <div class="order-title">Email:</div>
                                                <div class="order-content"><?= $record['email'] ?></div>
                                            </div>

                                            <div class="row">
                                                <div class="order-title">Service Type:</div>
                                                <div class="order-content"><?= $record['service_type'] ?></div>
                                            </div>

                                            <div class="row">
                                                <div class="order-title">Description:</div>
                                                <div class="order-content"><?= $record['description'] ?></div>
                                            </div>

                                            <div class="row">
                                                <div class="order-title">Order Status:</div>
                                                <div class="order-content"><?= $record['order_status'] ?></div>
                                            </div>

                                        </div>
                        <?php
                        //             }
                        //         } else {
                        //             echo "No records found";
                        //         }
                        //     } else {
                        //         echo "Error in retrieving records: " . mysqli_error($conn);
                        //     }
                        // }
                        ?>

                    </div>
                </section>
            </main>

            <?php include('./includes/footer.php'); ?>
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