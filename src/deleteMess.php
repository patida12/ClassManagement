<?php include './index.php'; 
    require_once './users.php';
    require_once './dbConnection.php'; 
    $conn = DbConnection::getConnection();
    if (isset($_GET['id']) && is_numeric($_GET['id']))
    {
        $id = $_GET['id'];
        $query = "SELECT idSender, idReceiver FROM mbox WHERE id=$id";
        $result = $conn->query($query);

        if($result) {
            while($row = $result->fetch_assoc())
            {
                $idReceiver = $row['idReceiver'];
                $idSender = $row['idSender'];
                $user = User::getById($idReceiver);
                $nameReceiver = $user->getUserName();
            }
        }
        else {
            echo "<h2 class='tab-content'>Error! Delete Failed." . "<pre>{$conn->error}</pre></h2>";
        }   

        $query = "DELETE FROM mbox WHERE id=$id";
        $result = mysqli_query($conn,$query);
        if($result) {
            echo '<h2 class="tab-content">Success! Your message has been deleted!</h2>';
        }
        else {
            echo "<h2 class='tab-content'>Error! Delete Failed." . "<pre>{$conn->error}</pre></h2>";
        }   
    }
    DbConnection::closeConnection($conn);
?>

<form action="sendMess.php" id="form_upload" method="POST" class="tab-content">   
	<input type="hidden" name="idSender" style="margin-top: 1%; margin-bottom: 1%;" value="<?php echo $idSender; ?>" />
	<input type="hidden" name="idReceiver" style="margin-top: 1%; margin-bottom: 1%;" value="<?php echo $idReceiver; ?>" />
	<input type="hidden" name="nameReceiver" style="margin-top: 1%; margin-bottom: 1%;" value="<?php echo $nameReceiver ?>" />
	<input type="submit" name="submit" value="Back" class="btn btn-primary"><br>
</form>
