<?php include './index.php'; 
require_once './dbConnection.php';
$link = DbConnection::getConnection();
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $idEdit = $_POST['idEdit'];
        $messageEdit = $_POST['messageEdit'];
        if (!empty($messageEdit)) {
			$query = "UPDATE mbox SET message='{$messageEdit}' WHERE id=$idEdit";
			$result = $link->query($query);
			if($result) {
                echo '<h2 class="tab-content">Success! Your message has been updated!</h2>';
			}
			else {
				echo "<h2 class='tab-content'>Error! Edit Failed." . "<pre>{$link->error}</pre></h2>";
			}
		} 
		else {
			echo '<h2 class="tab-content">Please enter new message.</h2>';
        }
    }
    DbConnection::closeConnection($conn);
?>
<a href='javascript:history.back(1);'><button type="button" class="btn btn-primary tab-content">Back</button></a>