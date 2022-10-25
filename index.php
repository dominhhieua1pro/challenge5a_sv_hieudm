<?php
session_start();
include("config/connect.php");
require_once("config/user.php");

// define variables and initialize with empty values
$username = $password = "";
$err = $username_err = $password_err = "";

// processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // check if username and password empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username";
    }else {
        $username = trim($_POST["username"]);
    }


    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter password";
    } else{
        $password = md5(trim($_POST["password"]));
    }

    // validate credentials
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT * FROM tbluser WHERE username = '$username' AND password = '$password'" ;
        $result = $conn->query($sql) ;
        $count = $result->num_rows;
        if($count > 0){
	        $row = $result -> fetch_array(MYSQLI_NUM);
            // echo "<pre>";
            // var_dump($_SESSION);
            // echo "</pre>"; 
            $_SESSION["id"] = $row[0];
            $_SESSION["username"] = $row[1];
            $_SESSION["password"] = $row[2];
            $_SESSION["pos"] = $row[3];
            $_SESSION["name"] = $row[4];
            $_SESSION["pnumber"] = $row[5];
            $_SESSION["email"] = $row[6];
            $_SESSION["avatar"] = $row[7];
            if($_SESSION["pos"] == 1 ){
                header("location: ./teacher/index.php");
                exit();
            }else{
                header("location: ./student/index.php");
                exit();
            }
        } else {
            $err = "Username or password is invalid";
        }

    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form" method="POST">
        <h1>LOGIN</h1>
        <?php echo "<span class='err'>".$err."</span>" ?>
        <?php echo "<span class='err'>".$username_err."</span>" ?>
        <input type="text" name="username" placeholder="Username">
        <?php echo "<span class='err'>".$password_err."</span>" ?>
        <input type="password" name="password" placeholder="Password">
        <input type="submit" value="Log in">
    </form>
    
</body>
</html>
