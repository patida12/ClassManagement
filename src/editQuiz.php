<?php include './index.php';
    include './permission.php';  
    require_once './dbConnection.php';

    $permission = Permission::hasPermission();
    $link = DbConnection::getConnection();
    if (isset($_GET['id']) && is_numeric($_GET['id']))
    {
        $id = $_GET['id'];
        if(isset($_POST['btnSubmit'])) {
            $description = $_POST['editedDescription'];
    
            $query = "UPDATE quizs SET description = '{$description}' WHERE id=$id";
            $result = $link->query($query);
            if($result) {
                echo '<h2 class="tab-content">Bạn đã sửa thành công</h2>';
            }
            else {
                echo 'Error! Failed to insert the file'
                    . "<pre>{$link->error}</pre>";
            }
        }
    }
    
?>

<body>
<section>
<div class="tab-content">
    <form action="#" method="POST">    
        <h4><b>Description:</b></h4>
        <textarea rows="5" id="editedDescription" name="editedDescription" style="width: 80%;"></textarea><br>
        <button type="submit" class="btn btn-success" name="btnSubmit" style="margin-top: 1%; margin-bottom: 1%;">Save</button> 
    </form>
    <a href="quizs.php"><button class="btn btn-primary">Back</button></a>
</div>
</section>
</body>