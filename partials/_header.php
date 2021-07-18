<!--Header Page -->

<?php
  session_start();
?>

<!--https://jackportfolio.ga jackson portfolio link-->
<!--starting of navigation Bar/nav Panel here we call the "data-bs-toggle" and "data-bs-target" from signIn and signUp Modal page-->
<nav class="navbar navbar-expand-lg  navbar-dark bg-dark py-2">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Discuss Rumour</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <!-- if $page is Home then active else none -->
                    <a class="nav-link <?= ($page=="home" ? "active" : "") ?>" aria-current="page"
                        href="/forum">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($page=="about" ? "active" : "") ?>" href="about.php">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Topics
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <?php
        $sql="SELECT category_name, category_id  FROM `category` LIMIT 3";
        $result=mysqli_query($conn,$sql);
        while ($row=mysqli_fetch_assoc($result)) {
          $id=$row['category_id'];
          $category_name=$row['category_name'];
          echo'<a class="dropdown-item" href="threadlist.php?catid='.$id.'">'.$category_name.'</a>';
        }
        ?>

                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($page=="contact" ? "active" : "") ?>" href="contact.php">Contact Us</a>
                </li>
            </ul>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true): ?>
            <form class="d-flex" action="search.php" method="GET">
                <input class="form-control mx-2" type="search" name="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-success mx-2" type="submit">Search</button>
                <p class="text-light my-2 mx-2"><? echo $_SESSION["user_mail"]; ?></p>
            </form>
            <a href="partials/_signoutHandler.php" class="btn btn-outline-success">Sign Out</a>
            <?php elseif (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true ): ?>
            <form class="d-flex" action="search.php" method="GET">
                <input class="form-control mx-2" type="search" name="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-success " type="submit">Search</button>
            </form>
            <button class="btn btn-outline-success mx-2 " data-bs-toggle="modal" data-bs-target="#signinModal">Sign
                In</button>
            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#signupModal">Sign
                Up</button>
            <?php endif; ?>
        </div>
    </div>
</nav>
<?php
//included SignUp model and Sign In Model after Nav Bar
include 'partials/_signupModal.php';
include 'partials/_signinModal.php';

if (isset($_GET['signupSuccess']) && ($_GET['signupSuccess']=='true')): ?>
<div class="alert alert-success alert-dismissible fade show " role="alert">
    <strong>Success!</strong> You have successfully created your account.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<?php elseif (isset($_GET['passError']) && ($_GET['passError']=='true')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> Please Enter the same password.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php elseif (isset($_GET['emailError']) && ($_GET['emailError']=='true')): ?>
<div class="alert alert-danger alert-dismissible fade show " role="alert">
    <strong>Error!</strong> Email already in use.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php elseif (isset($_GET['login']) && ($_GET['login']=='true')):?>
<div class="alert alert-success alert-dismissible fade show " role="alert">
    <strong>Success!</strong> You Have Successfully Logged In.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php elseif (isset($_GET['showError1']) && ($_GET['showError1']=='true')):?>
<div class="alert alert-warning alert-dismissible fade show " role="alert">
    <strong>Error!</strong>Please Enter a valid Password.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php elseif (isset($_GET['showError2']) && ($_GET['showError2']=='true')): ?>
<div class="alert alert-warning alert-dismissible fade show " role="alert">
    <strong>Error!</strong>Please Enter a valid Email ID.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>