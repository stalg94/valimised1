<?php
require_once ('conf.php');
global $yhendus;
if(!empty($_REQUEST['uusnimi'])){
    $kask=$yhendus->prepare('INSERT INTO valimised1(nimi, lisamisaeg)
    Values (?, Now())');
    $kask->bind_param('s', $_REQUEST['uusnimi']);
    $kask->execute();
    header("Location: kasutaja.php");

    //$yhendus->close();
}



?>
    <!Doctype html>
    <html lang="et">
    <head>
        <title>Haldusleht</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <script>
            function UusRaamat() {
                alert("Uus Raamat On Lisatud!");
            }
        </script>
    </head>
    <body>
    <?php include ('navigation.php');?>
    <h2>Uue nimi lisamine</h2>
    <form action="?">
        <label for="uusnimi">Nimi</label>
        <input type="text" id="uusnimi" name="uusnimi" placeholder="uus nimi">

        <input type="submit" value="Lisa" onclick="UusRaamat()">
    </form>

    </body>
    </html>
<?php
$yhendus->close();
