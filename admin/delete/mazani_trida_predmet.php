<meta charset="UTF-8">
<?php
session_start();
include "../../connection/Connection.php.php";

function smazPropojeniTridaPredmet($id)
{
    $db = Connection::spojeni();
    $sql = "DELETE FROM propojeni_trida_predmety WHERE id = ?";
    if($stmt = $db->prepare($sql)){
        $stmt->bind_param("i",$id);
        $stmt->execute();
        echo "Bylo odstraněno";
    }
}

smazPropojeniTridaPredmet($_GET["id"]);
header("Location: ../trida-predmet.php");
?>
