<?php
include '../../connection/Connection.php';
$q = intval($_GET['q']);

$db = Connection::spojeni();
$sql = "SELECT * FROM predmety ORDER BY nazev ASC";
if ($stmt = $db->prepare($sql)) {
    $stmt->execute();
    $data = $stmt->get_result();
    $zaznam = $data->fetch_all(MYSQLI_ASSOC);
    if (count($zaznam) > 0) {
        echo "<div class='obaleni'>";
        foreach ($zaznam as $row) {

            $sql2 = "SELECT propojeni_trida_predmety.id_predmet FROM propojeni_trida_predmety WHERE id_trida=? AND id_predmet=?";
            if ($stmt2 = $db->prepare($sql2)) {
                $stmt2->bind_param("ii", $q, $row['id']);
                $stmt2->execute();
                $data2 = $stmt2->get_result();
                $zaznam_t = $data2->fetch_assoc();
                echo "<div class='obleni2'>";
                echo "<label class='con'>{$row['nazev']}<input type='checkbox' name='id_predmetu[]' value='{$row['id']}' " . ($zaznam_t['id_predmet'] == $row['id'] ? "checked" : "") . " >";
                echo "<span class='checkmark'></label>";
                echo "</div>";
            }
        }
        echo "</div>";
    } else {
        echo "Nejsou tu žádné predmety:-(((((";
    }
}

?>
