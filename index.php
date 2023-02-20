<!DOCTYPE html>
<html>
    <head>
        <title>Pizza</title>
        <meta charset="UTF-8">
        <meta  name="viewport" content="width=device-width,
        initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css?t=1"> 
    </head>
    <body>
        <?php

        //variablen van de gegevens
        $fname = $lname = $adres = $place = $postcode = $date = $choice =  "";
        $pMargherita = $pFunghi = $pMarina = $pHawai = $pQuattro = $extraKosten = 0;
        $pizzas = array();
        $pizzaPrices = array($price1=12.50,$price2=12.50,$price3=13.95,$price4=11.50,$price5=14.50);
        $pizzaNames = array("Pizza Margherita","Pizza Funghi","Pizza Marina","Pizza Hawai","Pizza Quattro formaggi");
        $totalPrice = array();
        //(error) messages + extra messages
        $nameErr = $adresErr = $placeErr = $postcodeErr = $dateErr = $pizzaErr = $choiceErr = $dailyMsg = $extraMsg = "";
    
        // de functie die ervoor zorgt dat de data van de user wordt getest.
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        
        /*check voor als de post method word gebruikt
        en als die wordt gebruikt dan excuteer de 
        test_input function zodat de data geen speciale characters bevat.
        Daarna wordt de user data stored in n hoop variables.
        Er wordt ook gechecked op speciale chars met regular expression
        */ 
        if (isset($_POST["submit"])) {
            phpinfo(INFO_VARIABLES);

            $pMargherita = floatval($_POST["pMargherita"]);
            $pFunghi = floatval($_POST["pFunghi"]);
            $pMarina = floatval($_POST["pMarina"]);
            $pHawai = floatval($_POST["pHawai"]);
            $pQuattro = floatval($_POST["pQuattro"]);
            array_push($pizzas, $pMargherita,$pFunghi,$pMarina,$pHawai,$pQuattro);

            //if (empty) was de originele code just so u know lolololol.
            if (empty($_POST["fname"]) || empty($_POST["lname"])){
                $nameErr = "Vul uw naam en achternaam in alstublieft.";
            }else {
                $fname = test_input($_POST["fname"]);
                $lname = test_input($_POST["lname"]);
                if(!preg_match("/^[a-zA-Z-' ]*$/",$fname) || !preg_match("/^[a-zA-Z-' ]*$/",$lname)) {
                    $nameErr = "alleen letters en wit regels toegestaan!";
                }
            }

            if (empty($_POST["adres"]) || empty($_POST["place"]) || empty($_POST["postcode"])){
                $adresErr = "Vul uw adres in alstublieft.";
                $placeErr = "Vul uw plaats naam in alstublieft.";
                $postcodeErr = "Vul uw postcode in alstublieft.";
            }else {
                $adres = test_input($_POST["adres"]);
                $place = test_input($_POST["place"]);
                $postcode = test_input($_POST["postcode"]);
            }

            if (empty($_POST["date"])){
                $dateErr = "Vul de datum in alstublieft.";
            }else {
                $date = test_input($_POST["date"]);
                //check for maandagen en doe bonus prijzen als t maandag is.
                if(date('N') == 2) {
                    $dailyMsg = "Het is pizza actie dag, alle pizza's nu voor maar €7.50 per stuk!";
                    $pizzaPrices = array_fill(0,5,7.50);
                        //was eerst de code ik laat het hier omdat de code erboven mischien niet werkt.
                        //for($i=0;count($pizzaPrices)>$i;$i++) {
                        //    $pizzaPrices[$i] = 7.50;
                        //}
                }else if(date('N') == 1){
                    $dailyMsg = "Het is pizza start weekend dag, alle bestellingen boven de €20 krijgen nu 15% korting!";
                    
                    if(array_sum($pizzaPrices) > 20) {
                        $totaalBedrag = array_sum($pizzaPrices) / 100 * 15;
                        
                    }
                    
                }
            }
            //check of de bezorg keuze geselecteerd is. zo niet dan errormessage. check welke van de 2 keuzes zijn geselecteerd.
            if ($_POST["choice"] == "none") {
                $choiceErr = "Je moet kiezen tussen afhalen of laten bezorgen.";

            }else if($_POST["choice"] == "bezorgen"){
                $choice = test_input($_POST["choice"]);
                $extraKosten =+ 5;
                $extraMsg = "extra bezorg kosten";

            }else {
                $choice = test_input($_POST["choice"]);
                $extraKosten = 0;
                $extraMsg = "";
            }

            //check voor als er helemaal geen pizza's zijn besteld (zolang niet alle pizza's 0 zijn is t prima).
            if (array_sum($pizzas) == 0) {
                $pizzaErr = "Je moet tenminste 1 pizza bestellen!";
            }
        
        }
            
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <span class="dailyMsg"> <?php echo $dailyMsg; ?></span><br />

            Uw naam: <input type="text" name="fname"/>
            <span class="errorMsg">* <?php echo $nameErr; ?></span><br />

            Uw achternaam: <input type="text" name="lname"/>
            <span class="errorMsg">* <?php echo $nameErr; ?></span><br />

            Uw adres: <input type="text" name="adres"/>
            <span class="errorMsg">* <?php echo $adresErr; ?></span><br />

            Uw plaatsnaam: <input type="text" name="place"/>
            <span class="errorMsg">* <?php echo $placeErr; ?></span><br />

            Uw postcode: <input type="text" name="postcode"/>
            <span class="errorMsg">* <?php echo $postcodeErr; ?></span><br />

            Uw besteldatum: <input type="text" name="date" placeholder="dd-mm-yy"/>
            <span class="errorMsg">* <?php echo $dateErr; ?></span><br />

            Kiez tussen bezorgen of ophalen: <select name="choice" placeholder="select your choice" required>
                <option value="none" selected>Kiez een optie.</option>
                <option value="Afhalen" >Afhalen.</option>
                <option value="bezorgen">Laten bezorgen.</option>
            </select>
            <span class="errorMsg">* <?php echo $choiceErr; ?></span><br />
            
            <br /><br />

                <fieldset name="pizzas">
                    <span class="errorMsg">* <?php echo "$pizzaErr"; ?></span><br />
                    <legend>Pizzas die je kunt bestellen.</legend>

                    <p>Pizza margherita €12.50</p><input type="number" name="pMargherita" min="1" max="10">
                    <p>pizza Funghi €12,50</p><input type="number" name="pFunghi" min="1" max="10">
                    <p>pizza Marina €13,95</p><input type="number" name="pMarina" min="1" max="10">
                    <p>pizza Hawai €11,50</p><input type="number" name="pHawai" min="1" max="10">
                    <p>pizza Quattro Formaggi €14,50</p><input type="number" name="pQuattro" min="1" max="10">
                </fieldset>    

            <input type="submit" name="submit" value="Besteld"/><br />
        </form>
        <?php
        
            echo "<h2>Uw gegevens: </h2>";
            echo "<p>Uw voornaam: </p>".$fname;
            echo "<br></br>";
            echo "<p>Uw achternaam: </p>".$lname;
            echo "<br></br>";
            echo "<p>Uw adres: </p>".$adres;
            echo "<br></br>";
            echo "<p>Uw plaats naam: </p>".$place;
            echo "<br></br>";
            echo "<p>Uw postcode: </p>".$postcode;
            echo "<br></br>";
            echo "<p>Uw bestel datum: </p>".$date;
            echo "<p>Uw bestelling keuze: </p>".$choice;
            echo "<br></br>";
            echo date("j");

            //print de hoeveelheid van elke pizza * de prijs van elke pizza uit en print de bijbehorende naam.
            echo "<p>Uw bestelde pizza's: </p>";
            for ($i=0;count($pizzas)>$i;$i++) {
                echo $pizzas[$i]."x ".$pizzaNames[$i]."&nbsp";
                $pizzas[$i] *= $pizzaPrices[$i];
                echo  "€".$pizzas[$i]."<br>";
                array_push($totalPrice,$pizzas[$i]);
            }
            $totaalBedrag  = array_sum($totalPrice);
            echo "<p>Uw totaal bedrag: </p>"."€".$totaalBedrag + $extraKosten." (€$extraKosten $extraMsg)";
            
        ?>
    </body>
</html>