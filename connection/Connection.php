<?php


class Connection
{
    public static function spojeni()
    {
        $db = new mysqli("localhost", "root", "", "iwww_sem");
        if ($db->errno > 0)
            die("Je to rozbité.");
        $db->set_charset("utf8");
        return $db;
    }

    public static function prihlaseni($db)
    {
        if (!empty($_POST["login"]) && !empty($_POST["heslo"])) {
            $login = $_POST["login"];
            $heslo = $_POST["heslo"];

            $stmt = $db->prepare("select * from uzivatel where login=? limit 1");
            $stmt->bind_param("s", $login);
            $stmt->execute();
            $result = $stmt->get_result();
            $zaznam = $result->fetch_assoc();

            if (password_verify($heslo, $zaznam["heslo"])) {
                $_SESSION["login"] = $zaznam["login"];
                $_SESSION["opravneni"] = $zaznam["opravneni"];
                Connection::rozrazeni();
            } else {
                echo "<p class= 'hlaska'>Zadali jste špatné údaje, zkuste to prosím znovu.</p>";
            }
        }
    }

    public static function rozrazeni()
    {
        if (!isset($_SESSION["login"])) {
            header("Location: /iwww_semestralni_prace/index.php");
        } else {
            if ($_SESSION["opravneni"] == 0) {
                header("Location: /iwww_semestralni_prace/admin/admin.php");
            } elseif ($_SESSION["opravneni"] == 1) {
                header("Location: /iwww_semestralni_prace/user/uzivatel.php");
            } elseif ($_SESSION["opravneni"] == 2) {
                header("Location: user/zak.php");
            } elseif ($_SESSION["opravneni"] == 3) {
                header("Location: user/rodic.php");
            } else {
                header("Location: /iwww_semestralni_prace/index.php");
            }

        }
    }

    public static function opravneniA()
    {
        if (!isset($_SESSION["login"]) || !isset($_SESSION["opravneni"])) {
            header("Location: /iwww_semestralni_prace/index.php");
        } else {
            if ($_SESSION["opravneni"] != 0) {
                header("Location: /iwww_semestralni_prace/user/uzivatel.php");
            }
        }
    }

    public static function opravneniU()
    {
        if (!isset($_SESSION["login"]) || !isset($_SESSION["opravneni"])) {
            header("Location: /iwww_semestralni_prace/index.php");
        } else {
            if ($_SESSION["opravneni"] != 1) {
                header("Location: /iwww_semestralni_prace/user/zak.php");
            }
        }
    }

    public static function opravneniZ()
    {
        if (!isset($_SESSION["login"]) || !isset($_SESSION["opravneni"])) {
            header("Location: /iwww_semestralni_prace/index.php");
        } else {
            if ($_SESSION["opravneni"] != 2) {
                header("Location: /iwww_semestralni_prace/user/rodic.php");
            }
        }
    }

    public static function opravneniR()
    {
        if (!isset($_SESSION["login"]) || !isset($_SESSION["opravneni"])) {
            header("Location: /iwww_semestralni_prace/index.php");
        } else {
            if ($_SESSION["opravneni"] != 3) {
                header("Location: /iwww_semestralni_prace/index.php");
            }
        }
    }
}