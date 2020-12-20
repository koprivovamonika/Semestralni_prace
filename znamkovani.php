<?php
session_start();
include 'connection/Connection.php';
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
    </style>
    </head>
<?php
$db = Connection::spojeni();

echo "<h1 class='predmet'>Známkování</h1>";

$sql1 = "SELECT * FROM uzivatel WHERE login = ?";
if ($stmt1 = $db->prepare($sql1)) {
    $stmt1->bind_param("s",$_SESSION["login"]);
    $stmt1->execute();
    $data1 = $stmt1->get_result();
    $zaznam1 = $data1->fetch_all(MYSQLI_ASSOC);
    if (count($zaznam1) > 0) {
        foreach ($zaznam1 as $row1) {
            $id = $row1['id'];
        }
    } else {
        echo "<p class='hlaska'>Nejsou tu žádné záznamy.</p>";
    }
}


$sql = "SELECT predmety.nazev as nazev, predmety.id as id, tridy.id as id1, tridy.nazev as nazev1 FROM ucitel_predmet_trida JOIN predmety ON predmety.id=ucitel_predmet_trida.id_predmet JOIN tridy ON ucitel_predmet_trida.id_trida=tridy.id WHERE ucitel_predmet_trida.id_ucitel=?";
if ($stmt = $db->prepare($sql)) {
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $data = $stmt->get_result();
    $zaznam = $data->fetch_all(MYSQLI_ASSOC);
    if (count($zaznam) > 0) {
        foreach ($zaznam as $row) {
            echo "<a href='znamkovaniT1.php?id={$row['id']}&id1={$row['id1']}'><button class='znamkovani'>{$row['nazev']} {$row['nazev1']}</button></a>";
        }
    } else {
        echo "<p class='hlaska'>Nejsou tu žádné předměty.</p>";
    }
}
?>
<?php

include "./htmlKomponenty/footer.php";
?>