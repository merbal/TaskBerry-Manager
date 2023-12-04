<?php 

include("../db/connect_reg_db.php");

?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css"
        integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/PHP/css/reg.css">
    <link rel="stylesheet" href="../lib/bootstrap-4.5.2-dist/css/bootstrap.min.css">

</head>

<body>
    <?php
        function test ($str) {
            $str=trim($str);
            $str=strip_tags($str);
            $str=stripslashes($str);
            return $str;
        }

        $addressErr = $usernameErr = $passwordErr = $nameErr = $emailErr = "";
        $comment = $gender = "";
        $pets = $country = null;

        if($_SERVER['REQUEST_METHOD']=="POST"){
            if (isset($_POST['username']) && !empty($_POST['username'])
                && $_POST['username'] == test($_POST['username'])
                && preg_match("/^[a-zA-Z]*$/", $_POST['username'])
                && strlen($_POST['username']) <= 40) {
                $username = $_POST['username'];
                
            } else {
                $usernameErr = "Hibás felhasználónév!";
            }
            if (isset($_POST['password']) && !empty($_POST['password'])
                && $_POST['password'] == test($_POST['password'])
                && strlen($_POST['password']) <= 40
                && strlen($_POST['password']) > 10
                ) {
                $password = $_POST['password'];
            } else {
                $passwordErr =  "Hibás jelszó!";
            }
            if (isset($_POST['name']) && !empty($_POST['name'])
            && $_POST['name'] == test($_POST['name'])
            && preg_match("/^[a-zA-ZáéíóüöőűúŰÁÉÚŐÓÜÖ\s]*$/u", $_POST['name'])
            && strlen($_POST['password']) <= 40
            ) {
                $name = $_POST['name'];
            } else {
                $nameErr="hibás név!";
            }
            if (isset($_POST['email']) && !empty($_POST['email'])
                &&filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
            ) {
                $email = $_POST['email'];
            } else {
                $emailErr = "Hibás emailcím";
            }
            if (isset($_POST['address'])) {
                $address = $_POST['address'];
            } else {
                $addressErr = "Hibás cím";
            }
            if (isset($_POST['comment'])) {
                $comment = $_POST['comment'];
            }
            if (isset($_POST['forme'])) {
                $forme = $_POST['forme'];
            }
            if (isset($_POST['gender'])) {
                 $gender = $_POST['gender'];
            }
            if (isset($_POST['pets'])) {
                $pets = $_POST['pets'];
            }
            if (isset($_POST['country'])) {
                $country = $_POST['country'];
            }
        }
    ?>
    <div id="regdiv">
        <?php include '../../header/header.php'  ?>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <fieldset>
                <legend>Személyes Adatok</legend>
                <table>
                    <tr>
                        <td><label>Név:</label> </td>
                        <td><input id="name" name="name" type="text" placeholder="Név">* <?php echo $nameErr ?></td>
                    </tr>
                    <tr>
                        <td>Felhasználó név:</td>
                        <td><input id="username" name="username" type="text" placeholder="Felhasználónév">*
                            <?php echo $usernameErr ?></td>
                    </tr>
                    <tr>
                        <td>Jelszó</td>
                        <td><input id="password" name="password" type="password" placeholder="Jelszó">*
                            <?php echo $passwordErr ?></td>
                    </tr>
                    <tr>
                        <td>Email cím:</td>
                        <td><input id="email" name="email" type="email" placeholder="Email">* <?php echo $emailErr ?>
                        </td>
                    </tr>
                    <tr>
                        <td>cím:</td>
                        <td><input id="address" name="address" type="text" placeholder="Cím"></td>
                    </tr>
                    <tr>
                        <td>Magamról:</td>
                        <td><textarea id="forme" name="forme" rows="5" cols="40"></textarea></td>
                    </tr>
                    <tr>
                        <td>Megjegyzés:</td>
                        <td><textarea id="comment" name="comment" rows="5"></textarea></td>
                    </tr>
                    <tr>
                        <td>Nem:</td>
                        <td><input type="radio" name="gender" value=0 /><span>Férfi</span><input type="radio"
                                name="gender" value=1 /><span>Nő</span> </td>
                    </tr>
                    <tr>
                        <td>háziállatok:</td>
                        <td><input type="checkbox" name="pets[]" value="Kutya" />Kutya
                            <input type="checkbox" name="pets[]" value="Macska" />Macska
                            <input type="checkbox" name="pets[]" value="Hal" />Hal
                        </td>
                    </tr>
                    <tr>
                        <td>Kedvenc országaim:</td>
                        <td>
                            <select multiple='multiple' name="country[]">
                                <option value="Japán">Japán</option>
                                <option value="Magyarország">Magyarország</option>
                                <option value="USA">USA</option>
                                <option value="Németország">Németország</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="Küldd!"></td>
                    </tr>
                </table>
                <a href="login.php">Log in</a>
            </fieldset>
        </form>
        <br />
        <hr />
</body>

</html>
<?php
if (isset($username) && isset($password) && isset($name) && isset($email)) {
    echo "$username <br/> $password  <br/> $name <br/> $email <br/> $forme <br/> $comment <br/> $gender <br/>";
    echo "<br/>";
    if (isset($pets))
    foreach ($pets as $value) {
        echo "$value <br/>";
    }
    echo ' <br/>';
    if (isset ($country))
    foreach ($country as $value) {
        echo "$value <br/>";
    }
    $user_id = random_num(20);
    echo "1. $user_id";
    $sql = "INSERT INTO `users` (`user_id`, `user_name`, `password`) 
    VALUES ($user_id, '$username', '$password');";
    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    header("Location: login.php");
    die;
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
