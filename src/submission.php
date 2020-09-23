<?php include './index.php'; 
    include './permission.php';  
    require_once './dbConnection.php';

    $permission = Permission::hasPermission();
    $link = DbConnection::getConnection();

    function getListSubmission($idAssignment) 
    {
        $link = DbConnection::getConnection();
        $sqlSubmission = "SELECT * FROM submission WHERE idAssignment=$idAssignment";
        $submission = $link->query($sqlSubmission);
        DbConnection::closeConnection($link);
        return $submission;
    }
    function getStudentName($idStudent) 
    {
        $link = DbConnection::getConnection();
        $sql = "SELECT fullname FROM users WHERE id=$idStudent";
        $student = $link->query($sql);
        DbConnection::closeConnection($link);
        return $student;
    }
    if (isset($_GET['id']) && is_numeric($_GET['id']))
    {
        $id = $_GET['id'];
        $type = "";
        if ($permission) $type = "assignment";
        else $type = "submission";
        $submission = getListSubmission($id);
        if($submission) {
            if(!$permission) {
                ?>
                <form class="tab-content" action="upload.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="<?php echo $type; ?>" />
                    <input type="hidden" name="idAssignment" value="<?php echo $id; ?>" />
                    <input type="file" name="uploaded_file"><br>
                    <input type="submit" value="Upload file">
                </form>
                <?php
            }
            else {
                if($submission->num_rows == 0) {
                    echo '<h2 class="tab-content">There are no submission!</h2>';
                }
                else {
        ?>

<body class="link-tab">
  <section>
    <div class="tab-content">
    <h2>List submission</h2>
        <br>
        <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table id="table" class="table table-hover table-bordered table-striped table-inverse table-wrapper-scroll-y" cellspacing="0">
            <thead class="thead-inverse">
                <tr style="background-color: #555; color: white;">
                    <th>STT</th>
                    <th>Student</th>
                    <th>Description</th>
                    <th>Created</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $index = 0;
                    while($row = $submission->fetch_assoc())
                    {
                        $result = getStudentName($row['idStudent']);
                        $student = $result->fetch_assoc();
                        $index++;
                        echo "<tr>";
                        echo "<td>{$index}</td>";
                        echo "<td>{$student['fullname']}</td>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td>{$row['created']}</td>";
                        echo '<td>';
                ?>
                <?php
                        echo '<a style="color: white;" href="download.php?id=' . $row['id'] . '&type=submission">'
                ?>
                <button class="btn btn-primary btn-sm">Download</button></a></td>
                <?php       
                    }
                    $submission->free();
                        DbConnection::closeConnection($link);
                    }
                }
            }
                ?>
            </tbody>
        </table>
        </div>
    
</div>
<a class="tab-content" href="assignment.php"><button class="btn btn-primary">Back</button></a>
</section>
</body>
<?php 
}
else {                           
    header('Location: assignment.php');
}
?>
