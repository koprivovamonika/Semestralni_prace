<?php


class Json
{

    public static function ToJson($db)
    {
        $sql = "SELECT id, jmeno,prijmeni,login,email FROM uzivatel WHERE opravneni = 1";
        $pole = array();
        if ($stmt = $db->prepare($sql)) {
            $stmt->execute();
            $data = $stmt->get_result();
            $zaznam = $data->fetch_all(MYSQLI_ASSOC);
            if (count($zaznam) > 0) {
                foreach ($zaznam as $row) {
                    $pole[] = $row;
                }
                $pole1 = json_encode($pole, JSON_UNESCAPED_UNICODE);
                $adresa = '../uploads/historie.json';
                file_put_contents($adresa, $pole1);

                if (file_exists($adresa)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename=' . basename($adresa));
                    header('Content-Transfer-Encoding: binary');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($adresa));
                    ob_clean();
                    flush();
                    readfile($adresa);
                    unlink($adresa);
                    exit;
                }
            }
        }
    }

    public static function FromJson($db)
    {
        if (isset($_POST["sendedJ"])) {
            $uploaddir = '../uploads/';
            $uploadfile = $uploaddir . basename($_FILES['files']['name']);
            $extension = array("json", "JSON");
            $UploadOk = true;

            $ext = pathinfo($_FILES["files"]["name"], PATHINFO_EXTENSION);
            if (in_array($ext, $extension) == false) {
                $UploadOk = false;
                echo "<p class='hlaska'>Neplatny soubor</p>";

            }

            if ($UploadOk == true) {
                if (move_uploaded_file($_FILES['files']['tmp_name'], $uploadfile)) {

                    $jsondata = file_get_contents($uploadfile);
                    $obj = json_decode($jsondata, true);

                    foreach ($obj as $k => $v) {

                        $jmeno = $v["jmeno"];
                        $prijmeni = $v["prijmeni"];
                        $rc = $v["rc"];
                        $login = $v["login"];
                        $heslo = $v["heslo"];
                        $email = $v["email"];
                        $hesloHash = password_hash($heslo, PASSWORD_BCRYPT);
                        $o = 1;

                        $sql5 = "INSERT INTO `uzivatel`(`jmeno`, `prijmeni`, `rodne_cislo`, `login`, `heslo`, `hesloPuvodni`, `email`, `opravneni`) VALUES (?,?,?,?,?,?,?,?);";
                        if ($stmt = $db->prepare($sql5)) {
                            $stmt->bind_param("ssissssi", $jmeno, $prijmeni, $rc, $login, $hesloHash, $heslo, $email, $o);
                            $stmt->execute();
                        }

                    }
                    echo "<p class='hlaska'>Učitel/e vložen/i.</p>";
                    header('Location: ucitele.php');
                    //unlink($uploadfile);
                } else {
                    echo "<p class='hlaska'>Neplatný soubor</p>";
                }
            }
        }


    }
}