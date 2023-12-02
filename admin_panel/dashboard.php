<?php

@include '../config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location: /login/login_form.php');
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

    <link rel="stylesheet" href="../assets/css/admin_and_user.css">

    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <title>E Learning - Admin</title>
</head>

<body>

    <?php include('../admin_panel/includes/sidebar.php'); ?>

    <!-- CONTENT -->
    <section id="content">

        <?php include('./includes/header.php'); ?>

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                </div>
            </div>

            <ul class="box-info">
                <li>
                    <i class='bx bxs-calendar-check'></i>
                    <span class="text">
                        <h3>11</h3>
                        <p>Grades</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h3>9</h3>
                        <p>Active Students</p>
                    </span>
                </li>
            </ul>


            <div class="table-data">
                <div class="order">
                    <h2>Orders</h2><br>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Service Type</th>
                                <th>Accepted Admin Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            // function getAll($table)
                            // {
                            //     global $conn;
                            //     $query = "SELECT * FROM $table";
                            //     return mysqli_query($conn, $query);
                            // }

                            // $orders = getAll("confirmed_orders");

                            // if ($orders) {
                            //     if (mysqli_num_rows($orders) > 0) {
                            //         while ($record = mysqli_fetch_assoc($orders)) {
                            ?>
                                        <tr>
                                            <td><?= $record['confirmed_order_id'] ?></td>
                                            <td><?= $record['name'] ?></td>
                                            <td><?= $record['service_type'] ?></td>
                                            <td><?= $record['admin_email'] ?></td>
                                        </tr>
                            <?php
                            //         }
                            //     } else {
                            //         echo "No records found";
                            //     }
                            // } else {
                            //     echo "Error in retrieving records: " . mysqli_error($conn); // Display any potential errors
                            // }
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php include('../admin_panel/includes/footer.php'); ?>
            </div>
        </main>
        <!-- MAIN -->

    </section>
    <!-- CONTENT -->

    <script src="../assets/js/admin.js"></script>

</body>

</html>