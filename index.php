<?php
        //variablen van de gegevens
        $fname = $lname = $adres = $place = $postcode = $date = $choice =  "";
        $pMargherita = $pFunghi = $pMarina = $pHawai = $pQuattro = $extraKosten = 0;
        $pizzas = array();
        $pizzaPrices = array($price1=12.50,$price2=12.50,$price3=13.95,$price4=11.50,$price5=14.50);
        $pizzaNames = array("Pizza Margherita","Pizza Funghi","Pizza Marina","Pizza Hawai","Pizza Quattro formaggi");
        $totalPrice = array();
        $day = date('D');
        //(error) messages + extra messages
        $nameErr = $adresErr = $placeErr = $postcodeErr = $dateErr = $pizzaErr = $choiceErr = $dailyMsg = $extraMsg = "";
        //$currentDate = date('d-m-Y h:i:');
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

            //de variablen opslaan.
            $fname = test_input($_POST["fname"]);
            $lname = test_input($_POST["lname"]);
            $adres = test_input($_POST["adres"]);
            $place = test_input($_POST["place"]);
            $postcode = test_input($_POST["postcode"]);
            $date = test_input($_POST["date"]);
            $choice = test_input($_POST["choice"]);

            //de hoeveelheid pizzas opslaan en een floatvalue van maken zodat je ze keer de bijbehorende prijs kan doen.
            $pMargherita = floatval($_POST["pMargherita"]);
            $pFunghi = floatval($_POST["pFunghi"]);
            $pMarina = floatval($_POST["pMarina"]);
            $pHawai = floatval($_POST["pHawai"]);
            $pQuattro = floatval($_POST["pQuattro"]);
            array_push($pizzas, $pMargherita,$pFunghi,$pMarina,$pHawai,$pQuattro);

            //Check of de invoer velden niet leeg zijn nadat de form submitted is.
            if (!$fname || !$lname){
                $nameErr = "Vul uw naam en achternaam in alstublieft.";
            }else if (!preg_match("/^[a-zA-Z-' ]*$/",$fname) || !preg_match("/^[a-zA-Z-' ]*$/",$lname)) {
                $nameErr = "alleen letters en wit regels toegestaan!";
            }
            
            if (!$adres){
                $adresErr = "Vul uw adres in alstublieft.";
            }else{
                $adressErr = "";
            }
            if (!$place){
                $placeErr = "Vul uw plaatsnaam in alstublieft.";
            }else{
                $placeErr = "";
            }
            if (!$postcode) {
                $postcodeErr = "Vul uw postcode in alstublieft";
            }else{
                $postcodeErr = "";
            }
            if (!$date) {
                $dateErr = "Vul uw adres in alstublieft.";
            }else {
                $dateErr = "";
            }

            if ($choice == "none") {
                $choiceErr = "Kiez tussen laten bezorgen of ophalen in alstublieft.";
            }else if ($choice == "bezorgen") {
                $extraKosten =+ 5;
                $extraMsg = "extra bezorg kosten";
            }else {
                $extraKosten = 0;
                $extraMsg = "extra bezorg kosten";
            }
            //check voor als alle hoeveelheden van de verschillende pizza's niet 0 zijn, want dat betekent dat er niks besteld is.
            if (array_sum($pizzas) == 0) {
                $pizzaErr = "Je moet tenminste 1 pizza bestellen!";
            }
            if ($day == "Mon") {
                $dailyMsg = "Het is pizza actie dag wow epic.";
                array_fill_keys($pizzaPrices,7.50);
            }else if ($day == "Thu") {
                $dailyMsg = "Het is pizza start weekend dag idk.";
                array_fill_keys($pizzaPrices,7.50);
                
            }
        }
