<?php

class SelectUcitele
{

    public static function vypisUcitelePridani($db)
    {
        $sql = "SELECT * FROM uzivatel WHERE opravneni = 1 OR opravneni = 0";
        if ($stmt = $db->prepare($sql)) {
            $stmt->execute();
            $data = $stmt->get_result();
            $zaznam = $data->fetch_all(MYSQLI_ASSOC);
            if (count($zaznam) > 0) {
                echo "<select name='id_ucitele'>";
                foreach ($zaznam as $row) {
                    echo "<option value='$row[id]'>" . $row[prijmeni] . " " . $row[jmeno] . " (" . $row[login] . ")</option>";
                }
                echo "</select>";
            } else {
                echo "<p class='hlaska'>Nejsou tu žádní učitelé.</p>";
            }
        }
    }

    public static function VypisUcitele($db)
    {
        $sql = "SELECT uzivatel.jmeno as jmeno, uzivatel.prijmeni as prijmeni, uzivatel.login as login, uzivatel.id as idU FROM uzivatel WHERE uzivatel.opravneni = 1 ORDER by uzivatel.jmeno";
        if ($stmt = $db->prepare($sql)) {
            $stmt->execute();
            $data = $stmt->get_result();
            $zaznam = $data->fetch_all(MYSQLI_ASSOC);
            if (count($zaznam) > 0) {
                echo "<table>";
                echo "<tr><th>Jméno</th><th>Příjmení</th><th>Login</th><th>Změnit heslo</th><th>Upravit</th><th>Smazat</th></tr>";
                foreach ($zaznam as $row) {
                    echo "<tr>";
                    echo "<td>{$row['jmeno']}</td>";
                    echo "<td>{$row['prijmeni']}</td>";
                    echo "<td>{$row['login']}</td>";
                    echo "<td><a href='heslo_zmena.php?id=$row[idU]'><img src='../images/icon_uprava.png' class='upravit' alt='upravit'></a></td>";
                    echo "<td><a href='update/uprava.php?id=$row[idU]'><img src='../images/icon_uprava.png' class='upravit' alt='upravit'></a></td>";
                    echo "<td><a href='delete/mazani_ucitel.php?id=$row[idU]'><img src='../images/icon_delete.png' class='smazat' alt='smazat'></a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='hlaska'>Nejsou tu žádní učitelé.</p>";
            }
        }
    }

    public static function JeUcitel($db, $id)
    {
        $stmt = $db->prepare("SELECT opravneni FROM uzivatel WHERE id =? limit 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $zaznam = $result->fetch_assoc();

        if ($zaznam["opravneni"] == 1) {
            return "ucitel";
        } elseif ($zaznam["opravneni"] == 2) {
            return "zak";
        } else {
            return "jine";
        }
    }

    public static function VypisUcitelePredmetu($db)
    {
        $sql = "SELECT uzivatel.jmeno as jmeno, uzivatel.prijmeni as prijmeni, uzivatel.login as login, predmety.nazev as nazev, uzivatel.id as idU, predmety.id as idP, propojeni_ucitel_predmety.id as id FROM propojeni_ucitel_predmety JOIN uzivatel ON propojeni_ucitel_predmety.id_ucitel = uzivatel.id JOIN predmety ON propojeni_ucitel_predmety.id_predmet = predmety.id ORDER by uzivatel.login";
        if ($stmt = $db->prepare($sql)) {
            $stmt->execute();
            $data = $stmt->get_result();
            $zaznam = $data->fetch_all(MYSQLI_ASSOC);
            if (count($zaznam) > 0) {
                $idcko = -1;
                echo "<table class='specialni-tabulka'>";
                echo "<tr><th>Jméno</th><th>Příjmení</th><th>Login</th><th>Předmět</th><th>Smazat</th></tr>";
                foreach ($zaznam as $row) {
                    if ($idcko != $row['idU']) {
                        $idcko = $row['idU'];
                        $sql1 = "SELECT COUNT(predmety.nazev) as pocet FROM propojeni_ucitel_predmety JOIN uzivatel ON propojeni_ucitel_predmety.id_ucitel = uzivatel.id JOIN predmety ON propojeni_ucitel_predmety.id_predmet = predmety.id WHERE uzivatel.id = ?";
                        if ($stmt1 = $db->prepare($sql1)) {
                            $stmt1->bind_param("i", $row['idU']);
                            $stmt1->execute();
                            $data1 = $stmt1->get_result();
                            $zaznam1 = $data1->fetch_all(MYSQLI_ASSOC);
                            if (count($zaznam1) > 0) {
                                foreach ($zaznam1 as $row1) {
                                    $cislo = $row1['pocet'];
                                    echo "<tr><td class='tabulka_text' rowspan='{$cislo}'><p>{$row['jmeno']}</p></td>";
                                    echo "<td class='tabulka_text' rowspan='{$cislo}'>{$row['prijmeni']}</td>";
                                    echo "<td class='tabulka_text' rowspan='{$cislo}'>{$row['login']}</td>";
                                }
                            }
                        }
                    }
                    echo "<td>{$row['nazev']}</td>";
                    echo "<td><a href='../delete/mazani_ucitel_predmet.php?id=$row[id]'><img src='/iwww_semestralni_prace/images/icon_delete.png' class='smazat1' alt='smazat'></a></td><tr>";

                }
                echo "</table>";
            } else {
                echo "<p class='hlaska'>Nejsou tu žádné záznamy.</p>";
            }
        }
    }

    public static function VypisUcitelPredmetTrida($db)
    {
        $sql = "SELECT tridy.nazev as trida, predmety.nazev as predmety, predmety.id as id, tridy.id as id2 FROM propojeni_trida_predmety JOIN tridy ON propojeni_trida_predmety.id_trida = tridy.id JOIN predmety ON propojeni_trida_predmety.id_predmet = predmety.id ORDER BY tridy.nazev";
        if ($stmt = $db->prepare($sql)) {
            $stmt->execute();
            $data = $stmt->get_result();
            $zaznam = $data->fetch_all(MYSQLI_ASSOC);
            if (count($zaznam) > 0) {
                $i = 0;
                $smaz = 0;
                $z = 0;
                $idcko = -1;
                echo "<form >";
                echo "<table>";
                echo "<tr><th>Třída</th><th>Předmět</th><th>Učitel</th></tr>";
                foreach ($zaznam as $row) {
                    $i++;
                    echo "<tr>";
                    if ($idcko != $row['id2']) {
                        $idcko = $row['id2'];

                        $sql5 = "SELECT COUNT(predmety.id) as pocet FROM propojeni_trida_predmety JOIN tridy ON propojeni_trida_predmety.id_trida = tridy.id JOIN predmety ON propojeni_trida_predmety.id_predmet = predmety.id WHERE tridy.id = {$row['id2']}";
                        if ($stmt5 = $db->prepare($sql5)) {
                            $stmt5->execute();
                            $data5 = $stmt5->get_result();
                            $zaznam5 = $data5->fetch_all(MYSQLI_ASSOC);
                            if (count($zaznam5) > 0) {
                                foreach ($zaznam5 as $row5) {
                                    $cislo = $row5['pocet'];
                                    echo "<td class='td_special{$z}' rowspan='{$cislo}'>{$row['trida']}</td>";
                                    if ($z == 0) {
                                        $z++;
                                    } else {
                                        $z = 0;
                                    }
                                }
                            }
                        }
                    }
                    echo "<td>{$row['predmety']}</td>";
                    $predmet = $row['id'];
                    $trida = $row['id2'];
                    echo "<td>";
                    $sql1 = "SELECT uzivatel.id as id1, uzivatel.prijmeni as prijmeni, uzivatel.jmeno as jmeno, uzivatel.login as login FROM propojeni_ucitel_predmety JOIN uzivatel ON propojeni_ucitel_predmety.id_ucitel = uzivatel.id JOIN predmety ON propojeni_ucitel_predmety.id_predmet = predmety.id WHERE predmety.id={$predmet}";
                    if ($stmt1 = $db->prepare($sql1)) {
                        $stmt1->execute();
                        $data1 = $stmt1->get_result();
                        $zaznam1 = $data1->fetch_all(MYSQLI_ASSOC);
                        if (count($zaznam1) > 0) {
                            echo "<select name='ucitele{$i}'>";
                            foreach ($zaznam1 as $row1) {
                                $ab81 = 0;
                                $sql4 = "SELECT * FROM `ucitel_predmet_trida`";
                                if ($stmt4 = $db->prepare($sql4)) {
                                    $stmt4->execute();
                                    $data4 = $stmt4->get_result();
                                    $zaznam4 = $data4->fetch_all(MYSQLI_ASSOC);
                                    if (count($zaznam4) > 0) {
                                        foreach ($zaznam4 as $row4) {
                                            if ($row['id2'] == $row4['id_trida'] && $row['id'] == $row4['id_predmet'] && $row1["id1"] == $row4['id_ucitel']) {
                                                echo "<option value='$row1[id1]' selected=selected>" . $row1['prijmeni'] . " " . $row1['jmeno'] . " (" . $row1['login'] . ")</option>";
                                                $ab81 = 1;
                                                break;
                                            }
                                        }
                                    } else {
                                        echo "<p class='hlaska'>Nejsou tu žádní učitelé.</p>";
                                    }
                                }
                                if ($ab81 == 0) {
                                    echo "<option value='$row1[id1]'>" . $row1['prijmeni'] . " " . $row1['jmeno'] . " (" . $row1['login'] . ")</option>";
                                }
                            }
                            echo "</select>";
                        } else {
                            echo "<p class='hlaska'>Nejsou tu žádní učitelé.</p>";
                        }
                    }
                    echo "</td>";
                    echo "</tr>";
                    if (count($zaznam) == $i) {
                        echo "<input type='submit' name='sended' value='odeslat'>";
                    }
                    echo "</form>";

                    if (isset($_POST["sended"])) {
                        if ($smaz == 0) {
                            $sql3 = "DELETE FROM ucitel_predmet_trida";
                            if ($stmt3 = $db->prepare($sql3)) {
                                $stmt3->execute();
                            } else {
                                echo "<td>Nefunguje mazání</td>";
                            }
                            $smaz = 1;
                        }

                        $sql2 = "INSERT INTO ucitel_predmet_trida (id_ucitel, id_predmet, id_trida) VALUES (?,?,?)";
                        if ($stmt2 = $db->prepare($sql2)) {
                            $idUcitel = $_POST["ucitele{$i}"];
                            $stmt2->bind_param("iii", $idUcitel, $predmet, $trida);
                            $stmt2->execute();
                        } else {
                            echo "<td>Nefunguje přidání</td>";
                        }
                    }

                }
                echo "</table>";
            }
        }


/*        if ($data = $db->query($sql)) {
            if ($data->num_rows > 0) {
                $i = 0;
                $smaz = 0;
                $z = 0;
                $idcko = -1;
                echo "<form >";
                echo "<table>";
                echo "<tr><th>Třída</th><th>Předmět</th><th>Učitel</th></tr>";

                while ($row = $data->fetch_assoc()) {
                    $i++;
                    echo "<tr>";

                    if ($idcko != $row['id2']) {
                        $idcko = $row['id2'];

                        $sql5 = "SELECT COUNT(predmety.id) as pocet FROM propojeni_trida_predmety JOIN tridy ON propojeni_trida_predmety.id_trida = tridy.id JOIN predmety ON propojeni_trida_predmety.id_predmet = predmety.id WHERE tridy.id = {$row['id2']}";
                        if ($data5 = $db->query($sql5)) {
                            if ($data5->num_rows > 0) {

                                while ($row5 = $data5->fetch_assoc()) {
                                    $cislo = $row5['pocet'];
                                    echo "<td class='td_special{$z}' rowspan='{$cislo}'>{$row['trida']}</td>";
                                    if ($z == 0) {
                                        $z++;
                                    } else {
                                        $z = 0;
                                    }
                                }
                            }
                        }
                    }

                    echo "<td>{$row['predmety']}</td>";
                    $predmet = $row['id'];
                    $trida = $row['id2'];

                    echo "<td>";
                    $sql1 = "SELECT uzivatel.id as id1, uzivatel.prijmeni as prijmeni, uzivatel.jmeno as jmeno, uzivatel.login as login FROM propojeni_ucitel_predmety JOIN uzivatel ON propojeni_ucitel_predmety.id_ucitel = uzivatel.id JOIN predmety ON propojeni_ucitel_predmety.id_predmet = predmety.id WHERE predmety.id={$predmet}";
                    if ($data1 = $db->query($sql1)) {
                        if ($data1->num_rows > 0) {

                            echo "<select name='ucitele{$i}'>";

                            while ($row1 = $data1->fetch_assoc()) {
                                $ab81 = 0;
                                $sql4 = "SELECT * FROM `ucitel_predmet_trida`";
                                if ($data4 = $db->query($sql4)) {
                                    if ($data4->num_rows > 0) {
                                        while ($row4 = $data4->fetch_assoc()) {
                                            if ($row['id2'] == $row4['id_trida'] && $row['id'] == $row4['id_predmet'] && $row1["id1"] == $row4['id_ucitel']) {
                                                echo "<option value='$row1[id1]' selected=selected>" . $row1['prijmeni'] . " " . $row1['jmeno'] . " (" . $row1['login'] . ")</option>";
                                                $ab81 = 1;
                                                break;
                                            }
                                        }
                                    }
                                }
                                if ($ab81 == 0) {
                                    echo "<option value='$row1[id1]'>" . $row1['prijmeni'] . " " . $row1['jmeno'] . " (" . $row1['login'] . ")</option>";
                                }

                            }
                            echo "</select>";
                        } else {
                            echo "<p class='hlaska'>Nejsou tu žádní učitelé.</p>";
                        }
                    }
                    echo "</td>";
                    echo "</tr>";
                    if ($data->num_rows == $i) {
                        echo "<input type='submit' name='sended' value='odeslat'>";
                    }
                    echo "</form>";

                    if (isset($_POST["sended"])) {
                        if ($smaz == 0) {
                            $sql3 = "DELETE FROM `ucitel_predmet_trida` WHERE `id`=`id`";
                            if ($db->query($sql3) == TRUE) {

                            } else {
                                echo "<td>Nefunguje</td>";
                            }
                            $smaz = 1;
                        }

                        $sql2 = "INSERT INTO ucitel_predmet_trida (id_ucitel, id_predmet, id_trida) VALUES ('{$_POST["ucitele{$i}"]}', '" . $predmet . "','" . $trida . "');";
                        if ($db->query($sql2) == TRUE) {

                        } else {
                            echo "<td>Nefunguje1</td>";
                        }
                    }
                }
            }
            echo "</table>";
        }*/
    }
}