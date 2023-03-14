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
        Er wordt ook gechecked op speciale chars met regular expressions
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

            if (!$fname || !$lname){
                $nameErr = "Vul uw naam en achternaam in alstublieft.";
            }else if (!preg_match("/^[a-zA-Z-' ]*$/",$fname) || !preg_match("/^[a-zA-Z-' ]*$/",$lname)) {
                $nameErr = "alleen letters en wit regels toegestaan!";
            }
            $adresErr = !$adres ? "Vul uw adres in alstublieft" : "";
            $placeErr = !$place ? "Vul uw plaatsnaam in alstublieft" : "";
            $postcodeErr = !$postcode ? "Vul uw postcode in alstublieft." : "";
            $dateErr = !$date ? "Vul de datum & tijd in alstublieft." : "";
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
                $dailyMsg = "Het is pizza actie dag. alle pizza's nu voor maar €7.50!";
            }else if ($day == "Fri") {
                $dailyMsg = "Het is pizza start weekend dag. Alle bestelling boven de €20 krijgen 15% korting!";
                
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
        <link rel="stylesheet" type="text/css" href="style.css?t=2"> 
    </head>
    <body>
        <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <fieldset>
            <span class="dailyMsg"><?php echo $dailyMsg; ?></span><br />
            <span class="errorMsg">* <?php echo $pizzaErr; ?></span><br />
            <legend>Pizzas die je kunt bestellen.</legend>
                <p>Pizza margherita <?php echo "€".$pizzaPrices[0] ?></p><input type="number" name="pMargherita" min="0" max="10" 
                value="<?php echo $pMargherita; ?>">            
                <p>pizza Funghi <?php echo "€".$pizzaPrices[1] ?></p><input type="number" name="pFunghi" min="0" max="10" 
                value="<?php echo $pFunghi; ?>">
                <p>pizza Marina <?php echo "€".$pizzaPrices[2] ?></p><input type="number" name="pMarina" min="0" max="10" 
                value="<?php echo $pMarina; ?>">
                <p>pizza Hawai <?php echo "€".$pizzaPrices[3] ?></p><input type="number" name="pHawai" min="0" max="10" 
                value="<?php echo $pHawai ?>">
                <p>pizza Quattro Formaggi <?php echo "€".$pizzaPrices[4] ?></p><input type="number" name="pQuattro" min="0" max="10" 
                value="<?php echo $pQuattro ?>">
        </fieldset>
            <span class="errorMsg">* <?php echo $nameErr; ?></span><br />
            <p>Uw naam:</p>
            <input type="text" name="fname" value="<?php if(isset($_POST['fname'])) echo htmlspecialchars($_POST['fname']); ?>"/>
            <p>Uw achternaam:</p>
            <input type="text" name="lname" value="<?PHP if(isset($_POST['lname'])) echo htmlspecialchars($_POST['lname']); ?>"/>
            <p>Uw adres:</p>
            <input type="text" name="adres" value="<?PHP if(isset($_POST['adres'])) echo htmlspecialchars($_POST['adres']); ?>"/>
            <span class="errorMsg">* <?php echo $adresErr; ?></span><br />
            <p>Uw plaatsnaam:</p>
            <input type="text" name="place" value="<?PHP if(isset($_POST['place'])) echo htmlspecialchars($_POST['place']); ?>"/>
            <span class="errorMsg">* <?php echo $placeErr; ?></span><br />
            <p>Uw postcode:</p>
            <input type="text" name="postcode" value="<?PHP if(isset($_POST['postcode'])) echo htmlspecialchars($_POST['postcode']); ?>"/>
            <span class="errorMsg">* <?php echo $postcodeErr; ?></span><br />
            
            <p>Uw besteldatum: </p>
            <input type="date" min=<?php date("d-m-Y");?> name="date" value="<?php if(isset($_POST["date"])) echo htmlspecialchars($_POST["date"]); ?>" placeholder="<?php echo date('d-m-Y'); ?>"/>
            <span class="errorMsg">* <?php echo $dateErr; ?></span>
            <p>Uw besteltijd:</p> 
            <input type="time" min=<?php date("G");?> name="time"  value="<?php if(isset($_POST['time'])) echo htmlspecialchars($_POST['time']); ?>" placeholder="<?php echo date('G'); ?>"/>
            <br>
            Kiez tussen bezorgen of ophalen: 
            <select name="choice" value="<?php if(isset($_POST['choice'])) echo htmlspecialchars($_POST['choice']); ?>" required>
                <option value="none" selected>Kiez een optie.</option>
                <option value="Afhalen" >Afhalen.</option>
                <option value="bezorgen">Laten bezorgen.</option>
            </select>
            <span class="errorMsg">* <?php echo $choiceErr; ?></span><br />
            <br />
            <input type="submit" name="submit" value="Bestellen"/><br />
        </form>
        
            <!-- De gegevens van de user uitprinten. -->
            
            <h2> <?php echo "Uw gegevens: "; ?> </h2>
            <p> <?php echo "Uw voornaam: $fname "; ?> </p>
            <p> <?php echo "Uw achternaam: $lname"; ?> </p>
            <p> <?php echo "Uw adres: $adres"; ?> </p>
            <p> <?php echo "Uw plaats naam: $place"; ?> </p>
            <p> <?php echo "Uw postcode: $postcode"; ?> </p>
            <p> <?php echo "Uw bestel datum: $date"; ?> </p>
            <p> <?php echo "Uw bestelling keuze: $choice"; ?> </p>
            <br>
            <!-- De bestelde pizza's + hoeveel van elke pizza + de prijs van elke pizza + het totaal bedrag. -->
            <p> <?php echo "<p>Uw bestelde pizza's: "; ?></p>
        <?php 
            //check voor welke dag het is en bereken de korting uit.
            for ($i=0;count($pizzas)>$i;$i++) {
                if ($day == "Mon" && $pizzas[$i] > 0) {
                    echo "<p>".$pizzas[$i]."x ".$pizzaNames[$i]."&nbsp";
                    $pizzas[$i] *= 7.50;
                    echo  "€".$pizzas[$i]."</p>";
                    array_push($totalPrice,$pizzas[$i]);
                    }else if ($day == "Fri" && $pizzas[$i] > 0) {
                        echo "<p>".$pizzas[$i]."x ".$pizzaNames[$i]."&nbsp";
                        $pizzas[$i] *= $pizzaPrices[$i];
                        array_push($totalPrice,$pizzas[$i]);
                    if (array_sum($totalPrice) > 20) {
                        $totalPrice[$i] / 100 * 15;
                        }
                        echo "€".$pizzas[$i]."</p>";     
                    }else if ($day != "Mon" && $day != "Fri" && $pizzas[$i] > 0) {
                        echo "<p>".$pizzas[$i]."x ".$pizzaNames[$i]."&nbsp";
                        $pizzas[$i] *= $pizzaPrices[$i];
                        echo  "€".$pizzas[$i]."</p>";
                        array_push($totalPrice,$pizzas[$i]);
                    }
                }
                $totaalBedrag  = array_sum($totalPrice);
                echo "<p>Uw totaal bedrag: €".$totaalBedrag + $extraKosten; 
                if ($extraKosten > 0) {
                    echo " (+ €$extraKosten $extraMsg)</p>";
                }
        ?>
    </body>
</html>