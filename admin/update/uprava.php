<?php
session_start();
include '../../connection/Connection.php';
include '../select/SelectUcitele.php';
Connection::opravneniA();
include '../../htmlKomponenty/header.php';
?>
    <style>
        #prvni {
            margin-top: 7%;
        }

        .hlaska {
            margin-top: 7%;
            position: relative;
            margin-bottom: -6%;
        }
    </style>

<?php

$db = Connection::spojeni();
$stmt2 = $db->prepare("SELECT * FROM uzivatel WHERE id= ? limit 1");
$stmt2->bind_param("i", $_GET['id']);
$stmt2->execute();
$result2 = $stmt2->get_result();
$zaznam = $result2->fetch_assoc();



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
    if (empty($_POST["jmeno"]) || empty($_POST["prijmeni"]) || empty($_POST["cislo"])) {
        echo "<p class='hlaska'>Vyplňte formulář</p>";
    } else if (!preg_match("/^[0-9]{9,10}$/", $_POST["cislo"]) || $test != 1) {
        echo "<p class='hlaska'>Špatně jste vyplnili rodné číslo</p>\n";
    } else {
        $jmeno = htmlspecialchars($_POST["jmeno"]);
        $prijmeni = htmlspecialchars($_POST["prijmeni"]);
        $rc = $_POST["cislo"];
        if (SelectUcitele::JeUcitel(Connection::spojeni(), $_GET['id']) == "zak") {
            $trida = $_POST["id_tridy"];
        }

        $db = Connection::spojeni();

        $den = date("j");
        $mes = date("n");
        $rok = date("Y");
        $rok1 = $rok - 2000;
        $urok = substr($rc, 0, 2);
        $umes = substr($rc, 2, 2);
        $uden = substr($rc, 4, 2);

        if ($umes > 32) {
            $pohlavi = "žena";
        } else {
            $pohlavi = "muž";
        }

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
        if (empty($chyby)) {
            $urok = ($rok1 < $urok) ? "19" . $urok : "20" . $urok;
            echo $urok;

            $vek = 2017 - $urok;
            if ($umes > $mes) {
                $vek = $vek - 1;
            } else if ($umes < $mes) {

            } else if ($umes = $mes && $uden > $den) {
                $vek = $vek - 1;
            } else if ($umes = $mes && $uden <= $den) {

            }

            $sql = "UPDATE uzivatel SET jmeno = ?, prijmeni = ?, rodne_cislo = ? WHERE uzivatel.id = " . $_GET['id'] . ";";
            if ($stmt = $db->prepare($sql)) {
                $stmt->bind_param("ssi", $jmeno, $prijmeni, $rc);
                $stmt->execute();

                if (SelectUcitele::JeUcitel(Connection::spojeni(), $_GET['id']) == "zak") {
                    $sql = "UPDATE propojeni_zak_trida SET id_trida = ? WHERE id_zak = " . $_GET['id'] . ";";
                    if ($stmt = $db->prepare($sql)) {
                        $stmt->bind_param("i", $trida);
                        $stmt->execute();
                    }
                    header("Location: ../zaci.php");
                } elseif (SelectUcitele::JeUcitel(Connection::spojeni(), $_GET['id']) == "ucitel") {
                    header("Location: ../ucitele.php");
                }

            } else {
                echo "<br><br><br><p>Nefunguje</p>";
            }
        } else {
            foreach ($chyby as $chyba) {
                echo "<br><br><br><br><p class='hlaska'>$chyba</p>";
            }
        }
    }
}
?>

    <form action="" method="POST">
        <h1 class='predmet' id="prvni">Úprava uživatele</h1>
        <input type="text" name="jmeno" required value="<?php echo $zaznam['jmeno']; ?>">
        <input type="text" name="prijmeni" required value="<?php echo $zaznam['prijmeni']; ?>">
        <input type="number" name="cislo" required value="<?php echo $zaznam['rodne_cislo']; ?>">

        <?php

        if (SelectUcitele::JeUcitel(Connection::spojeni(), $_GET['id']) == "zak") {
            $sql1 = "SELECT * FROM tridy ORDER BY tridy.nazev ASC";
            if ($stmt1 = $db->prepare($sql1)) {
                $stmt1->execute();
                $data1 = $stmt1->get_result();
                $zaznam1 = $data1->fetch_all(MYSQLI_ASSOC);
                if (count($zaznam1) > 0) {
                    echo "<select name=\"id_tridy\">";
                    foreach ($zaznam1 as $row) {
                        echo "<option value='{$row['id']}' " . ($row["id"] == $_GET[id1] ? "selected" : "") . ">{$row['nazev']}</option>\n";
                    }
                    echo "</select>";
                } else {
                    echo "<p class='hlaska'>Nejsou tu žádné třídy.</p>";
                }
            }
        }


        ?>


        <input type="submit" name="sended" class="send" value="Odeslat">
    </form>
<?php
include "../../htmlKomponenty/footer.php";
?>