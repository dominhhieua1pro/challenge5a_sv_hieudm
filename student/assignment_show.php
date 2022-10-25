<?php
session_start();
include("../config/user.php");
include("../config/connect.php");
$assignment_list = "";
    
// show assignment list
$sql = "SELECT * FROM tblassignment, tbluser WHERE tblassignment.idteacher=tbluser.id";
$result = $conn->query($sql);
$id_tmp = $sql_tmp = $row_tmp = '';

while($row = $result->fetch_array(MYSQLI_NUM)) { 
    // process each row
    $assignment_list .= "<th>".$row[9]."</th>";
    $assignment_list .= "<th>".$row[1]."</th>";
    $assignment_list .= "<th>".$row[4]."</th>";
    $assignment_list .= "<th> <a href='../uploads/".$row[3]."' download>Download</th>";
    $assignment_list .= "<th> <a href='assignment_upload.php?id=".$row[0]."'> Submit </a> </th>";
    $assignment_list .= "</tr>";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Assignment</title>
    <link rel="stylesheet" href="student_style.css">
    <script src="https://kit.fontawesome.com/50e4937a61.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- side bar  -->
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
                <a href="assignment_show.php" class="darkblue">Assignments</a>
            </li>
            <li>
                <a href="challenge.php" >Puzzle Challenges</a>
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
        <div id="asgm-scroll" class="assignment-list">
            <table>
                <tr>
                    <th>Teacher</th>
                    <th>Title</th>
                    <th>Time</th>
                    <th>Assignment</th>
                    <th></th>
                </tr>
                <?php 
                    echo $assignment_list;
                ?>
            </table>
        </div>
    </div>

    <script>
            var objDiv = document.getElementById("asgm-scroll");
            objDiv.scrollTop = objDiv.scrollHeight;
    </script>

</body>
</html>