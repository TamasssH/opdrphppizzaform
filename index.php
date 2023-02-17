<!DOCTYPE html>
<html>
    <head>
        <title>Pizza</title>
        <meta charset="UTF-8">
        <meta  name="viewport" content="width=device-width,
        initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
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
        //(error) messages
        $fnameErr = $lnameErr = $adresErr = $placeErr = $postcodeErr = $dateErr = $pizzaErr = $choiceErr = $dailyMsg = "";
    
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

            if (empty($_POST["fname"])){
                $fnameErr = "Vul uw naam in alstublieft.";
            }else {
                $fname = test_input($_POST["fname"]);
                if(!preg_match("/^[a-zA-Z-' ]*$/",$fname)) {
                    $fnameErr = "Only letters and white space allowed";
                }
            }

            if (empty($_POST["lname"])){
                $lnameErr = "Vul uw achternaam in alstublieft.";
            }else {
                $lname = test_input($_POST["lname"]);
                if(!preg_match("/^[a-zA-Z-' ]*$/",$lname)) {
                    $lnameErr = "Only letters and white space allowed";
                }
            }

            if (empty($_POST["adres"])){
                $adresErr = "Vul uw adres in alstublieft.";
            }else {
                $adres = test_input($_POST["adres"]);
            }

            if (empty($_POST["place"])){
                $placeErr = "Vul uw plaats naam in alstublieft.";
            }else {
                $place = test_input($_POST["place"]);
            }

            if (empty($_POST["postcode"])){
                $postcodeErr = "Vul uw postcode in alstublieft.";
            }else {
                $postcode = test_input($_POST["postcode"]);
            }

            if (empty($_POST["date"])){
                $dateErr = "Vul de datum in alstublieft.";
            }else {
                $date = test_input($_POST["date"]);
            }
            //check for maandagen 
            if(date("D") == "Mon") {
                foreach($pizzas as $value) {
                    $value = 7.50;
                }
            }

            if (array_sum($pizzas) == 0) {
                $pizzaErr = "Je moet tenminste 1 pizza bestellen!";
            }
            
            if ($_POST["choice"] == "none") {
                $choiceErr = "Je moet kiezen tussen afhalen of laten bezorgen.";

            }else if($_POST["choice"] == "bezorgen"){
                $choice = test_input($_POST["choice"]);
                $extraKosten =+ 5;

            }else {
                $choice = test_input($_POST["choice"]);
            }

        }
            
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <span class="dialyMsg"> <?php echo $dailyMsg ?></span>

            Enter your first name: <input type="text" name="fname"/>
            <span class="errorMsg">* <?php echo $fnameErr; ?></span><br />

            Enter your last name: <input type="text" name="lname"/>
            <span class="errorMsg">* <?php echo $lnameErr; ?></span><br />

            Enter your adres: <input type="text" name="adres"/>
            <span class="errorMsg">* <?php echo $adresErr; ?></span><br />

            Enter your place: <input type="text" name="place"/>
            <span class="errorMsg">* <?php echo $placeErr; ?></span><br />

            Enter your postal code: <input type="text" name="postcode"/>
            <span class="errorMsg">* <?php echo $postcodeErr; ?></span><br />

            Enter your order date: <input type="text" name="date" placeholder="dd-mm-yy"/>
            <span class="errorMsg">* <?php echo $dateErr; ?></span><br />

            order or pick up: <select name="choice" placeholder="select your choice" required>
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

            //print de hoeveelheid van elke pizza * de prijs van elke pizza uit en print de bijbehorende naam.
            echo "<p>Uw bestelde pizza's: </p>";
            for ($i=0;count($pizzas)>$i;$i++) {
                echo $pizzas[$i]."x ".$pizzaNames[$i]."&nbsp";
                $pizzas[$i] *= $pizzaPrices[$i];
                echo  "€".$pizzas[$i]."<br>";
                array_push($totalPrice,$pizzas[$i]);
            }
            echo "<p>Uw totaal bedrag: </p>"."€".array_sum($totalPrice) + $extraKosten." (+ €$extraKosten Extra bezorg kosten)";
            
        ?>
    </body>
</html>