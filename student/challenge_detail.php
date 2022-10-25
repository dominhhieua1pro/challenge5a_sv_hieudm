<?php
session_start();
include("../config/connect.php");
require_once("../config/user.php");
$title = $description = $hint = $result_chall = "";

// get information of the challenge
if(isset($_GET["id"])){
    $chall_id = $_GET["id"];
    $sql = "SELECT * FROM tblchallenge WHERE id = '$chall_id'";
    $result = $conn->query($sql);
    while($row = $result->fetch_array(MYSQLI_NUM)){
        $title = $row[2];
        $hint = $row[4];
        $description = $row[3];
    }
}

if(isset($_POST["submit"])){
    $result_chall = $_POST["result"];
    $folder = "../challenge/";
    $list = scandir($folder);
    $len = count($list);
    for ($i=0 ; $i < $len ; $i++ ) { 
        // echo $list[$i];
        // echo $title;
        $arr = explode('.',$list[$i]);
        if($title == $arr[0] && $arr[1] == $result_chall){
            header("location: ./challenge_result.php?challenge-id=".$chall_id."&file-name=".$list[$i]."");
            exit();
        }else{
            $err = "*Wrong answer!";
            echo "<script type='text/javascript'>alert('$err'); window.location.href='challenge_detail.php?id='+$chall_id</script>";
            // header("location:challenge_detail.php?id=".$chal_id);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenge Details</title>
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
                <a href="assignment_show.php" >Assignments</a>
            </li>
            <li>
                <a href="challenge.php" class="darkblue" >Puzzle Challenges</a>
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

        <form action="" method="post" enctype="multipart/form-data">
            <p style="text-align:center;">Challenge Title <br /> <?php echo $title;?></p>
            <span style="display:block; font-size: 18px; margin-top: 32px">Description: <?php echo $description;?> </span> <br><br>
            <span style="display:block; font-size: 18px; line-height: 10px">Hint: <?php echo $hint;?> </span> <br><br>
            <span style="display:block; font-size: 18px; line-height: 10px">Type your result below:</span><br>
            <textarea id="result" name="result" rows="2" cols="42"><?php echo $result_chall;?></textarea><br><br>
			<input type="submit" value="Submit" name="submit"><br><br>
        </form>    
    </div>

</body>
</html>