<?php
include ('navigation.php');

?>
<?php
require_once ('conf.php');
global $yhendus;
// uue nimi lisamine
if(!empty($_REQUEST['uusnimi'])){
    $kask=$yhendus->prepare('INSERT INTO valimised(nimi, lisamisaeg)
    Values (?, Now())');
    $kask->bind_param('s', $_REQUEST['uusnimi']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
}

//Update käsk
if(isset($_REQUEST["haal"])) {
    $kask = $yhendus->prepare('
    UPDATE valimised SET punktid=punktid + 1 WHERE id=?');
    $kask->bind_param('i', $_REQUEST["haal"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

?>


    <!Doctype html>
    <html lang="et">
    <head>
        <title>Valimiste leht</title>
        <link rel="stylesheet" type="text/css" href="style/style.css">
    </head>
    <body>
    <h1>Uue nimi lisamine</h1>
    <form action="?">
        <label for="uusnimi">Nimi</label>
        <input type="text" id="uusnimi" name="uusnimi" placeholder="uus nimi">
        <input type="submit" value="OK">
    </form>
    <h1>Valimiste leht</h1>


    <?php
    //valimiste tabeli sisu vaatamine andmebaasist
    global $yhendus;
    $kask=$yhendus->prepare('
    SELECT id, nimi, punktid FROM valimised WHERE avalik=1');
    $kask->bind_result($id, $nimi, $punktid);
    $kask->execute();
    echo "<table>";
    echo "<tr><th>Nimi</th><th>Punktid</th><th>Anna oma hääl</th>";

    while($kask->fetch()){
        echo "<tr>";
        echo "<td>".htmlspecialchars($nimi)."</td>";
        echo "<td>".($punktid)."</td>";
        echo "<td><a href='?haal=$id'>Lisa +1 punkt</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
    </body>
    </html>
<?php
$yhendus->close();
/*CREATE TABLE valimised(
    id int primary key auto_increment,
    nimi varchar(100),
    lisamisaeg datetime,
    punktid int DEFAULT 0,
    kommentaarid text,
    avalik int DEFAULT 1);
Insert into valimised(nimi, lisamisaeg, punktid, kommentaarid,avalik)
Values ('Karlson', '2021-11-1', 10, 'Väga hea raamat', 1);
Select * From valimised*/
