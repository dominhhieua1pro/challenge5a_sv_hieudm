<?php
session_start();
include("../config/connect.php");
require_once("../config/user.php");

$id = $_SESSION["id"];
$oldpwd_err = $newpwd_err = $reenternewpwd_err = '';

// click change password
if(isset($_POST["chpwd"])){
	$oldpwd = trim($_POST["oldpwd"]);
    $newpwd = trim($_POST["newpwd"]);
    $reenternewpwd = trim($_POST["reenternewpwd"]);

    if(empty($oldpwd) || empty($newpwd) || empty($reenternewpwd)){
        $err = "*Fill out the blanks!";
        echo "<script type='text/javascript'>alert('$err');</script>";
    }
    else {
        $oldpwd_encrypted = md5($oldpwd);
        $newpwd_encrypted = md5($newpwd);
        $reenternewpwd_encrypted = md5($reenternewpwd);

        $sql = "SELECT * FROM tbluser WHERE id = '$id' AND password = '$oldpwd_encrypted'";
        $result = $conn->query($sql);
        $count = $result->num_rows;
        
        if($count>0){
            if ($oldpwd_encrypted == $newpwd_encrypted) {
                $err = "The new password cannot be same as the old password.";
                echo "<script type='text/javascript'>alert('$err');</script>";
            }
            else if($newpwd_encrypted == $reenternewpwd_encrypted) {
                $sql = "UPDATE tbluser SET password = '$newpwd_encrypted' WHERE id = '$id'";
                if($conn->query($sql) == true){
                    $err = "Change password successfully!";
                    echo "<script type='text/javascript'>alert('$err'); window.location='changepwd.php';</script>";
                }else {
                    $err = "Change password failed!";
                    echo "<script type='text/javascript'>alert('$err');</script>";
                }
            } else 
                $err = "The confirmation password does not match the new password.";
                echo "<script type='text/javascript'>alert('$err');</script>";                
        }else{
            $err = "The current password you entered is incorrect. Please try again!";
            echo "<script type='text/javascript'>alert('$err');</script>";
        }
    }
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change password</title>
    <link rel="stylesheet" href="student_style.css">
    <script src="https://kit.fontawesome.com/50e4937a61.js" crossorigin="anonymous"></script>
</head>
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
                <a href="changeinfo.php" >Change Info</a>
            </li>
			<li>
                <a href="changepwd.php" class="darkblue">Change Password</a>
			</li>
			<li>
                <a href="../logout.php">Log out</a>
            </li>
        </ul>
	</div>

            
        
    </div>

    <div class="content">
        <form action="" method="post">
			<!-- <span class="err"> <?php echo $err; ?> </span> <br><br> -->
            <p class="changepwd-text" >Change password</p>
			<label for="oldpwd">Current password:</label><br>
			<input type="password" name="oldpwd" placeholder="Current password"><br>
			<label for="newpwd">New password</label><br>
			<input type="password" name="newpwd" placeholder="New password"><br>
            <label for="reenternewpwd">Confirm password</label><br>
			<input type="password" name="reenternewpwd" placeholder="Confirm password"><br>
			<input type="submit" class="changeInfo" value="Save password" name="chpwd">
		</form>
    </div>

</body>
</html> 