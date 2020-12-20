<meta charset="UTF-8">
<?php
session_start();
include "../../connection/Connection.php";

function smazZaka($id)
{
    $db = Connection::spojeni();
    $sql = "DELETE FROM znamkovani WHERE zak_id = ?";
    if($stmt = $db->prepare($sql)){
        $stmt->bind_param("i",$id);
        $stmt->execute();
        echo "Bylo odstraněno";
    }

    $sql2 = "DELETE FROM archiv WHERE id_zaka = ?";
    if($stmt2 = $db->prepare($sql2)){
        $stmt2->bind_param("i",$id);
        $stmt2->execute();
        echo "Bylo odstraněno";
    }

    $sql1 = "DELETE FROM uzivatel WHERE id = ?";
    if($stmt1 = $db->prepare($sql1)){
        $stmt1->bind_param("i",$id);
        $stmt1->execute();
        echo "Bylo odstraněno";
    }
}

smazZaka($_GET["id"]);
header("Location: ../zaci.php");
?>
