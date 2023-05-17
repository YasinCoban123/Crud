<?php
require_once('functions.php');
include 'navbar.php';
if(isset($_POST) && isset($_POST['btn_toevoegen'])){
    $naam = $_POST['naam'];
    $soort = $_POST['soort'];
    $stijl = $_POST['stijl'];
    $alcohol = $_POST['alcohol'];
    $brouwcode = $_POST['brouwcode'];
    $biercode = $_POST['biercode'];

    insert_bier($biercode, $naam, $soort, $alcohol, $stijl, $brouwcode);
    header('Location: crud_bieren.php');
}
?>

<html>
<body>
<form method="post">
Biercode:<input type="text" name="biercode" required><br>
Naam:<input type="text" name="naam" required><br>
Soort:<input type="text" name="soort" required><br>
Stijl:<input type="text" name="stijl" required><br>
Alcohol:<input type="text" name="alcohol" required><br>
Brouwcode:<input type="text" name="brouwcode" required><br>

<input type="submit" name="btn_toevoegen" value="Voeg toe"><br>

</form>
</body>
</html>
