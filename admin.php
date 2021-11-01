<?php
require_once ('conf.php');
global $yhendus;
if(!empty($_REQUEST['uusnimi'])){
    $kask=$yhendus->prepare('INSERT INTO valimised1(nimi, lisamisaeg)
    Values (?, Now())');
    $kask->bind_param('s', $_REQUEST['uusnimi']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    //$yhendus->close();
}
//peitmine, avalik=0
if(isset($_REQUEST["peitmine"])) {
    $kask = $yhendus->prepare('
    UPDATE valimised1 SET avalik=0 WHERE id=?');
    $kask->bind_param('i', $_REQUEST["peitmine"]);
    $kask->execute();
}
//avalikustamine, avalik=1
if(isset($_REQUEST["avamine"])) {
    $kask = $yhendus->prepare('
    UPDATE valimised1 SET avalik=1 WHERE id=?');
    $kask->bind_param('i', $_REQUEST["avamine"]);
    $kask->execute();
}
if(isset($_REQUEST["kustuta"])) {
    $kask = $yhendus->prepare("DELETE FROM valimised1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["kustuta"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
if(isset($_REQUEST["kustuta_punkt"])) {
    $kask = $yhendus->prepare('
    UPDATE valimised1 SET punktid=0 WHERE id=?');
    $kask->bind_param('i', $_REQUEST["kustuta_punkt"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
if(isset($_REQUEST["kustuta_komment"])) {
    $kask = $yhendus->prepare('
    UPDATE valimised1 SET kommentaarid= " " WHERE id=?');
    $kask->bind_param('i', $_REQUEST["kustuta_komment"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

?>
    <!Doctype html>
    <html lang="et">
    <head>
        <title>Haldusleht</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="style/style.css">
    </head>
    <body>
    <?php include ('navigation.php');?>
    <h1>Valimisnimede haldus</h1>
    <?php
    //valimiste tabeli sisu vaatamine andmebaasist
    global $yhendus;
    $kask=$yhendus->prepare('
    SELECT id, nimi, avalik, punktid, kommentaarid FROM valimised1 order by punktid DESC');
    $kask->bind_result($id, $nimi, $avalik,$punktid, $kommentaarid);
    $kask->execute();
    echo "<table>";
    echo "<tr><th>Nimi</th><th>Seisund</th><th>Tegevus</th><th>Kustuta</th><th>Punktid</th><th>Kommentaarid</th><th>Komment 0</th><th>Punktid 0</th>";

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
        echo "<td><a href='".strtok(basename($_SERVER['REQUEST_URI']),"&")."&kustuta=$id'>&#10060;</a></td>";
        echo "<td>".($punktid)."</td>";
        echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
        echo "<td><a href='".strtok(basename($_SERVER['REQUEST_URI']),"&")."&kustuta_komment=$id'>Kustuta komment</a></td>";
        echo "<td><a href='".strtok(basename($_SERVER['REQUEST_URI']),"&")."&kustuta_punkt=$id'>Kustuta punktid</a> </td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
    </body>
    </html>
<?php
$yhendus->close();
?>
