<?php
$serverinimi="localhost"; //d101712.mysql.zonevs.eu
$kasutaja="mariabustsik20"; //d101712_maria20 //  d101712_maria22
$parool="kolokol123"; //55539379Kolokol
$andmebaas="mariabustsik20"; // d101712_mariabaas // d101712_mariabaas2

$yhendus=new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
$yhendus->set_charset('UTF8');
?>
