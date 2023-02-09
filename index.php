<?php

if (isset($_POST["submit"])) {

    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $adres = $_POST["adres"];
    $place = $_POST["place"];
    $date = $_POST["date"];
    $choice = $_POST["choice"];

}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Pizza</title>
        <meta charset="UTF-8">
        <meta  name="viewport" content="width=device-width,
        initial-scale=1.0">
    </head>
    <body>
        <form method="post" action="">
            <label>Enter your first name:</label><br />
            <input type="text" name="fname" placeholder="Enter your name" 
            required /><br />

            <label>Enter your last name:</label><br />
            <input type="text" name="lname" placeholder="Enter your last name"
             required /><br />

            <label>Enter your adres:</label><br />
            <input type="text" name="adres" placeholder="Enter your adres"/><br />

            <label>Enter your place:</label><br />
            <input type="text" name="place" placeholder="Enter your place"/><br />

            <label>Enter your order date:</label><br />
            <input type="text" name="date" placeholder="Enter your order date"/><br />

            <label>order or pick up:</label><br />
            <select name="choice" placeholder="select your choice">
                <option value="pick up">Pick up</option>
                <option value="deliver">Deliver</option>
            </select>
            <br /><br />

            <!-- <button type="button" name="pMargherita"><p>pizza Margherita 12,50 euro</p></button> -->
            <input type="submit" name="pMargherita" value="pizza Margherita 12,50 euro">
            <button type="button" name="pFunghi"><p>pizza Funghi 12,50 euro</p></button>
            <button type="button" name="pMarina"><p>pizza Marina 13,95 euro</p></button>
            <button type="button" name="pHawai"><p>pizza Hawai 11,50 euro</p></button>
            <button type="button" name="pQuattro"><p>pizza Quattro Formaggi 14,50 euro</p></button>
            
            <input type="submit" name="submit" formaction="" value="Bestelling plaatsen"/><br />
        </form>
        <?php

            

            echo "Dit zijn je gegevens: <br /><br />"
            ."Naam: ".$fname."<br /> ".$lname."<br /> "."Adres: "
            .$adres."<br /> "."Plaats: ".$place."<br /> "."Datum: "
            .$date."<br /> "."Bezorg keuze: ".$choice." <br />"."Dikke pizza's: ";
            
        ?>

    </body>
</html>