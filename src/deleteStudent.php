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
                echo '<script>alert("Delete success!")</script>';
                header('Location: index.php');
            }
            else 
            {
                echo '<script>alert("Delete failt!")</script>';
                header('Location: index.php');
            }
        
            
        }
        DbConnection::closeConnection($conn);
    ?>

    </div>
</body>

</html>