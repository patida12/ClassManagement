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
}

function _construct($username, $password, $fullname, $email, $phonenumber)
{
    $this->username = $username;
    $this->password = $password;
    $this->fullname = $fullname;
    $this->email = $email;
    $this->phonenumber = $phonenumber;
}

function getUserName() { return $this->username;}
function getPassword() { return $this->password;}
function getFullName() { return $this->fullname;}
function getEmail() { return $this->email;}
function getPhoneNumber() { return $this->phonenumber;}

function getAll()
{
    $rows = array();

    $conn = DBConnection::getConnection();
    $sql = 'SELECT * FROM users';
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_object($result)) {
            $user = new User($row->username, $row->password, $row->fullname, $row->email, $row->phonenumber);
            $rows[] = $user;
        }
    }
    DBConnection::closeConnection($conn);
    return $rows;
}
?>