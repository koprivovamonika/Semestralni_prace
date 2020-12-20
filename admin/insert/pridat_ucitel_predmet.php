<?php
session_start();
include '../../connection/Connection.php';
include "../select/SelectUcitele.php";
include "../select/SelectPredmety.php";
Connection::opravneniA();
include '../../htmlKomponenty/header.php';
?>
<style>
    .hlaska {
        margin-top: 7%;
        position: relative;
        margin-bottom: -6%;
    }
</style>

<?php
if (isset($_POST["sended"])) {
    if (empty($_POST["id_ucitele"]) || empty($_POST["id_predmetu"])) {
        echo "<p class='hlaska'>Vyplň formulář</p>";
    } else {
        $db = Connection::spojeni();

        $ucitel = $_POST["id_ucitele"];
        $predmet = $_POST["id_predmetu"];


        $sql1 = "SELECT * FROM propojeni_ucitel_predmety JOIN ucitele ON propojeni_ucitel_predmety.id_ucitel = ucitele.id JOIN predmety ON propojeni_ucitel_predmety.id_predmet = predmety.id WHERE ucitele.id =? AND predmety.id = ?";
        if ($stmt1 = $db->prepare($sql1)) {
            $stmt1->bind_param("ii",$ucitel,$predmet);
            $stmt1->execute();
            $data1 = $stmt1->get_result();
            $zaznam1 = $data1->fetch_all(MYSQLI_ASSOC);
            if (count($zaznam1) > 0) {
                echo "<p class='hlaska'>Tento učitel již učí tento předmět, proto nelze toto propojení vytvořit.</p>";
            } else {
                $sql = "INSERT INTO propojeni_ucitel_predmety (id_ucitel, id_predmet) VALUES (?,?);";
                if ($stmt = $db->prepare($sql)) {
                    $stmt->bind_param("ii", $ucitel, $predmet);
                    $stmt->execute();
                    header("Location: ucitel-predmet.php");
                }
            }
        }
    }
}
?>

<form action="pridat_ucitel_predmet.php" method="POST" class="form">
    <h1 class='predmet'>Přidat učitelovi předmět</h1>
    <?php
    SelectUcitele::vypisUcitelePridani(Connection::spojeni());
    SelectPredmety::VypisPredmety(Connection::spojeni());
    ?>
    <input type="submit" name="sended" class="send" value="odeslat">
</form>
<?php
include "../../htmlKomponenty/footer.php";
?>
