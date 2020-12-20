<?php
session_start();
include '../connection/Connection.php';
Connection::opravneniA();
include '../htmlKomponenty/header.php';
?>
    <style>
        .text {
            margin-left: 42%;
            font-size: 125%;

        }

        .odesilani {
            width: 20%;
            background-color: #31d8fc;
            color: white;
            padding: 0.4vw 0.4vw;
            margin: 0.3vw 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 40%;
        }

        .odesilani:hover {
            background-color: #0033ff;
        }
    </style>
    <script>
        function Predmety(str) {
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
            xmlhttp.open("GET", "trida-predmet-V.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>

    <div class="obal">
        <form method=post class="form">
            <h1 class="predmet">Výpis předmětů pro třídu</h1>
            <select name="id_tridy" class='select_archiv' onchange="Predmety(this.value)">
                <option value="">Vyber tridu:</option>
                <?php
                $db = Connection::spojeni();
                $sql = "SELECT * FROM tridy ORDER BY nazev ASC";
                if ($stmt = $db->prepare($sql)) {
                    $stmt->execute();
                    $data = $stmt->get_result();
                    $zaznam = $data->fetch_all(MYSQLI_ASSOC);
                    if (count($zaznam) > 0) {
                        foreach ($zaznam as $row) {
                            echo "<option value='$row[id]'>$row[nazev]</option>";
                        }
                    } else {
                        echo "Nejsou tu zadne tridy :-(((((";
                    }
                }
                ?>

            </select>
            <br>
            <div id="txtHint"><b class="text">Výpis předmětů bude zde.</b></div>
        </form>

        <a href="../admin/insert/pridat_tridy_predmety.php">
            <button class="odesilani">Přidat třídě předměty</button>
        </a>
    </div>
<?php
include "../htmlKomponenty/footer.php";
?>