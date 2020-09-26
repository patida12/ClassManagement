<?php include './index.php'; 
require_once './dbConnection.php';
$conn = DbConnection::getConnection();
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$idEdit = $_POST['idEdit'];
		$idSender = $_POST['idSender'];
		$idReceiver = $_POST['idReceiver'];
		$receiver = $_POST['receiver'];
        $messageEdit = $_POST['messageEdit'];
        if (!empty($messageEdit)) {
			$query = "UPDATE mbox SET message='{$messageEdit}' WHERE id=$idEdit";
			$result = $conn->query($query);
			if($result) {
                echo '<h2 class="tab-content">Success! Your message has been updated!</h2>';
			}
			else {
				echo "<h2 class='tab-content'>Error! Edit Failed." . "<pre>{$conn->error}</pre></h2>";
			}
		} 
		else {
			echo '<h2 class="tab-content">Please enter new message.</h2>';
        }
    }
    DbConnection::closeConnection($conn);
?>

<form action="sendMess.php" id="form_upload" method="POST" class="tab-content">   
	<input type="hidden" name="idSender" style="margin-top: 1%; margin-bottom: 1%;" value="<?php echo $idSender; ?>" />
	<input type="hidden" name="idReceiver" style="margin-top: 1%; margin-bottom: 1%;" value="<?php echo $idReceiver; ?>" />
	<input type="hidden" name="nameReceiver" style="margin-top: 1%; margin-bottom: 1%;" value="<?php echo $receiver ?>" />
	<input type="submit" name="submit" value="Back" class="btn btn-primary"><br>
</form>