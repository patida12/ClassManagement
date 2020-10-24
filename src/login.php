<?php
session_start();
require_once "../vendor/twilio/sdk/src/Twilio/autoload.php";
use Twilio\Rest\Client;

$sid = "ACcf9a8ba39a168be14b909712767f5587";
$token = "102ba45b9671645dd0da92b00ee88f98";
 
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
        $sql = "SELECT id, username, password, permission, phonenumber, is_tfa_enabled FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $permission, $phonenumber, $is_tfa_enabled);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            if ($is_tfa_enabled == 1) {
                                $_SESSION["loggedin"] = false;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;
                                $_SESSION["permission"] = $permission;  
 
                                $pin = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
                                
                                $sql = "UPDATE users SET pin = $pin  WHERE id = $id";
                                mysqli_query($conn, $sql);
            
                                $client = new Client($sid, $token);
                                $client->messages->create(
                                    $phonenumber, array(
                                        "from" => "+12513877015",
                                        "body" => "Your classmanagement.com 2-factor authentication code is: ". $pin
                                    )
                                );
            
                                header("Location: enter-pin.php");
                            } else {
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;
                                $_SESSION["permission"] = $permission;                            
                                
                                header("location: home.php");
                            }
                            
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