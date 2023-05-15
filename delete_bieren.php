<?php
include 'navbar.php';
 echo "<h1>Delete Bier</h1>";
 require_once('functions.php');
 if(isset($_POST) && isset($_POST['btn_wzg'])){

 DeleteBier($_POST);
 header('Location: crud_bieren.php');
 }
 if(isset($_GET['biercode']))

 {

echo "Data uit het vorige formulier:<br>";

 $biercode = $_GET['biercode'];

 $row = GetBier($biercode);

}
?>

<html>
<body>
<form method="post">
Biercode:<input type="" name="biercode" value="<?php echo $row['biercode'];?>" readonly><br>
Naam:<input type="" name="naam" value="<?php echo $row['naam'];?>" readonly><br>
Soort: <input type="text" name="soort" value="<?= $row['soort']?>" readonly><br>
Stijl: <input type="text" name="stijl" value="<?= $row['stijl']?>" readonly><br>
Alcohol: <input type="text" name="alcohol" value="<?= $row['alcohol']?>" readonly><br>
Brouwcode: <input type="text" name="brouwcode" value="<?= $row['brouwcode']?>" readonly><br><br>


<input type="submit" name="btn_wzg" value="Delete"><br>

</form>
</body>
</html>