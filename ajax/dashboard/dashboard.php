<?php
unset($_SESSION['login_msg']);

if (!isset($_GET['filtro'])) $_GET['filtro'] = "todos";
$filter = $_GET['filtro'];