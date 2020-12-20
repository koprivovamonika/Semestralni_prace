<?php
session_start();
include '../connection/Connection.php';
include 'select/SelectUcitele.php';
Connection::opravneniA();
include '../htmlKomponenty/header.php';
?>
<form method="POST" action="" class="form">
    <h1 class='predmet'>Změna hesla</h1>
    <input type="password" name="heslo" placeholder="Heslo" required>
    <input type="password" name="heslo1" placeholder="Heslo znovu" required>
    <input type="submit" name="sended" value="odeslat">
</form>
<?php
$uzivatel = $_GET["id"];
$db = Connection::spojeni();

if (isset($_POST["sended"])) {
    if (empty($_POST["heslo"]) || empty($_POST["heslo1"])) {
        echo "Vyplň formulář :)";
    } else {
        $h = htmlspecialchars($_POST["heslo"]);
        $h1 = htmlspecialchars($_POST["heslo1"]);

        if ($h == $h1) {
            $heslo = password_hash($h, PASSWORD_BCRYPT);
            $sql = "UPDATE uzivatel SET heslo = ? WHERE id = '" . $uzivatel . "'";
            if ($stmt = $db->prepare($sql)) {
                $stmt->bind_param("s", $heslo);
                $stmt->execute();
            } else {
                echo "<p>Nefunguje</p>";
            }
            if (SelectUcitele::JeUcitel(Connection::spojeni(), $uzivatel) == "zak") {
                header("Location: zaci.php");
            } elseif (SelectUcitele::JeUcitel(Connection::spojeni(), $uzivatel) == "ucitel") {
                header("Location: ucitele.php");
            }

        } else {
            echo "<p class='hlaska'>Zadali jste špatné údaje, zkuste to prosím znovu.</p>";
        }
    }
}
?>
<?php
include "../htmlKomponenty/footer.php";
?>
