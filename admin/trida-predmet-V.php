<?php

include '../connection/Connection.php';
$q = intval($_GET['q']);

$db = Connection::spojeni();
$sql = "SELECT tridy.nazev as trida, predmety.nazev as predmet, predmety.id as idP, tridy.id as idT, propojeni_trida_predmety.id as id FROM propojeni_trida_predmety JOIN tridy ON propojeni_trida_predmety.id_trida = tridy.id JOIN predmety ON propojeni_trida_predmety.id_predmet = predmety.id WHERE tridy.id=? ORDER BY `trida` ASC";
if ($stmt = $db->prepare($sql)) {
    $stmt->bind_param("i",$q);
    $stmt->execute();
    $data = $stmt->get_result();
    $zaznam = $data->fetch_all(MYSQLI_ASSOC);
    if (count($zaznam) > 0) {
        $idcko = -1;
        echo "<table id='tabulka'>";
        echo "<tr><th>Třída</th><th>Předmět</th><th>Smazat</th></tr>";
        foreach ($zaznam as $row) {
            echo "<tr>";
            if ($idcko != $row['idT']) {
                $idcko = $row['idT'];
                $sql1 = "SELECT COUNT(predmety.id) as pocet FROM propojeni_trida_predmety JOIN tridy ON propojeni_trida_predmety.id_trida = tridy.id JOIN predmety ON propojeni_trida_predmety.id_predmet = predmety.id WHERE tridy.id = ?";
                if ($stmt1 = $db->prepare($sql1)) {
                    $stmt1->bind_param("i",$row['idT']);
                    $stmt1->execute();
                    $data1 = $stmt1->get_result();
                    $zaznam1 = $data1->fetch_all(MYSQLI_ASSOC);
                    if (count($zaznam1) > 0) {
                        foreach ($zaznam1 as $row1) {
                            $cislo = $row1['pocet'];
                            echo "<td rowspan='{$cislo}'>{$row['trida']}</td>";
                        }
                    }
                }
            }
            echo "<td>{$row['predmet']}</td>";
            echo "<td><a href='delete/mazani_trida_predmet.php?id=$row[id]'><img src='../images/icon_delete.png' class='smazat' alt='smazat'></a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='hlaska'>Nejsou tu žádné předměty.</p>";
    }
}

