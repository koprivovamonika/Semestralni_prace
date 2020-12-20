<?php
session_start();
include '../../connection/Connection.php';
include '../select/SelectUcitele.php';
Connection::opravneniA();
?>
<html>
<head>
    <title>Škola</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/special.css">
    <?php
    include "../../htmlKomponenty/menu_admin.php";
    ?>
    <form action="trida_predmet_ucitel.php" method="POST">
        <h1 class='predmet'>Přiřazení učitele ke třídě</h1>
        <?php
        SelectUcitele::VypisUcitelPredmetTrida(Connection::spojeni());

        ?>
    </form>
    <?php
    include "../../htmlKomponenty/footer.php";
    ?>


