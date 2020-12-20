<meta charset="UTF-8">
<?php
session_start();
include "../../connection/Connection.php";

function smazPropojeniUcitelPredmet($id)
{
    $db = Connection::spojeni();
    $sql = "DELETE FROM propojeni_ucitel_predmety WHERE id = ?";
    if($stmt = $db->prepare($sql)){
        $stmt->bind_param("i",$id);
        $stmt->execute();
        echo "Bylo odstraněno";
    }
}

smazPropojeniUcitelPredmet($_GET["id"]);
header("Location: ../insert/ucitel-predmet.php");
?>
