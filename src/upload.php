<?php include './index.php';
include './session.php'; 
include './dbConnection.php'; 
?>
<body>
  <section>
    <div class="tab-content">
<?php
$conn = DbConnection::getConnection();

if(isset($_FILES['uploaded_file'])) {
    if($_FILES['uploaded_file']['error'] == 0) {
        $type = $_POST['type'];
        $idAssignment = $_POST['idAssignment'];
        $name = $conn->real_escape_string($_FILES['uploaded_file']['name']);
        $mime = $conn->real_escape_string($_FILES['uploaded_file']['type']);
        $data = $conn->real_escape_string(file_get_contents($_FILES  ['uploaded_file']['tmp_name']));
        $size = intval($_FILES['uploaded_file']['size']);
    
        if ($type == "assignment") {
            $query = "INSERT INTO assignment (name, mime, size, data, created, type) VALUES ('{$name}', '{$mime}', {$size}, '{$data}', NOW(), '{$type}')";
            $result = $conn->query($query);
        } else if ($type == "submission" && isset($_SESSION['id'])) {

            $idStudent = (int)$_SESSION['id'];

            $query = "INSERT INTO submission (name, idAssignment, idStudent, mime, size, data, created) VALUES ('{$name}', '{$idAssignment}', '{$idStudent}', '{$mime}', {$size}, '{$data}', NOW())";
            $result = $conn->query($query);
        } else {
            $result = false;
        }
    
        if($result) {
            echo '<h2>Success! Your file was successfully added!</h2>';
        }
        else {
            echo 'Error! Failed to insert the file'
                . "<pre>{$conn->error}</pre>";
        }
    }
    else {
        echo 'An error accured while the file was being uploaded. '
            . 'Error code: '. intval($_FILES['uploaded_file']['error']);
    }
    
}
else {
    echo 'Error! A file was not sent!';
}
DbConnection::closeConnection($conn);
?>
</div>
<a class="tab-content" href="<?php echo $type; ?>.php"><button class="btn btn-primary">Back</button></a>
</section>
</body>