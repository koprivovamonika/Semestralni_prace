<?php
session_start();
include '../../connection/Connection.php';
Connection::opravneniA();
include '../../htmlKomponenty/header.php';
?>
    <style>
        form {
            width: 80%;
            margin: auto;
            margin-top: 8%;
            margin-bottom: -5%;
        }

        h1.predmet {
            text-align: center;
            font-size: 170%;
        }

    </style>
<?php
if (!isset($_SESSION["login"])) {
    header("Location: ../admin.php");
}

$db = Connection::spojeni();
$stmt1 = $db->prepare("SELECT * FROM predmety WHERE id= ? limit 1");
$stmt1->bind_param("s", $_GET['id']);
$stmt1->execute();
$result1 = $stmt1->get_result();
$zaznam = $result1->fetch_assoc();


if (isset($_POST["sended"])) {
    if (empty($_POST["predmet"])) {
        echo "<p class='hlaska'>Vyplňte formulář</p>";
    } else {
        $predmet = htmlspecialchars($_POST["predmet"]);

        $db = Connection::spojeni();

        $sql = "UPDATE predmety SET nazev = ? WHERE id = " . $_GET['id'] . ";";
        if ($stmt = $db->prepare($sql)) {
            $stmt->bind_param("s", $predmet);
            $stmt->execute();
            header("Location: ../insert/predmet.php");
        } else {
            echo "<p>Nefunguje</p>";
        }
    }
}
?>
    <form action="" method="POST">
        <h1 class="predmet">Upravit předmět</h1>
        <input type="text" name="predmet" id="prvni" required value="<?php echo $zaznam['nazev']; ?>">
        <input type="submit" name="sended" class="send" value="odeslat">
    </form>
<?php
include "../../htmlKomponenty/footer.php";
?>