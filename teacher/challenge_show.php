<?php
session_start();
include("../config/connect.php");
require_once("../config/user.php");
$puzzle_list = "";
$id = $_SESSION["id"];

if(isset($_GET["action"])){
    if($_GET["action"]=="show"){
        $sql = "SELECT * FROM tblchallenge";
        $result = $conn->query($sql);
        while($row = $result->fetch_array(MYSQLI_NUM)) { 
            // process each row
            $puzzle_list .= "<tr>";
            $id_tmp = $row[1];
            $sql_tmp = "SELECT * FROM tbluser WHERE id = '$id_tmp'";
            $result_tmp = $conn->query($sql_tmp);
            $row_tmp = $result_tmp->fetch_array(MYSQLI_NUM);
            $puzzle_list .= "<th>".$row_tmp[4]."</th>";

            $puzzle_list .= "<th>".$row[2]."</th>";
            $puzzle_list .= "<th>".$row[3]."</th>";
            $puzzle_list .= "<th>".$row[4]."</th>";
            $puzzle_list .= "<th>".$row[5]."</th>";
            $puzzle_list .= "</tr>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show challenges</title>
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
                <a href="assignment.php" >Assignments</a>
            </li>
            <li>
                <a href="challenge.php" class="darkblue">Puzzle Game</a>
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
        <a href="challenge.php" class="add">Back</a>
        <div id="assignment-scroll" class="assignmentSubmitted-list">
            <table>
                <tr>
                    <th>Teacher</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Hint</th>
                    <th>Time</th>
                </tr>
                <?php 
                    echo $puzzle_list;
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