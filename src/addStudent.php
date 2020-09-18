<html>
<?php include './head.php'; ?>

<body>
    <div class="container">
        <?php require_once './dbConnection.php'; 
        if(isset($_POST['btnSubmit']))
        {
            $conn = DbConnection::getConnection();
            $username = htmlspecialchars(trim($_POST['username']));
            $password = $_POST['password'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $phonenumber = $_POST['phonenumber'];
            $query = "INSERT INTO users
            VALUES 
            (null, '$username','$password','$fullname','$email','$phonenumber');";
            
            $result = mysqli_query($conn,$query);
            if ($result)
            {
                echo '<script>alert("Add student success!")</script>';
                header('Location: index.php');
            }
            else 
            {
                echo "<div class='alert alert-danger' role='alert'>";
                echo "<h4 class='alert-heading'>Add fail!</h4>";;
                echo "</div>";
            }
            DbConnection::closeConnection($conn);
        }
        
    ?>
        <form action="#" method="post">
            <div class="form-group">
                <label for="username">Username: </label>
                <input type="text" name="username" class="form-control" placeholder="Enter username..." required>
            </div>
            <div class="form-group">
                <label for="password">Password: </label>
                <input type="password" class="form-control" name="password" placeholder="Enter password: " required>
            </div>
            <div class="form-group">
                <label for="fullname">Full Name: </label>
                <input type="text" name="fullname" class="form-control" placeholder="Enter your full name..." required>
            </div>
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="email" class="form-control" name="email" aria-describedby="emailHelpId"
                    placeholder="Enter email...">
                <small id="emailHelpId" class="form-text text-muted">Help text</small>
            </div>
            <div class="form-group">
                <label for="phonenumber">Phone number: </label>
                <input type="text" name="phonenumber" class="form-control" placeholder="Enter phone number...">
            </div>
            <button type="submit" class="btn btn-primary" name="btnSubmit" s>Add</button>
        </form>
    </div>
</body>

</html>