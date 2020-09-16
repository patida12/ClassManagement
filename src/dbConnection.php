<?php
class DbConnection
{
    public static function getConnection()
    {
        $hostname = 'localhost:3306';
        $username = 'root';
        $password = 'root';
        $dbname = "class_management";
        $conn = mysqli_connect($hostname, $username, $password,$dbname);
        if (!$conn) {
            die('Không thể kết nối: ' . mysqli_error($conn));
            exit();
        }
        return $conn;
    }

    public static function closeConnection($link)
    {
        mysqli_close($link);
    }
}
?>