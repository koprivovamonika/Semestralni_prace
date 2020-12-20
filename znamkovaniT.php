<?php
session_start();
include 'connection/Connection.php';
if ($_SESSION["opravneni"] == 0) {
    Connection::opravneniA();
} else {
    Connection::opravneniU();
}

include './htmlKomponenty/header.php';
?>
    <style>
        .predmet {
            margin-top: 8%;
        }

        table {
            margin-top: 2%;
        }
    </style>
<?php
$db = Connection::spojeni();
$ql1 = "SELECT * FROM uzivatel WHERE login = ?";
if ($stmt1 = $db->prepare($ql1)) {
    $stmt1->bind_param("s",$_SESSION["login"]);
    $stmt1->execute();
    $data1 = $stmt1->get_result();
    $zaznam1 = $data1->fetch_all(MYSQLI_ASSOC);
    if (count($zaznam1) > 0) {
        foreach ($zaznam1 as $row1) {
            $idU = $row1['id'];
        }
    }else{
        echo "<p class='hlaska'>Tento učitel není v databázi.</p>";
    }
}


$idP = $_GET['idP'];
$idT = $_GET['idT'];

$ql2 = "SELECT tridy.nazev as trida, predmety.nazev as predmet FROM propojeni_trida_predmety JOIN predmety ON propojeni_trida_predmety.id_predmet = predmety.id JOIN tridy ON propojeni_trida_predmety.id_trida = tridy.id WHERE predmety.id = ? AND tridy.id = ?";
if ($stmt2 = $db->prepare($ql2)) {
    $stmt2->bind_param("ii",$idP, $idT);
    $stmt2->execute();
    $data2 = $stmt2->get_result();
    $zaznam2 = $data2->fetch_all(MYSQLI_ASSOC);
    if (count($zaznam2) > 0) {
        foreach ($zaznam2 as $row2) {
            echo "<h1 class='predmet'>Známkování {$row2['predmet']} v {$row2['trida']}</h1>";
        }
    }
}



$sql = "SELECT uzivatel.jmeno as jmeno, uzivatel.prijmeni as prijmeni, uzivatel.id as id FROM uzivatel JOIN propojeni_zak_trida ON uzivatel.id=propojeni_zak_trida.id_zak WHERE propojeni_zak_trida.id_trida=?";
if ($stmt = $db->prepare($sql)) {
    $stmt->bind_param("i",$idT);
    $stmt->execute();
    $data = $stmt->get_result();
    $zaznam = $data->fetch_all(MYSQLI_ASSOC);
    if (count($zaznam) > 0) {
        $i = 0;
        echo "<form method=post>";
        echo "<table>";
        echo "<tr><th>Žák</th><th>Známka</th><th>Váha</th></tr>";
        foreach ($zaznam as $row) {
            $i++;
            echo "<tr>";
            echo "<td>{$row['jmeno']} {$row['prijmeni']}</td>";
            $idZ = $row['id'];

            echo "<td>";
            echo "<select name='znamka{$i}' class='select_znamky'>";
            echo "<option value='1'>1</option>";
            echo "<option value='2'>2</option>";
            echo "<option value='3'>3</option>";
            echo "<option value='4'>4</option>";
            echo "<option value='5'>5</option>";
            echo "<option value='6'>N</option>";
            echo "</select>";
            echo "</td>";

            echo "<td>";
            echo "<select name='vaha{$i}' class='select_znamky'>";
            echo "<option value='1'>1</option>";
            echo "<option value='2'>2</option>";
            echo "<option value='3'>3</option>";
            echo "<option value='4'>4</option>";
            echo "<option value='5'>5</option>";
            echo "<option value='6'>6</option>";
            echo "<option value='7'>7</option>";
            echo "<option value='8'>8</option>";
            echo "<option value='9'>9</option>";
            echo "<option value='10'>10</option>";
            echo "</select>";
            echo "</td>";

            echo "</tr>";
            echo "<tr>";

            if (count($zaznam) == $i) {
                echo "<tr><td colspan='3'><input type='text' name='popis' placeholder='Popisek známky' required></td></tr>";
                echo "<td colspan='3'>";
                echo "<input type='submit' name='sended' value='odeslat' class='send1'>";
                echo "</td>";
            }

            echo "</tr>";
            echo "</form>";

            if (isset($_POST["sended"])) {
                if (empty($_POST["znamka1"])) {
                    echo "<p class='hlaska'>Vyplňte prosím formulář</p>";
                } else {

                    $sql2 = "INSERT INTO znamkovani (zak_id, predmet_id, znamka, vaha, popis)
				        VALUES (?,?,?,?,?);";
                    if ($stmt3 = $db->prepare($sql2)) {
                        $popis = htmlspecialchars($_POST["popis"]);
                        $stmt3->bind_param("iiiis", $idZ, $idP, $_POST["znamka{$i}"], $_POST["vaha{$i}"], $popis);
                        $stmt3->execute();
                        header("Location: znamkovaniT1.php?id=$idP&id1=$idT");
                    }
                }
            }
        }
        echo "</table>";
    }else{
        echo "<p class='hlaska'>Nejsou tu žádné záznamy.</p>";
    }
}

?>
<?php

include "./htmlKomponenty/footer.php";
?>