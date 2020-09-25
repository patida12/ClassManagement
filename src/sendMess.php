<?php include './index.php';?>
<body>
<section>
    <div class="tab-content">
<?php
	include './dbConnection.php';
	$link = DbConnection::getConnection();
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$message = $_POST['message'];
		$idSender = $_POST['idSender'];
		$idReceiver = $_POST['idReceiver'];
		
		if (!empty($message)) {
			$query = "INSERT INTO mbox (message, idSender, idReceiver, created) VALUES ('{$message}', '{$idSender}', {$idReceiver}, NOW())";
			$result = $link->query($query);
			if($result) {
				echo '<h2>Success! Your message has been sent!</h2>';
			}
			else {
				echo 'Error! Failed.'
					. "<pre>{$link->error}</pre>";
			}
		} 
		else {
			echo '<h2>Please enter message.</h2>';
		}
	}
	else {
		echo '<h2>Error</h2>';
	}
?>
		<a href='javascript:history.back(1);'><button type="button" class="btn btn-primary">Back</button></a>
	</div>
</section>
</body>
