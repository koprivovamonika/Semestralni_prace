<?php
session_start();
if (isset($_SESSION["login"])) {
    header("Location: /iwww_semestralni_prace/admin/admin.php");
}
include "htmlKomponenty/menu_login.php";
include 'connection/Connection.php';
?>

    <div class="prihlaseni">
        <form action="index.php" method="POST">
            <input type="text" name="login" placeholder="Jméno" required>
            <input type="password" name="heslo" placeholder="Heslo" required>
            <input type="submit" name="sended" value="Odeslat" class="odeslat">
        </form>
    </div>

<?php
if (isset($_POST["sended"])) {
    if (empty($_POST["login"]) || empty($_POST["heslo"])) {
        echo "<p class='hlaska'>Vyplň formulář</p>";
    }
    $_POST["login"] = htmlspecialchars($_POST["login"]);
    $_POST["heslo"] = htmlspecialchars($_POST["heslo"]);
    Connection::prihlaseni(Connection::spojeni());
}

include 'htmlKomponenty/footer.php';
?>