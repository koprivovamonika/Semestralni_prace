<?php
session_start();
include '../../connection/Connection.php';
include '../select/SelectPredmety.php';
Connection::opravneniA();
include '../../htmlKomponenty/header.php';

?>
    <style>
        form {
            width: 80%;
            margin: auto;
            margin-top: 8%;
        }

        h1.predmet {
            text-align: center;
            font-size: 170%;
        }
    </style>

    <form method="POST" action="predmet.php">
        <h1 class="predmet">Přidat předmět</h1>
        <input type="text" name="predmet" placeholder="Název" required>
        <input type="submit" name="send">
    </form>
<?php
if (isset($_POST["send"])) {
    if (!empty($_POST["predmet"])) {
        $predmet = htmlspecialchars($_POST["predmet"]);
        $sql = "INSERT INTO predmety (nazev) VALUES(?)";
        $db = Connection::spojeni();
        if ($stmt = $db->prepare($sql)) {
            $stmt->bind_param("s", $predmet);
            $stmt->execute();
            header("Location: predmet.php");
        } else {
            echo "UPS";
        }
    }
}

SelectPredmety::vypisPredmet(Connection::spojeni());
?>

<?php
include "../../htmlKomponenty/footer.php";
?>