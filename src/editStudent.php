<html>
<?php include './head.php'; ?>

<body>
    <h4 style="text-align: center;">Edit student's information</h4>
    <div class="container">
        <?php require_once './dbConnection.php'; 
          require_once './users.php';
        $conn = DbConnection::getConnection();
        if (isset($_GET['id']) && is_numeric($_GET['id']))
        {
          $id = $_GET['id'];
          $sql = "SELECT * FROM users WHERE id=$id";
          $result = mysqli_query($conn, $sql);
          if (mysqli_num_rows($result) == 1) {
            while($row = mysqli_fetch_assoc($result)) {
                $user = new User($row['id'], $row['username'], $row['password'], $row['fullname'], $row['email'], $row['phonenumber']);
            }
          }
          if(isset($_POST['btnSubmit']))
          {
              $conn = DbConnection::getConnection();
              $id = $_POST['id'];
              $username = htmlspecialchars(trim($_POST['username']));
              $password = $_POST['password'];
              $fullname = $_POST['fullname'];
              $email = $_POST['email'];
              $phonenumber = $_POST['phonenumber'];
              $query = "UPDATE users SET username='$username', password='$password', fullname='$fullname', email='$email', phonenumber='$phonenumber' WHERE id='$id';";
              
              $result = mysqli_query($conn,$query);
              if ($result)
              {
                  echo '<script>alert("Edit success!")</script>';
                  header('Location: index.php');
              }
              else 
              {
                echo '<script>alert("Edit fail!")</script>';
                header('Location: index.php');
              }
              DbConnection::closeConnection($conn);
          }
        }
        DbConnection::closeConnection($conn);
    ?>

        <form action="#" method="post">
            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
            </div>
            <div class="form-group">
                <label for="username">Username: </label>
                <input type="text" name="username" class="form-control" value="<?php echo $user->getUserName(); ?>"
                    placeholder="Enter username..." required>
            </div>
            <div class="form-group">
                <label for="password">Password: </label>
                <input type="password" class="form-control" name="password" value="<?php echo $user->getPassword(); ?>"
                    placeholder="Enter password: " required>
            </div>
            <div class="form-group">
                <label for="fullname">Full Name: </label>
                <input type="text" name="fullname" class="form-control" value="<?php echo $user->getFullName(); ?>"
                    placeholder="Enter your full name..." required>
            </div>
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="email" class="form-control" name="email" value="<?php echo $user->getEmail(); ?>"
                    aria-describedby="emailHelpId" placeholder="Enter email...">
                <small id="emailHelpId" class="form-text text-muted">Help text</small>
            </div>
            <div class="form-group">
                <label for="phonenumber">Phone number: </label>
                <input type="text" name="phonenumber" class="form-control"
                    value="<?php echo $user->getPhoneNumber(); ?>" placeholder="Enter phone number...">
            </div>
            <button type="submit" class="btn btn-primary" name="btnSubmit">Save</button>
            <button class="btn btn-warning" type="submit" style="color: white;"> <a href="#" onclick="history.back();">Back</a></button>

        </form>

    </div>
</body>

</html>