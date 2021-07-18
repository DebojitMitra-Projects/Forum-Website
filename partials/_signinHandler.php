<?php
$login=false;
$showError1=false;
$showError2=false;
if($_SERVER['REQUEST_METHOD']=='POST'){
    require 'C:\xampp\htdocs\forum\partials\_dbconnect.php';
    $user_email = $_POST['signinEmail'];
    $password = $_POST['signinPassword'];

    $sql="SELECT * FROM `users` WHERE `user_email`='$user_email'";
    $result=mysqli_query($conn,$sql);
    $numRow = mysqli_num_rows($result);
    if ($numRow==1){
        while ($row=mysqli_fetch_assoc($result)) {
                if (password_verify($password,$row['password'])) {
                    $login=true;
                    session_start();
                    $_SESSION["loggedin"]=true;
                    $_SESSION["sno"]=$row['sno'];
                    $_SESSION["user_mail"]=$user_email;
                    
                    header("Location:/forum/index.php?login=true");
                }
                else {
                    $showError1=true;
                    header("Location:/forum/index.php?showError1=true");
                }
        }
    }
    else {
        $showError2=true;
        header("Location:/forum/index.php?showError2=true");
    }  
}
?>