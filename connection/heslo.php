<?php
session_start();
include '../connection/Connection.php';
include '../htmlKomponenty/header.php';
?>
    <form method="POST" action="" class="form">
        <h1 class='predmet'>Změna hesla</h1>
        <input type="password" name="stare_heslo" placeholder="Staré heslo" required>
        <input type="password" name="heslo" placeholder="Nové heslo" required>
        <input type="password" name="heslo1" placeholder="Nové heslo znovu" required>
        <input type="submit" name="sended" value="odeslat">
    </form>
    <p>Po změně údajů, se budete muset znovu přihlásit :)</p>
<?php
$db = Connection::spojeni();

if (isset($_POST["sended"])) {
    if (empty($_POST["heslo"])) {
        echo "Vyplň formulář :)";
    } else {
        $hesloS = htmlspecialchars($_POST["stare_heslo"]);
        $hesloN = htmlspecialchars($_POST["heslo"]);
        $hesloN1 = htmlspecialchars($_POST["heslo1"]);

        $stmt1 = $db->prepare("select * from uzivatel where login=? limit 1");
        $stmt1->bind_param("s", $_SESSION["login"]);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $zaznam1 = $result1->fetch_assoc();
        $stare_heslo = $zaznam1["heslo"];


        if (password_verify($hesloS, $stare_heslo) && $hesloN == $hesloN1) {
            $sql = "UPDATE uzivatel SET heslo = ? WHERE login = '" . $_SESSION["login"] . "'";
            $heslo = password_hash($hesloN, PASSWORD_BCRYPT);
            if ($stmt = $db->prepare($sql)) {
                $stmt->bind_param("s", $heslo);
                $stmt->execute();
            } else {
                echo "<p>Nefunguje</p>";
            }

            unset($_SESSION["login"]);
            unset($_SESSION["opravneni"]);
            header("Location: ../index.php");
        } else {
            echo "<p class='hlaska'>Zadali jste špatné údaje, zkuste to prosím znovu.</p>";
        }
    }
}
?>
<?php
include "../htmlKomponenty/footer.php";
?>