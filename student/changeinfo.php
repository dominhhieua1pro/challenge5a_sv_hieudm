<?php
session_start();
include("../config/connect.php");
require_once("../config/user.php");
    
$msg = "";
$id = $_SESSION["id"];
$sql = "SELECT * FROM tbluser WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_array(MYSQLI_NUM);
$name = $row["4"];
$username = $row["1"];
$phonenumber = $row["5"];
$email = $row["6"];
$avatar = $row["7"];
$username_err = $name_err = $phonenumber_err = $email_err = "";

// click change info
if(isset($_POST["update"])){
	// $email = $_POST["email"];
    // $name = $_POST["name"];
    // $username = $_POST["username"];
	// $phonenumber = $_POST["phonenumber"];
    $filename = $_FILES["uploadFile"]["name"];
    $tempname = $_FILES["uploadFile"]["tmp_name"];    
    $targetFilePath = "../image/avatars/".$filename;
    // $targetFilePath = $targetDir.$fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    $allowTypes = array('jpg', 'png', 'gif', 'jpeg');

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
    if(!empty(trim($_POST["email"])) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email_err = "*Invalid email format";
        echo "<script type='text/javascript'>alert('$email_err');</script>";
    } 
    
    if(!empty(trim($_POST["phonenumber"])) && !preg_match("/^[0]{1}[0-9]{9}$/", $phonenumber)){
        $phonenumber_err = "*Invalid phone number format";
        echo "<script type='text/javascript'>alert('$phonenumber_err');</script>";
    } 

    if (!$username_err && !$name_err && !$email_err && !$phonenumber_err ){
        if(!empty($filename) && in_array($fileType, $allowTypes)){
            $sql = "UPDATE tbluser SET email = '$email', pnumber = '$phonenumber', avatar = '$filename' WHERE id = '$id'";
            //check file upload
            if($conn->query($sql) == true && move_uploaded_file($tempname, $targetFilePath)){
                $msg = "Avatar uploaded successfully!";
                echo "<script type='text/javascript'>alert('$msg');</script>";
                echo '<script language="javascript">alert("Change info successfully!"); window.location="changeinfo.php";</script>';
            }else {
                $err = "Change info failed!";
                echo "<script type='text/javascript'>alert('$err');</script>";
            }
	    }else if (!empty($filename)) {
            $err = "Only jpg, png, jpeg, gif avatar files are allowed to upload.";
            echo "<script type='text/javascript'>alert('$err');</script>";
        }else {
            $sql = "UPDATE tbluser SET email = '$email', pnumber = '$phonenumber' WHERE id = '$id'";
            if($conn->query($sql) == true){
                echo '<script language="javascript">alert("Change info successfully!"); window.location="changeinfo.php";</script>';
            }else {
                $err = "Change info failed!";
                echo "<script type='text/javascript'>alert('$err');</script>";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change infomation</title>
    <link rel="stylesheet" href="student_style.css">
    <script src="https://kit.fontawesome.com/50e4937a61.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="sidebar" >
        <ul class="menu">
            <li>              
                <?php 
                    $id = $_SESSION["id"];
                    $sql = "SELECT * FROM tbluser WHERE id = '$id'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_array(MYSQLI_NUM);
                    echo '<a href="index.php"> <img src="../image/avatars/'.($row[7] ? $row[7] : "default-avatar.png").'" class="avatar" alt=""> </a>';
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
                <a href="user.php" >View All Users</a>
            </li>
            <li>
                <a href="assignment_show.php">Assignments</a>
            </li>
            <li>
                <a href="challenge.php" >Puzzle Challenges</a>
            </li>
			<li>
                <a href="changeinfo.php" class="darkblue">Change Info</a>
            </li>
			<li>
                <a href="changepwd.php" >Change Password</a>
			</li>
			<li>
                <a href="../logout.php">Log out</a>
            </li>
        </ul>
	</div>

    <div class="content">
        <form action="changeinfo.php" method="post" enctype="multipart/form-data">
            <!-- <span class="err"> <?php echo $err; ?> </span><br><br> -->
			<p>Information student<br /> <?php echo $name ?> </p>	
            <label for="username">Username</label><br>
            <input type="text" class="username-readonly" name="username" value="<?php echo $username?>" disabled><br>
            <label for="name">Name</label><br>
            <input type="text" class="name-readonly" name="name" value="<?php echo $name?>" disabled><br>
			<label for="email">Email</label><br>
			<input type="text" name="email" value="<?php echo $email?>"><br>
			<label for="phonenumber">Phone number</label><br>
			<input type="text" name="phonenumber" value="<?php echo $phonenumber?>"><br>
            <label for="avatar">Upload avatar</label>
            <input type="file" name="uploadFile" value="<?php echo $avatar?>"><br><br>
            <input type="submit" class="changeInfo" value="Save info" name="update">
		</form>
    </div>


</body>
</html>  

