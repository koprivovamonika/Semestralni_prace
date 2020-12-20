<?php
session_start();
include '../../connection/Connection.php';
include '../select/SelectUcitele.php';
Connection::opravneniA();
include '../../htmlKomponenty/header.php';
?>
    <style>
        table {
            margin-top: 2%;
        }

        .predmet {
            margin-top: 8%;
        }
    </style>
    <body>
<?php
echo "<h1 class='predmet'>Výpis předmětů pro učitele</h1>";
SelectUcitele::VypisUcitelePredmetu(Connection::spojeni());
?>

    <a href="pridat_ucitel_predmet.php">
        <button>Přidat učitelovi předmět</button>
    </a>
<?php
include "../../htmlKomponenty/footer.php";
?>