<!--Header section start-->
<header>

    <a href="/index.php" class="logo">E Learning</a>

    <nav class="navbar">
        <a href="/index.php">Home</a>
        <a href="#">Time Table</a>
        <a href="#">Contact Us</a>
        <a href="#">About Us</a>
    </nav>

    <div class="icons">
        <i class="fas fa-bars" id="menu-bars"></i>
        <i class="fas fa-search" id="search-icon"></i>
        <a href="/login/login_form.php"><i class="fas fa-user" id="login-icon"></i></a>
    </div>

</header>
<!--Header section end-->

<!--Search form start-->
<form action="/search_result.php" id="search-form" method="GET">
    <input type="search" placeholder="Search here..." name="search" id="search-box">
    <button type="submit" name="submit-search"><label for="search-box" class="fas fa-search"></label></button>
    <i class="fas fa-times" id="search-form-close"></i>
</form>
<!-- Search form end -->