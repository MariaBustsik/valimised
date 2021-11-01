<?php
include ('navigation.php');

?>

<?php
require_once ('conf.php');
global $yhendus;
//peitmine, avalik=0
if(isset($_REQUEST["peitmine"])) {
    $kask = $yhendus->prepare('
    UPDATE valimised SET avalik=0 WHERE id=?');
    $kask->bind_param('i', $_REQUEST["peitmine"]);
    $kask->execute();
}
//avalikustamine, avalik=1
if(isset($_REQUEST["avamine"])) {
    $kask = $yhendus->prepare('
    UPDATE valimised SET avalik=1 WHERE id=?');
    $kask->bind_param('i', $_REQUEST["avamine"]);
    $kask->execute();
}

if(isset($_REQUEST["kustutasid"])){
    $kask=$yhendus->prepare("DELETE FROM valimised WHERE id=?");
    $kask->bind_param("i", $_REQUEST["kustutasid"]);
    $kask->execute();

}

?>


    <!Doctype html>
    <html lang="et">
    <head>
        <title>Haldusleht</title>
        <link rel="stylesheet" type="text/css" href="style/style.css">
    </head>
    <body>
    <h1>Uue nimi lisamine</h1>
    <form action="?">
        <label for="uusnimi">Nimi</label>
        <input type="text" id="uusnimi" name="uusnimi" placeholder="uus nimi">

        <input type="submit" value="OK">
    </form>
    <h1>Valimisnimede haldus</h1>
    <?php
    //valimiste tabeli sisu vaatamine andmebaasist
    global $yhendus;
    $kask=$yhendus->prepare('
    SELECT id, nimi, avalik FROM valimised');
    $kask->bind_result($id, $nimi, $avalik);
    $kask->execute();
    echo "<table>";
    echo "<tr><th>Nimi</th><th>Seisund</th><th>Tegevus</th><th>Kustutamine</th><th>Annuleerimine</th>";


    while($kask->fetch()){
        $avatekst="Ava";
        $param="avamine";
        $seisund="Peidetud";
        if($avalik==1){
            $avatekst="Peida";
            $param="peitmine";
            $seisund="Avatud";
        }

        echo "<tr>";
        echo "<td>".htmlspecialchars($nimi)."</td>";
        echo "<td>".($seisund)."</td>";
        echo "<td><a href='?$param=$id'>$avatekst</a></td>";
        echo "<td><a href='$_SERVER[PHP_SELF]?kustutasid=$id'>Kustuta</a></td></tr>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
    <?php
    include ('footer.php');

    ?>
    </body>
    </html>
<?php
$yhendus->close();
//Ülesanne.
// Lehe värskendamine ei lisa punkti.
// Haldusleht -võimaldab nimede kustutamine
// Halduslehel saab punktid panna nulliks
// Navigeerimismenüü + CSS kujundus
