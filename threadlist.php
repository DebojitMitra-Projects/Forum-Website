<!--Index Page -->
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

 <!-- here scc is used manually to remove underline from href link -->
<style>
a {
    text-decoration: none;
}
</style>

<body>

    <!-- Included database _dbconnect file to connect to the database-->
    <?php require 'partials/_dbconnect.php';?>


    <!-- Included header file -->
    <?php require 'partials/_header.php';?>  



    <?php
        //$id is variable which will store the category_id recieved from index.php by using $_GET
        $id=$_GET['catid'];

        //after recieveing the $id it will run the sql query
        $sql="SELECT * FROM `category` WHERE category_id = $id";
        $result=mysqli_query($conn,$sql);
        
        while ($row=mysqli_fetch_assoc($result)){
            
            //two variables declared to store the category name and description fetched from the dataset 
            $catname=$row['category_name'];
            $catdesc = $row['category_description'];
        }    
    ?>




    <!-- starting new Descussion using post method and making the form functional-->
    <?php 
        $showAlert = false;
        $formMethod=$_SERVER['REQUEST_METHOD'];
            if ($formMethod=='POST'){
         
                //htmlentities Solution
                $th_title = mysqli_real_escape_string($conn, htmlentities($_POST['title']));
                $th_desc = mysqli_real_escape_string($conn,htmlentities($_POST['desc']));
                $sno = mysqli_real_escape_string($conn,$_POST['sno']);
                $sql="INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
                $result=mysqli_query($conn,$sql);
                $showAlert=true;
                if ($showAlert){
                    echo'<div class="alert alert-success alert-dismissible fade show fixed-top " role="alert">
                    <strong>Success!</strong> You have successfully posted a thread now wait for the community to respond.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            }

    ?>


    <!--Container for Jumbtron  -->
    <div class="p-5 my-5 text-center bg-image"
        style="background-image: url('https://source.unsplash.com/1600x900/?code,coding');height: 400px;">
        <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="text-white">
                    <!--two variables are called inside this jumbtron using php to diplay the name and description  -->
                    <h1 class="mb-3">Welcome To <?php echo $catname;?> Forum</h1>
                    <h5 class="mb-3"><?php echo $catdesc;?></h5>
                    <hr>
                    <p class="mb-3">No Spam / Advertising / Self-promote in the forums. Do not post
                        copyright-infringing
                        material. Do not post “offensive” posts, links or images. Remain respectful of other members
                        at
                        all times </p>
                    <a class="btn btn-outline-success btn-lg" type="submit" href="#!" role="button">Learn More</a>
                </div>
            </div>
        </div>
    </div>



    <!-- Form to Start a new discussion -->

<?php
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true){ 
    echo'<div class="container">
        <h1 class="py-2">Start a Discussion</h1>

        <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Post Your Thread Title</label>
                <input type="text" class="form-control" name="title" id="title" aria-describedby="title">
                <div id="title" class="form-text">We will never share your email with anyone else.</div>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Describe Your Thread</label>
                <textarea class="form-control" name="desc" id="desc" id="exampleFormControlTextarea1" rows="3"></textarea>
                <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
            </div>
            <button type="submit" class="btn btn-success my-2">Submit</button>
        </form>
    </div>';
    }
    else {
        
        echo '<div class="container"> <h1 class="py-2">Start a Discussion</h1>
        <h5 class="mb-3">Please Sign In to Start a Discussion</h5> </div>';
    }
?>


    <!-- Container for Media Object -->
    <div class="container my-4">
        <h1 class="py-2">Browse Questions</h1>


        <?php
            //$id is variable which will store the category_id recieved from index.php by using $_GET
            $id=$_GET['catid'];

            $sql="SELECT * FROM `threads` WHERE thread_cat_id=$id";
            $result=mysqli_query($conn,$sql);
            $noResult=true;
            while ($row=mysqli_fetch_assoc($result)){
                $noResult=false;
                //two variables declared to store the category name and description fetched from the dataset 
                $threadid=$row['thread_id'];
                $threadtitle=$row['thread_title'];
                $threadtitle=str_replace("<","&lt;","$threadtitle");
                $threadtitle=str_replace(">","&gt;","$threadtitle");

                $threaddesc = $row['thread_desc'];
                $threaddesc=str_replace("<","&lt;","$threaddesc");
                $threaddesc=str_replace("<","&gt;","$threaddesc");



                $thread_user_id=$row['thread_user_id'];

                $sql2="SELECT user_email FROM `users` WHERE sno=$thread_user_id";
                $result2=mysqli_query($conn,$sql2);
                $row2=mysqli_fetch_assoc($result2);
                $email=$row2['user_email'];
                   //Media objects
                   echo '<div class="d-flex">
                        <img src="img/userdefault.png" alt="John Doe" class="me-3 rounded-circle"
                            style="width: 60px; height: 60px;" />
                        <div>
                            <h5 class="fw-bold"><a href="thread.php?threadid='.$threadid.'">'.$threadtitle.'</a>Asked By: '.$email.'</h5>
                            <p>'.$threaddesc.' </p>
                        </div>
                    </div>';
            }
            if ($noResult) {
                echo"<div class='d-flex jumbotron-fluid'>
                <div class='container'>
                    <h1 class='display-4'>No Thread Posted Yet</h1>
                    <p class='lead'>Be the first to ask.</p>
                </div>
                </div>";
        }

            ?>
    </div>




    <!-- Included Footer File -->
    <?php require 'partials/_footer.php';?>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->
</body>

</html>