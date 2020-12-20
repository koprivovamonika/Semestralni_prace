<?php
session_start();
include '../connection/Connection.php';
include '../admin/select/SelectZnamky.php';
Connection::opravneniR();
include '../htmlKomponenty/header.php';
?>
<style type="text/css">
    .vaha1 {
        background-color: #ccffff;
        color: black;
    }

    .vaha2 {
        background-color: #99ccff;
        color: black;
    }

    .vaha3 {
        background-color: #66ffff;
        color: black;
    }

    .vaha4 {
        background-color: #00ccff;
        color: black;
    }

    .vaha5 {
        background-color: #0066ff;
        color: white;
    }

    .vaha6 {
        background-color: #0000ff;
        color: white;
    }

    .vaha7 {
        background-color: #006699;
        color: white;
    }

    .vaha8 {
        background-color: #330099;
        color: white;
    }

    .vaha9 {
        background-color: #003366;
        color: white;
    }

    .vaha10 {
        background-color: #330066;
        color: white;
    }

    #kosticka {
        float: left;
        width: 1.25vw;
        height: 1.25vw;
        margin-right: 0.5%;
    }

    #popisek {
        float: left;
        margin-bottom: 2%;
        margin-right: 0.5%;

    }

    th {
        background-color: #31d8fc;
        color: white;
        text-align: left;
        padding: 0.5vw;
        font-family: Times, 'Times New Roman', serif;
        font-weight: normal;
        text-align: justify;
    }

    td {
        text-align: left;
        padding: 0.5vw;
        font-family: Times, 'Times New Roman', serif;
        font-weight: normal;
        border-bottom: 0.1vw solid #cccccc;
        background-color: white;
    }

    td a:hover {
        color: red;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
        margin: auto;
        margin-top: 1%;
    }

    .hlavni-div {
        margin: auto;
        margin-top: 10%;
        width: 80%;
    }

    .zak {
        font-size: 1.2vw;
        font-weight: 600;
        clear: both;
    }

    .vysvetlivky {
        width: 100%;
    }

    .predmet {
        font-size: 170%;
        margin-right: 20%;
    }
</style>

<div class=hlavni-div>
    <div class="vysvetlivky">
        <h1 class='predmet'>Klasifikace</h1>
        <div id="popisek">Váha 1:</div>
        <div class="vaha1" id="kosticka"></div>
        <div id="popisek">Váha 2:</div>
        <div class="vaha2" id="kosticka"></div>
        <div id="popisek">Váha 3:</div>
        <div class="vaha3" id="kosticka"></div>
        <div id="popisek">Váha 4:</div>
        <div class="vaha4" id="kosticka"></div>
        <div id="popisek">Váha 5:</div>
        <div class="vaha5" id="kosticka"></div>
        <div id="popisek">Váha 6:</div>
        <div class="vaha6" id="kosticka"></div>
        <div id="popisek">Váha 7:</div>
        <div class="vaha7" id="kosticka"></div>
        <div id="popisek">Váha 8:</div>
        <div class="vaha8" id="kosticka"></div>
        <div id="popisek">Váha 9:</div>
        <div class="vaha9" id="kosticka"></div>
        <div id="popisek">Váha 10:</div>
        <div class="vaha10" id="kosticka"></div>
    </div>
    <?php
    SelectZnamky::VypisZnamkyRodic(Connection::spojeni());
    ?>
</div>
<?php
include "../htmlKomponenty/footer.php";
?>
