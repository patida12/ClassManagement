<?php include './index.php'; ?>

<body>
    <div class="modal-dialog"> 
        <div class="modal-content">
            <div class="modal-header"  style="background-color: blue; color: white;">
            <h4 class="modal-title">Enter student's information!</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <?php require_once './dbConnection.php'; 
                        require_once './users.php';
                        $conn = DbConnection::getConnection();

                        $username = $fullname = $password = $confirm_password = $email = $phonenumber = "";
                        $username_err = $fullname_err = $password_err = $confirm_password_err = "";
                        if (isset($_GET['id']) && is_numeric($_GET['id']))
                        {
                            $id = $_GET['id'];
                            $user = User::getById($id);
                            if(isset($_POST['btnSubmit']))
                            {
                                $conn = DbConnection::getConnection();
                                $id = $_POST['id'];
                                $email = $_POST['email'];
                                $phonenumber = $_POST['phonenumber'];

                                // Validate username
                                if(empty(trim($_POST["username"]))){
                                    $username_err = "Please enter a username.";
                                } 
                                else{
                                    $sql = "SELECT id FROM users WHERE username = ?";
                                    
                                    if($stmt = mysqli_prepare($conn, $sql)){

                                        mysqli_stmt_bind_param($stmt, "s", $param_username);
                                        
                                        $param_username = trim($_POST["username"]);
                                        
                                        if(mysqli_stmt_execute($stmt)){
                                            mysqli_stmt_store_result($stmt);
                                            
                                            if($user->getUserName() != $param_username && mysqli_stmt_num_rows($stmt) == 1){
                                                $username_err = "This username is already taken.";
                                            } else{
                                                $username = trim($_POST["username"]);
                                            }
                                        } else{
                                            echo "Oops! Something went wrong. Please try again later.";
                                        }

                                        mysqli_stmt_close($stmt);
                                    }
                                }

                                // Validate password
                                if(empty(trim($_POST["password"]))){
                                    $password_err = "Please enter a password.";     
                                } elseif(strlen(trim($_POST["password"])) < 6){
                                    $password_err = "Password must have atleast 6 characters.";
                                } else{
                                    $password = trim($_POST["password"]);
                                }

                                // Validate confirm password
                                if(empty(trim($_POST["confirm_password"]))){
                                    $confirm_password_err = "Please confirm password.";     
                                } else{
                                    $confirm_password = trim($_POST["confirm_password"]);
                                    if(empty($password_err) && ($password != $confirm_password)){
                                        $confirm_password_err = "Password did not match.";
                                    }
                                }

                                // Validate fullname
                                if(empty(trim($_POST["fullname"]))){
                                    $fullname_err = "Please enter a full name.";
                                } else{
                                    $fullname = $_POST["fullname"];
                                }

                                // Check input errors
                                if(empty($username_err) && empty($fullname_err) && empty($password_err) && empty($confirm_password_err)){
                                    $param_password = password_hash($password, PASSWORD_DEFAULT); 
                                    $query = "UPDATE users SET username='$param_username', password='$param_password', fullname='$fullname', email='$email', phonenumber='$phonenumber' WHERE id='$id';";
                                    
                                    $result = mysqli_query($conn,$query);
                                    if ($result)
                                    {
                                        echo '<div class="alert alert-success">
                                                <strong>Success!</strong>
                                            </div>';
                                    }
                                    else 
                                    {
                                        echo '<div class="alert alert-danger">
                                                <strong>Failt!</strong>
                                            </div>';
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
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>User Name</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $user->getUserName(); ?>" required>
                            <span style="color: red;" class="help-block"><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required
                                placeholder="********">
                            <span style="color: red;" class="help-block"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" required
                                placeholder="********">
                            <span style="color: red;" class="help-block"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($fullname_err)) ? 'has-error' : ''; ?>">
                            <label>Full Name</label>
                            <input type="text" name="fullname" class="form-control" value="<?php echo $user->getFullName(); ?>" required >
                            <span style="color: red;" class="help-block"><?php echo $fullname_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email: </label>
                            <input type="email" class="form-control" name="email"
                                value="<?php echo $user->getEmail(); ?>" aria-describedby="emailHelpId"
                                placeholder="Enter email...">
                            <small id="emailHelpId" class="form-text text-muted">Help text</small>
                        </div>
                        <div class="form-group">
                            <label for="phonenumber">Phone number: </label>
                            <input type="text" name="phonenumber" class="form-control" 
                                value="<?php echo $user->getPhoneNumber(); ?>" placeholder="Enter phone number...">
                        </div>
                        <button type="submit" class="btn btn-primary" name="btnSubmit">Save</button>
                        <a href='./getAllStudents.php' style="float: right;">Back</a>
                    </form>
                        <?php }
                        else {                           
                            header('Location: getAllStudents.php');
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>
</body>
