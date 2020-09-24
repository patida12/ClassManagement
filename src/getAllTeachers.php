<?php include './index.php'; 
?>
<body class="link-tab">
<section>
    <div class="tab-content">
        <h2>List Teachers</h2>
        <br>
        <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table id="table" class="table table-hover table-bordered table-striped table-inverse table-wrapper-scroll-y" cellspacing="0">
            <thead class="thead-inverse">
                <tr style="background-color: #555; color: white;">
                    <th>STT</th>
                    <th>User Name</th>
                    <th>Full Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php require_once './users.php';
                    $users = User::getTeachers();
                    $index = 0;
                    foreach($users as $user)
                    {
                        $index++;
                        echo "<tr>";
                        echo "<td>{$index}</td>";
                        echo "<td>{$user->getUserName()}</td>";
                        echo "<td>{$user->getFullName()}</td>";
                        echo '<td>';
                ?>
                <?php
                        echo '<a style="color: white;" href="details.php?id=' . $user->getId() . '">' 
                ?>
                        <button class="btn btn-info btn-sm">Details</button>
                <?php echo '</td>'; 
                    }
                ?>
            </tbody>
        </table>
        </div>
        <a href="index.php"><button class="btn btn-primary">Back</button></a>
</div>
</section>
</body>
