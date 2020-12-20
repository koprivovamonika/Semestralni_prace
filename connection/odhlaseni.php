<?php
session_start();
unset($_SESSION["login"]);
unset($_SESSION["opravneni"]);
header("Location: /iwww_semestralni_prace/index.php");
?>