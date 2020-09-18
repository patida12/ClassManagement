<a style="color: white;" href="editStudent.php?id=' . $user->getId() . '">
    <button class="btn btn-warning btn-sm">Edit</button>
</a>
<a style="color: white;" href="deleteStudent.php?id=' . $user->getId() . '">
    <button onclick="return  confirm('Do you want to delete Y/N')" class="btn btn-danger btn-sm">Delete</button>
</a>