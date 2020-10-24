<?php include './index.php'; 
include './session.php';
require_once './dbConnection.php';

    $conn = DbConnection::getConnection();
    session_start();
    $user_id = $_SESSION["id"];

    if (isset($_POST["toggle_tfa"]))
    {
        $is_tfa_enabled = $_POST["is_tfa_enabled"];

        $sql = "UPDATE users SET is_tfa_enabled = '$is_tfa_enabled' WHERE id = '$user_id'";
        mysqli_query($conn, $sql);

    }

    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_object($result);
?>

<body>
  <section  class="mbox">
    <div class="tab-content">
    <form method="POST" action="home.php">
        <h1>Enable TFA</h1>

        <input type="radio" name="is_tfa_enabled" value="1" <?php echo $row->is_tfa_enabled ? "checked" : ""; ?>> Yes
        <input type="radio" name="is_tfa_enabled" value="0" <?php echo !$row->is_tfa_enabled ? "checked" : ""; ?>> No

        <input type="submit" name="toggle_tfa">
    </form>

    <a class="btn btn-primary" href="logout.php">
        Logout
    </a>
    </div>
    </section>
</body>


