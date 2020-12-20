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
        a {
            color: white;
            text-decoration: none;
        }

        .barva {
            color: black;
        }

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

$idP = $_GET['id'];
$idT = $_GET['id1'];
$prumer = 0;
$n = true;

$ql2 = "SELECT tridy.nazev as trida, predmety.nazev as predmet FROM propojeni_trida_predmety JOIN predmety ON propojeni_trida_predmety.id_predmet = predmety.id JOIN tridy ON propojeni_trida_predmety.id_trida = tridy.id WHERE predmety.id =? AND tridy.id = ?";
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
    $stmt->bind_param("i", $idT);
    $stmt->execute();
    $data = $stmt->get_result();
    $zaznam = $data->fetch_all(MYSQLI_ASSOC);
    if (count($zaznam) > 0) {
        $i = 0;
        echo "<form method=post>";
        echo "<table>";
        echo "<tr><th>Žák</th><th>Známky</th><th>Průměr</th><th>Přidat známku</th></tr>";
        foreach ($zaznam as $row) {
            $i++;
            echo "<tr>";
            echo "<td>{$row['jmeno']} {$row['prijmeni']}</td>";
            echo "<td>";
            $idZak = $row['id'];


            $sql2 = "SELECT znamkovani.znamka as znamka, znamkovani.vaha as vaha ,znamkovani.popis, znamkovani.id as idZ FROM znamkovani JOIN uzivatel ON znamkovani.zak_id= uzivatel.id JOIN predmety ON znamkovani.predmet_id=predmety.id WHERE predmety.id=? AND uzivatel.id = ?";
            if ($stmt3 = $db->prepare($sql2)) {
                $stmt3->bind_param("ii", $idP, $row['id']);
                $stmt3->execute();
                $data3 = $stmt3->get_result();
                $zaznam3 = $data3->fetch_all(MYSQLI_ASSOC);
                if (count($zaznam3) > 0) {
                    $soucet = 0;
                    $soucet_vah = 0;
                    foreach ($zaznam3 as $row3) {
                        if ($row3['znamka'] < 6) {
                            $soucet = $soucet + $row3['znamka'] * $row3['vaha'];
                            $soucet_vah = $soucet_vah + $row3['vaha'];
                        } else {
                            $prumer = "N";
                            $n = false;
                        }
                        if ($row3['znamka'] == 6) {
                            $row3['znamka'] = "N";
                        }
                        echo "<div class='znamka'><a href='admin/update/upravaZnamky.php?id=$row3[idZ]&id1={$row3['znamka']}&id2={$row3['vaha']}&idP={$idP}&idT={$idT}' class='barva' title='{$row3['popis']}, váha: {$row3['vaha']}'>{$row3['znamka']}</a></div>";

                    }
                    if ($n) {
                        $prumer = $soucet / $soucet_vah;
                    } else {
                        $prumer = "N";
                    }
                } else {
                    echo "<p class='hlaska'>Nejsou tu žádné předměty.</p>";
                }
            }

            echo "</td>";
            if ($n) {
                echo "<td>" . round($prumer, 2) . "</td>";
            } else {
                echo "<td>" . $prumer . "</td>";
            }

            echo "<td><a href='znamkovani_jednotlive.php?idP={$idP}&idT={$idT}&idZ={$idZak}&jmeno={$row['jmeno']}&prijmeni={$row['prijmeni']}' class='tl_znamkovat'>Známkovat</a></td>";
            echo "</tr>";

            $n = true;
        }
        echo "</table>";
        echo "<a href='znamkovaniT.php?idP={$idP}&idT={$idT}' class='a-znamkovani'>Přidat známku</a>";
    }else{
        echo "<p class='hlaska'>V této třídě nejsou žádní žáci.</p>";
    }
}
?>
<?php

include "./htmlKomponenty/footer.php";
?>