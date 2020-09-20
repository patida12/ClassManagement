<html>
<?php include './head.php'; 
    include './permission.php';
    $permission = Permission::hasPermission();
?>

<section>
    <div class="tab-content">
        <?php
            if ($permission) {
                echo '<div style="margin-bottom: 10px;">
                        <div class="col-sm-12">
                            <a style="color: white; margin-left: -14px;" href="addStudent.php">
                                <button class="btn btn-primary">Add new</button>
                            </a>
                        </div>
                    </div>';    
            }
        ?>
        <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table id="users" class="table table-hover table-bordered table-striped table-inverse table-wrapper-scroll-y" cellspacing="0">
            <thead class="thead-inverse">
                <tr style="background-color: #555; color: white;">
                    <th>STT</th>
                    <th>User Name</th>
                    <th>Full Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php require_once './users.php';
                    $users = User::getStudents();
                    $index = 0;
                    foreach($users as $user)
                    {
                        $index++;
                        echo "<tr>";
                        echo "<td>{$index}</td>";
                        echo "<td>{$user->getUserName()}</td>";
                        echo "<td>{$user->getFullName()}</td>";
                        echo '<td>';
                ?>
                <?php
                        echo '<a style="color: white;" href="details.php?id=' . $user->getId() . '">' 
                ?>
                        <button class="btn btn-info btn-sm">Details</button>
                <?php
                if ($permission) {
                        echo '<a style="color: white;" href="editStudent.php?id=' . $user->getId() . '">' 
                ?>
                        <button class="btn btn-warning btn-sm">Edit</button>
                <?php echo '</a>
                        <a style="color: white;" href="deleteStudent.php?id=' . $user->getId() . '">' 
                ?>
                        <button onclick="return  confirm('Do you want to delete this student?')" class="btn btn-danger btn-sm">Delete</button></a>
                <?php echo '</td>';
                        }   
                    }
                ?>
            </tbody>
        </table>
            </div>
    </div>
</section>

</html>