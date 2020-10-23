<?php
//Hàm login sau khi mạng xã hội trả dữ liệu về
function loginFromSocialCallBack($socialUser) {
    require_once "./dbConnection.php";
    $conn = DbConnection::getConnection();
    $socialEmail = $socialUser['email'];
    $socialName = $socialUser['name'];
    $query = "SELECT * from users WHERE email='$socialEmail'";
    $result = $conn->query($query);
    print $query;
    print $result->num_rows;
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO users (username, fullname, email) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_fullname, $param_email);
            
            // Set parameters
            $param_username = $socialName;
            $param_fullname = $socialName;
            $param_email = $socialEmail;
            
            if(mysqli_stmt_execute($stmt)){
                echo "OK";
            } else{
                echo "Error! Add Failed." . "<pre>{$conn->error}</pre>";
            }

            mysqli_stmt_close($stmt);
        }
        $query = "SELECT * from users WHERE email='$socialEmail'";
        $result = $conn->query($query);
    }
    if ($result->num_rows > 0) {
        $user = mysqli_fetch_assoc($result);

        session_start();
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $user['id'];
        $_SESSION["username"] = $user['username'];
        $_SESSION["permission"] = $user['permission'];
        header('Location: ./login.php');
    }
}

?>