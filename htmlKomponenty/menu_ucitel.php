</head>
<body>
<nav id="nav" class="mymenu">
    <div class="menu-cast1">
        <ul>
            <li><a href="/iwww_semestralni_prace/user/uzivatel.php" class="menu1"><h1 class="line">Domů</h1></a></li>
            <li><a href="/iwww_semestralni_prace/znamkovani.php" class="menu1"><h1 class="line">Známkování</h1></a></li>
            <li><a href="/iwww_semestralni_prace/connection/heslo.php" class="menu1"><h1 class="line">Změna hesla</h1>
                </a></li>
            <li><a href="/iwww_semestralni_prace/connection/odhlaseni.php" class="menu1"><h1 class="line">Odhlášení</h1>
                </a></li>
        </ul>
    </div>
    <div class="menu-cast2">Je přihlášen uživatel: <b><?php echo $_SESSION["login"]; ?></b></div>
</nav>
