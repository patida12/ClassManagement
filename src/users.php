<?php 
 require_once './dbConnection.php';
 
class User 
{
    private $id;
    private $username;
    private $password;
    private $fullname;
    private $email;
    private $phonenumber;

    function __construct($_id, $_username, $_password, $_fullname, $_email, $_phonenumber)
    {
        $this->id = $_id;
        $this->username = $_username;
        $this->password = $_password;
        $this->fullname = $_fullname;
        $this->email = $_email;
        $this->phonenumber = $_phonenumber;
    }

    function getId() { return $this->id;}
    function getUserName() { return $this->username;}
    function getPassword() { return $this->password;}
    function getFullName() { return $this->fullname;}
    function getEmail() { return $this->email;}
    function getPhoneNumber() { return $this->phonenumber;}

    static function getAll()
    {
        $rows = array();

        $conn = DbConnection::getConnection();
        $sql = 'SELECT * FROM users';
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_object($result)) {
                $user = new User($row->id, $row->username, $row->password, $row->fullname, $row->email, $row->phonenumber);
                $rows[] = $user;
            }
        }
        DbConnection::closeConnection($conn);
        return $rows;
    }

    static function getById($id) 
    {
        $user = new User();
        $conn = DbConnection::getConnection();
        $sql = "SELECT * FROM users WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 1) {
            while($row = mysqli_fetch_assoc($result)) {
                $user = new User($row['id'], $row['username'], $row['password'], $row['fullname'], $row['email'], $row['phonenumber']);
            }
        }
        DbConnection::closeConnection($conn);
        return $user;
    }
}
?>