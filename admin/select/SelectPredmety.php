<?php


class SelectPredmety
{
    public static function VypisPredmety($db)
    {
        $sql = "SELECT * FROM predmety ORDER BY nazev ASC";
        if ($stmt = $db->prepare($sql)) {
            $stmt->execute();
            $data = $stmt->get_result();
            $zaznam = $data->fetch_all(MYSQLI_ASSOC);
            if (count($zaznam) > 0) {
                echo "<select name='id_predmetu'>";
                foreach ($zaznam as $row) {
                    echo "<option value='$row[id]'>$row[nazev]</option>";
                }
                echo "</select>";
            } else {
                echo "<p class='hlaska'>Nejsou tu žádné předměty.</p>";
            }
        }

    }

    public static function vypisPredmet($db)
    {
        $sql = "SELECT * FROM predmety ORDER BY nazev ASC";
        if ($stmt = $db->prepare($sql)) {
            $stmt->execute();
            $data = $stmt->get_result();
            $zaznam = $data->fetch_all(MYSQLI_ASSOC);
            if (count($zaznam) > 0) {
                echo "<table>";
                echo "<tr><th>Předmět</th><th>Upravit</th><th>Smazat</th></tr>";
                foreach ($zaznam as $row) {
                    echo "<tr>";
                    echo "<td>{$row['nazev']}</td>";
                    echo "<td><a href='../update/uprava_predmetu.php?id={$row['id']}'><img src='/iwww_semestralni_prace/images/icon_uprava.png' class='upravit' alt='upravit'></a></td>";
                    echo "<td><a href='../delete/mazani_predmetu.php?id={$row['id']}'><img src='/iwww_semestralni_prace/images/icon_delete.png' class='smazat' alt='smazat'></a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='hlaska'>Nejsou tu žádné předměty.</p>";
            }
        }

    }
}