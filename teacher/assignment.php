<?php
session_start();
include("../config/connect.php");
require_once("../config/user.php");

$assignment_list = "";
$id = $_SESSION["id"];

// click submit assignment 
if(isset($_POST["submit"])){
    // check whether chosen file yet
    if(!empty($_FILES["file"]["name"])){
        $targetDir = "../uploads/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir.$fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        $title = $_POST["title"];
        $allowTypes = array('doc','docx','pdf','pptx', 'txt');
        // check format
        if(in_array($fileType, $allowTypes)){
            if($_FILES["file"]["size"] > 2097152){
                $err = "*Your file is too large. Maximum file size is 2MB!";
                echo "<script type='text/javascript'>alert('$err'); </script>";
            }elseif(empty($title)){
                $err = "*Title can not be empty";
                echo "<script type='text/javascript'>alert('$err'); </script>";
            }else{
                // upload file to server
                $id = $_SESSION["id"];
                $sql = "INSERT INTO tblassignment (title,idteacher, filename, updateon) VALUES('$title','$id','$fileName',NOW())";
                if($conn->query($sql) && move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                    $err = "Upload assignment successfully!";
                    echo "<script type='text/javascript'>alert('$err'); window.location='assignment.php'; </script>";
                }else{
                    $err = "Upload assignment failed. Please try again!";
                    echo "<script type='text/javascript'>alert('$err'); </script>";
                }
            }            
        }else{
            $err = "Only doc, docx, pdf, pptx, txt files are allowed to upload.";
            echo "<script type='text/javascript'>alert('$err'); </script>";
        }
    }else{
        $err = "Please select a file to upload";
        echo "<script type='text/javascript'>alert('$err'); </script>";
    }
}

// show assignment list
$sql = "SELECT * FROM tblassignment WHERE idteacher='$id'";
$result = $conn->query($sql);
$id_tmp = $sql_tmp = $row_tmp = '';

while($row = $result->fetch_array(MYSQLI_NUM)) { 
    // process each row
    $assignment_list .= "<tr>";
    $id_tmp = $row[2];
    $sql_tmp = "SELECT * FROM tbluser WHERE id = '$id_tmp'";
    $result_tmp = $conn->query($sql_tmp);
    $row_tmp = $result_tmp->fetch_array(MYSQLI_NUM);

    $assignment_list .= "<th>".$row_tmp[4]."</th>";
    $assignment_list .= "<th> <a href='../uploads/".$row[3]."' download>".$row[1]."</th>";
    $assignment_list .= "<th>".$row[4]."</th>";
    $assignment_list .= "<th> <a class='assignment-list' href='assignment_show.php?action=show&id=".$row[0]."'>View the list of submitted assignments</a> </th>";
    $assignment_list .= "</tr>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment</title>
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
        <form action="" method="post" enctype="multipart/form-data" class="assignment">
            <p>Assignment</p>
            <label for="title">Title</label> 
            <input type="text" id="title" name="title" placeholder="Title"><br><br>
            <label for="myfile">Select file</label> 
            <input type="file" id="myfile" name="file"><br><br>
			<input type="submit" value="Upload new" name="submit"><br><br>
            <!-- <span class="err"> <?php echo $err ?> </span> -->
		</form>

        <div id="assignment-scroll" class="assignment-list">
            <table>
                <tr>
                    <th>Teacher</th>
                    <th>Title</th>
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