<?php 
 require_once './dbConnection.php';
 require_once './session.php';
 
class User 
{
    private $id;
    private $username;
    private $password;
    private $fullname;
    private $email;
    private $phonenumber;
    private $permission;

    function __construct($_id, $_username, $_password, $_fullname, $_email, $_phonenumber, $_permission)
    {
        $this->id = $_id;
        $this->username = $_username;
        $this->password = $_password;
        $this->fullname = $_fullname;
        $this->email = $_email;
        $this->phonenumber = $_phonenumber;
        $this->permission = $_permission;
    }

    function getId() { return $this->id;}
    function getUserName() { return $this->username;}
    function getPassword() { return $this->password;}
    function getFullName() { return $this->fullname;}
    function getEmail() { return $this->email;}
    function getPhoneNumber() { return $this->phonenumber;}
    function getPermission() { return $this->permission;}

    static function getStudents()
    {
        $rows = array();

        $conn = DbConnection::getConnection();
        $sql = 'SELECT * FROM users WHERE permission = 0';
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_object($result)) {
                $user = new User($row->id, $row->username, $row->password, $row->fullname, $row->email, $row->phonenumber, $row->permission);
                $rows[] = $user;
            }
        }
        DbConnection::closeConnection($conn);
        return $rows;
    }

    static function getTeachers()
    {
        $rows = array();

        $conn = DbConnection::getConnection();
        $sql = 'SELECT * FROM users WHERE permission = 1';
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_object($result)) {
                $user = new User($row->id, $row->username, $row->password, $row->fullname, $row->email, $row->phonenumber, $row->permission);
                $rows[] = $user;
            }
        }
        DbConnection::closeConnection($conn);
        return $rows;
    }

    static function getById($id) 
    {
        $user = new User(0,'','','','','',0);
        $conn = DbConnection::getConnection();
        $sql = "SELECT * FROM users WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 1) {
            while($row = mysqli_fetch_assoc($result)) {
                $user = new User($row['id'], $row['username'], $row['password'], $row['fullname'], $row['email'], $row['phonenumber'], $row['phonenumber'], $row['permission']);
            }
        }
        DbConnection::closeConnection($conn);
        return $user;
    }

}
?>