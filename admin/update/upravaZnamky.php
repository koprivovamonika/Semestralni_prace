<?php
session_start();
include '../../htmlKomponenty/header.php';
?>
<style>
    #prvni {
        margin-top: 7%;
    }

    .mazani {
        margin-top: -0.5%;
    }
</style>
<?php


$id = $_GET['id'];
$idP = $_GET["idP"];
$idT = $_GET["idT"];

if (!isset($_SESSION["login"])) {
    header("Location: ../admin.php");
}
include '../../connection/Connection.php';
$db = Connection::spojeni();
$dotaz = "SELECT * FROM znamkovani WHERE id=?";
if ($stmt1 = $db->prepare($dotaz)) {
    $stmt1->bind_param("i",  $_GET['id']);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $zaznam = $result1->fetch_assoc();
}

if (isset($_POST["sended"])) {
    if (empty($_POST["znamka"]) || empty($_POST["vaha"])) {
        echo "Vyplň formulář";
    } else {
        $znamka = $_POST["znamka"];
        $vaha = $_POST["vaha"];
        $popisek = $_POST["popisek"];
        $sql = "UPDATE znamkovani SET znamka = ?, vaha = ? , popis =? WHERE znamkovani.id = '" . $_GET['id'] . "';";
        if ($stmt = $db->prepare($sql)) {
            $stmt->bind_param("iis", $znamka, $vaha, $popisek);
            $stmt->execute();
            header("Location: ../../znamkovaniT1.php?id=$idP&id1=$idT");
        } else {
            echo "<p>Nefunguje</p>`id` = " . $_GET['id'] . ";";
        }
    }
}
?>

<form action="" method="POST">
    <h1 class='predmet' id="prvni">Úprava známky</h1>
    <h2 class="form-popis">Popisek</h2>
    <input type="text" name="popisek" required value="<?php echo $zaznam['popis']; ?>">
    <h2 class="form-popis">Známka</h2>
    <select name="znamka">
        <?php
        echo "<option value='6' " . (6 == $_GET['id1'] ? "selected" : "") . ">N</option>";
        echo "<option value='1' " . (1 == $_GET['id1'] ? "selected" : "") . ">1</option>";
        echo "<option value='2' " . (2 == $_GET['id1'] ? "selected" : "") . ">2</option>";
        echo "<option value='3' " . (3 == $_GET['id1'] ? "selected" : "") . ">3</option>";
        echo "<option value='4' " . (4 == $_GET['id1'] ? "selected" : "") . ">4</option>";
        echo "<option value='5' " . (5 == $_GET['id1'] ? "selected" : "") . ">5</option>";
        ?>
    </select>
    <h2 class="form-popis">Váha</h2>
    <select name="vaha">
        <?php
        echo "<option value='1' " . (1 == $_GET['id2'] ? "selected" : "") . ">1</option>";
        echo "<option value='2' " . (2 == $_GET['id2'] ? "selected" : "") . ">2</option>";
        echo "<option value='3' " . (3 == $_GET['id2'] ? "selected" : "") . ">3</option>";
        echo "<option value='4' " . (4 == $_GET['id2'] ? "selected" : "") . ">4</option>";
        echo "<option value='5' " . (5 == $_GET['id2'] ? "selected" : "") . ">5</option>";
        echo "<option value='6' " . (6 == $_GET['id2'] ? "selected" : "") . ">6</option>";
        echo "<option value='7' " . (7 == $_GET['id2'] ? "selected" : "") . ">7</option>";
        echo "<option value='8' " . (8 == $_GET['id2'] ? "selected" : "") . ">8</option>";
        echo "<option value='9' " . (9 == $_GET['id2'] ? "selected" : "") . ">9</option>";
        echo "<option value='10' " . (10 == $_GET['id2'] ? "selected" : "") . ">10</option>";
        ?>
    </select>


    <input type="submit" name="sended" class="send" value="Odeslat">
</form>
<a href='../../mazani_znamka.php?id=<?php echo $id ?>&idP=<?php echo $idP ?>&idT=<?php echo $idT ?>'>
    <button class="mazani">Smazat</button>
</a>
<?php
include "../../htmlKomponenty/footer.php";
?>
