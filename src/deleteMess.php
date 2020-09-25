<?php include './index.php'; 
    require_once './dbConnection.php'; 
    $conn = DbConnection::getConnection();
    if (isset($_GET['id']) && is_numeric($_GET['id']))
    {
        $id = $_GET['id'];
        
        $query = "DELETE FROM mbox WHERE id=$id";
        $result = mysqli_query($conn,$query);
        if($result) {
            echo '<h2 class="tab-content">Success! Your message has been deleted!</h2>';
        }
        else {
            echo "<h2 class='tab-content'>Error! Delete Failed." . "<pre>{$link->error}</pre></h2>";
        }   
    }
    DbConnection::closeConnection($conn);
?>
<a href='javascript:history.back(1);'><button type="button" class="btn btn-primary tab-content">Back</button></a>
