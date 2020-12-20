<?php
session_start();
include '../connection/Connection.php';
$q = intval($_GET['q']);

$db = Connection::spojeni();
$sql = "SELECT archiv.trida as tr, archiv.pololeti as p, predmety.nazev as n, archiv.znamky as z FROM archiv JOIN uzivatel ON archiv.id_zaka=uzivatel.id JOIN predmety ON predmety.id=archiv.id_predmet WHERE uzivatel.login = ? AND archiv.trida =?";
if ($stmt = $db->prepare($sql)) {
    $stmt->bind_param("si",$_SESSION["login"],$q);
    $stmt->execute();
    $data = $stmt->get_result();
    $zaznam = $data->fetch_all(MYSQLI_ASSOC);
    if (count($zaznam) > 0) {
        echo "<table>";
        echo "<tr><th>Pololetí</th><th>Předmět</th><th>Známka</th></tr>";
        foreach ($zaznam as $row) {
            echo "<tr><td>{$row["p"]}</td><td>{$row["n"]}</td><td>{$row["z"]}</td></tr>";
        }
        echo "</table>";
    }
}


