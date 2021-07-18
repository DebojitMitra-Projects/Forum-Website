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
        //$id is variable which will store the category_id recieved from threadlist.php by using $_GET
        $id=$_GET['threadid'];
        


        //after recieveing the $id it will run the sql query
        $sql="SELECT * FROM `threads` WHERE thread_id=$id";
        $result=mysqli_query($conn,$sql);
        while ($row=mysqli_fetch_assoc($result)){
            //two variables declared to store the category name and description fetched from the dataset 
            $thread_user_id=$row['thread_user_id'];
            $threadtitle=$row['thread_title'];
            $threadDesc = $row['thread_desc'];
            
            $sql2="SELECT user_email FROM `users` WHERE sno=$thread_user_id";
            $result2=mysqli_query($conn,$sql2);
            $row2=mysqli_fetch_assoc($result2);
            $email=$row2['user_email'];
        }
    ?>

    <!--Container for Jumbtron  -->

    <div class="p-5 my-5 text-center bg-image"
        style="background-image: url('https://source.unsplash.com/1600x900/?code,coding');height: 400px;">
        <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="text-white">
                    <!--two variables are called inside this jumbtron using php to diplay the name and description  -->
                    <h1 class="mb-3"> <?php echo $threadtitle;?> Forum</h1>
                    <h5 class="mb-3"><?php echo $threadDesc;?></h5>
                    <hr>
                    <p class="mb-3">No Spam / Advertising / Self-promote in the forums. Do not post copyright-infringing
                        material. Do not post “offensive” posts, links or images. Remain respectful of other members at
                        all times </p>
                </div>
            </div>
            <p class="mb-3 text-white">Posted By: <?php echo $email; ?></p>
        </div>
    </div>

 <!-- making the comment box functional-->
<?php 
        $showAlert = false;
        $formMethod=$_SERVER['REQUEST_METHOD'];
            if ($formMethod=='POST'){
                $commentContent = $_POST['comment'];
                $commentContent=str_replace("<","&lt;","$commentContent");
                $commentContent=str_replace(">","&gt;","$commentContent");

                $sno=$_POST['sno'];
                $sql="INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$commentContent', '$id', '$sno', current_timestamp())";
                $result=mysqli_query($conn,$sql);
                $showAlert=true;
                if ($showAlert){
                    echo'<div class="alert alert-success alert-dismissible fade show fixed-top " role="alert">
                    <strong>Success!</strong> You have successfully posted a comment.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            }

    ?>

    <!-- Container for Media Object -->
    <?php
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true) {
        echo'<div class="container my-4">
            <h1 class="py-2 ">Post Your Comment Here</h1>

                <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Type Your Comment</label>
                        <textarea class="form-control" name="comment" id="comment" id="exampleFormControlTextarea1" rows="3"></textarea>
                        <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
                    </div>
                    <button type="submit" class="btn btn-success my-2">Post Comment</button>
                </form>
            </div>';
            }
    else {
        echo'<div class="container"> <h1 class="py-2">Post Your Comment Here</h1>
            <h5 class="mb-3">Please Sign In to comment</h5> </div>';
            }
    ?>



        <?php
            //$id is variable which will store the category_id recieved from index.php by using $_GET
            $id=mysqli_real_escape_string($conn,$_GET['threadid']);
            
            $sql="SELECT * FROM `comments` WHERE thread_id=$id";
            $result=mysqli_query($conn,$sql);
            $noComment=true;
            while ($row=mysqli_fetch_assoc($result)){
                $noComment=false;
                //two variables declared to store the category name and description fetched from the dataset 
                $c_id=$row['comment_id'];
                $c_content=$row['comment_content'];
                $c_time=$row['comment_time'];
                $comment_by=$row['comment_by'];
                $sql2="SELECT user_email FROM `users` WHERE sno=$comment_by";
                $result2=mysqli_query($conn,$sql2);
                $row2=mysqli_fetch_assoc($result2);
                $email=$row2['user_email'];
                
               
                   //Media object
                   echo '<div class="container my-3 mb-4">
                        <div class="d-flex">
                        <img src="img/userdefault.png" alt="John Doe" class="me-3 rounded-circle"
                            style="width: 60px; height: 60px;" />

                        <div class="media-body">
                        <p class="fw-bold my-0">'.$email.' at ' . $c_time . '</p>
                            <p>'.$c_content.'</p>
                        </div>
                    </div>
                    </div>';
            }
            if ($noComment) {
                echo"<div class='d-flex jumbotron-fluid'>
                <div class='container'>
                    <h1 class='display-4'>No Comments Posted Yet</h1>
                    <p class='lead'>Be the first to ask.</p>
                </div>
                </div>";
        }
            ?>
    




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