<?php
session_start();
include("../config/connect.php");
require_once("../config/user.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome teacher</title>
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
                <a href="student_show.php" >Student Management</a>
            </li>
            <li>
                <a href="user.php">Show All Users</a>
            </li>
            <li>
                <a href="assignment.php">Assignments</a>
            </li>
            <li>
                <a href="challenge.php">Puzzle Game</a>
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

    <!-- home form -->
    <div class="content" id="home">
        <div style="position:absolute;top:35%;left:40%;transform:transfer(-50%,-50%);">
            <p style="font-size:30px;font-style:bold;">Welcome <?php echo $row[4]?></p>
            <p style="font-size:30px;font-style:bold;">You are a teacher</p>
        </div>
    </div>

</body>
</html> 