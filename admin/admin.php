<?php
session_start();
include '../connection/Connection.php';
Connection::opravneniA();
include '../htmlKomponenty/header.php';

?>
<script type="text/javascript">
    function kontrola() {
        return confirm("Opravdu si přejete ukončit školní rok? Vymaží se všechny známky a všichni žáci devátých tříd.");
    }

    function kontrola1() {
        return confirm("Opravdu si přejete ukončit pololetí? Vymaží se všechny známky.");
    }
</script>
<style type="text/css">
    td {
        border: 2px solid black;
    }

    .uvodni-obsah {
        text-align: justify;
        margin: inherit;
    }

    .uvod {
        font-size: 150%;
        margin-top: 8%;
        margin-bottom: -5%;
    }
</style>


<div style="height:34vw" class="obalovaci-div">
    <h1 class="uvod">Vítejte na stránce</h1>
    <p class="uvodni-obsah">Lorem Ipsum je demonstrativní výplňový text používaný v tiskařském a knihařském průmyslu.
        Lorem Ipsum je považováno za standard v této oblasti už od začátku 16. století, kdy dnes neznámý
        tiskař vzal kusy textu a na jejich základě vytvořil speciální vzorovou knihu. Jeho odkaz nevydržel
        pouze pět století, on přežil i nástup elektronické sazby v podstatě beze změny. Nejvíce popularizováno
        bylo Lorem Ipsum v šedesátých letech 20. století, kdy byly vydávány speciální vzorníky s jeho pasážemi
        a později pak díky počítačovým DTP programům jako Aldus PageMaker.</p>
    <button class="konec"><a href="konec.php" onclick='return kontrola()'>KONEC ŠKOLNÍHO ROKU</a></button>
    <br>
    <button class="konec"><a href="konec-pololeti.php" onclick='return kontrola1()'>KONEC POLOLETÍ</a></button>


</div>

<?php
include "../htmlKomponenty/footer.php";
?>
