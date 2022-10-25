<?php
session_start();
include("../config/connect.php");
require_once("../config/user.php");
$challenge_list = $title = $hint = $description = "";
$id = $_SESSION["id"];
// click submit assignment 
if(isset($_POST["submit"])){
    $title = $_POST["title"];
    $hint = $_POST["hint"];
    $description = $_POST["description"];

    if(!empty($title) && !empty($hint)){
        // check whether chose file yet
        if(!empty($_FILES["file"]["name"])){
            $targetDir = "../challenge/";
            $fileNameTmp = basename($_FILES["file"]["name"]);
            $fileName = $title.".".$fileNameTmp;
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            
            $allowTypes = array('txt');
            // check format
            if(in_array($fileType, $allowTypes)){

                if($_FILES["file"]["size"] > 2097152){
                    $err = "*Your file is too large. Maximum file size is 2MB!";
                    echo "<script type='text/javascript'>alert('$err');</script>";
                }else{
                    // upload file to server
                    if(file_exists("$targetFilePath")) unlink("$targetFilePath");
                    $sql = "INSERT INTO tblchallenge (id_teacher, title, description, hint, updateon) VALUES('$id','$title', '$description', '$hint', NOW())";
                    if($conn->query($sql)==true){
                        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                            $success = "Upload puzzle challenge successfully!";         
                            echo "<script type='text/javascript'>alert('$success'); window.location='challenge.php';</script>";                   
                        }else{
                            $err = "There was an error while uploading your file";
                            echo "<script type='text/javascript'>alert('$err'); </script>";
                        }                            
                    }else{
                        $err = "Upload challenge failed. Please try again!";
                        echo "<script type='text/javascript'>alert('$err'); </script>";
                    } 
                }  
            }else{
                $err = "Only txt files are allowed to upload.";
                echo "<script type='text/javascript'>alert('$err'); </script>";
            }
        }else{
            $err = "Please select a file to upload";
            echo "<script type='text/javascript'>alert('$err'); </script>";
        }
    }else{
        $err = "*Title or Hint can not be empty";
        echo "<script type='text/javascript'>alert('$err'); </script>";
    }
    
}

// // show challenge list
// $sql = "SELECT * FROM tblchallenge WHERE id_teacher='$id'";
// $result = $conn->query($sql);
// while($row = $result->fetch_array(MYSQLI_NUM)) { 
//     // process each row
//     $challenge_list .= "<tr>";
//     $challenge_list .= "<th>".$row[2]."</th>";
//     $challenge_list .= "<th>".$row[4]."</th>";
//     // $challenge_list .= "<th> <a href=''> Xem danh sach</a> </th>";
//     $challenge_list .= "</tr>";
// }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puzzle Challenge</title>
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
        <a href="challenge_show.php?action=show" class="add">View all challenges</a>
        <form action="" method="post" enctype="multipart/form-data" class="assignment">
            <p>Puzzle Challenge</p>
            <label for="title">Title</label> 
            <input type="text" id="title" name="title" placeholder="Title" value="<?php echo $title;?>"><br><br>
            <label for="description">Challenge description</label><br><br>
            <textarea id="description" name="description" rows="4" cols="42"><?php echo $description;?></textarea><br><br>
            <label for="hint">Hint</label><br><br>
            <textarea id="hint" name="hint" rows="3" cols="42"><?php echo $hint;?></textarea><br><br>
            <label for="myfile">Select file</label> 
            <input type="file" id="myfile" name="file"><br><br>
			<input type="submit" value="Upload challenge" name="submit"><br><br>
            <!-- <span class="err"> <?php echo $err ?> </span> -->
		</form>

        <!-- <div class="assignment-list">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Time</th>
                </tr>
                <?php 
                    echo $challenge_list;
                ?>
            </table>
        </div> -->
    </div>

</body>
</html>