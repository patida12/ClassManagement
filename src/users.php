<?php 
 require_once './dbConnection.php';
 
class User {
    private $username;
    private $password;
    private $fullname;
    private $email;
    private $phonenumber;

    function __construct($_username, $_password, $_fullname, $_email, $_phonenumber)
    {
        $this->username = $_username;
        $this->password = $_password;
        $this->fullname = $_fullname;
        $this->email = $_email;
        $this->phonenumber = $_phonenumber;
    }

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
                $user = new User($row->username, $row->password, $row->fullname, $row->email, $row->phonenumber);
                $rows[] = $user;
            }
        }
        DbConnection::closeConnection($conn);
        return $rows;
    }

    function save() 
    {
        $conn = DbConnection::getConnection();
        $sql = 'INSERT INTO VALUES (null,?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $password, $fullname, $email, $phonenumber);
        $username = $this->getUserName();
        $password = $this->getPassword();
        $fullname = $this->getFullName();
        $email = $this->getEmail();
        $phonenumber = $this->getPhoneNumber();
        $ret = $stmt->execute();
        DbConnection::closeConnection($conn);
        return $ret;
    }
}
?>