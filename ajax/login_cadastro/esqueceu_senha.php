<?php
var_dump($_POST['flag_unset_login_msg']);
$flag_unset_login_msg = $_POST['flag_unset_login_msg'];

if ($flag_unset_login_msg == "true") {
    unset($_SESSION['login_msg']);
}
