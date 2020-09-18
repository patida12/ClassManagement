<html>
<?php include './head.php'; ?>

<section>
    <div class="tab-content">
        <div style="margin-bottom: 10px; margin-top: 10px;">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#modalAdd">Add Student</button>
                <div class="modal fade" id="modalAdd">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        
                            <!-- Modal Header -->
                            <div class="modal-header">
                            <h4 class="modal-title">Enter new student's information!</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            
                            <!-- Modal body -->
                            <div class="modal-body">
                            <?php include './addStudent.php'; ?>
                            </div>
                            
                            <!-- Modal footer -->
                            <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table id="users" class="table table-hover table-bordered table-striped table-inverse">
            <thead class="thead-inverse">
                <tr style="background-color: #555; color: white;">
                    <th>User Name</th>
                    <th>Password</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php require_once './users.php';
                $users = User::getAll();
                foreach($users as $user)
                {
                    echo "<tr>";
                    echo "<td>{$user->getUserName()}</td>";
                    echo "<td>{$user->getPassword()}</td>";
                    echo "<td>{$user->getFullName()}</td>";
                    echo "<td>{$user->getEmail()}</td>";
                    echo "<td>{$user->getPhoneNumber()}</td>";
                    echo '<td><a style="color: white;" href="editStudent.php?id=' . $user->getId() . '"><button class="btn btn-warning btn-sm">Edit</button></a>
                              <a style="color: white;" href="deleteStudent.php?id=' . $user->getId() . '"><button class="btn btn-danger btn-sm">Delete</button></a>
                          </td>';
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

    </div>
</section>

</html>
