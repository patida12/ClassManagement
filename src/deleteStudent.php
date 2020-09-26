<?php include './index.php'; ?>

<body>
    <div class="tab-content">
        <?php require_once './dbConnection.php'; 
        $conn = DbConnection::getConnection();
        if (isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $id = $_GET['id'];
            
            $query = "DELETE FROM users WHERE id=$id";
            $result = mysqli_query($conn,$query);
            if ($result)
            {
                echo '<h2>Delete success!</h2>';
            }
            else 
            {
                echo '<h2>Failt!</h2>';
            }
        }
        DbConnection::closeConnection($conn);
    ?>
    <a href="getAllStudents.php"><button class="btn btn-primary">Back</button></a>
    </div>
</body>

