<?php
include 'dbConnection.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>real time chat system in php</title>
	<script type="text/javascript">
		function ajax(){
		var req=new XMLHttpRequest();
		req.onreadystatechange=function(){
		if(req.readyState==4 && req.status==200){
		document.getElementById('chat').innerHTML=req.responseText;

	}

	}
	req.open('GET','sendMess.php',true);
	req.send();


	}
	setInterval(function(){ajax()},1000);

	</script>
</head>
<body onload="ajax()">
	<div id="container">
	<div id="chat_box">
		<div id="chat">
		</div>

	</div>
		<form method="post" action="index.php">
			<input type="text" name="name" placeholder="Enter name">
			<textarea name="msg" placeholder="Enter the meassage:)"></textarea>
			<input type="submit" name="submit" value="Sendit">

		</form>
<?php
if (isset($_POST['submit'])) {
    $sendby  = 1;
    $sendto = 30;
	$msg   = $_POST['msg'];
	$query = "INSERT INTO mbox (message,sendby, sendto) values ('$msg',$sendby, $sendto)";
	$run   = $conn->query($query);
	if ($run) {
		echo "<p>OK</p>";
	}

}
?>
</div>

</body>
</html>
