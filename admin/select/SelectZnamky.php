<?php


class SelectZnamky
{
    public static function VypisZnamky($db)
    {
        $ql1 = "SELECT * FROM uzivatel WHERE login = ?";
        if ($stmt = $db->prepare($ql1)) {
            $stmt->bind_param("s",$_SESSION["login"]);
            $stmt->execute();
            $data = $stmt->get_result();
            $zaznam = $data->fetch_all(MYSQLI_ASSOC);
            if (count($zaznam) > 0) {
                foreach ($zaznam as $rowH1) {
                    $id = $rowH1['id'];
                }
            } else {
                echo "Nejsou tu zadne zaznamy :-(((((";
            }
        }

        $sql = "SELECT predmety.nazev FROM znamkovani JOIN predmety ON znamkovani.predmet_id= predmety.id JOIN uzivatel ON znamkovani.zak_id=uzivatel.id WHERE uzivatel.id = ? GROUP BY predmety.nazev";
        if ($stmt1 = $db->prepare($sql)) {
            $stmt1->bind_param("i", $id);
            $stmt1->execute();
            $data1 = $stmt1->get_result();
            $zaznam1 = $data1->fetch_all(MYSQLI_ASSOC);
            if (count($zaznam1) > 0) {
                echo "<table>";
                echo "<tr><th>Předmět</th><th>Známky</th><th id ='posledni'>Průměr</th></tr>";
                foreach ($zaznam1 as $row) {
                    echo "<tr>";
                    echo "<td>{$row['nazev']}</td>";
                    echo "<td>";
                    $sql2 = "SELECT znamkovani.znamka as znamka, znamkovani.vaha as vaha, znamkovani.popis as popis FROM znamkovani JOIN uzivatel ON znamkovani.zak_id= uzivatel.id JOIN predmety ON znamkovani.predmet_id=predmety.id WHERE predmety.nazev=? AND uzivatel.id = ?";
                    if ($stmt2 = $db->prepare($sql2)) {
                        $stmt2->bind_param("si",$row['nazev'], $id);
                        $stmt2->execute();
                        $data2 = $stmt2->get_result();
                        $zaznam2 = $data2->fetch_all(MYSQLI_ASSOC);
                        if (count($zaznam2) > 0) {
                            $soucet = 0;
                            $soucet_vah = 0;
                            $n = true;
                            foreach ($zaznam2 as $row2) {
                                if ($row2['znamka'] < 6) {
                                    $soucet = $soucet + $row2['znamka'] * $row2['vaha'];
                                    $soucet_vah = $soucet_vah + $row2['vaha'];
                                } else {
                                    $prumer = "n";
                                    $n = false;
                                }
                                if ($row2['znamka'] == 6) {
                                    $row2['znamka'] = "n";
                                }

                                if ($row2['vaha'] == 1) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha1' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 2) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha2' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 3) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha3' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 4) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha4' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 5) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha5' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 6) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha6' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 7) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha7' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 8) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha8' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 9) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha9' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 10) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha10' id='znamka'>{$row2['znamka']}</div></a>";
                                }
                            }
                            echo "</td>";
                            if ($n) {
                                $prumer = $soucet / $soucet_vah;
                            }
                            echo "<td id='posledni'>" . round($prumer, 2) . "</td>";
                        } else {
                            echo "Nejsou tu žádné záznamy";
                        }
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "Nejsou tu žádné známky";
            }
        }
    }

    public static function VypisZnamkyRodic($db)
    {
        $login = $_SESSION["login"];
        $loginZak = substr($login, 2, strlen($login));
        $ql1 = "SELECT * FROM uzivatel WHERE login = ?";
        if ($stmt = $db->prepare($ql1)) {
            $stmt->bind_param("s",$loginZak);
            $stmt->execute();
            $data = $stmt->get_result();
            $zaznam = $data->fetch_all(MYSQLI_ASSOC);
            if (count($zaznam) > 0) {
                foreach ($zaznam as $rowH1) {
                    $id = $rowH1['id'];
                    $jmeno = $rowH1['jmeno'];
                    $prijmeni = $rowH1['prijmeni'];
                }
            } else {
                echo "Nejsou tu zadne zaznamy :-(((((";
            }
        }

        $sql = "SELECT predmety.nazev FROM znamkovani JOIN predmety ON znamkovani.predmet_id= predmety.id JOIN uzivatel ON znamkovani.zak_id=uzivatel.id WHERE uzivatel.id = ? GROUP BY predmety.nazev";
        if ($stmt1 = $db->prepare($sql)) {
            $stmt1->bind_param("i",$id);
            $stmt1->execute();
            $data1 = $stmt1->get_result();
            $zaznam1 = $data1->fetch_all(MYSQLI_ASSOC);
            if (count($zaznam1) > 0) {
                echo "<br><br><div class='zak'>Známky žáka: " . $jmeno . " " . $prijmeni . "</div>";
                echo "<table>";
                echo "<tr><th>Předmět</th><th>Známky</th><th id='posledni'>Průměr</th></tr>";
                foreach ($zaznam1 as $row) {
                    echo "<tr>";
                    echo "<td>{$row['nazev']}</td>";
                    echo "<td>";

                    $sql2 = "SELECT znamkovani.znamka as znamka, znamkovani.vaha as vaha, znamkovani.popis as popis FROM znamkovani JOIN uzivatel ON znamkovani.zak_id= uzivatel.id JOIN predmety ON znamkovani.predmet_id=predmety.id WHERE predmety.nazev=? AND uzivatel.id = ?";
                    if ($stmt2 = $db->prepare($sql2)) {
                        $stmt2->bind_param("si",$row['nazev'],$id);
                        $stmt2->execute();
                        $data2 = $stmt2->get_result();
                        $zaznam2 = $data2->fetch_all(MYSQLI_ASSOC);
                        if (count($zaznam2) > 0) {
                            $soucet = 0;
                            $soucet_vah = 0;
                            $n = true;
                            foreach ($zaznam2 as $row2) {
                                if ($row2['znamka'] < 6) {
                                    $soucet = $soucet + $row2['znamka'] * $row2['vaha'];
                                    $soucet_vah = $soucet_vah + $row2['vaha'];
                                } else {
                                    $prumer = "n";
                                    $n = false;
                                }
                                if ($row2['znamka'] == 6) {
                                    $row2['znamka'] = "n";
                                }

                                if ($row2['vaha'] == 1) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha1' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 2) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha2' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 3) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha3' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 4) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha4' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 5) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha5' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 6) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha6' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 7) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha7' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 8) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha8' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 9) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha9' id='znamka'>{$row2['znamka']}</div></a>";
                                } else if ($row2['vaha'] == 10) {
                                    echo "<a title = '{$row2['popis']}, váha: {$row2['vaha']}'><div class='vaha10' id='znamka'>{$row2['znamka']}</div></a>";
                                }
                            }
                            echo "</td>";
                            if ($n) {
                                $prumer = $soucet / $soucet_vah;
                            }
                            echo "<td id='posledni'>" . round($prumer, 2) . "</td>";
                        } else {
                            echo "Nejsou tu zadne zaznamy :-(((((";
                        }
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "Nejsou tužádné známky.";
            }
        }
    }

    public static function VypisArchivZak($db, $pololeti)
    {
        $poleZnamky = array();
        $polePredmety = array();
        $prvek = 0;
        $prvek2 = 0;
        $pruchod = 0;

        $sql1 = "SELECT * FROM uzivatel WHERE opravneni = 2";
        if ($stmt = $db->prepare($sql1)) {
            $stmt->execute();
            $data = $stmt->get_result();
            $zaznam = $data->fetch_all(MYSQLI_ASSOC);
            if (count($zaznam) > 0) {
                foreach ($zaznam as $rowSuper) {
                    $pruchod++;
                    echo " " . $pruchod . " ";
                    $idZ = $rowSuper['id'];
                    echo $idZ;
                    $ql1 = "SELECT uzivatel.id as id, uzivatel.jmeno as jmeno, uzivatel.prijmeni as prijmeni, tridy.nazev as nazev FROM uzivatel JOIN propojeni_zak_trida ON propojeni_zak_trida.id_zak=uzivatel.id JOIN tridy ON tridy.id = propojeni_zak_trida.id_trida WHERE uzivatel.id = ? ";
                    if ($stmt1 = $db->prepare($ql1)) {
                        $stmt1->bind_param("i",$idZ);
                        $stmt1->execute();
                        $data1 = $stmt1->get_result();
                        $zaznam1 = $data1->fetch_all(MYSQLI_ASSOC);
                        if (count($zaznam1) > 0) {
                            foreach ($zaznam1 as $rowH1) {
                                $id = $rowH1['id'];
                                $trida = $rowH1['nazev'];
                                if ($trida == "1.A" || $trida == "1.B")
                                    $tr = "1.třída";
                                elseif ($trida == "2.A" || $trida == "2.B")
                                    $tr = "2.třída";
                                elseif ($trida == "3.A" || $trida == "3.B")
                                    $tr = "3.třída";
                                elseif ($trida == "4.A" || $trida == "4.B")
                                    $tr = "4.třída";
                                elseif ($trida == "5.A" || $trida == "5.B")
                                    $tr = "5.třída";
                                elseif ($trida == "6.A" || $trida == "6.B")
                                    $tr = "6.třída";
                                elseif ($trida == "7.A" || $trida == "7.B")
                                    $tr = "7.třída";
                                elseif ($trida == "8.A" || $trida == "8.B")
                                    $tr = "8.třída";
                                elseif ($trida == "9.A" || $trida == "9.B")
                                    $tr = "9.třída";
                            }
                        } else {
                            echo "Chyba";
                        }
                    }

                    $sql = "SELECT predmety.nazev, predmety.id FROM znamkovani JOIN predmety ON znamkovani.predmet_id= predmety.id JOIN uzivatel ON znamkovani.zak_id=uzivatel.id WHERE uzivatel.id = ? GROUP BY predmety.id";
                    if ($stmt2 = $db->prepare($sql)) {
                        $stmt2->bind_param("i", $idZ);
                        $stmt2->execute();
                        $data2 = $stmt2->get_result();
                        $zaznam2 = $data2->fetch_all(MYSQLI_ASSOC);
                        if (count($zaznam2) > 0) {
                            foreach ($zaznam2 as $row) {
                                $idP = $row['id'];
                                $polePredmety[$prvek2] = $row['nazev'];
                                $prvek2++;

                                $sql2 = "SELECT znamkovani.znamka as znamka, znamkovani.vaha as vaha, znamkovani.popis as popis FROM znamkovani JOIN uzivatel ON znamkovani.zak_id= uzivatel.id JOIN predmety ON znamkovani.predmet_id=predmety.id WHERE predmety.nazev=? AND uzivatel.id = ?";
                                if ($stmt3 = $db->prepare($sql2)) {
                                    $stmt3->bind_param("si", $row['nazev'],$idZ);
                                    $stmt3->execute();
                                    $data3 = $stmt3->get_result();
                                    $zaznam3 = $data3->fetch_all(MYSQLI_ASSOC);
                                    if (count($zaznam3) > 0) {
                                        $soucet = 0;
                                        $soucet_vah = 0;
                                        $n = true;
                                        foreach ($zaznam3 as $row2) {
                                            if ($row2['znamka'] < 6) {
                                                $soucet = $soucet + $row2['znamka'] * $row2['vaha'];
                                                $soucet_vah = $soucet_vah + $row2['vaha'];
                                            } else {
                                                $pr = 0;
                                                $n = false;
                                            }
                                            if ($row2['znamka'] == 6) {
                                                $row2['znamka'] = "n";
                                            }
                                        }
                                        if ($n) {
                                            $prumer = $soucet / $soucet_vah;
                                            $pr = round($prumer);
                                            $poleZnamky[$prvek] = $pr;
                                            $prvek++;
                                        }
                                    } else {
                                        echo "Nejsou tu zadne zaznamy :-(((((";
                                    }
                                }

                                $kontrola = "SELECT * FROM archiv WHERE id_zaka=? AND id_predmet=? AND trida=? AND pololeti=?";
                                if ($stmt5 = $db->prepare($kontrola)) {
                                    $stmt5->bind_param("iiii", $idZ, $idP, $tr, $pololeti);
                                    $stmt5->execute();
                                    $data5 = $stmt5->get_result();
                                    $zaznam5 = $data5->fetch_all(MYSQLI_ASSOC);
                                    if (count($zaznam5) > 0) {

                                    } else {
                                        $sqlko = "INSERT INTO `archiv` (id_zaka, trida, pololeti, id_predmet, znamky)
				                            VALUES (?,?,?,?,?);";
                                        if ($stmt4 = $db->prepare($sqlko)) {
                                            $stmt4->bind_param("isiii", $idZ, $tr, $pololeti, $idP, $pr);
                                            $stmt4->execute();
                                        } else {
                                            echo "UPS";
                                        }
                                    }
                                }
                            }
                        } else {
                            echo "<p class='hlaska'>CHYBA</p>";
                        }
                    }
                }
            } else {
                echo "Nejsou tu zadne zaznamy :-(((((";
            }
        }
    }
}