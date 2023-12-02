<?php

@include '../config/config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location: /login/login_form.php');
}

if (isset($_POST['add-new-admin'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = $_POST['contact'];
    $password = md5($_POST['password']);
    $user_type = $_POST['user-type'];

    $select_from_register = "SELECT * FROM login_and_register WHERE email = '$email' && password = '$password' ";

    $result_for_register = mysqli_query($conn, $select_from_register);

    if (mysqli_num_rows($result_for_register) > 0) {
        alert("User already exists!");
    } else {

        $insert_to_register = "INSERT INTO login_and_register (name, email, contact_number, password, user_type) VALUES ('$name', '$email', '$contact', '$password', '$user_type')";
        mysqli_query($conn, $insert_to_register);
        header('location: ./user_manage.php');
        alert("Admin Account Added Successfully.");
    }
}

if (isset($_POST['delete-user'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $delete_user = "DELETE FROM login_and_register WHERE id = '$id'";
    $delete_user_run = mysqli_query($conn, $delete_user);

    if ($delete_user_run) {
        header('location: ./user_manage.php');
        alert("User Account deleted.");
    } else {
        header('location: ./user_manage.php');
        alert("Something went wrong.");
    }
}

if (isset($_POST['account-active'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $account_status_active_query = "UPDATE login_and_register SET account_status = 'Active' WHERE id = '$id' ";

    $account_status_active_query_run = mysqli_query($conn, $account_status_active_query);

    if ($account_status_active_query_run) {
        header('location: ./user_manage.php');
        alert("User Account Active!");
    } else {
        header('location: ./user_manage.php');
        alert("Something went wrong.");
    }
}

if (isset($_POST['account-hold'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $account_status_hold_query = "UPDATE login_and_register SET account_status = 'Hold' WHERE id = '$id' ";

    $account_status_hold_query_run = mysqli_query($conn, $account_status_hold_query);

    if ($account_status_hold_query_run) {
        header('location: ./user_manage.php');
        alert("User Account Hold.");
    } else {
        header('location: ./user_manage.php');
        alert("Something went wrong.");
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

    <link id="stylesheet" href="../assets/css/admin_and_user.css" rel="stylesheet" />

    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <title>E Learning - User Management</title>
</head>

<body>

    <section class="admin-page-user-manage">

        <?php include('./includes/sidebar.php'); ?>

        <!-- CONTENT -->
        <section id="content">

            <?php include('./includes/header.php'); ?>

            <!-- MAIN -->
            <main>
                <div class="head-title">
                    <div class="left">
                        <h1>User Management</h1>
                    </div>
                </div>

                <section class="user-section">

                    <h1>Users</h1>

                    <h3>Active Users</h3>

                    <div class="users">
                        <table class="active-users">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                function getAllUsers()
                                {
                                    global $conn;
                                    $query = "SELECT * FROM login_and_register WHERE user_type = 'user' ";
                                    return mysqli_query($conn, $query);
                                }

                                $users = getAllUsers();

                                if ($users) {
                                    if (mysqli_num_rows($users) > 0) {
                                        while ($record = mysqli_fetch_assoc($users)) {
                                ?>
                                            <tr>
                                                <td><?= $record['id'] ?></td>
                                                <td><?= $record['name'] ?></td>
                                                <td><?= $record['email'] ?></td>
                                                <td><?= $record['contact_number'] ?></td>
                                                <td style="background-color: <?php echo ($record['account_status'] === 'Active') ? '#06c258' : (($record['account_status'] === 'Hold') ? '#FD7238' : 'inherit'); ?>">
                                                    <?= $record['account_status'] ?>
                                                </td>
                                                <td>
                                                    <form action="" method="POST">
                                                        <input type="hidden" name="id" value="<?= $record['id'] ?>">
                                                        <button class="btn-active" type="submit" name="account-active">Active Account</button>
                                                        <button class="btn-hold" type="submit" name="account-hold">Hold Account</button>
                                                        <button class="btn-delete" type="submit" name="delete-user">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                <?php
                                        }
                                    } else {
                                        echo "No records found";
                                    }
                                } else {
                                    echo "Error in retrieving records: " . mysqli_error($conn);
                                }
                                ?>
                            </tbody>
                        </table>

                        <form id="form">

                            <h3>User account Blocking email</h3>

                            <div class="field">
                                <label for="to_name">Account Holder Name:</label>
                                <input type="text" name="to_name" id="to_name" required>
                            </div>
                            <div class="field">
                                <label for="from_name">Sender Name:</label>
                                <label for=""><span>*</span>Use WEBXEL name for this field</label>
                                <input type="text" name="from_name" id="from_name" required>
                            </div>
                            <div class="field">
                                <label for="to">To:</label>
                                <input type="text" name="to" id="to" required>
                            </div>
                            <div class="field">
                                <label for="reply_to">Reply To:</label>
                                <label for=""><span>*</span>Use admin@webxel.xyz email address for this field</label>
                                <input type="text" name="reply_to" id="reply_to" required>
                            </div>

                            <input type="submit" id="button" value="Send Email">
                        </form>

                        <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>

                        <script type="text/javascript">
                            emailjs.init('sB6Xsn2XV0uE9guSx')
                        </script> -->
                    </div>

                </section>

                <section class="admin-section">

                    <h1>Admins</h1>

                    <div class="add-new-admin">
                        <div class="register-form-container">
                            <form action="" method="POST">

                                <h3>Add New Admins and Users</h3>

                                <input type="text" name="name" placeholder="Name" required>
                                <input type="email" name="email" placeholder="Email" required>
                                <input type="password" name="password" placeholder="Password" required>
                                <input type="text" name="contact" placeholder="Contact Number">
                                <select name="user-type">
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>

                                <input type="submit" name="add-new-admin" value="Add Account" class="form-btn">
                            </form>
                        </div>
                    </div>

                    <h3>Active Admins</h3>

                    <div class="admins">
                        <table class="active-admins">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                function getAllAdmins()
                                {
                                    global $conn;
                                    $query = "SELECT * FROM login_and_register WHERE user_type = 'admin' ";
                                    return mysqli_query($conn, $query);
                                }

                                $admins = getAllAdmins();

                                if ($admins) {
                                    if (mysqli_num_rows($admins) > 0) {
                                        while ($record = mysqli_fetch_assoc($admins)) {
                                ?>
                                            <tr>
                                                <td><?= $record['id'] ?></td>
                                                <td><?= $record['name'] ?></td>
                                                <td><?= $record['email'] ?></td>
                                                <td><?= $record['contact_number'] ?></td>
                                                <td style="background-color: #06c258;"><?= $record['account_status'] ?></td>
                                            </tr>
                                <?php
                                        }
                                    } else {
                                        echo "No records found";
                                    }
                                } else {
                                    echo "Error in retrieving records: " . mysqli_error($conn);
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </section>

                <div class="google-analytics">
                    <a href="https://analytics.google.com/analytics/web/?authuser=0#/p413781736/reports/intelligenthome?params=_u..nav%3Dmaui">
                        Click here to Track visitors from Google Analytics</a>
                </div>

                <?php include('./includes/footer.php'); ?>

            </main>

        </section>

    </section>

    <script src="../assets/js/admin.js"></script>
    <script src="../assets/js/user_acc_hold.js"></script>

</body>

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

</html>