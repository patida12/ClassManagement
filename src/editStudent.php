<html>
<?php include './head.php'; ?>
<body>
<div class="container">
    <?php require_once './dbConnection.php'; 
          require_once './users.php';
        
        $conn = DbConnection::getConnection();
        $id = 0;
        $user = new User();
        if (isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $id = $_GET['id'];
            $user = User::getById($id);
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
                //header('Location: index.php#');
            }
            else 
            {
                echo "<div class='alert alert-danger' role='alert'>";
                echo "<h4 class='alert-heading'>Edit fail!</h4>";;
                echo "</div>";
            }
            DbConnection::closeConnection($conn);
        }
        DbConnection::closeConnection($conn);
    ?>  
    <form action="#" method="post" class="was-validated">
        <div class="form-group">
            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        </div>
        <div class="form-group">
          <label for="username">Username: </label>
          <input type="text" name="username" class="form-control"  value="<?php echo $user->getUserName(); ?>" placeholder="Enter username..." required>
          <div class="valid-feedback">Valid.</div>
          <div class="invalid-feedback">Please fill out this field.</div>
        </div>
        <div class="form-group">
          <label for="password">Password: </label>
          <input type="password" class="form-control" name="password"  value="<?php echo $user->getPassword(); ?>" placeholder="Enter password: " required>
          <div class="valid-feedback">Valid.</div>
          <div class="invalid-feedback">Please fill out this field.</div>
        </div>
          <div class="form-group">
            <label for="fullname">Full Name: </label>
            <input type="text" name="fullname" class="form-control"  value="<?php echo $user->getFullName(); ?>" placeholder="Enter your full name..." required>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>  
        </div>
          <div class="form-group">
            <label for="email">Email: </label>
            <input type="email" class="form-control" name="email"  value="<?php echo $user->getEmail(); ?>" aria-describedby="emailHelpId" placeholder="Enter email...">
            <small id="emailHelpId" class="form-text text-muted">Help text</small>
          </div>
          <div class="form-group">
            <label for="phonenumber">Phone number: </label>
            <input type="text" name="phonenumber" class="form-control"  value="<?php echo $user->getPhoneNumber(); ?>" placeholder="Enter phone number...">
          </div>
          <button type="submit" class="btn btn-primary" name="btnSubmit"s>Save</button>
    </form>
</div>
</body>
</html>
