<?php
// auteur: Wigmans
// functie: algemene functies tbv hergebruik
 function ConnectDb(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bieren";
   
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        echo "Connected successfully";
        return $conn;
    } 
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

 }

 
 
 function GetData($table){
    // Connect database
    $conn = ConnectDb();

    // Select data uit de opgegeven table methode query
    // query: is een prepare en execute in 1 zonder placeholders
    // $result = $conn->query("SELECT * FROM $table")->fetchAll();

    // Select data uit de opgegeven table methode prepare
    $query = $conn->prepare("SELECT * FROM $table");
    $query->execute();
    $result = $query->fetchAll();

    return $result;
 }

 function GetBier($biercode){
    // Connect database
    $conn = ConnectDb();

    // Select data uit de opgegeven table methode query
    // query: is een prepare en execute in 1 zonder placeholders
    // $result = $conn->query("SELECT * FROM $table")->fetchAll();

    // Select data uit de opgegeven table methode prepare
    $query = $conn->prepare("SELECT * FROM bier WHERE biercode = :biercode");
    $query->execute([':biercode'=>$biercode]);
    $result = $query->fetch();

    return $result;
 }


 function OvzBieren(){

    // Haal alle bier record uit de tabel 
    $result = GetData("bier");
    
    //print table
    PrintTable($result);
    //PrintTableTest($result);
    
 }

 function OvzBrouwers(){
    // Haal alle bier record uit de tabel 
    $result = GetData("brouwer");
    
    //print table
    PrintTable($result);
     
 }

 function dropDown($label, $data) {
    foreach($data as $row){
        $text .= "<option value= '$row[brouwcode]'$row[brouwcode]</option>";

/*
        <option value='volvo'>Volvo</option>
        <option value='saab'>Saab</option>
        <option value='mercedes'>Mercedes</option>
        <option value='audi'>Audi</option>
*/ 

$text .= "</select>";

echo "$text";

    }
 }

 function insert_bier($naam, $brouwcode, $soort, $alcohol, $stijl) {
    $conn = ConnectDb();
    
    $query = $conn->prepare("INSERT INTO bier (naam, brouwcode, soort, alcohol, stijl) VALUES (:naam, :brouwcode, :soort, :alcohol, :stijl)");
    $query->execute([':naam' => $naam, ':brouwcode' => $brouwcode, ':soort' => $soort, ':alcohol' => $alcohol, ':stijl' => $stijl]);
    
    return $query->rowCount() === 1; // return true if a single row was affected
}

 function PrintTableTest($result){
    // Zet de hele table in een variable en print hem 1 keer 
    $table = "<table border = 1px>";
    // print elke rij
    foreach ($result as $row) {
        echo "<br> rij:";
        
        foreach ($row as  $value) {
            echo "kolom" . "$value";
        }          
        
    }
}

// Function 'PrintTable' print een HTML-table met data uit $result.
function PrintTable($result){
    // Zet de hele table in een variable en print hem 1 keer 
    $table = "<table border = 1px>";

    // Print header table

    // haal de kolommen uit de eerste [0] van het array $result mbv array_keys
    $headers = array_keys($result[0]);
    $table .= "<tr>";
    foreach($headers as $header){
        $table .= "<th bgcolor=gray>" . $header . "</th>";   
    }

    // print elke rij
    foreach ($result as $row) {
        
        $table .= "<tr>";
        // print elke kolom
        foreach ($row as $cell) {
            $table .= "<td>" . $cell . "</td>";
        }
        $table .= "</tr>";
    }
    $table.= "</table>";

    echo $table;
}

function CrudBieren(){

    // Haal alle bier record uit de tabel 
    $result = GetData("bier");
    
    //print table
    PrintCrudBier($result);
    
 }
function PrintCrudBier($result){
    // Zet de hele table in een variable en print hem 1 keer 
    $table = "<table border = 1px>";

    // Print header table

    // haal de kolommen uit de eerste [0] van het array $result mbv array_keys
    $headers = array_keys($result[0]);
    $table .= "<tr>";
    foreach($headers as $header){
        $table .= "<th bgcolor=gray>" . $header . "</th>";   
    }

    // print elke rij
    foreach ($result as $row) {
        
        $table .= "<tr>";
        // print elke kolom
        foreach ($row as $cell) {
            $table .= "<td>" . $cell . "</td>";
        }
        // $table .= "</tr>";
        
        // Wijzig knopje
        $table .= "<td>". 
            "<form method='post' action='update_bieren.php?biercode=$row[biercode]' >       
                    <button name='wzg'>Wzg</button>	 
            </form>" . "</td>";

        // Delete via linkje href
        $table .= '<td><a href="delete_bieren.php?biercode='.$row["biercode"].'">verwijder</a></td>';
        $table .= '<td><a href="insert_bieren.php?biercode='.$row["biercode"].'">Insert</a></td>';
        
        $table .= "</tr>";
    }
    $table.= "</table>";

    echo $table;
}

function UpdateBier($row){
    echo "Update row<br>";

    $conn = ConnectDb();

    $sql = "UPDATE `bier` 
    SET 
    `naam` = '$row[naam]', 
    `soort` = '$row[soort]', 
    `stijl` = '$row[stijl]', 
    `alcohol` = '$row[alcohol]', 
    `brouwcode` = '$row[brouwcode]'
    WHERE `bier`.`biercode` = $row[biercode]";
    $query = $conn->prepare($sql);
    $query->execute();
}

function DeleteBier($row){
    echo "delete row<br>";

    $conn = ConnectDb();

    $sql = "DELETE 
    FROM bier
    WHERE `bier`.`biercode` = $row[biercode]";
    $query = $conn->prepare($sql);
    $query->execute();
}


?>