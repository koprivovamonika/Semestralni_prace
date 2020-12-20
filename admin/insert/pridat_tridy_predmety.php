<?php
session_start();
include '../../connection/Connection.php';
Connection::opravneniA();
include '../../htmlKomponenty/header.php';
?>
<?php
if (isset($_POST["sended"])) {
    if (empty($_POST["id_tridy"]) || empty($_POST["id_predmetu"])) {
        echo "<p class='hlaska'>Pokusili jste se odeslat prázdná pole, tento příkaz bohužel nemohl být uskutečněn.</p>";
    } else {
        $db = Connection::spojeni();

        $trida = $_POST["id_tridy"];
        $sql1 = "DELETE FROM propojeni_trida_predmety WHERE id_trida = ?";
        if($stmt1 = $db->prepare($sql1)){
            $stmt1->bind_param("i",$trida);
            $stmt1->execute();
            echo "Bylo odstraněno";
        }


        foreach ($_POST['id_predmetu'] as $predmet) {
            $sql2 = "INSERT INTO propojeni_trida_predmety (id_trida, id_predmet) VALUES (?,?)";
            if ($stmt2 = $db->prepare($sql2)) {
                $stmt2->bind_param("ii", $trida,$predmet);
                $stmt2->execute();
                header("Location: ../trida-predmet.php");
            }
        }
    }
}
?>


    <style>
        #odesilani {
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

        .text {
            margin-left: 38%;
            font-size: 125%;
        }
    </style>
    <script>
        function showUser(str) {
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
            xmlhttp.open("GET", "pridat_tridy_predmety_V.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>
    </head>
    <body>

    <form method=post class="form">
        <h1 class="predmet">Přidání předmětu třídě</h1>
        <select name="id_tridy" class="select_archiv" onchange="showUser(this.value)">
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
                    echo "<p class='hlaska'>Nejsou tu žádné třídy.</p>";
                }
            }
            ?>

        </select>

        <br><input type="submit" name="sended" id="odesilani" value="odeslat">

        <br>

        <div id="txtHint"><b class="text">Výpis předmětů pro danou třídu bude zde.</b></div>
    </form>

<?php
include "../../htmlKomponenty/footer.php";
?>