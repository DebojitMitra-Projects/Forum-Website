<?php
$emailError=false;
$signupSuccess=false;
$passError=false;

if ($_SERVER['REQUEST_METHOD']=='POST'){
    require '_dbconnect.php';
    $user_email = $_POST['signupEmail'];
    $password = $_POST['signupPassword'];
    $cpassword = $_POST['cpassword'];
        $existSql="SELECT * FROM `users` WHERE user_email='$user_email'";
        $result = mysqli_query($conn,$existSql);
            $numExistRows=mysqli_num_rows($result);
            if ($numExistRows>0) {
                $emailError = true;
                header("Location:/forum/index.php?emailError=true");
                
            }
            else {
                if ($password==$cpassword) {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO `users` (`user_email`, `password`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp())";
                    $result = mysqli_query($conn,$sql);
                    if ($result) {
                        $signupSuccess=true;
                        header("Location:/forum/index.php?signupSuccess=true");
                        exit();
                    }
                }
                else {
                    $passError=true;
                    header("Location:/forum/index.php?passError=true");
                }
            }


        }



?>