
<?php
echo "<header>";
echo "<div class='header'>";

if (isset ($_SESSION['pseudo'])){
    echo "<ul>";
    echo "<li><a href='deconnexion.php'>".$_SESSION['pseudo']."</a></li>";
    echo "</ul>";
}else{
    echo "<ul>";
    echo "<li> </li>";
    echo "</ul>";
}
echo "</div>";
echo "</header>";
?>

