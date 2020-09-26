<?php include './index.php';
    include './permission.php';  
    require_once './dbConnection.php';

    $permission = Permission::hasPermission();
    $conn = DbConnection::getConnection();

function deleteQuiz($id) {
    $conn = DbConnection::getConnection();
    $query = "DELETE FROM quizs WHERE id=$id";
    $result = $conn->query($query);
    if($result) {
        echo '<h2 class="tab-content">Bạn đã xóa thành công!</h2>';
    }
    else {
        echo 'Error! Failed to delete the file'
            . "<pre>{$conn->error}</pre>";
    }
    DbConnection::closeConnection($conn);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $error = array();
    $description = $_POST['description'];
    $target_dir = "./quizs/";
    $name = $_FILES['fileUpload']['name'];
    $target_file = $target_dir . basename($_FILES['fileUpload']['name']);

    $type_file = pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);
    $type_fileAllow = array('txt');
    if (!in_array(strtolower($type_file), $type_fileAllow)) {
        echo '<h2 class="tab-content">File bạn vừa chọn hệ thống không hỗ trợ, bạn vui lòng chọn file .txt</h2>';
    }
    else
    {
        if (file_exists($target_file)) {
            $createdFile = date ("Y-m-d H:i:s", filemtime($target_file));
            $query = "SELECT id, description, created FROM quizs WHERE created='{$createdFile}'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $newFile = fopen($_FILES["fileUpload"]["tmp_name"],'r');
                $body = "";
                while ($line = fgets($newFile)) {
                    $body = $body . $line;
                }
                fclose($newFile);

                $oldFile = fopen($target_file, 'w');
                fwrite($oldFile, $body);
                fclose($oldFile);

                $query = "UPDATE quizs SET description = '{$description}', created = NOW() WHERE created='{$createdFile}'";
                $result = $conn->query($query);
                if($result) {
                    echo '<h2 class="tab-content">Upload Success!</h2>';
                }
                else {
                    echo 'Error! Failed to insert the file.'
                        . "<pre>{$conn->error}</pre>";
                }
            }
            else {
                echo 'Error!'
                        . "<pre>{$conn->error}</pre>";
            }
            
        }
        else {
            if (empty($error)) {
                if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) {
                    $query = "INSERT INTO quizs (description, created) VALUES ('{$description}',  NOW())";
                    $result = $conn->query($query);
                    if($result) {
                        echo '<h2 class="tab-content">Upload Success!</h2>';
                    }
                    else {
                        echo 'Error! Failed to insert the file'
                            . "<pre>{$conn->error}</pre>";
                    }
                } else {
                    echo '<h2 class="tab-content">Failt!</h2>';
                }
            }
        }

        
    }  
}
?>

<body>
<section>
<div class="tab-content">
    <?php
    if($permission) {
    ?>
        <form action="quizs.php" id="form_upload" method="POST" enctype="multipart/form-data">
            <input type="file" name="fileUpload"  id="fileUpload" >
            <br><br>     
            <h4><b>Description:</b></h4>
            <textarea rows="5" id="description" name="description" style="width: 80%;"></textarea><br>
            <input type="submit" name="submit" class="btn btn-primary" style="margin-top: 1%; margin-bottom: 1%;"><br>
        </form>
        <?php
    }
    $sqlQuiz = 'SELECT id, description, created FROM quizs';
    $quizs = $conn->query($sqlQuiz);
    if($quizs->num_rows == 0) {
        echo '<h2>There are no assignment!</h2>';
    }
    else {

    ?>
        <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table id="table" class="table table-hover table-bordered table-striped table-inverse table-wrapper-scroll-y" cellspacing="0">
            <thead class="thead-inverse">
                <tr style="background-color: #555; color: white;">
                    <th>STT</th>
                    <th>Question</th>
                    <th>Created</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $index = 0;
                    while($row = $quizs->fetch_assoc())
                    {
                        $index++;
                        echo "<tr>";
                        echo "<td>{$index}</td>";
                        echo '<td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal' .  $index . '">Question ' .  $index . ' </button>
                                <div class="modal" id="myModal' .  $index . '">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                    
                                        <div class="modal-header">
                                        <h4 class="modal-title">Question ' .  $index . ' </h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
            
                                        <div class="modal-body">
                                        <p>' . $row["description"] . '</p>
                                        
                                        </div>
            
                                        <div class="modal-footer">
                                        <form action="answerQuiz.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="created" value="' . $row["created"] . '" />
                                            <label>Answer here...(Viet khong dau, moi tu cach nhau 1 dau cach, vi du: tra loi)</label>
                                            <input type="text" name="submission" style="margin-bottom: 3%;" ><br>
                                            <input type="submit" value="Submit" class="btn btn-primary">
                                        </form>
                                        </div>
                                        
                                    </div>
                                    </div>
                                </div>
                            </td>
                            <td>' . $row['created'] . '</td>';
                            if ($permission) {
                                echo '<td>
                                        <a style="color: white;" href="editQuiz.php?id=' . $row['id'] . '">
                                        <button class="btn btn-warning btn-sm">Edit</button></a>
                                        <a style="color: white;" href="deleteQuiz.php?id=' . $row['id'] . '&created=' . $row['created'] . '">';
                            ?>
                                        <button onclick="return  confirm('Do you want to delete this student?')" class="btn btn-danger btn-sm">Delete</button></a>
                                    </td>
                            <?php
                            }
                
                ?>
                <?php        
                    }
                    $assignment->free();
                        DbConnection::closeConnection($conn);
                }

                ?>
            </tbody>
            
        </table>
        <a href="index.php"><button class="btn btn-primary">Back</button></a>
        </div>
</div>
</section>
</body>