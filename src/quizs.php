<?php include './index.php';
    include './permission.php';  
    require_once './dbConnection.php';

    $permission = Permission::hasPermission();
    $link = DbConnection::getConnection();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $error = array();
    $description = $_POST['description'];
    $target_dir = "./quizs/";
    $target_file = $target_dir . basename($_FILES['fileUpload']['name']);

    $type_file = pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);
    $type_fileAllow = array('txt');
    if (!in_array(strtolower($type_file), $type_fileAllow)) {
        echo '<h2 class="tab-content">File bạn vừa chọn hệ thống không hỗ trợ, bạn vui lòng chọn hình ảnh</h2>';
    }
    else
    {
        if (file_exists($target_file)) {
            echo '<h2 class="tab-content">File bạn chọn đã tồn tại trên hệ thống</h2>';
        }
        else 
        {
            if (empty($error)) {
                if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) {
                    $query = "INSERT INTO quizs (description, created) VALUES ('{$description}',  NOW())";
                    $result = $link->query($query);
                    if($result) {
                        echo '<h2 class="tab-content">Bạn đã upload file thành công</h2>';
                    }
                    else {
                        echo 'Error! Failed to insert the file'
                            . "<pre>{$link->error}</pre>";
                    }
                } else {
                    echo '<h2 class="tab-content">File bạn vừa upload gặp sự cố</h2>';
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
            <textarea rows="5" id="description" name="description" style="width: 50%;"></textarea><br>
            <input type="submit" name="submit" class="btn btn-primary" style="margin-top: 1%; margin-bottom: 1%;"><br>
        </form>
        <?php
    }
    $sqlQuiz = 'SELECT id, description, created FROM quizs';
    $quizs = $link->query($sqlQuiz);
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
                        </div></td>';
                        echo "<td>{$row['created']}</td>";
                ?>
                <?php        
                    }
                    $assignment->free();
                        DbConnection::closeConnection($link);
                }

                ?>
            </tbody>
            
        </table><a href="index.php"><button class="btn btn-primary">Back</button></a>
        </div>

</div>
</section>
</body>