?>
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
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <fieldset>
            <span class="dailyMsg"><?php echo $dailyMsg; ?></span><br />
            <span class="errorMsg">* <?php echo $pizzaErr; ?></span><br />
            <legend>Pizzas die je kunt bestellen.</legend>
                <p>Pizza margherita €12.50</p><input type="number" name="pMargherita" min="0" max="10" 
                value="<?php echo $pMargherita; ?>">            
                <p>pizza Funghi €12,50</p><input type="number" name="pFunghi" min="0" max="10" 
                value="<?php echo $pFunghi; ?>">
                <p>pizza Marina €13,95</p><input type="number" name="pMarina" min="0" max="10" 
                value="<?php echo $pMarina; ?>">
                <p>pizza Hawai €11,50</p><input type="number" name="pHawai" min="0" max="10" 
                value="<?php echo $pHawai ?>">
                <p>pizza Quattro Formaggi €14,50</p><input type="number" name="pQuattro" min="0" max="10" 
                value="<?php echo $pQuattro ?>">
        </fieldset>
            <span class="errorMsg">* <?php echo $nameErr; ?></span><br />
            Uw naam: 
            <input type="text" name="fname" value="<?php if(isset($_POST['fname'])) echo htmlspecialchars($_POST['fname']); ?>"/>
            <br>
            Uw achternaam: 
            <input type="text" name="lname" value="<?PHP if(isset($_POST['lname'])) echo htmlspecialchars($_POST['lname']); ?>"/>
            <br>
            Uw adres: <input type="text" name="adres" value="<?PHP if(isset($_POST['adres'])) echo htmlspecialchars($_POST['adres']); ?>"/>
            <span class="errorMsg">* <?php echo $adresErr; ?></span><br />
            Uw plaatsnaam: 
            <input type="text" name="place" value="<?PHP if(isset($_POST['place'])) echo htmlspecialchars($_POST['place']); ?>"/>
            <span class="errorMsg">* <?php echo $placeErr; ?></span><br />
            Uw postcode: 
            <input type="text" name="postcode" value="<?PHP if(isset($_POST['postcode'])) echo htmlspecialchars($_POST['postcode']); ?>"/>
            <span class="errorMsg">* <?php echo $postcodeErr; ?></span><br />
            Uw besteldatum: 
            <input type="datetime-local" name="date" value="<?php if(isset($_POST['date'])) echo htmlspecialchars($_POST['date']); ?>" placeholder="<?php echo date('d-m-Y'); ?>"/>
            <span class="errorMsg">* <?php echo $dateErr; ?></span><br />
            Kiez tussen bezorgen of ophalen: 
            <select name="choice" value="<?php if(isset($_POST['choice'])) echo htmlspecialchars($_POST['choice']); ?>" required>
                <option value="none" selected>Kiez een optie.</option>
                <option value="Afhalen" >Afhalen.</option>
                <option value="bezorgen">Laten bezorgen.</option>
            </select>
            <span class="errorMsg">* <?php echo $choiceErr; ?></span><br />
            <br />
            <input type="submit" name="submit" value="Bestellen"/><br />
                <?php
            
                    //De gegevens van de user uitprinten.
                    echo "<h2>Uw gegevens: </h2>";
                    echo "<p>Uw voornaam: $fname</p>";
                    echo "<p>Uw achternaam: $lname</p>";
                    echo "<p>Uw adres: $adres</p>";
                    echo "<p>Uw plaats naam: $place</p>";
                    echo "<p>Uw postcode: $postcode</p>";
                    echo "<p>Uw bestel datum: $date </p>";
                    echo "<p>Uw bestelling keuze: $choice</p>";
                    echo "<br>";

                    //print de hoeveelheid van elke pizza * de prijs van elke pizza uit en print de bijbehorende naam.
                    //check voor welke dag het is en bereken de korting uit.
                    echo "<p>Uw bestelde pizza's: </p>";
                    for ($i=0;count($pizzas)>$i;$i++) {
                        if ($day == "Thu" && $pizzas[$i] > 0) {
                            echo "test ";
                            echo $pizzas[$i]."x ".$pizzaNames[$i]."&nbsp";
                            $pizzas[$i] *= $pizzaPrices[$i];
                            echo  "€".$pizzas[$i]."<br>";
                            array_push($totalPrice,$pizzas[$i]);

                            }else if ($day == "Fri" && $pizzas[$i] > 0) {
                                echo "test ";
                                $dailyMsg = "Dikke pizza vrijdag jooooo!!!";
                                echo $pizzas[$i]."x ".$pizzaNames[$i]."&nbsp";
                                $pizzas[$i] *= $pizzaPrices[$i];
                                array_push($totalPrice,$pizzas[$i]);
                            if (array_sum($totalPrice) > 20) {
                                $totalPrice[$i] / 100 * 15;
                                }
                                
                            }else if ($pizzas[$i] > 0) {
                                echo $pizzas[$i]."x ".$pizzaNames[$i]."&nbsp";
                                $pizzas[$i] *= $pizzaPrices[$i];
                                echo  "€".$pizzas[$i]."<br>";
                                array_push($totalPrice,$pizzas[$i]);
                                
                            }

                    }
                    $totaalBedrag  = array_sum($totalPrice);
                    echo "<p>Uw totaal bedrag: </p>"."€".$totaalBedrag + $extraKosten; 
                    if ($extraKosten > 0) {
                        echo " (+ €$extraKosten $extraMsg)";
                    }
                ?>
        </form>
        
    </body>
</html>