<?php


class SelectTridy
{
    public static function VypisTridy($db)
    {
        $sql = "SELECT * FROM tridy ORDER BY nazev ASC";
        if ($stmt = $db->prepare($sql)) {
            $stmt->execute();
            $data = $stmt->get_result();
            $zaznam = $data->fetch_all(MYSQLI_ASSOC);
            if (count($zaznam) > 0) {
                echo "<br>";
                echo "<select name='id_tridy' class='select'>";
                foreach ($zaznam as $row) {
                    echo "<option value='$row[id]'>$row[nazev]</option>";
                }
                echo "</select>";
            } else {
                echo "<p class='hlaska'>Nejsou tu žádné třídy.</p>";
            }
        }
    }
}