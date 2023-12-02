<section id="sidebar">
    <a href="/user_panel/user_dashboard.php" class="brand">
        <span class="text">Welcome <?php echo ($_SESSION['user_name']); ?></span>
    </a>
    <ul class="side-menu top">
        <li>
            <a href="../index.php">
                <i class='bx bxs-home'></i>
                <span class="text">E Learning</span>
            </a>
        </li>
        <li>
            <a href="#profile">
                <i class='bx bxs-user'></i>
                <span class="text">Profile</span>
            </a>
        </li>
        <li>
            <a href="#classes">
                <i class='bx bxs-book-alt'></i>
                <span class="text">Classes</span>
            </a>
        </li>
        <li>
            <a href="#upload">
                <i class='bx bx-upload'></i>
                <span class="text">Uploads</span>
            </a>
        </li>
        <li>
            <a href="/login/logout.php" class="logout">
                <i class='bx bx-log-out'></i>
                <span class="text">Log Out</span>
            </a>
        </li>
    </ul>
</section>