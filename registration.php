<html>

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <title>PHP registrering</title>
</head>

<body>



    <div>
        <a href="Home.html" class="hjemmeside">Hjem</a>
    </div>







    <br><br><br>
    <div class="containerofall">
        <div class="oprettcontainer">
            <p>Opprett ny bruker:</p>
            <form method="post">
                <label for="brukernavn">Brukernavn:</label>
                <input type="text" name="username" /><br />
                <label for="passord">Passord:</label>
                <input type="password" name="password" /><br />
                <div class="btnstyle">
                    <input type="submit" value="Logg inn" name="submit" />
                </div>
            </form>
        </div>



        <?php
        if (isset($_POST['submit'])) {
            //Gjøre om POST-data til variabler
            $brukernavn = $_POST['username'];
            $passord = md5($_POST['password']);

            //Koble til databasen
            $dbc = mysqli_connect('localhost', 'root', 'Admin', 'skyteoppdragnyeste')
                or die('Error connecting to MySQL server.');

            // Prepare a SELECT query to check if the username already exists
            $check_username_query = "SELECT * FROM user WHERE brukernavn = '$brukernavn'";

            // Execute the SELECT query
            $check_username_result = mysqli_query($dbc, $check_username_query);

            // Check if any rows were returned
            if (mysqli_num_rows($check_username_result) > 0) {
                // Username already exists
                echo "Username already exists. Please choose a different one.";
            } else {
                //Gjøre klar SQL-strengen
                $query = "INSERT INTO user (brukernavn, passord) VALUES ('$brukernavn','$passord')";

                //Utføre spørringen
                $result = mysqli_query($dbc, $query)
                    or die('Error querying database.');

                //Koble fra databasen
                mysqli_close($dbc);

                //Sjekke om spørringen gir resultater
                if ($result) {
                    //Gyldig login
                    echo "<p class='quicktest'>Takk for at du lagde bruker! Trykk <a href='mainpage.html' class='quicktest'>her</a> for å logge inn</p>";
                } else {
                    //Ugyldig login
                    echo "Noe gikk galt, prøv igjen!";
                }
            }
        }
        ?>
    </div>

</body>

</html>