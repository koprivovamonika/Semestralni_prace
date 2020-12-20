<meta charset="UTF-8">
<?php
session_start();
include "../../connection/Connection.php";

function smazPredmet($id)
{
    $db = Connection::spojeni();
    $sql = "DELETE FROM predmety WHERE id = ?";
    if($stmt = $db->prepare($sql)){
        $stmt->bind_param("i",$id);
        $stmt->execute();
        echo "Bylo odstraněno";
    }

}

smazPredmet($_GET["id"]);
header("Location: ../insert/predmet.php");
?>

