<?php
 
    session_start();
    require_once "dbConnection.php";
    $conn = DbConnection::getConnection();
 
    if (isset($_POST["enter_pin"]))
    {
        $pin = $_POST["pin"];
        $user_id = $_SESSION["id"];
 
        $sql = "SELECT * FROM users WHERE id = '$user_id' AND pin = '$pin'";
        $result = mysqli_query($conn, $sql);
 
        if (mysqli_num_rows($result) > 0)
        {
            $sql = "UPDATE users SET pin = '' WHERE id = '$user_id'";
            mysqli_query($conn, $sql);
 
            $_SESSION["loggedin"] = true;
            header("Location: index.php");
        }
        else
        {
            echo "<h2>Wrong pin!</h2>";
        }
    }
 
?>
<html>
<?php include './head.php'; 
?>

<body>
    <div style="top: 15%;" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: blue; color: white;">
                <h3 class="modal-title">Enter pin!</h3>
            </div>
            <div class="modal-body">
                <div class="container">
                <form method="POST" action="enter-pin.php">
                    <input type="text" name="pin">
                    
                    <input type="submit" name="enter_pin">
                </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
