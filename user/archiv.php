<?php
session_start();
include '../connection/Connection.php';
Connection::opravneniZ();
include '../htmlKomponenty/header.php';
?>
    <style type="text/css">

        th {
            background-color: #31d8fc;
            color: white;
            text-align: left;
            padding: 0.5vw;
            font-family: Times, 'Times New Roman', serif;
            font-size: 1vw;
            font-weight: normal;
            text-align: justify;
        }

        td {
            text-align: left;
            padding: 0.5vw;
            font-family: Times, 'Times New Roman', serif;
            font-size: 1vw; /*font-size: 20px;*/
            font-weight: normal;
            border-bottom: 0.1vw solid #cccccc;
            background-color: white;
        }

        td a:hover {
            color: red;
        }

        table {
            width: 80%;
            margin-left: 10%;
            border-collapse: collapse;
            text-align: center;
            margin-top: 2%;
        }

        .text {
            margin-left: 41%;
            font-size: 125%;
        }
    </style>
    <script>
        function Trida(str) {
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
            xmlhttp.open("GET", "archiv_V.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>

    <br><br><br><br>
    <form method=post class="form">
        <select name="id_tridy" class="select_archiv2" onchange="Trida(this.value)">
            <option value="">Vyber tridu:</option>
            <?php
            $db = Connection::spojeni();
            $sql = "SELECT archiv.trida as trida FROM archiv JOIN uzivatel ON archiv.id_zaka=uzivatel.id WHERE uzivatel.login = ? GROUP BY trida";
            if ($stmt = $db->prepare($sql)) {
                $stmt->bind_param("s",$_SESSION["login"]);
                $stmt->execute();
                $data = $stmt->get_result();
                $zaznam = $data->fetch_all(MYSQLI_ASSOC);
                if (count($zaznam) > 0) {
                    foreach ($zaznam as $row) {
                        echo "<option value='$row[trida]'>$row[trida]</option>";
                    }
                } else {
                    echo "Nejsou tu zadne tridy :-(((((";
                }
            }

            ?>

        </select>
        <div id="txtHint"><b class="text">Výpis třídy bude vypsán zde.</b></div>
    </form>
<?php
include "../htmlKomponenty/footer.php";
?>