<?php
class DbConnection
{
    public static function getConnection()
    {
        $hostname = 'localhost:3306';
        $uname = 'patida';
        $passwd = 'Oimeoioimeoi12@';
        $dbname = "class_management";
        $conn = mysqli_connect($hostname, $uname, $passwd,$dbname);
        if (!$conn) {
            die('Can not connect: ' . mysqli_error($conn));
            exit();
        }
        return $conn;
    }

    public static function closeConnection($conn)
    {
        mysqli_close($conn);
    }
}
?>