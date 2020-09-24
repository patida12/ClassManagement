<?php include './index.php';?>

<body>
<section>
<div class="tab-content">
<?php
    require_once './dbConnection.php';
    $link = DbConnection::getConnection();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $submission = $_POST['submission'];
        $created = $_POST['created'];
        $target_dir = "./quizs/";
        $answer = $target_dir . basename($submission);
        $answer = $answer . ".txt";
        if (file_exists($answer)) {
            $createdFile = date ("Y-m-d H:i:s", filemtime($answer));
            if ($created == $createdFile) {
                echo '<h2>Correct!</h2>';
                $fh = fopen($answer,'r');
                while ($line = fgets($fh)) {
                    print($line);
                }
                fclose($fh);  
            }     
            else {
                echo '<h2>Incorrect!</h2>';
            }  
        }
        else {
            echo '<h2>Incorrect!</h2>';
        }
        echo '<br><a href="quizs.php"><button class="btn btn-primary">Back</button></a>';
    ?>
    
    <?php
    }
    else {                           
        header('Location: quizs.php');
    }
?>


</div>
</section>
</body>