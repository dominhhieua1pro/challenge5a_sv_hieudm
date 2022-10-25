<?php
session_start();
include("../config/connect.php");
require_once("../config/user.php");
$id = $_SESSION["id"];
$sql = "SELECT * FROM tbluser WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_array(MYSQLI_NUM);
$name = $row[4];
$id_guest = "";
$name_guest = $username_guest = $email_guest = $phonenumber_guest = "";
$messagelist = "";

// get guest id
    if(isset($_GET["idguest"])){
        $id_guest = $_GET["idguest"];

        $sql = "SELECT * FROM tbluser WHERE id = '$id_guest'";
        $result = $conn->query($sql);
        $row = $result->fetch_array(MYSQLI_NUM);
        $username_guest = $row[1];
        $name_guest = $row[4];
        $phonenumber_guest = $row[5];
        $email_guest = $row[6];


        $sql2 = "";
        $sql2 .= "  SELECT * FROM message WHERE id_sender='$id' AND id_reciever='$id_guest' UNION
                    SELECT * FROM message WHERE id_sender='$id_guest' AND id_reciever='$id'
                    ORDER BY id";
        $result = $conn->query($sql2);
        $row = $result->num_rows;
        while($row = $result->fetch_array(MYSQLI_NUM)){
            if($row[1]==$id){
                $messagelist .= "<form action='' method='POST'>";
                $messagelist .= "<span>".$name."</span><br>";
                $messagelist .= "<input type='text' name='message' value='".$row[3]."' >";
                $messagelist .= "<input type='hidden' name='id' value='".$row[0]."' />";
                $messagelist .= "<input type='submit' class='msg-edit' name='edit' value='Edit'>";
                $messagelist .= "<input type='submit' class='msg-delete' name='delete' value='Delete'>";
                $messagelist .= "</form>";
            }else if($row[1]==$id_guest){
                $messagelist .= "<form action='' method='POST'>";
                $messagelist .= "<span>".$name_guest."</span><br>";
                $messagelist .= "<input type='text' name='message' value='".$row[3]."' disabled>";
                $messagelist .= "</form>";
            }
        }	
    }


// click send new message
if(isset($_POST["send"])){
    if ($content = $_POST["newmessage"]){
        $content = htmlspecialchars($content, ENT_QUOTES);
        $sql = "INSERT INTO message(id_sender,id_reciever,content) VALUES ('$id','$id_guest','$content')";
        if($result = $conn->query($sql)){
            header("location: ./message.php?idguest=".$id_guest."");
        }else {
            $err="*Failed to send message";
            echo "<script type='text/javascript'>alert('$err');</script>";
        }
    }
}

// click edit message
if(isset($_POST["edit"])){
    $id_sender = $_POST["id"];
    $content = $_POST["message"];
    $sql = "UPDATE message SET content='$content' WHERE id='$id_sender'";
    if($result = $conn->query($sql)){
        header("location: ./message.php?idguest=".$id_guest."");
    }else {
        $err="*Failed to edit message";
        echo "<script type='text/javascript'>alert('$err');</script>";
    }
}

// click delete message
if(isset($_POST["delete"])){
    $id_sender = $_POST["id"];
    $sql = "DELETE FROM message WHERE id='$id_sender'";
    if($result = $conn->query($sql)){
        header("location: ./message.php?idguest=".$id_guest."");
    }else {
        $err="*Failed to delete message";
        echo "<script type='text/javascript'>alert('$err');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Message</title>
    <link rel="stylesheet" href="teacher_style.css">
    <script src="https://kit.fontawesome.com/50e4937a61.js" crossorigin="anonymous"></script>
</head>
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
                    <a href="user.php" class="darkblue">Show All Users</a>
                </li>
                <li>
                    <a href="assignment.php">Assignments</a>
                </li>
                <li>
                    <a href="challenge.php" id="bchallenge">Puzzle Game</a>
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
 
 
	<div class="container">
		<div class="row">
			<a href="user.php" class="add" style="float:right;">Back</a>
		</div>
		<div class="row"> 
			<p> Name: <?php echo $name_guest;?></p>
			<p> Phone number: <?php echo $phonenumber_guest;?></p>
			<p> Email: <?php echo $email_guest;?></p>
		</div>
		<div id="message-scroll" class="row" style="height:400px; margin-top:40px; overflow: scroll;">
            <?php
                echo $messagelist;
            ?>          
		</div>
        <div class="row type-msg">
            <form action="" method="POST">
                <!-- <span class="err"> <?php echo $err; ?> </span> -->
                <input type="text" name="newmessage" placeholder="Type message here...">
                <input type="submit" class='msg-send' name="send" value="Send">
            </form> 
        </div>	

        <script>
                var objDiv = document.getElementById("message-scroll");
                objDiv.scrollTop = objDiv.scrollHeight;
        </script>

	</div>

</body>
</html> 