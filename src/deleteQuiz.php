<?php include './index.php'; ?>

<body>
    <div class="tab-content">
        <?php require_once './dbConnection.php'; 
        $conn = DbConnection::getConnection();
        if (isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $id = $_GET['id'];
            $created = $_GET['created'];
            foreach (glob("./quizs/*") as $filename) {
                $createdFile = date ("Y-m-d H:i:s", filemtime($filename));
                if($created == $createdFile) {
                    $status = unlink($filename);
                    if ($status){
                        $query = "DELETE FROM quizs WHERE id=$id";
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
                } else {
                    echo '<h2>Failt!</h2>';
                }
                break;
            }
                echo '<a href="quizs.php"><button class="btn btn-primary">Back</button></a>';
        }
        
        DbConnection::closeConnection($conn);
    ?>
    </div>
</body>
