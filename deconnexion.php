<?php session_start()?>

<?php
if (isset($_SESSION['pseudo'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
?>
