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

  
    <!-- Wallpaper Slider Carousel starts here -->
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://source.unsplash.com/1600x500/?code,technology" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://source.unsplash.com/1600x500/?code,technology" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://source.unsplash.com/1600x500/?code,technology" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>



    <!-- Category Conatiner Starts Here -->
    <div class="container my-3">
        <h2 class="text-center">Rumuor Categories</h2>
        <div class="row">

                <!-- Fetch all the categories from the database and loop it to iterate through categories-->
                <?php
                    $sql = 'SELECT * FROM `category`';
                    $result=mysqli_query($conn,$sql);

                            while ($row=mysqli_fetch_assoc($result)){

                                //echo '$row[category_id]' and echo '$row[category_name]' are just used to check the fetched dataset not mendatory
                                
                                //echo '$row[category_id]';
                                //echo '$row[category_name]';
                                $catid=$row['category_id'];
                                $catname=$row['category_name'];
                                $catdesc=$row['category_description'];
                               if ($catid >= 1) {
                                   echo "<div class='col-md-4 my-2'>
                                   <div class='card' style='width: 18rem;'>
                                       <img src='https://source.unsplash.com/400x400/?".$catname.",technology' class='card-img-top' alt='...'>
                                       <div class='card-body'>
                                           <h5 class='card-title'> <a  href='threadlist.php?catid=".$catid."'> ".$catname." </a> </h5>
                                           <p class='card-text'>".substr($catdesc,0,80)."....</p>
                                           <a href='threadlist.php?catid=".$catid."'  class='btn btn-primary'>View Thread</a>
                                       </div>
                                   </div>
                               </div>";
                               }

                            }
                
                
                ?>

        <!-- Use a for loop to iterate through catrgories -->
          
        </div>
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