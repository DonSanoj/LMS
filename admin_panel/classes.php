<?php

@include '../config/config.php';

session_start();

if (isset($_POST['add-new-class'])) {
    $class_grade = $_POST['class-grade'];
    $class_day = $_POST['class-day'];
    $class_time = $_POST['class-time'];
    $class_status = $_POST['class-status'];

    $insert_into_classes = "INSERT INTO classes (grade, day, time) VALUES ('$class_grade', '$class_day', '$class_time')";

    $result_for_classes = mysqli_query($conn, $insert_into_classes);

    if ($result_for_classes) {
        header('location: ./classes.php');
        alert('Class added successfully.');
    } else {
        header('location: ./classes.php');
        alert('Failed to add class.');
    }
}

if (isset($_POST['class-delete'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $class_delete = "DELETE FROM classes WHERE id = '$id'";
    $class_delete_run = mysqli_query($conn, $class_delete);

    if ($class_delete_run) {
        header('location: ./classes.php');
        alert("Class deleted.");
    } else {
        header('location: ./classes.php');
        alert("Something went wrong.");
    }
}

if (isset($_POST['class-active'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $class_status_active_query = "UPDATE classes SET class_status = 'Active' WHERE id = '$id' ";

    $class_status_active_query_run = mysqli_query($conn, $class_status_active_query);

    if ($class_status_active_query_run) {
        header('location: ./classes.php');
        alert("Class Active!");
    } else {
        header('location: ./classes.php');
        alert("Something went wrong.");
    }
}

if (isset($_POST['class-hold'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $class_status_hold_query = "UPDATE classes SET class_status = 'Hold' WHERE id = '$id' ";

    $class_status_hold_query_run = mysqli_query($conn, $class_status_hold_query);

    if ($class_status_hold_query_run) {
        header('location: ./classes.php');
        alert("Class Hold.");
    } else {
        header('location: ./classes.php');
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/c4254e24a8.js"></script>

    <title>E Learning - Classes</title>
</head>

<body>

    <?php include('./includes/header.php'); ?>

    <?php include('./includes/sidebar.php'); ?>

    <section class="admin-section">

        <h1>Classes</h1>

        <div class="add-new-class">
            <div class="class-form-container">
                <form action="" method="POST">

                    <h3>Add New Classes</h3>

                    <input type="text" name="class-grade" placeholder="Grade" required>
                    <input type="day" name="class-day" placeholder="Day" required>
                    <input type="time" name="class-time" placeholder="Time" required>

                    <input type="submit" name="add-new-class" value="Add Class" class="form-btn">
                </form>
            </div>
        </div>

        <div class="active-classes">

            <h2>Active Classes</h2>

            <table class="active-users">
                <thead>
                    <tr>
                        <th>Grade</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    function getAllClasses()
                    {
                        global $conn;
                        $query = "SELECT * FROM classes";
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
                                    <td>
                                        <form action="" method="POST">
                                            <input type="hidden" name="id" value="<?= $record['id'] ?>">
                                            <button class="btn-active" type="submit" name="class-active">Active Class</button>
                                            <button class="btn-hold" type="submit" name="class-hold">Hold Class</button>
                                            <button class="btn-delete" type="submit" name="class-delete">Delete</button>
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
        </div>
    </section>

    <?php include('./includes/footer.php'); ?>

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