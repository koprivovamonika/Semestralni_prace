<meta charset="UTF-8">
<?php
session_start();
include "../connection/Connection.php";
include 'select/SelectZnamky.php';
function Konec()
{
    $db = Connection::spojeni();
    SelectZnamky::VypisArchivZak(Connection::spojeni(), 1);
    $sql = "DELETE FROM znamkovani";
    if($stmt = $db->prepare($sql)){
        $stmt->execute();
        echo "Údaje ze známkování byly odstraněny";
    }

}

Konec();
header("Location: admin.php");
?>

