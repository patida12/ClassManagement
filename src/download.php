<?php include './dbConnection.php';
$conn = DbConnection::getConnection();

if(isset($_GET['id']) && isset($_GET['type'])) {
    $type = strval($_GET['type']);
    $id = intval($_GET['id']);
    $assignment = "assignment";
    $submission = "submission";

    if($id <= 0) {
        die('The ID is invalid!');
    }
    else {
        if ($type == "assignment") {
            $query = "
            SELECT mime, name, size, data
            FROM assignment
            WHERE id = {$id}";
        $result = $conn->query($query);
        } else if ($type == "submission"){
            $query = "
            SELECT mime, name, size, data
            FROM submission
            WHERE id = {$id}";
        $result = $conn->query($query);
        } else {
            $result = false;
        }

        if($result) {
            if($result->num_rows == 1) {
                $row = mysqli_fetch_assoc($result);
 
                header("Content-Type: ". $row['mime']);
                header("Content-Length: ". $row['size']);
                header("Content-Disposition: attachment; filename=". $row['name']);
 
                echo $row['data'];
            }
            else {
                echo 'Error! No file exists with that ID.';
            }
 
            @mysqli_free_result($result);
        }
        else {
            echo "Error! Query failed: <pre>{$type}</pre>";
        }
        @mysqli_close($conn);
    }
}
else {
    echo 'Error! No ID was passed. ';
}
DbConnection::closeConnection($conn);
?>