<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="form.css">
    <script src="master.js"></script>
    <title>Document</title>
</head>

<body>

    <h1>Ajouter une ville</h1>
    <div class="form">

        <form id="myform" method="post" action="creer_ville.php">
            <label for="nomVille">Ville:</label><BR>
            <input type="text" name="nomVille" placeholder="saisir la ville" maxlength="10" required><br><br>
            <label for="nomPays">Pays:</label><BR>

            <?php
            //enterer la ville a la base de donnees et les necessaires
            $conn = mysqli_connect("localhost:3306", "root", "");
            $sqlFile = file_get_contents("../database/voyage.sql");

            if (mysqli_multi_query($conn, $sqlFile)) {
                // liberer le buffer pour faire autres requets
                while (mysqli_next_result($conn)) {
                    if (!mysqli_more_results($conn)) {
                        break;
                    }
                }
            } else {
                echo "Error executing SQL file: " . mysqli_error($conn);
            }

            // Retrieve continent and pays data from the database
            $sql = "SELECT c.idcon, c.nomcon AS continent, ct.idpay, ct.nompay AS pays
        FROM continent c JOIN pays ct ON c.idcon = ct.idcon
        ORDER BY c.idcon, ct.nompay;";
            $result = $conn->query($sql);

            // Generate HTML
            echo '<select id="pays" name="pays" required>';
            $currentContinentId = null;
            while ($row = $result->fetch_assoc()) {
                $idContinent = $row['idcon'];
                $continent = $row['continent'];
                // $pays = $row['idpay'];
                $pays = $row['pays'];

                // Check if a new continent group is starting
                if ($idContinent !== $currentContinentId) {
                    // Close the previous optgroup if it exists
                    if ($currentContinentId !== null) {
                        echo '</optgroup>';
                    }

                    // Open a new optgroup for the current continent
                    echo '<optgroup label="' . $continent . '">';
                    $currentContinentId = $idContinent;
                }

                // Create an option for the pays
                echo '<option value="' . $pays . '">' . $pays . '</option>';
            }

            // Close the last optgroup
            if ($currentContinentId !== null) {
                echo '</optgroup>';
            }

            echo '</select>';

            // Close the database connection
            $conn->close();

            ?>
            <button type="button" onclick="nouveauPaysContinent()">Nouveau</button>
            <br><br>

            <label for="descVille">Descriptif:</label><BR>
            <textarea name="descriptif" maxlength="255" required></textarea><br><br>

            <fieldset>
            <a id="downloadLink" style="display: none;"></a>

                <legend>Entrer le nom d'un site avec url d'une photo et clicker sur ajouter</legend>
                <label for="nomSite">Sites:</label><BR>
                <input id="site" type="text" name="site" required><br><br>
                <label>Photos</label><BR>
                <input id="photos" type="text" name="photo" required><br>

                <button id="buttonSite" type="button" style="float: right;
                padding:10px 20px;
                margin: 5px" onclick="getSitePhoto();
                downloadImage();">Ajouter</button>

            </fieldset>
            <br>
            <input id='sqlNecessaire' type='text' name="sqlNecessaire" value="" style="display:none">
            <input id='sqlOthers' type='text' name="sqlOthers" value="" style="display:none">
            <input id='sqlSite' type='text' name="sqlSite" value="" style="display:none">
            <input id='sqlPhoto' type='text' name="sqlPhoto" value="" style="display:none">

            <label>Hotels</label><BR>
            <input id="inputHotel" type="text">
            <button type="button" onclick="addOption2('hotel','inputHotel')">Ajouter</button>
            <select id='hotel'>

            </select>
            <br><br>
            <label>Restaurants</label> <BR>
            <input id="inputRestaurant" type="text">
            <button type="button" onclick="addOption2('restaurant','inputRestaurant')">Ajouter</button>
            <select id='restaurant'>

            </select>

            <br><br>
            <label>Gares</label><BR>
            <input id="inputGare" type="text">
            <button type="button" onclick="addOption2('gare','inputGare')">Ajouter</button>
            <select id='gare'>

            </select>

            <br><br>
            <label>Airoports</label><BR>
            <input id='inputAiroport' type="text">
            <button type="button" onclick="addOption2('airoport','inputAiroport')">Ajouter</button>
            <select id='airoport'>

            </select>
            <br><br>
            <button type="submit" style="float:right;" onclick='sendSQLCommands();'>Submit</button>
            <button type="reset" style="float:right;
            margin-right:10px;">Reset</button>


        </form>
    </div>

</body>

</html>