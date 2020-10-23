<?php include './index.php'; 
    include './permission.php';  
    include './dbConnection.php';

    $permission = Permission::hasPermission();
    $conn = DbConnection::getConnection();
    $type = ""; 

    if ($permission) {
        $type = "assignment";
    }
    else {
        $type = "submission";
    }
    $sqlAssignment = 'SELECT id, name, mime, size, created, type FROM assignment WHERE type = "assignment"';
    $assignment = $conn->query($sqlAssignment);
    if($assignment) {
        if($permission) {
            ?>
            <form class="tab-content" action="upload.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="type" value="<?php echo $type; ?>" />
                <input type="file" name="uploaded_file"><br>
                <input type="submit" value="Upload file" style="margin-top: 1%;">
            </form>
            <?php
        }
        if($assignment->num_rows == 0) {
            echo '<h2 class="tab-content">There are no assignment!</h2>';
        }
        else {
    ?>

  <body>
  <section>
    <div class="tab-content">
    <h2>List Assignment</h2>
        <br>
        <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table id="table" class="table table-hover table-bordered table-striped table-inverse table-wrapper-scroll-y" cellspacing="0">
            <thead class="thead-inverse">
                <tr style="background-color: #555; color: white;">
                    <th>STT</th>
                    <th>Assigment</th>
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
                        <button class="btn btn-info btn-sm">Submission</button></a>
                <?php if ($permission) {
                        echo '<a style="color: white;" href="deleteAssignment.php?id=' . $row['id'] . '">';
                ?>
                        <button onclick="return  confirm('Do you want to delete this assignment?')" class="btn btn-danger btn-sm">Delete</button></a>
                <?php
                    }
                ?>
                <?php echo '</td>';        
                    }
                    $assignment->free();
                    DbConnection::closeConnection($conn);
                }
            }
                ?>
            </tbody>
            
        </table><a href="index.php"><button class="btn btn-primary">Back</button></a>
        </div>

</div>
</section>
</body>
