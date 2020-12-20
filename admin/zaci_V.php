<?php
include '../connection/Connection.php';
$q = intval($_GET['q']);

$db = Connection::spojeni();
$sql = "SELECT uzivatel.jmeno as jmeno, uzivatel.prijmeni as prijmeni, uzivatel.login as login, tridy.nazev as nazev, uzivatel.id as idZ, tridy.id as idT FROM uzivatel JOIN propojeni_zak_trida ON uzivatel.id = propojeni_zak_trida.id_zak JOIN tridy ON propojeni_zak_trida.id_trida = tridy.id WHERE tridy.id=? ORDER BY uzivatel.prijmeni";
if ($stmt = $db->prepare($sql)) {
    $stmt->bind_param("i",$q);
    $stmt->execute();
    $data = $stmt->get_result();
    $zaznam = $data->fetch_all(MYSQLI_ASSOC);
    if (count($zaznam) > 0) {
        echo "<table class='special_table'>";
        echo "<tr><th>Třída</th><th>Jméno</th><th>Příjmení</th><th>Login</th><th>Změnit heslo</th><th>Upravit</th><th>Smazat</th></tr>";
        foreach ($zaznam as $row) {
            echo "<tr>";
            echo "<td>{$row['nazev']}</td>";
            echo "<td>{$row['jmeno']}</td>";
            echo "<td>{$row['prijmeni']}</td>";
            echo "<td><a href='../user/archiv2.php?id=$row[idZ]' class='archiv-odkaz'>{$row['login']}</a></td>";
            echo "<td><a href='heslo_zmena.php?id=$row[idZ]'><img src='../images/icon_uprava.png' class='upravit' alt='upravit'></a></td>";
            echo "<td><a href='update/uprava.php?id=$row[idZ]&id1=$row[idT]'><img src='../images/icon_uprava.png' class='upravit' alt='upravit'></a></td>";
            echo "<td><a href='delete/mazani.php?id=$row[idZ]'><img src='../images/icon_delete.png' class='smazat' alt='smazat'></a></td>";
            echo "<tr>";
        }
        echo "</table>";
    } else {
        echo "<b class='text'>Omlouváme se, ale nejsou tu žádní žáci.</b>";
    }
}

