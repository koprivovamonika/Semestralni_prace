<?php
session_start();
include 'connection/Connection.php';
$db = Connection::spojeni();
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

    .tab {
        margin-top: -5vw;
    }
</style>
<?php
$jmeno = htmlspecialchars($_GET["jmeno"]);
$prijmeni = htmlspecialchars($_GET["prijmeni"]);
echo "<h1 class='predmet'>Známkování žáka: {$jmeno}  {$prijmeni}</h1>";

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
        echo "<p class='hlaska'>Chybička.</p>";
    }
}
$idP = $_GET['idP'];
$idT = $_GET['idT'];
$idZak = $_GET['idZ'];


if (isset($_POST["sended"])) {
    if (empty($_POST["popis"])) {
        echo "<p class='hlaska'>Zadejte prosím popisek známky</p>";
    } else {

        $sql2 = "INSERT INTO znamkovani (zak_id, predmet_id, znamka, vaha, popis)
				VALUES (?,?,?,?,?);";
        if ($stmt = $db->prepare($sql2)) {
            $popisek = htmlspecialchars($_POST["popis"]);
            $stmt->bind_param("iiiis", $idZak, $idP, $_POST["znamka"], $_POST["vaha"], $popisek);
            $stmt->execute();
            header("Location: znamkovaniT1.php?id=$idP&id1=$idT");
        }
    }
}
?>
<form method="post" id="formular_znamkovani">
    <table class="tab">
        <tr>
            <th>Žák</th>
            <th>Známka</th>
            <th>Váha</th>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($_GET['jmeno']) . " " . htmlspecialchars($_GET['prijmeni']) ?></td>
            <td>
                <select name='znamka' class='select_znamky'>
                    <option value='1'>1</option>
                    <option value='2'>2</option>
                    <option value='3'>3</option>
                    <option value='4'>4</option>
                    <option value='5'>5</option>
                    <option value='6'>N</option>
                </select>
            </td>
            <td>
                <select name='vaha' class='select_znamky'>
                    <option value='1'>1</option>
                    <option value='2'>2</option>
                    <option value='3'>3</option>
                    <option value='4'>4</option>
                    <option value='5'>5</option>
                    <option value='6'>6</option>
                    <option value='7'>7</option>
                    <option value='8'>8</option>
                    <option value='9'>9</option>
                    <option value='10'>10</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="3"><input type='text' name='popis' placeholder='Popisek známky' required></td>
        </tr>
        <tr>
            <td colspan="3"><input type='submit' name='sended' value='odeslat' class='send1'></td>
        </tr>
    </table>
</form>
<?php
include "./htmlKomponenty/footer.php";
?>

