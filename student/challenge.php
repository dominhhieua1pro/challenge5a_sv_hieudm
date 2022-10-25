<?php
session_start();
include("../config/connect.php");
require_once("../config/user.php");
$challenge_list = "";

// show assignment list
$sql = "SELECT * FROM tblchallenge, tbluser WHERE tblchallenge.id_teacher = tbluser.id";
$result = $conn->query($sql);
while($row = $result->fetch_array(MYSQLI_NUM)) { 
    // process each row
    $challenge_list .= "<tr>";
    $challenge_list .= "<th>".$row[10]."</th>";
    $challenge_list .= "<th>".$row[2]."</th>";
    $challenge_list .= "<th>".$row[5]."</th>";
    $challenge_list .= "<th> <a href='challenge_detail.php?id=".$row[0]."'> More details & Answer </a> </th>";
    $challenge_list .= "</tr>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puzzle challenges</title>
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
    <div class="content" id="assignment">
        <div class="assignment-list">
            <table>
                <tr>
                    <th>Teacher</th>
                    <th>Title</th>
                    <th>Time</th>
                    <th></th>
                </tr>
                <?php 
                    echo $challenge_list;
                ?>
            </table>
        </div>
    </div>

</body>
</html>