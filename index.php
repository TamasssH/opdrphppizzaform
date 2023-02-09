<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <form method="post" action="">
            <label>Enter your first name:</label><br />
            <input type="text" name="fname" id="fname"><br />
            <label>Enter your last name</label><br />
            <input type="text" name="lname" id="lname"><br />
            <input type="submit" value="submit bitch!!1"><br />
        </form>
        <?php 
        
            if(isset($_POST["submit"])){
                $fname = $_POST["fname"];
                $lname = $_POST["lname"];

            echo "Goedemorgen, ".$fname." ".$lname;
            }

        ?>

    </body>
</html>