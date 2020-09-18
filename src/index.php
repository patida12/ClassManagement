<!doctype html>
<html lang="en">
<?php include './head.php'; ?>

<body>
    <header>
        <h3><i class="fa fa-graduation-cap">ClassManagement</i></h3>
    </header>

    <section>

        <ul class="nav nav-tabs flex-column" role="tablist">
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#home"><i class="fa fa-home"> Home</i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#assignment"><i class="fa fa-book"> Assignment</i></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" data-toggle="tab" href="#teachers"><i class="fa fa-user"> Teachers</i></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" data-toggle="tab" href="#students"><i class="fa fa-users"> Students</i></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" data-toggle="tab" href="#quizs"><i class="fa fa-gamepad"> Quizs</i></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" data-toggle="tab" href="#profile"><i class="fa fa-user-circle"> Profile</i></a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="home" class="container tab-pane active"><br>
                <h3>HOME</h3>
                <p>Lorem
                    idfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffpsum
                    dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore
                    magna aliqua.</p>
            </div>
            <div id="assignment" class="container tab-pane fade"><br>
                <h3>Menu 1</h3>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat.</p>
            </div>
            <div id="teachers" class="container tab-pane fade"><br>
                <h3>Menu 2</h3>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                    totam rem aperiam.</p>
            </div>
            <div id="students" class="container tab-pane fade"><br>
                <?php include './getAllUsers.php'; ?>
            </div>
            <div id="quizs" class="container tab-pane fade"><br>
                <h3>Menu 2</h3>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                    totam rem aperiam.</p>
            </div>
            <div id="profile" class="container tab-pane fade"><br>
                <h3>Menu 2</h3>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                    totam rem aperiam.</p>
            </div>
        </div>



    </section>


</body>

</html>