<?php
session_start();
include("../config/connect.php");
require_once("../config/user.php");

$username = $password = $name = $phonenumber = $email = "";
$username_err = $password_err = $name_err = $phonenumber_err = $email_err = "";

if(isset($_GET["action"])){
    if($_GET["action"] == "edit"){
        $id = $_GET["id"];
        // $_SESSION["stu-id"] = $id;
        $sql = "SELECT * FROM tbluser WHERE id = '$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_array(MYSQLI_NUM);
        $username = $row[1];
        // $password = $row[2];
        $name = $row[4];
        $phonenumber = $row[5];
        $email = $row[6];
    }

    // if($_GET["action"] == "delete"){
    //     $id = $_GET["id"];
    //     $sql = "DELETE FROM tbluser WHERE id = '$id'";
    //     if($conn->query($sql) == true){     
    //         $message = "Delete sucessfully";
    //         echo "<script type='text/javascript'>alert('$message'); window.location='student_show.php';</script>";
    //     }

    //     $pageName = "student";
    // }
}


// click on edit
if(isset($_POST["modification"])){
    // $username = $_POST["username"];
    // $password = $_POST["password"];
    // $name = $_POST["name"];
    // $phonenumber = $_POST["phonenumber"];
    // $email = $_POST["email"];
    // $encrypt_pwd = md5($password);

    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username";
    }else {
        $username = trim($_POST["username"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter password";
    } else{
        $password = $_POST["password"];
        $password_encrypted = md5(trim($_POST["password"]));
    }

    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter name";
    } else{
        $name = trim($_POST["name"]);
    }

    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email";
    } else{
        $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["phonenumber"]))){
        $phonenumber_err = "Please enter phonenumber";
    } else{
        $phonenumber = trim($_POST["phonenumber"]);
    }

    // check if information is in the right format
    // if(empty($username) or empty($password) or empty($name) or empty($phonenumber) or empty($email)){
    //     $err = "*Fill all the fields";
    //     // echo "<script type='text/javascript'>alert('$err');</script>";
    // } 
    
    if(!empty(trim($_POST["email"])) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email_err = "*Invalid email format";
        // echo "<script type='text/javascript'>alert('$err');</script>";
    } 
    
    if(!empty(trim($_POST["phonenumber"])) && !preg_match("/^[0]{1}[0-9]{9}$/", $phonenumber)){
        $phonenumber_err = "*Invalid phone number format";
        // echo "<script type='text/javascript'>alert('$err');</script>";
    } 
    
    if (!$username_err && !$password_err && !$name_err && !$email_err && !$phonenumber_err ){
        // $id = $_SESSION["id"];
        $sql = "UPDATE tbluser SET username='$username',password='$password_encrypted',name='$name',pnumber='$phonenumber',
        email='$email' WHERE id = '$id'";
        if($conn->query($sql) == true){
            $err = "Edit student infomation sucessfully!";
            echo "<script type='text/javascript'>alert('$err'); window.location='student_show.php';</script>";
        }else{
            $err = "Failed to edit!";
            echo "<script type='text/javascript'>alert('$err');</script>";
        }
    }

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit student</title>
    <link rel="stylesheet" href="teacher_style.css">
    <script src="https://kit.fontawesome.com/50e4937a61.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- side bar  -->
    <div class="sidebar" >
            <ul class="menu">
                <li>              
                    <?php 
                        $id = $_SESSION["id"];
                        $sql = "SELECT * FROM tbluser WHERE id = '$id'";
                        $result = $conn->query($sql);
                        $row = $result->fetch_array(MYSQLI_NUM);
                        if($row[7])
                            echo '<a href="index.php"> <img src="../image/avatars/'.$row[7].'" class="avatar" alt=""> </a>';
                        else
                            echo '<a href="index.php"> <img src="../image/avatars/default-avatar.png" class="avatar" alt=""> </a>';
                    ?>
                </li>
                <li>
                    <a href="index.php">
                        <?php 
                        echo "<span>".$row[4]."</span>"; 
                        ?>
                    </a>              
                </li>
                <li>
                    <a href="student_show.php" class="darkblue">Student Management</a>
                </li>
                <li>
                    <a href="user.php">Show All Users</a>
                </li>
                <li>
                    <a href="assignment.php">Assignments</a>
                </li>
                <li>
                    <a href="challenge.php" id="bchallenge">Puzzle Game</a>
                </li>
                <li>
                    <a href="changeinfo.php" >Change Info</a>
                </li>
                <li>
                    <a href="changepwd.php" >Change Password</a>
                </li>
                <li>
                    <a href="../logout.php">Log out</a>
                </li>
            </ul>

    </div>

    <!-- modifying students'information form -->
    <div class="content displaynone" id="stu-modification">
        <a href="student_show.php" class="add">Back</a>
        <form method="post" action=""  class="addition">
			<p>Edit Student Info</p>
            <!-- <span  class="err"> <?php echo $err ?> </span> -->
			<?php echo "<span class='err'>".$username_err."</span>" ?>
			<input type="text" name="username"  placeholder="Username" value="<?php echo $username?>" >
            <?php echo "<span class='err'>".$password_err."</span>" ?>
			<input type="password" name="password"  placeholder="Password" value="<?php echo $password?>" >
            <?php echo "<span class='err'>".$name_err."</span>" ?>
			<input type="text" name="name"  placeholder="Name" value="<?php echo $name?>" >
            <?php echo "<span class='err'>".$email_err."</span>" ?>
			<input type="text" name="email"  placeholder="Email" value="<?php echo $email?>" >
            <?php echo "<span class='err'>".$phonenumber_err."</span>" ?>
			<input type="text" name="phonenumber"  placeholder="Phone number" value="<?php echo $phonenumber?>" >
			<input type="submit" value="Save edits" name="modification">
        </form>
    </div>


</body>
</html>