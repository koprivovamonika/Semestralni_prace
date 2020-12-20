<?php
session_start();
include '../connection/Connection.php';
include "select/SelectUcitele.php";
include "select/Json.php";
Connection::opravneniA();
include '../htmlKomponenty/header.php';

if (isset($_GET['tojson'])) {
    Json::ToJson(Connection::spojeni());
}

?>
    <style>
        table {
            margin-top: 2%;
        }

        .predmet {
            margin-top: 8%;
        }
    </style>
<?php
echo "<h1 class='predmet'>Výpis učitelů</h1>";
SelectUcitele::VypisUcitele(Connection::spojeni());
?>
    <a href="insert/pridat_uzivatele.php?opravneni=1">
        <button class="buttonPridani">Přidat učitele</button>
    </a>

    <a href="ucitele.php?tojson=true">
        <button class="buttonPridani">Nahrát do JSON</button>
    </a>

    <a href="uciteleJson.php">
        <button class="buttonPridani">Nahrát z JSON</button>
    </a>

<?php
include "../htmlKomponenty/footer.php";
?>