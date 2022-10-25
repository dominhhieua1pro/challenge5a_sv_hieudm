<?php
session_start();
include("../config/connect.php");
require_once("../config/user.php");
// get information of the challenge
if(isset($_GET["file-name"])){
    $file_name = $_GET["file-name"];
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenge Result</title>
    <link rel="stylesheet" href="student_style.css">
    <script src="https://kit.fontawesome.com/50e4937a61.js" crossorigin="anonymous"></script>
</head>
<body style="background-color:powderblue;">
    <!-- side bar  -->
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
                <a href="assignment_show.php" >Assignments</a>
            </li>
            <li>
                <a href="challenge.php" class="darkblue">Puzzle Challenges</a>
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

    <!-- assignment tab -->
    <div class="content">
        <a href="challenge.php" class="add">Back</a>

        <div style="background-color: #d1ebe6; box-sizing:unset; margin: -20px; padding: 20px;">
            <p>Correct Answer!!!<br/> </p>
            <p>File content</p>
            <?php
                $file = fopen("../challenge/".$file_name,"r");

                while(!feof($file)){
                    echo fgets($file). "<br />";
                }
                
                fclose($file);
            ?>
        </div>  
    </div>

</body>
</html>