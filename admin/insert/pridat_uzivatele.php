<?php
session_start();
include '../../connection/Connection.php';
include '../select/SelectTridy.php';
Connection::opravneniA();
include '../../htmlKomponenty/header.php';
$uzivatel = $_GET["opravneni"];
?>

<?php
if (isset($_POST["sended"])) {
    $test = 0;
    if (strlen($_POST["cislo"]) == 10) {
        $prvni = substr($_POST["cislo"], 0, 1);
        $druhe = substr($_POST["cislo"], 1, 1);
        $treti = substr($_POST["cislo"], 2, 1);
        $ctvrte = substr($_POST["cislo"], 3, 1);
        $pate = substr($_POST["cislo"], 4, 1);
        $seste = substr($_POST["cislo"], 5, 1);
        $sedme = substr($_POST["cislo"], 6, 1);
        $osme = substr($_POST["cislo"], 7, 1);
        $devate = substr($_POST["cislo"], 8, 1);
        $desate = substr($_POST["cislo"], 9, 1);
        $xyz = ($prvni + $treti + $pate + $sedme + $devate) - ($druhe + $ctvrte + $seste + $osme + $desate);
        if ($xyz % 11 == 0) {
            $test = 1;
        }
    } else if (strlen($_POST["cislo"]) == 9) {
        $test = 1;
    }
    $rc = $_POST["cislo"];
    $den = date("j");
    $mes = date("n");
    $rok = date("Y");
    $rok1 = $rok - 2000;
    $urok = substr($rc, 0, 2);
    $umes = substr($rc, 2, 2);
    $uden = substr($rc, 4, 2);

    $chyby = array();
    $mesic = ($umes > 12) ? $umes - 50 : $umes;
    if (!(strlen($rc) == 9 || strlen($rc) == 10)) {
        $chyby[] = "Rodné číslo nemá 10 (příp. 9 znaků).";
    }
    if ($den > 31) {
        $chyby[] = "Den nemůže mít víc než 31 dnů.";
    }
    if ($mesic > 12) {
        $chyby[] = "Měsíc nemůže být větší jak 12.";
    }


    if (empty($_POST["jmeno"]) || empty($_POST["prijmeni"]) || empty($_POST["cislo"])) {
        echo "Vyplň formulář";
    } else if (!preg_match("/^[0-9]{9,10}$/", $_POST["cislo"]) || $test != 1 || !empty($chyby)) {
        echo "<p class='hlaska'>Špatně jste vyplnili rodné číslo</p>\n";
        if (!empty($chyby)) {
            foreach ($chyby as $chyba) {
                echo "<p>$chyba</p>";
            }
        }
    } else {
        $jmeno = htmlspecialchars($_POST["jmeno"]);
        $prijmeni = htmlspecialchars($_POST["prijmeni"]);
        if ($uzivatel == 2) {
            $trida = $_POST["id_tridy"];
        }

        $db = Connection::spojeni();

        mb_internal_encoding('UTF-8');

        $log1 = mb_substr($jmeno, 0, 2);
        $log2 = mb_substr($prijmeni, 0, 3);
        $login = $log1 . $log2 . "1";
        $login = mb_strtolower($login, 'UTF-8');

        $utf8table = array("\xc3\xa1" => "a",
            "\xc3\xa4" => "a", "\xc4\x8d" => "c", "\xc4\x8f" => "d", "\xc3\xa9" => "e", "\xc4\x9b" => "e", "\xc3\xad" => "i", "\xc4\xbe" => "l", "\xc4\xba" => "l", "\xc5\x88" => "n", "\xc3\xb3" => "o",
            "\xc3\xb6" => "o", "\xc5\x91" => "o", "\xc3\xb4" => "o", "\xc5\x99" => "r", "\xc5\x95" => "r", "\xc5\xa1" => "s", "\xc5\xa5" => "t", "\xc3\xba" => "u", "\xc5\xaf" => "u", "\xc3\xbc" => "u",
            "\xc5\xb1" => "u", "\xc3\xbd" => "y", "\xc5\xbe" => "z", "\xc3\x81" => "A", "\xc3\x84" => "A", "\xc4\x8c" => "C", "\xc4\x8e" => "D", "\xc3\x89" => "E", "\xc4\x9a" => "E", "\xc3\x8d" => "I",
            "\xc4\xbd" => "L", "\xc4\xb9" => "L", "\xc5\x87" => "N", "\xc3\x93" => "O", "\xc3\x96" => "O", "\xc5\x90" => "O", "\xc3\x94" => "O", "\xc5\x98" => "R", "\xc5\x94" => "R", "\xc5\xa0" => "S",
            "\xc5\xa4" => "T", "\xc3\x9a" => "U", "\xc5\xae" => "U", "\xc3\x9c" => "U", "\xc5\xb0" => "U", "\xc3\x9d" => "Y", "\xc5\xbd" => "Z");
        $login = strtr($login, $utf8table);

        $i = 2;
        do {
            $sql1 = "SELECT * FROM uzivatel WHERE login=?";
            if ($stmt4 = $db->prepare($sql1)) {
                $stmt4->bind_param("s",$login);
                $stmt4->execute();
                $data4 = $stmt4->get_result();
                $zaznam4 = $data4->fetch_all(MYSQLI_ASSOC);
                if (count($zaznam4) > 0) {
                    foreach ($zaznam4 as $row4) {
                        $login = $log1 . $log2 . $i;
                        $login = mb_strtolower($login, 'UTF-8');
                        $utf8table = array("\xc3\xa1" => "a",
                            "\xc3\xa4" => "a", "\xc4\x8d" => "c", "\xc4\x8f" => "d", "\xc3\xa9" => "e", "\xc4\x9b" => "e", "\xc3\xad" => "i", "\xc4\xbe" => "l", "\xc4\xba" => "l", "\xc5\x88" => "n", "\xc3\xb3" => "o",
                            "\xc3\xb6" => "o", "\xc5\x91" => "o", "\xc3\xb4" => "o", "\xc5\x99" => "r", "\xc5\x95" => "r", "\xc5\xa1" => "s", "\xc5\xa5" => "t", "\xc3\xba" => "u", "\xc5\xaf" => "u", "\xc3\xbc" => "u",
                            "\xc5\xb1" => "u", "\xc3\xbd" => "y", "\xc5\xbe" => "z", "\xc3\x81" => "A", "\xc3\x84" => "A", "\xc4\x8c" => "C", "\xc4\x8e" => "D", "\xc3\x89" => "E", "\xc4\x9a" => "E", "\xc3\x8d" => "I",
                            "\xc4\xbd" => "L", "\xc4\xb9" => "L", "\xc5\x87" => "N", "\xc3\x93" => "O", "\xc3\x96" => "O", "\xc5\x90" => "O", "\xc3\x94" => "O", "\xc5\x98" => "R", "\xc5\x94" => "R", "\xc5\xa0" => "S",
                            "\xc5\xa4" => "T", "\xc3\x9a" => "U", "\xc5\xae" => "U", "\xc3\x9c" => "U", "\xc5\xb0" => "U", "\xc3\x9d" => "Y", "\xc5\xbd" => "Z");
                        $login = strtr($login, $utf8table);
                    }
                } else {
                    $login = $login;
                }
                $i++;
            }
        } while (count($zaznam4) > 0);

        $pismena1 = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        $pismena2 = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
        $cisla = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        $znaky = array("!", "_", "?", "-", "[", "]", "{", "}", "@", "$", "#");

        $rand = mt_rand(0, count($pismena1) - 1);
        $rand1 = mt_rand(0, count($pismena2) - 1);
        $rand2 = mt_rand(0, count($cisla) - 1);
        $rand3 = mt_rand(0, count($znaky) - 1);

        $cast1 = $pismena1[$rand];
        $cast2 = $pismena2[$rand1];
        $cast3 = $cisla[$rand2];
        $cast4 = $znaky[$rand3];

        $heslo = $cast1 . $cast2 . $cast4 . $cast3;

        for ($i = 0; $i < 3; $i++) {
            $nahoda = mt_rand(1, 2);
            $rand4 = mt_rand(0, count($pismena1) - 1);

            $pismena = 0;
            if ($nahoda == 1) {
                $pismena = $pismena1;
            } else if ($nahoda == 2) {
                $pismena = $pismena2;
            }

            $cast = $pismena[$rand4];
            $heslo = $heslo . $cast;
        }

        $hesloHash = password_hash($heslo, PASSWORD_BCRYPT);
        $email = $login . "@zsroven.cz";

        if ($uzivatel == 2) {
            $rodic = "r-" . $login;

            for ($i = 0; $i < 3; $i++) {
                $nahoda1 = mt_rand(1, 2);
                $rand5 = mt_rand(0, count($pismena1) - 1);

                $pismena = 0;
                if ($nahoda1 == 1) {
                    $pismena = $pismena1;
                } else if ($nahoda1 == 2) {
                    $pismena = $pismena2;
                }

                $cast1 = $pismena[$rand5];
                $hesloRV = $heslo . $cast1;
            }
            $hesloRHash = password_hash($hesloRV, PASSWORD_BCRYPT);
            $emailR = $rodic . "@zsroven.cz";
        }


        if ($uzivatel == 1) {
            $sql2 = "INSERT INTO `uzivatel`(`jmeno`, `prijmeni`, `rodne_cislo`, `login`, `heslo`, `hesloPuvodni`, `email`, `opravneni`) 
                        VALUES (?,?,?,?,?,?,?,?)";
            if ($stmt = $db->prepare($sql2)) {
                $o = 1;
                $stmt->bind_param("ssissssi", $jmeno, $prijmeni, $rc, $login, $hesloHash, $heslo, $email, $o);
                $stmt->execute();
                header("Location: ../ucitele.php");
            }
        } elseif ($uzivatel == 2) {
            $sql2 = "INSERT INTO `uzivatel`(`jmeno`, `prijmeni`, `rodne_cislo`, `login`, `heslo`, `hesloPuvodni`, `email`, `opravneni`) 
                        VALUES (?,?,?,?,?,?,?,?)";
            if ($stmt = $db->prepare($sql2)) {
                $o = 2;
                $stmt->bind_param("ssissssi", $jmeno, $prijmeni, $rc, $login, $hesloHash, $heslo, $email, $o);
                $stmt->execute();
            }

            $stmt1 = $db->prepare("select * from uzivatel where login=? limit 1");
            $stmt1->bind_param("s", $login);
            $stmt1->execute();
            $result = $stmt1->get_result();
            $zaznam = $result->fetch_assoc();
            $id = $zaznam["id"];

            $sql3 = "INSERT INTO propojeni_zak_trida(id_zak, id_trida) VALUES (?,?)";
            if ($stmt2 = $db->prepare($sql3)) {
                $stmt2->bind_param("ii", $id, $trida);
                $stmt2->execute();
            }

            $sql4 = "INSERT INTO `uzivatel`(`jmeno`, `prijmeni`,  `login`, `heslo`, `hesloPuvodni`, `email`, `opravneni`) 
                        VALUES (?,?,?,?,?,?,?)";
            if ($stmt3 = $db->prepare($sql4)) {
                $o = 3;
                $jmeno = $jmeno . " - rodič";
                $prijmeni = $prijmeni . " - rodič";
                $stmt3->bind_param("ssssssi", $jmeno, $prijmeni, $rodic, $hesloRHash, $hesloRV, $emailR, $o);
                $stmt3->execute();
            }
            header("Location: ../zaci.php");
        }

    }
}
?>

<form action="pridat_uzivatele.php?opravneni=<?php echo $uzivatel ?>" method="POST" class="form">
    <?php
    if ($uzivatel == 1) {
        echo "<h1 class='predmet'>Přidání učitele</h1>";
    } elseif ($uzivatel == 2) {
        echo "<h1 class='predmet'>Přidání žáka</h1>";
    }
    ?>
    <input type="text" name="jmeno" class="input" placeholder="Jméno" required>
    <input type="text" name="prijmeni" class="input" placeholder="Příjmení" required>
    <input type="number" name="cislo" class="input" placeholder="Rodné číslo" required>
    <?php
    if ($uzivatel == 2) {
        SelectTridy::VypisTridy(Connection::spojeni());
    }
    ?>
    <input type="submit" name="sended" class="send" value="odeslat">
</form>

<?php
include "../../htmlKomponenty/footer.php";
?>
