<?php
session_start();
include("../config/connect.php");
require_once("../config/user.php");
$student_list = "";
$pos = 2;
$username = $password = $name = $phonenumber = $email = "";

if(isset($_GET["action"])){
    if($_GET["action"] == "delete"){
        $id = $_GET["id"];
        $sql = "DELETE FROM tbluser WHERE id = '$id'";
        if($conn->query($sql) == true){     
            $message = "Delete student sucessfully!";
            echo "<script type='text/javascript'>alert('$message'); window.location='student_show.php';</script>";
        }else {
            $message = "Failed to delete!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
}


// get students list
$sql = "SELECT * FROM tbluser WHERE pos = '$pos'";
$result = $conn->query($sql);
        
while($row = $result->fetch_array(MYSQLI_NUM)) { 
    // process each row
    $student_list .= "<tr>";
    // $student_list .= "<th>".$row[0]."</th>";
    // $student_list .= "<th>".$row[1]."</th>";
    // $student_list .= "<th>".$row[2]."</th>";
    // $student_list .= "<th>".$row[3]."</th>";
    $student_list .= "<th>".$row[4]."</th>";
    $student_list .= "<th>".$row[5]."</th>";
    $student_list .= "<th>".$row[6]."</th>";
    $student_list .= "<th> <a class='students-list__edit' href='student_edit.php?action=edit&id=".$row[0]."'> Edit </a> </th>";
    $student_list .= "<th> <a class='students-list__delete' href='student_show.php?action=delete&id=".$row[0]."'> Delete </a> </th>";
    $student_list .= "</tr>";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show students</title>
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

    <!-- student form -->
    <div class="content">
        <a href="student_add.php" class="add">Add student</a>
        <div id="assignment-scroll" class="students-list">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
					<th></th>
					<th></th>
                </tr>
                <?php 
                    echo $student_list;
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