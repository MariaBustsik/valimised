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
    header ("Location: https://bustsik20.thkit.ee/valimised/kommenteerimine.php");
    //$yhendus->close();
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
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Questrial&display=swap" rel="stylesheet">
    </head>
    <body>
    <ul>
        <li><a href="valimised.php">Home page</a></li>
        <li><a href="nimideHaldus.php">Admin page</a></li>
        <li><a href="kommenteerimine.php">Kasutaja page</a></li>
    </ul>
    <h1>Uue kandidaadi nimi lisamine</h1>
    <form action="?">
        <label for="uusnimi">Sisesta nimi</label>
        <input type="text" id="uusnimi" name="uusnimi" placeholder="uus nimi">
        <input type="submit" value="OK">
    </form>

    <img src="style/valimised.gif" alt="pic">

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
