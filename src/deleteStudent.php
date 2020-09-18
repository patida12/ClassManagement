<html>
<?php include './head.php'; ?>
<body>
<div class="container">
    <?php require_once './dbConnection.php'; 
        $conn = DbConnection::getConnection();
        if (isset($_GET['id']) && is_numeric($_GET['id']))
        {
        $id = $_GET['id'];
        
        $query = "DELETE FROM users WHERE id=$id";
        $result = mysqli_query($conn,$query);
            if ($result)
            {
                //header('Location: ' . $_SERVER['HTTP_REFERER']);
                echo '<script>alert("Delete success!")</script>';
            }
            else 
            {
                echo "<div class='alert alert-danger' role='alert'>";
                echo "<h4 class='alert-heading'>Delete fail!</h4>";;
                echo "</div>";
            }
        
            
        }
        DbConnection::closeConnection($conn);
    ?>
    
</div>
</body>
</html>
