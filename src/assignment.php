<html>
<?php include './head.php'; 
    include './permission.php';  
    include './dbConnection.php';

    $permission = Permission::hasPermission();
    $link = DbConnection::getConnection();
    $type = ""; 

    if ($permission) {
        $type = "assignment";
    }
    else {
        $type = "submission";
    }
    $sqlAssignment = 'SELECT id, name, mime, size, created, type FROM assignment WHERE type = "assignment"';
    $assignment = $link->query($sqlAssignment);
    if($assignment) {
        if($permission) {
            ?>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="type" value="<?php echo $type; ?>" />
                <input type="file" name="uploaded_file"><br>
                <input type="submit" value="Upload file">
            </form>
            <?php
        }
        if($assignment->num_rows == 0) {
            echo '<h2>There are no assignment!</h2>';
        }
        else {
    ?>

  <body class="link-tab">
  <section>
    <div class="tab-content">
    <h2>List Assignment</h2>
        <br>
        <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table id="table" class="table table-hover table-bordered table-striped table-inverse table-wrapper-scroll-y" cellspacing="0">
            <thead class="thead-inverse">
                <tr style="background-color: #555; color: white;">
                    <th>STT</th>
                    <th>Description</th>
                    <th>Created</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $index = 0;
                    while($row = $assignment->fetch_assoc())
                    {
                        $index++;
                        echo "<tr>";
                        echo "<td>{$index}</td>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td>{$row['created']}</td>";
                        echo '<td>';
                ?>
                <?php
                        echo '<a style="color: white;" href="download.php?id=' . $row['id'] . '&type=assignment">'
                ?>
                <button class="btn btn-primary btn-sm">Download</button></a>
                <?php              
                        echo '<a style="color: white;" href="submission.php?id=' . $row['id'] . '">' ;
                ?>
                        <button class="btn btn-info btn-sm">Submission</button></a></td>
                <?php        
                    }
                    $assignment->free();
                        DbConnection::closeConnection($link);
                }
            }
                ?>
            </tbody>
        </table>
        </div>
    <a href="index.php"><button class="btn btn-primary">Back</button></a>
</div>
</section>
</body>
</html>