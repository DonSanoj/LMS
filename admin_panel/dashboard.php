<?php

@include '../config/config.php';

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
                        <p>Classes</p>
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
                    <h2>Active Classes</h2><br>
                    <table>
                        <thead>
                            <tr>
                                <th>Grade</th>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            function getAllClasses()
                            {
                                global $conn;
                                $query = "SELECT * FROM classes ";
                                return mysqli_query($conn, $query);
                            }

                            $classes = getAllClasses();

                            if ($classes) {
                                if (mysqli_num_rows($classes) > 0) {
                                    while ($record = mysqli_fetch_assoc($classes)) {
                            ?>
                                        <td><?= $record['grade'] ?></td>
                                        <td><?= $record['day'] ?></td>
                                        <td><?= $record['time'] ?></td>
                                        <td style="background-color: <?php echo ($record['class_status'] === 'Active') ? '#06c258' : (($record['class_status'] === 'Hold') ? '#FD7238' : 'inherit'); ?>">
                                            <?= $record['class_status'] ?>
                                        </td>
                            <?php
                                    }
                                } else {
                                    echo "No records found";
                                }
                            } else {
                                echo "Error in retrieving records: " . mysqli_error($conn); // Display any potential errors
                            }
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