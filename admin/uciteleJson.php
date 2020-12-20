<?php
session_start();
include '../connection/Connection.php';
include "select/Json.php";
Connection::opravneniA();
include '../htmlKomponenty/header.php';

?>
<form action="" method="POST" enctype="multipart/form-data" class="form">
    <label class="label">Vyberte JSON k nahrání:</label>
    <br><div class="fileUpload">
        <span>Zvolit soubor</span>
        <input type="file" name="files" class="file22" />
    </div>

    <input type="submit" name="sendedJ" class="send" value="Odeslat">
</form>

<?php
Json::FromJson(Connection::spojeni());
?>

<?php
include "../htmlKomponenty/footer.php";
?>
