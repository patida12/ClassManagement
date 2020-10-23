<?php
session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
require_once "dbConnection.php";
$conn = DbConnection::getConnection();

$username = $password = "";
$username_err = $password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate 
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password, permission FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $permission);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["permission"] = $permission;                            
                            
                            header("location: index.php");
                        } else{
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    DbConnection::closeConnection($conn);
}
?>

<html>
<?php include './head.php'; 
include './facebook_source.php';
?>

<body>
    <div style="top: 15%;" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: blue; color: white;">
                <h3 class="modal-title">Log in!</h3>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span style="color: red;" class="help-block"><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                            <span style="color: red;" class="help-block"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Login">
                        </div>  
                    </form>
                    <p style="text-align: center;">OR</p>
                    <div style="text-align: center;">
                        <a href="<?= $loginUrl ?>"><img src="./facebook.png" alt='facebook login' title="Facebook Login" height="50" width="280" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>