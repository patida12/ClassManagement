<?php include './index.php'; ?>

<body>
    <div class="tab-content">
        <?php require_once './dbConnection.php'; 
        $conn = DbConnection::getConnection();
        if (isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $id = $_GET['id'];
            
            $querySubmission = "SELECT id FROM submission WHERE idAssignment=$id";
            $resultSubmission = mysqli_query($conn,$querySubmission);

            if($resultSubmission) {
                while($rowSubmission = $resultSubmission->fetch_assoc())
                {
                    $idSubmission = $rowSubmission['id'];
                    $query = "DELETE FROM submission WHERE id=$idSubmission";
                    $result = mysqli_query($conn,$query);
                }
            }
            else 
            {
                echo '<h2>Failt!</h2>';
            }

            $query = "DELETE FROM assignment WHERE id=$id";
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
    <a href="assignment.php"><button class="btn btn-primary">Back</button></a>
    </div>
</body>

