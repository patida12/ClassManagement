<?php

function active($currect_page){
    $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
    $url = end($url_array);  
    if($currect_page == $url){
        echo 'active'; 
    } 
  }

session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

?>

 
<!Doctype html>
<html>
<?php include './head.php'; ?>

<body>
    <header>
        <h3><i class="fa fa-graduation-cap">ClassManagement</i></h3>
    </header>

    <section style="margin-top: 30px;">
        <ul id="ul_index" class="nav flex-column" >
            <li class="nav-item">
                <a class="nav-link <?php active('home.php');?>" href="home.php"><i class="fa fa-home"> Home</i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php active('assignment.php');?>"  href="assignment.php"><i class="fa fa-book"> Assignment</i></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link <?php active('getAllTeachers.php');?>"  href="getAllTeachers.php"><i class="fa fa-user"> Teachers</i></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link <?php active('getAllStudents.php');?>" href="getAllStudents.php"><i class="fa fa-users"> Students</i></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link <?php active('quizs.php');?>"  href="quizs.php"><i class="fa fa-gamepad"> Quizs</i></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link <?php active('profile.php');?>"  href="profile.php"><i class="fa fa-user-circle"> Profile</i></a>
            </li>
        </ul>
    </section>
</body>

</html>