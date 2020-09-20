<?php include './session.php'; 
    class Permission {
        function hasPermission() {
            if (isset($_SESSION['permission'])) {
                $permission = $_SESSION['permission'];
                if ($permission == '0') {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }
?>
