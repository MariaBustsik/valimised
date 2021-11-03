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

//punktide annulleerimine
if(isSet($_REQUEST["annulleerima"])){
    $kask=$yhendus->prepare('UPDATE valimised SET punktid=0 WHERE id=?');
    $kask->bind_param('i',$_REQUEST["annulleerima"]);
    $kask->execute();
}

if(isset($_REQUEST["kustutamine"])){
    $kask=$yhendus->prepare("DELETE FROM valimised WHERE id=?");
    $kask->bind_param("i", $_REQUEST["kustutamine"]);
    $kask->execute();

}

//kommentaarid nullliks
if(isSet($_REQUEST["knull"])){
    $kask=$yhendus->prepare('UPDATE valimised SET kommentaarid=" " WHERE id=?');
    $kask->bind_param('i',$_REQUEST["knull"]);
    $kask->execute();
}

?>


    <!Doctype html>
    <html lang="et">
    <head>
        <title>Haldusleht</title>
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Questrial&display=swap" rel="stylesheet">
    </head>
    <body>

    <h1>Valimisnimede haldus</h1>
    <?php
    //valimiste tabeli sisu vaatamine andmebaasist
    global $yhendus;
    $kask=$yhendus->prepare('
    SELECT id, nimi, punktid, kommentaarid, avalik FROM valimised');
    $kask->bind_result($id, $nimi, $punktid, $kommentaarid, $avalik);
    $kask->execute();
    echo "<table>";
    echo "<tr><th>Nimi</th><th>Punktid</th><th>Kommentaarid</th><th>Seisund</th><th>Tegevus</th><th>Annuleeri punktid</th>
<th>Annuleeri kommentaarid</th><th>Kustuta</th>";


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
        echo "<td>".($punktid)."</td>";
        echo "<td>".($kommentaarid)."</td>";
        echo "<td>".($seisund)."</td>";
        echo "<td><a href='?$param=$id'>$avatekst</a></td>";
        echo "<td><a href='$_SERVER[PHP_SELF]?annulleerima=$id'>Annuleeri punktid</a></td>";
        echo "<td><a href='$_SERVER[PHP_SELF]?knull=$id'>Annuleeri kommentaarid</a></td>";
        echo "<td><a href='$_SERVER[PHP_SELF]?kustutamine=$id'>Kustuta</a></td></tr>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
    <?php



    ?>
    <a href="https://github.com/MariaBustsik/valimised">GitHub link: github.com/MariaBustsik/valimised</a>
    </body>
    </html>
<?php
$yhendus->close();

//Ülesanne.
// Lehe värskendamine ei lisa punkti.
// Haldusleht -võimaldab nimede kustutamine
// Halduslehel saab punktid panna nulliks
// Navigeerimismenüü + CSS kujundus
