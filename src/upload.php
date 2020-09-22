<?php include './session.php'; 
include './dbConnection.php';
$link = DbConnection::getConnection();

if(isset($_FILES['uploaded_file'])) {
    if($_FILES['uploaded_file']['error'] == 0) {
        $type = $_POST['type'];
        $idAssignment = $_POST['idAssignment'];
        $name = $link->real_escape_string($_FILES['uploaded_file']['name']);
        $mime = $link->real_escape_string($_FILES['uploaded_file']['type']);
        $data = $link->real_escape_string(file_get_contents($_FILES  ['uploaded_file']['tmp_name']));
        $size = intval($_FILES['uploaded_file']['size']);
    
        if ($type == "assignment") {
            $query = "
            INSERT INTO assignment (
                name, mime, size, data, created, type
            )
            VALUES (
                '{$name}', '{$mime}', {$size}, '{$data}', NOW(), '{$type}'
            )";
            $result = $link->query($query);
        } else if ($type == "submission" && isset($_SESSION['id'])) {

            $idStudent = (int)$_SESSION['id'];

            $query = "
            INSERT INTO submission (
                name, idAssignment, idStudent, mime, size, data, created
            )
            VALUES (
                '{$name}', '{$idAssignment}', '{$idStudent}', '{$mime}', {$size}, '{$data}', NOW()
            )";
            $result = $link->query($query);
        } else {
            $result = false;
        }
    
        
    
        if($result) {
            header('Location: ' . $type . '.php');
            echo '<script>alert("Success! Your file was successfully added!")</script>';
            
        }
        else {
            echo 'Error! Failed to insert the file'
                . "<pre>{$link->error}</pre>";
        }
    }
    else {
        echo 'An error accured while the file was being uploaded. '
            . 'Error code: '. intval($_FILES['uploaded_file']['error']);
    }
    
    $link->close();
}
else {
    echo 'Error! A file was not sent!';
}

DbConnection::closeConnection($link);
?>