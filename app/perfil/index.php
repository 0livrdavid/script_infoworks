<?php
require_once '../../config.php';
require_once '../../layout/start.php';
require_once '../../ajax/perfil/perfil.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Unset the session variable
    session_destroy();

    // Redirect to the same page to prevent form resubmission
    header('Location: ../dashboard/');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Session Variable</title>
</head>
<body>
    <h1>Delete Session Variable</h1>

    <?php if (isset($_SESSION['my_session_variable'])) : ?>
        <p>Session variable value: <?php echo $_SESSION['my_session_variable']; ?></p>
    <?php endif; ?>

    <form method="post">
        <button type="submit">Delete Session Variable</button>
    </form>
</body>
</html>