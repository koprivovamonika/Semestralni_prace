<?php
session_start();
include '../connection/Connection.php';
Connection::opravneniA();
include '../htmlKomponenty/header.php';
?>
    <style type="text/css">

        th {
            background-color: #31d8fc;
            color: white;
            text-align: left;
            padding: 0.5vw;
            font-family: Times, 'Times New Roman', serif;
            font-size: 1vw;
            font-weight: normal;
            text-align: justify;
        }

        td {
            text-align: left;
            padding: 0.5vw;
            font-family: Times, 'Times New Roman', serif;
            font-size: 1vw; /*font-size: 20px;*/
            font-weight: normal;
            border-bottom: 0.1vw solid #cccccc;
        }

        td a:hover {
            color: red;
        }

        table {
            width: 80%;
            margin-left: 10%;
            border-collapse: collapse;
            text-align: center;
            margin-top: 3.5%;
        }

        .odesilani_archiv {
            width: 20%;
            background-color: #31d8fc;
            color: white;
            padding: 0.4vw 0.4vw;
            margin: 0.3vw 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 40%;
        }

        .odesilani_archiv:hover {
            background-color: #0033ff;
        }

        h1.jmeno {
            text-align: center;
            font-size: 150%;

        }

        .trida {
            text-align: center;
            font-size: 150%;
            margin-bottom: -5.5vw;
        }
    </style>
    <br><br><br><br>
<?php
$id = $_GET['id'];
$db = Connection::spojeni();
$ql = "SELECT uzivatel.jmeno as jmeno, uzivatel.prijmeni as prijmeni, tridy.nazev as trida FROM uzivatel JOIN propojeni_zak_trida ON propojeni_zak_trida.id_zaka=uzivatel.id JOIN tridy ON tridy.id = propojeni_zak_trida.id_trida WHERE uzivatel.id= ?";
if ($stmt = $db->prepare($ql)) {
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $data = $stmt->get_result();
    $zaznam = $data->fetch_all(MYSQLI_ASSOC);
    if (count($zaznam) > 0) {
        foreach ($zaznam as $row1) {
            echo "<h1 class='jmeno'>" . $row1['jmeno'] . " " . $row1['prijmeni'] . "</h1>";
            echo "<h1 class='trida'>" . $row1['trida'] . "</h1>";
        }
    }
}

echo "<form method=post class='form'>";
echo "<select name='id_tridy' class='select_archiv' onchange='Trida(this.value,35)'>";
echo "<option value=''>Vyber tridu:</option>";


$sql = "SELECT archiv.trida as trida FROM archiv JOIN uzivatel ON archiv.id_zaka=uzivatel.id WHERE uzivatel.id = ? GROUP BY `trida`";
if ($stmt1 = $db->prepare($sql)) {
    $stmt1->bind_param("i",$id);
    $stmt1->execute();
    $data1 = $stmt1->get_result();
    $zaznam1 = $data1->fetch_all(MYSQLI_ASSOC);
    if (count($zaznam1) > 0) {
        foreach ($zaznam1 as $row) {
            echo "<option value='$row[trida]'>$row[trida]</option>";
        }
    }else{
        echo "Nejsou tu zadne tridy.";
    }
}

echo "</select>";
echo "<button type='submit' class='odesilani_archiv' name='send'>Odeslat</button>";
echo "</form>";
?>
<?php
if (isset($_POST["send"])) {

    $q = $_POST["id_tridy"];
    $sql2 = "SELECT archiv.trida as tr, archiv.pololeti as p, predmety.nazev as n, archiv.znamky as z FROM archiv JOIN uzivatel ON archiv.id_zaka=uzivatel.id JOIN predmety ON predmety.id=archiv.id_predmet WHERE uzivatel.id = ? AND archiv.trida =?";
    if ($stmt2 = $db->prepare($sql2)) {
        $stmt2->bind_param("ii",$id, $q);
        $stmt2->execute();
        $data2 = $stmt2->get_result();
        $zaznam2 = $data2->fetch_all(MYSQLI_ASSOC);
        if (count($zaznam2) > 0) {
            echo "<table>";
            echo "<tr><th>Pololetí</th><th>Předmět</th><th>Známka</th></tr>";
            foreach ($zaznam2 as $row2) {
                echo "<tr><td>{$row2["p"]}</td><td>{$row2["n"]}</td><td>{$row2["z"]}</td></tr>";
            }
            echo "</table>";
        }
    }
}
?>
<?php
include "../htmlKomponenty/footer.php";
?>