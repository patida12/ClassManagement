 <?php 
 require_once './dbConnection.php';
 $conn = DBConnection::getConnection();
 $sql = 'SELECT * FROM users';
 $result = mysqli_query($conn, $sql);
 if (mysqli_num_rows($result) > 0) {
    // Hiển thị kết quả
  while($row = mysqli_fetch_assoc($result)) {
    echo "Account Name: " . $row["username"]. ", Account Password: " . $row["password"]. "<br>";
  }
 } else {
    echo "Không có tài khoản nào";
 } 
 DBConnection::closeConnection($conn);
 ?>