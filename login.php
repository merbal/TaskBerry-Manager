<?php
session_start();
include("../db/connect_reg_db.php");
//echo $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
   //echo "$user_name";
    //echo "$password";
    //read database
    $query = "select * from users where user_name = '$user_name' limit 1";

    
    $result = mysqli_query($conn,  $query);
    
    if ($result) {
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            if ($user_data['password'] === $password) {
                $_SESSION['user_id'] = $user_data['user_id'];
                $_SESSION['user_acc_id'] = $user_data['id'];
                $_SESSION['user_name'] = $user_data['user_name'];
                if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {

                    header("Location: ../index.php");
                    die;
                }
            }
        }
        echo "Wrong username or password";
    } else {
        echo "please enter some valid information";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login oldal</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
        
        <link rel="stylesheet" href="../css/selectors.css">
    </head>
    
    <body>
        <?php include '../../header/header.php'  ?>
        <div class="container">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <form method="POST" class="form-horizontal">
                        <input type="user_name" name="user_name" class="form-control" aria-describedby="user_name" placeholder="LUser name">
                        <div class="form-group">
                            <label for="user_name">User name</label>
                            <small id="user_name_small" class="form-text text-muted"></small>
                        </div>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <div class="form-group">
                            <label for="password">Password</label>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="signup.php">Signup</a>
                </form>


            </div>

            <div class="col-2"></div>
        </div>
    </div>

</body>

</html>
