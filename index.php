<?php
    //variablen van de gegevens
    $fname = $lname = $adres = $place = $postcode = $date = $choice = $time = "";
    $pMargherita = $pFunghi = $pMarina = $pHawai = $pQuattro = $extraKosten = 0;
    $pizzas = array();
    $pizzaPrices = array($price1=12.50,$price2=12.50,$price3=13.95,$price4=11.50,$price5=14.50);
    $pizzaNames = array("Pizza Margherita","Pizza Funghi","Pizza Marina","Pizza Hawai","Pizza Quattro formaggi");
    $totalPrice = array();
    $day = date('D');
    $dateToday = date("Y-m-d");
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
        //de variablen opslaan.
        $fname = test_input($_POST["fname"]);
        $lname = test_input($_POST["lname"]);
        $adres = test_input($_POST["adres"]);
        $place = test_input($_POST["place"]);
        $postcode = test_input($_POST["postcode"]);
        $date = test_input($_POST["date"]);
        $time = test_input($_POST["time"]);
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
        $dateErr = !$date || !$time ? "Vul de datum & tijd in alstublieft." : "";
        if ($choice == "none") {
            $choiceErr = "Kies tussen laten bezorgen of ophalen in alstublieft.";
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
        <title>Pizzaria di sog</title>
        <meta charset="UTF-8">
        <meta  name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css?t=3"> 
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@1,300&display=swap" rel="stylesheet">   
    </head>
    <body>
        <header>
            <h1 class="title">Pizzaria di sog</h1>
        </header>
        <main>
            <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div>
                    <h2 class="header2">Acties: <span class="dailyMsg"><?php echo $dailyMsg; ?></span></h2>
                    <span class="errorMsg">* <?php echo $pizzaErr; ?></span><br />
                    <div class="pizzaLijst">      
                        <div class="column1">
                            <img src="resources/margherita.jpg" alt="pizza margherita" width="250" height="250">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer luctus cursus libero, 
                                id gravida neque rhoncus in. In nisl purus, faucibus quis ullamcorper sit amet. Lorem ipsum 
                                dolor sit amet, consectetur adipiscing elit.
                            </p>
                            <p>Pizza margherita <?php if($day == "Mon") echo "€7.50"; else echo "€".$pizzaPrices[0] ?></p>
                            <input class="inputfield" type="number" name="pMargherita" min="0" max="10" value="<?php echo $pMargherita; ?>">
                        </div>
                        <div class="column2">
                            <img src="resources/funghi.png" alt="pizza funghi" width="250" height="250">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer luctus cursus libero, 
                                id gravida neque rhoncus in. In nisl purus, faucibus quis ullamcorper sit amet. Lorem ipsum 
                                dolor sit amet, consectetur adipiscing elit.
                            </p>
                            <p>pizza Funghi <?php if($day == "Mon") echo "€7.50"; else echo "€".$pizzaPrices[1] ?></p>
                            <input class="inputfield" type="number" name="pFunghi" min="0" max="10" value="<?php echo $pFunghi; ?>">
                        </div>
                        <div class="column3">
                            <img src="resources/marina.jpg" alt="pizza marina" width="250" height="250">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer luctus cursus libero, 
                                id gravida neque rhoncus in. In nisl purus, faucibus quis ullamcorper sit amet. Lorem ipsum 
                                dolor sit amet, consectetur adipiscing elit.
                            </p>
                            <p>pizza Marina <?php if($day == "Mon") echo "€7.50"; else echo "€".$pizzaPrices[2] ?></p>
                            <input class="inputfield" type="number" name="pMarina" min="0" max="10" value="<?php echo $pMarina; ?>">
                        </div>
                        <div class="column4">
                            <img src="resources/Quattro_formaggi.png" alt="pizza quattro formaggi" width="250" height="250">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer luctus cursus libero, 
                                id gravida neque rhoncus in. In nisl purus, faucibus quis ullamcorper sit amet. Lorem ipsum 
                                dolor sit amet, consectetur adipiscing elit.
                            </p>
                            <p>pizza Quattro Formaggi <?php if($day == "Mon") echo "€7.50"; else echo "€".$pizzaPrices[3] ?></p>
                            <input class="inputfield" type="number" name="pQuattro" min="0" max="10" value="<?php echo $pQuattro ?>">
                        </div>
                        <div class="column5">
                            <img src="resources/hawaii.jpg" alt="pizza hawaii" width="250" height="250">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer luctus cursus libero, 
                                id gravida neque rhoncus in. In nisl purus, faucibus quis ullamcorper sit amet. Lorem ipsum 
                                dolor sit amet, consectetur adipiscing elit.
                            </p>
                            <p>pizza Hawai <?php if($day == "Mon") echo "€7.50"; else echo "€".$pizzaPrices[4] ?></p>
                            <input class="inputfield" type="number" name="pHawai" min="0" max="10" value="<?php echo $pHawai ?>">
                        </div>
                    </div>
                </div>
                <div class="forminput">
                    <span class="errorMsg">* <?php echo $nameErr; ?></span><br />
                    <p>Uw naam:</p>
                    <input class="textinput" type="text" name="fname" value="<?php if(isset($_POST['fname'])) echo htmlspecialchars($_POST['fname']); ?>"/>
                    <p>Uw achternaam:</p>
                    <input class="textinput" type="text" name="lname" value="<?php if(isset($_POST['lname'])) echo htmlspecialchars($_POST['lname']); ?>"/>
                    <p>Uw adres:</p>
                    <input class="textinput" type="text" name="adres" value="<?php if(isset($_POST['adres'])) echo htmlspecialchars($_POST['adres']); ?>"/>
                    <span class="errorMsg">* <?php echo $adresErr; ?></span><br />
                    <p>Uw plaatsnaam:</p>
                    <input class="textinput" type="text" name="place" value="<?PHP if(isset($_POST['place'])) echo htmlspecialchars($_POST['place']); ?>"/>
                    <span class="errorMsg">* <?php echo $placeErr; ?></span><br />
                    <p>Uw postcode:</p>
                    <input class="textinput" type="text" name="postcode" value="<?PHP if(isset($_POST['postcode'])) echo htmlspecialchars($_POST['postcode']); ?>"/>
                    <span class="errorMsg">* <?php echo $postcodeErr; ?></span><br />
                    <p>Uw besteldatum: </p>
                    <input class="textinput" type="date" name="date" min="<?php echo date("Y-m-d"); ?>" value="<?php if(isset($_POST["date"])) echo htmlspecialchars($_POST["date"]); ?>"/>
                    <span class="errorMsg">* <?php echo $dateErr; ?></span>
                    <p>Uw besteltijd:</p> 
                    <input class="textinput" type="time" name="time" value="<?php if(isset($_POST['time'])) echo htmlspecialchars($_POST['time']); ?>"/>
                    <br>
                    <p>Kies tussen bezorgen of ophalen: </p>
                    <select name="choice" value="<?php if(isset($_POST['choice'])) echo htmlspecialchars($_POST['choice']); ?>" required>
                        <option value="none" selected>Kies een optie.</option>
                        <option value="Afhalen" >Afhalen.</option>
                        <option value="bezorgen">Laten bezorgen.</option>
                    </select>
                    <span class="errorMsg">* <?php echo $choiceErr; ?></span><br />
                    <br />
                    <input type="submit" name="submit" value="Bestelling plaatsen"/><br />
                </div>
            </form>
            <div class="gegevens">
                <!-- De gegevens van de user uitprinten. -->
                <h2>
                    <?php echo "Uw gegevens: "; ?>
                </h2>
                <p>
                    <?php echo "Uw voornaam: $fname "; ?><br>
                    <?php echo "Uw achternaam: $lname"; ?><br>
                    <?php echo "Uw adres: $adres"; ?><br>
                    <?php echo "Uw plaats naam: $place"; ?><br>
                    <?php echo "Uw postcode: $postcode"; ?><br>
                    <?php echo "Uw bestel datum: $date om $time"; ?><br>
                    <?php echo "Uw bestelling keuze: $choice"; ?><br>
                </p>     
                <br>
                <h2>
                    <?php echo "<p>Uw bestelde pizza's: "; ?>
                </h2>
                <table class="gegevenspizzas">
                    <?php 
                        //check voor welke dag het is en bereken de korting uit.
                        //check voor maandag en doe de hoeveelheid pizza's * €7.50
                        if (array_sum($pizzas) > 0) {
                            if ($day == "Mon") {
                                echo "<p>Bestelde pizza's</p>";
                                for ($i=0;count($pizzas)>$i;$i++) {
                                    if ($pizzas[$i] > 0) {
                                        echo "<p>".$pizzas[$i]."x ".$pizzaNames[$i];
                                        //prijs berekenen
                                        $pizzas[$i] *= 7.50;
                                        echo " €".$pizzas[$i]."</p>";
                                        array_push($totalPrice,$pizzas[$i]);
                                    }
                                        
                                }
                            }
                            //check voor vrijdag en check daarna of de prijs boven de €20 is en doe dan de prijs / 100 * 15.
                            if ($day == "Fri") {
                                echo "<p>Bestelde pizza's</p>";
                                for ($i=0;count($pizzas)>$i;$i++) {
                                    if ($pizzas[$i] > 0) {
                                        echo "<p>".$pizzas[$i]."x ".$pizzaNames[$i];
                                        $pizzas[$i] *= $pizzaPrices[$i];
                                        array_push($totalPrice,$pizzas[$i]);
                                    }
                                }
                                if (array_sum($totalPrice) > 20) {
                                    $totalPrice[$i] / 100 * 15;
                                }
                                echo "€".$pizzas[$i]."</p>";
                            }
                            //als het niet maandag of vrijdag is doe de normale prijs berekening.
                            if ($day != "Mon" && $day != "Fri") {
                                echo "<p>Bestelde pizza's</p>";
                                for ($i=0;count($pizzas)>$i;$i++) {
                                    if ($pizzas[$i] > 0) {
                                        echo "<p>".$pizzas[$i]."x ".$pizzaNames[$i];
                                        $pizzas[$i] *= $pizzaPrices[$i];
                                        echo  "€".$pizzas[$i]."</p>";
                                        array_push($totalPrice,$pizzas[$i]);
                                    }
                                    
                                }  
                            }
                            //print het totaal bedrag uit en de extra bezorg kosten.
                            $totaalBedrag  = array_sum($totalPrice);
                                echo "<p>Uw totaal bedrag: €".$totaalBedrag + $extraKosten; 
                                if ($extraKosten > 0) {
                                    echo " (+ €$extraKosten $extraMsg)</p>";
                                }
                        }
                        
                        ?>
                </table>
            </div>
        </main>
        <footer>
            <p>©Copyright 2023 by Mr Sogga. All rights reversed.</p>
        </footer>
    </body>
</html>