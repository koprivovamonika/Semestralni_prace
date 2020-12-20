<?php
session_start();
include '../connection/Connection.php';
include '../admin/select/SelectZnamky.php';
Connection::opravneniZ();
include '../htmlKomponenty/header.php';
?>

<div class="vysvetlivky">
    <h1 class='predmet'>Klasifikace</h1>
    <div class="popisek">Váha 1:</div>
    <div class="vaha1" id="kosticka"></div>
    <div class="popisek">Váha 2:</div>
    <div class="vaha2" id="kosticka"></div>
    <div class="popisek">Váha 3:</div>
    <div class="vaha3" id="kosticka"></div>
    <div class="popisek">Váha 4:</div>
    <div class="vaha4" id="kosticka"></div>
    <div class="popisek">Váha 5:</div>
    <div class="vaha5" id="kosticka"></div>
    <div class="popisek">Váha 6:</div>
    <div class="vaha6" id="kosticka"></div>
    <div class="popisek">Váha 7:</div>
    <div class="vaha7" id="kosticka"></div>
    <div class="popisek">Váha 8:</div>
    <div class="vaha8" id="kosticka"></div>
    <div class="popisek">Váha 9:</div>
    <div class="vaha9" id="kosticka"></div>
    <div class="popisek">Váha 10:</div>
    <div class="vaha10" id="kosticka"></div>
</div>
<?php
SelectZnamky::VypisZnamky(Connection::spojeni());
?>
<?php
include "../htmlKomponenty/footer.php";
?>
