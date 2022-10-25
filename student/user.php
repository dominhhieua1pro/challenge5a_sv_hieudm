<?php
session_start();
include("../config/connect.php");
require_once("../config/user.php");
$id = $_SESSION["id"];
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Show all users</title>
    <link rel="stylesheet" href="student_style.css">
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
                <a href="user.php" class="darkblue">View All Users</a>
            </li>
            <li>
                <a href="assignment_show.php">Assignments</a>
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
 
	<div class="content" id="user">
		<table border="1" style="border:1 solid black;margin-left:auto;margin-right:auto;">
			<tr>
				  <th>ID</th>
				  <th>Username</th>
				  <th>Name</th>
				  <th>Position</th>
				  <th>Phone Number</th>
				  <th>Email</th>
				  <th>Avatar</th>
				  <th>Function</th>
				  </tr>
			<?php
				$sql = "SELECT id, avatar, username, name, pnumber, email, pos FROM tbluser";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
				  
				  // output data of each row
				  while($row = $result->fetch_assoc()) { ?>
				    <tr>
			    		<td><?php echo $row["id"] ?></td>
			    		<td><?php echo $row["username"]?></td>
			    		<td><?php echo $row["name"]?></td> 
			    		<td><?php if ($row["pos"] == 1) echo 'Teacher'; else echo 'Student' ?></td> 
			    		<td><?php echo $row["pnumber"] ?></td> 
			    		<td><?php echo $row["email"] ?></td>
						<td><?php echo $row["avatar"]?></td>
			    		<td><button> <a class="send-message" href='message.php?idguest=<?php echo $row['id']?> '>Send message</a></button></td>
			    	</tr>
				  <?php }
				  
				} else {
				  echo "0 results";
				}
				$conn->close();
			?>

		</table>
	</div>
	

</body>
</html> 