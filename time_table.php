<?php

@include './config/config.php';

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/c4254e24a8.js"></script>

    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">

    <title>E Learning - Time Table</title>
</head>

<body>

    <?php include('./includes/header.php'); ?>

    <div class="active-classes">

        <h2>Active Classes</h2>

        <table class="active-users">
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
                    $query = "SELECT * FROM classes WHERE class_status = 'Active' ";
                    return mysqli_query($conn, $query);
                }

                $classes = getAllClasses();

                if ($classes) {
                    if (mysqli_num_rows($classes) > 0) {
                        while ($record = mysqli_fetch_assoc($classes)) {
                ?>
                            <tr>
                                <td><?= $record['grade'] ?></td>
                                <td><?= $record['day'] ?></td>
                                <td><?= $record['time'] ?></td>
                                <td style="background-color: <?php echo ($record['class_status'] === 'Active') ? '#06c258' : (($record['class_status'] === 'Hold') ? '#FD7238' : 'inherit'); ?>">
                                    <?= $record['class_status'] ?>
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
    </div>

    <?php include('./includes/footer.php'); ?>

</body>

</html>