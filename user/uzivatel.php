<?php
session_start();
include "../connection/Connection.php";
Connection::opravneniU();
include '../htmlKomponenty/header.php';
?>
<style type="text/css">
    td {
        border: 2px solid black;
    }

    .uvodni-obsah {
        text-align: justify;
        margin: inherit;
        width: 40%;
        margin-left: 4%;
    }

    .uvod {
        font-size: 150%;
        margin-top: 8%;
        margin-left: 4%;
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


</div>
<?php
include "../htmlKomponenty/footer.php";
?>
