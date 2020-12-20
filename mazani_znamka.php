<meta charset="UTF-8">
<?php
session_start();
include "connection/Connection.php";

function smazZnamku($id)
{
    $db = Connection::spojeni();
    $sql = "DELETE FROM znamkovani WHERE id = ?";
    if($stmt = $db->prepare($sql)){
        $stmt->bind_param("i",$id);
        $stmt->execute();
        echo "Bylo odstraněno";
    }
}

$idP = $_GET["idP"];
$idT = $_GET["idT"];
smazZnamku($_GET["id"]);
header("Location: znamkovaniT1.php?id=$idP&id1=$idT");
?>

