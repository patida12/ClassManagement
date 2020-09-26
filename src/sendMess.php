<?php include './index.php'; 
include './session.php';
require_once './dbConnection.php';

    $conn = DbConnection::getConnection();
    
    if(isset($_POST['btnSubmit'])) {
        $message = $_POST['message'];
		$idSender = $_POST['idSender'];
		$idReceiver = $_POST['idReceiver'];
        
		if (!empty($message)) {
			$query = "INSERT INTO mbox (message, idSender, idReceiver, created) VALUES ('{$message}', '{$idSender}', {$idReceiver}, NOW())";
			$result = $conn->query($query);
			if($result) {
				echo 'OK';
			}
			else {
				echo "Error! Add Failed." . "<pre>{$conn->error}</pre>";
			}
		} 
		else {
			echo '<h2>Please enter message.</h2>';
		}
	}
?>

<body>
  <section  class="mbox">
    <div class="tab-content">
        <?php
            $result = false;
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $idSender = $_POST['idSender'];
                $idReceiver = $_POST['idReceiver'];
                $sender = $_SESSION['username'];
                $receiver = $_POST['nameReceiver'];

                $query = "SELECT id FROM mbox WHERE idSender=$idReceiver AND idReceiver=$idSender";
                $result = $conn->query($query);
                if($result) {
                    while($row = $result->fetch_assoc())
                    {
                        $idMess = $row['id'];
                        $queryUpdate = "UPDATE mbox SET isRead=true WHERE id=$idMess";
                        $resultUpdate = $conn->query($queryUpdate);
                    }
                }

                $query = "SELECT * FROM mbox WHERE (idSender=$idSender AND idReceiver=$idReceiver) OR (idSender=$idReceiver AND idReceiver=$idSender)";
                $result = $conn->query($query);
            }
            if($result) {
                while($row = $result->fetch_assoc())
                {
                    if ($idSender == $row['idSender']){         
                        echo '<div class="container send btn btn-primary" type="button" data-toggle="collapse" data-target="#mess' . $row['id'] . '">';
                        echo $row['message'] . " " . ":<strong><i class='fa fa-user-circle'>$sender</i></strong>";
                        echo '<br><span class="time-right">' . $row['created'] .'</span>
                        </div>';
                        echo '<div id="mess' . $row['id'] . '" class="collapse" style="float:right; margin: 10px 0;"> 
                        <button class="btn btn-warning btn-sm" data-toggle="collapse" data-target="#edit' . $row['id'] . '">Edit</button>';
                        ?>
                        <form action="editMess.php" method="POST" id="edit<?php echo $row['id'] ?>" class="collapse">  
                            <input type="hidden" name="idSender" value="<?php echo $idSender; ?>" />
                            <input type="hidden" name="idReceiver" value="<?php echo $idReceiver; ?>" />
                            <input type="hidden" name="nameReceiver" value="<?php echo $receiver ?>" /> 
                            <input type="hidden" name="idEdit" value="<?php echo $row['id'] ?>" />
                            <textarea rows="3" id="messageEdit" name="messageEdit" style="width: 100%;"></textarea><br>
                            <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 1%; margin-bottom: 1%;">Submit</button>
                        </form>
                        <a style="color: white;" href="deleteMess.php?id=<?php echo $row['id'] ?>">
                        <button onclick="return  confirm('Do you want to delete this message?')" class="btn btn-danger btn-sm">Delete</button>
                        </a>
                        </div>
                        <?php
                        echo '<br>';
                        
                    }

                    if ($idReceiver == $row['idSender']){
                        echo '<div class="container receive">';
                        echo "<strong><i class='fa fa-user-circle'>$receiver</i></strong>:" . " " .$row['message'];
                        echo '<br><span class="time-left">' . $row['created'] .'</span>
                        </div>';
                        echo '<br>';
                    }  
                }
                    echo '<div class="container box-message">';
        ?>
        
                    <form action="#" method="POST">   
                        <input type="hidden" name="idSender" style="margin-top: 1%; margin-bottom: 1%;" value="<?php echo $idSender; ?>" />
                        <input type="hidden" name="idReceiver" style="margin-top: 1%; margin-bottom: 1%;" value="<?php echo $idReceiver; ?>" />
                        <textarea rows="3" id="message" name="message" style="width: 100%;"></textarea><br>
                        <button type="submit" class="btn btn-primary" name="btnSubmit" style="margin-top: 1%; margin-bottom: 1%;">Send</button> 
                    </form>
                    </div>
        <?php
                }
            else {
                echo 'Error! Failed.' . "<pre>{$conn->error}</pre>";
            }
            DbConnection::closeConnection($conn);
            ?>
 
        </div>
    </section>
</body>


