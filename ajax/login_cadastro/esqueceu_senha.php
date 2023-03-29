<?php
if ($_POST['flag_unset_login_msg']) {
    echo $_POST['flag_unset_login_msg'];
    unset($_SESSION['login_msg']);
    die;
}