<?php
session_start();
include '../connection/Connection.php';
Connection::opravneniA();
include '../htmlKomponenty/header.php';
?>

<style>
    .text {
        text-align: center;
        margin-left: 35%;
    }

    #tlacitko {
        margin-top: 2%;
    }

</style>
<script>
    function Zaci(str) {
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "zaci_V.php?q=" + str, true);
        xmlhttp.send();
    }
</script>
<div class="obal">
    <form method=post class="form">
        <h1 class="predmet">Výpis žáků</h1>
        <select name="id_tridy" onchange="Zaci(this.value)">
            <option value="">Vyber třídu:</option>
            <?php
            $db = Connection::spojeni();
            $sql = "SELECT * FROM `tridy` ORDER BY `nazev` ASC";
            if ($stmt = $db->prepare($sql)) {
                $stmt->execute();
                $data = $stmt->get_result();
                $zaznam = $data->fetch_all(MYSQLI_ASSOC);
                if (count($zaznam) > 0) {
                    foreach ($zaznam as $row) {
                        echo "<option value='$row[id]'>$row[nazev]</option>";
                    }
                }else{
                    echo "Nejsou tu zadne tridy :-(((((";
                }
            }
            ?>

        </select>
        <br>

        <div id="txtHint"><b class="text">Výpis třídy bude vypsán zde.</b></div>
    </form>


    <a href='insert/pridat_uzivatele.php?opravneni=2'>
        <button id="tlacitko">Přidat žáka</button>
    </a></div>
<?php
include "../htmlKomponenty/footer.php";
?>

