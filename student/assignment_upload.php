<?php
    session_start();
    include("../config/connect.php");
    require_once("../config/user.php");
    
    $assign_title = "";
    if(isset($_GET["id"])){
        $id_assign = $_GET["id"];
        $sql = "SELECT * FROM tblassignment WHERE id='$id_assign'";
        $result = $conn->query($sql);
        $row = $result->fetch_array(MYSQLI_NUM);
        $assign_title = $row[1];
    }

    // click submit assignment 
    if(!empty($_POST["submit"])){
        // check whether chose file yet
        if(!empty($_FILES["file"]["name"])){
            $targetDir = "../uploads/";
            $fileName = basename($_FILES["file"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            $allowTypes = array('doc','docx','pdf','pptx', 'txt');
            
            if(in_array($fileType, $allowTypes)){
                if($_FILES["file"]["size"] > 2097152){
                    $err = "*Your file is too large. Maximum file size is 2MB!";
                    echo "<script type='text/javascript'>alert('$err'); </script>";
                }else{
                    // upload file to server
                    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                        $id_stu = $_SESSION["id"];
                        $sql = "INSERT INTO tblsubmit (id_assign,id_stu, filename, updateon) VALUES('$id_assign','$id_stu','$fileName',NOW())";
                        if($conn->query($sql)==true){
                            $err = "Assignment uploaded successfully!";
                            echo "<script type='text/javascript'>alert('$err'); window.location='assignment_upload.php';</script>";
                        }else{
                            $err = "Assignment uploaded failed. Please try again!";
                            echo "<script type='text/javascript'>alert('$err'); </script>";
                        }
                    }else{
                        $err = "There was an error while uploading your assignment";
                        echo "<script type='text/javascript'>alert('$err'); </script>";
                    }
                }              
            }else{
                $err = "Only doc, docx, pdf, pptx, txt files are allowed to upload.";
                echo "<script type='text/javascript'>alert('$err'); </script>";
            }
        }else{
            $err = "Please select a file to upload";
            echo "<script type='text/javascript'>alert('$err');</script>";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Assignment</title>
    <link rel="stylesheet" href="student_style.css">
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
    <div class="content">
        <a href="assignment_show.php" class="add">Back</a>
        <form action="" class="asgm-upload" method="post" enctype="multipart/form-data" >
            <p style="text-align:center; margin-bottom: 30px;"> Assignment <br /> <?php echo $assign_title; ?> </p>
            <label for="avatar">Upload your assignment here</label>
            <input style="position: relative;left: 50%; transform: translateX(-50%);" type="file" id="myfile" name="file"><br><br>
			<input type="submit" value="Upload" name="submit"><br><br>
            
		</form>
    </div>

</body>
</html>