<!--Index Page -->
<?php $page="home";?>

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


    <!-- css used to remove undereline from card-title -->
<style>a {text-decoration: none;} </style>


<body>

    <!-- Included database _dbconnect file to connect to the database-->
    <?php require 'partials/_dbconnect.php';?>
  
    <!-- Included header file -->
    <?php include 'partials/_header.php';?>


<?php

        $search=$_GET['search'];
        $search=str_replace("<","&lt;","$search");
        $search=str_replace(">","&gt;","$search");

        $sql="SELECT * FROM `threads` WHERE MATCH (thread_title, thread_desc) AGAINST ('$search')";
            $result=mysqli_query($conn,$sql);
            $noResult=true;
            while ($row=mysqli_fetch_assoc($result)){
                $noResult=false;
                $thread_id=$row['thread_id'];
                //two variables declared to store the category name and description fetched from the dataset 
                $threadtitle=$row['thread_title'];
                $threadtitle=str_replace("<","&lt;","$threadtitle");
                $threadtitle=str_replace(">","&gt;","$threadtitle");

                $threaddesc = $row['thread_desc'];
                $threaddesc=str_replace("<","&lt;","$threaddesc");
                $threaddesc=str_replace("<","&gt;","$threaddesc");
                $url="thread.php?threadid=". $thread_id;
           
                
          

                echo '<div class="d-flex jumbotron-fluid">
                <div class="container my-3">
                
                <h1>Search Results For <em>"'.$search.'"</em></h1>
                    <h3 class="display-4"><a href="'.$url.'">'.$threadtitle.'</a></h3>
                    <p class="lead">'.$threaddesc.'</p>
                </div>
                </div>';
            }
         if($noResult){
            echo'<div class="container my-2">
            <h1>Search Results For <em>"'.$search.'"</em></h1>

           <h3>Your search <em>'.$search.'</em> did not match any documents</h3>
            <h3>Suggestions:</h3>
            <ul>
            <li>Make sure that all words are spelled correctly</li>
            <li>Try different keywords.</li>
            <li>Try more general keywords.</li>
            <li>Try fewer keywords.</li>
            </ul>
            </div>';   
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