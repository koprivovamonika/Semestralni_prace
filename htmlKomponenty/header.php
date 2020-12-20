<html>
<head>
    <title>Škola</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
    <link rel="stylesheet" type="text/css" href="css/print.css" media = "print">
    <link rel="stylesheet" type="text/css" href="../css/print.css" media = "print">
    <link rel="stylesheet" type="text/css" href="../../css/print.css" media = "print">
<?php

if (isset($_SESSION["login"]) && isset($_SESSION["opravneni"])) {

    if ($_SESSION["opravneni"] == 0) {
        include 'menu_admin.php';
    } elseif ($_SESSION["opravneni"] == 1) {
        include "menu_ucitel.php";
    } elseif ($_SESSION["opravneni"] == 2) {
        include 'menu_zak.php';
    } elseif ($_SESSION["opravneni"] == 3) {
        include 'menu_rodic.php';
    }
} else {
    include 'menu.php';
}
?>