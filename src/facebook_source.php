<?php
include '../vendor/facebook/graph-sdk/src/Facebook/autoload.php';
include('./fbconfig.php');
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; 
$loginUrl = $helper->getLoginUrl('https://classmanagement.com/fb-callback.php', $permissions);
?>