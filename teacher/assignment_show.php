<?php
session_start();
include("../config/connect.php");
require_once("../config/user.php");
$assignment_list = "";
$id = $_SESSION["id"];

if(isset($_GET["action"])){
    if($_GET["action"]=="show"){
        $id_assign = $_GET["id"];
        $sql = "SELECT tblsubmit.filename, tbluser.name, tblsubmit.updateon FROM tblsubmit, tbluser 
                WHERE tbluser.id = tblsubmit.id_stu AND tblsubmit.id_assign = '$id_assign'";
        $result = $conn->query($sql);
        while($row = $result->fetch_array(MYSQLI_NUM)) { 
            // process each row
            $assignment_list .= "<tr>";
            $assignment_list .= "<th>".$row[1]."</th>";
            $assignment_list .= "<th>".$row[2]."</th>";
            $assignment_list .= "<th> <a href='../uploads/".$row[0]."' download> Download </a> </th>";
            $assignment_list .= "</tr>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show assignments</title>
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
                <a href="assignment.php" class="darkblue">Assignments</a>
            </li>
            <li>
                <a href="challenge.php" >Puzzle Game</a>
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
        <a href="assignment.php" class="add">Back</a>
        <div id="assignment-scroll" class="assignmentSubmitted-list">
            <table>
                <tr>
                    <th>Student</th>
                    <th>Time</th>
                    <th>Assignment</th>
                </tr>
                <?php 
                    echo $assignment_list;
                ?>
            </table>
        </div>
    </div>

    <script>
            var objDiv = document.getElementById("assignment-scroll");
            objDiv.scrollTop = objDiv.scrollHeight;
    </script>

</body>
</html>