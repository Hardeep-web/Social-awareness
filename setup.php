<?php
session_start();
ob_start();
include('config.php');

/*********  REGISTER CODE STARTS HERE  ***********/

if(isset($_POST['register']))
{
    $user_firstname = $_POST['first_name'];
    $user_lastname = $_POST['last_name'];
    $user_email = $_POST['email'];
    $user_phone = $_POST['phone'];
    $user_bio = $_POST['bio'];
    $user_password = $_POST['password'];
    if ($mysqli -> connect_errno){
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }
    else{
        $query = "SELECT * FROM `tb_register` WHERE `email` = '$user_email'";
        $res = mysqli_query($con,$query);
        //echo $query;
        if ($res->num_rows > 0) {

            header('Location:register.php?error=registered');

        }
        else
        {
        
            $query = "INSERT INTO `tb_register` (`first_name`,`last_name`,`email`,`phone`,`bio`,`password`) VALUES ('$user_firstname','$user_lastname','$user_email','$user_phone','$user_bio','$user_password')";
            $rows = mysqli_query($con,$query); 
            //echo $rows.' '.$query;
            header('Location:login.php?msg=registered');
        }

    }
}

/*********  LOGIN CODE STARTS HERE  ***********/

if(isset($_POST['login']))
{
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
    if ($mysqli -> connect_errno){
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }
    else{
        $query = "SELECT * FROM `tb_register` WHERE `email` = '$user_email' AND `password` = '$user_password' AND `status` = '1'";
        $res = mysqli_query($con,$query);
        echo $query;
        if ($res->num_rows > 0) {
            while($row = $res->fetch_assoc()) {
                echo $row['id'];
                echo $row['first_name'];
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['first_name'];
                $_SESSION['logged_in'] = TRUE;
                $_SESSION['user_email'] = $row['email'];

                header('Location:index.php');
            }
        }
        else{
            header('Location:login.php?val=invalid');
        }
        
    }
   
}
?>