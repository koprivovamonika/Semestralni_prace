<meta charset="UTF-8">
<?php
session_start();
include "../connection/Connection.php";
include 'select/SelectZnamky.php';

function Konec()
{
    $db = Connection::spojeni();
    SelectZnamky::VypisArchivZak(Connection::spojeni(), 2);

    $sql = "DELETE FROM znamkovani";
    if ($db->query($sql) === TRUE) {
        echo "Údaje ze známkování byly odstraněny";
    } else {
        echo "Nejsou údaje";
    }

    $ql = "SELECT id FROM uzivatel JOIN propojeni_zak_trida ON propojeni_zak_trida.id_zak = uzivatel.id  WHERE id_trida=17 OR id_trida=18";
    if ($stmt = $db->prepare($ql)) {
        $stmt->execute();
        $data = $stmt->get_result();
        $zaznam = $data->fetch_all(MYSQLI_ASSOC);
        if (count($zaznam) > 0) {
            foreach ($zaznam as $row) {
                $ql2 = "DELETE FROM archiv WHERE id_zaka={$row['id']}";
                if ($db->query($ql2) === TRUE) {
                    echo "Záznam odstraněn";
                } else {
                    echo "Chyba";
                }
            }
        }
    }

    $sql2 = "DELETE FROM uzivatel JOIN propojeni_zak_trida ON propojeni_zak_trida.id_zak = uzivatel.id WHERE id_trida=18 OR id_trida = 17";
    if($stmt1 = $db->prepare($sql2)){
        $stmt1->execute();
        echo "Žáci byli odstraněni";
    }


    for ($i = 16; $i >= 1; $i--) {
        $sql3 = "UPDATE propojeni_zak_trida SET id_trida = ? WHERE id_trida=$i";
        if ($stmt2 = $db->prepare($sql3)) {
            $j = $i + 2;
            $stmt2->bind_param("i", $j);
            $stmt2->execute();
        } else {
            echo "Nejsou tu zadni zaci :-(((((";
        }
    }
}

Konec();
header("Location: admin.php");
?>