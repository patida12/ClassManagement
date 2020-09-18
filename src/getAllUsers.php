<html>
<?php include './head.php'; ?>

<?php require_once './users.php'; ?>
<section>
    <div class="tab-content">
        <div style="margin-bottom: 10px; margin-top: 10px;">
            <div class="col-sm-12">
                <form action="addStudent.php">
                    <button type="submit" class="btn btn-primary">Add Student</button>
                </form>
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
                <?php
          $users = User::getAll();
          foreach($users as $user)
          {
            echo "<tr>";
            echo "<td>{$user->getUserName()}</td>";
            echo "<td>{$user->getPassword()}</td>";
            echo "<td>{$user->getFullName()}</td>";
            echo "<td>{$user->getEmail()}</td>";
            echo "<td>{$user->getPhoneNumber()}</td>";
            echo "<td>{$user->getPhoneNumber()}</td>";
            echo "</tr>";
          }
        ?>
            </tbody>
        </table>

    </div>
</section>

</html>
