<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Page d"accueil</title>
    <script src='accueil.js'></script>
</head>

<body>


    <nav>
        <p class="eName"> School project</p>
        <hr>
        <pre>  it was about implementing
             a fully working site that 
             let you view,add,edit delete
             cities and their things
        </pre>
        <hr id="nnnn">

        <pre>  another thing
        </pre>

        <hr>
        <ul>
            <li><a href="Formulaire/Formulaire.php" id="fix"> Ajouter une ville</a></li>
        </ul>
    </nav>
    <header>
        <h1> MyTourism Guide</h1>
    </header>

    <section id="barreDeRecherche">
        <h2> <u><i>Recherche</i></u></h2>
        <br>
        <form method="post" action="index.php">
            <div>
                <label id="spec">Continent :</label>
                <input type="text" name="continent" value='' placeholder="Entrez un continent">
            </div>

            <div>
                <label id="nn">Pays :</label>
                <input type="text" name="pays" value='' placeholder="Entrez un pays">
            </div>

            <br><br>

            <div>
                <label id="spec">Ville :</label>
                <input type="text" name="ville" value='' placeholder="Entrez une ville">
            </div>


            <div>
                <label id="nn">Site :</label>
                <input type="text" name="site" value='' placeholder="Entrez un site">
            </div>

            <br><br>

            <button id="voir" type="submit">valider</button>

        </form>
        <hr>
        <h2> <u><i>Resultats</i></u></h2>
        <br>
        <?php
        // $_POST['ville'] =='' && $_POST['site']=='' && $_POST['continent']=='' && $_POST['pays']==''
        if (empty($_POST)) {
            echo "saisie les donnees pour la recherche";
            die(0);
        }
        //fetching data from our database
        $conn = mysqli_connect("localhost:3306", "root", "");
        $sqlFile = file_get_contents("database/voyage.sql");

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
        $sql = "SELECT idvil,nomvil from ville v";

        if ($_POST["pays"] != "") {

            $sql = $sql . " JOIN pays p ON p.idpay = v.idpay and p.nompay like\"" . $_POST["pays"] . "%\" ";
        }

        if ($_POST["continent"] != "" && $_POST["pays"] != '') {
            $sql = $sql . "JOIN continent c ON p.idcon = c.idcon and c.nomcon like\""  . $_POST["continent"] . "%\" ";
        }

        if ($_POST["continent"] != "" && $_POST["pays"] == '') {
            $sql = $sql . " JOIN pays p ON p.idpay = v.idpay JOIN continent c ON p.idcon = c.idcon and c.nomcon like\""  . $_POST["continent"] . "%\" ";
        }

        if ($_POST["site"] != "") {
            $sql = $sql . " JOIN sites s ON s.idvil = v.idvil and s.nomsit like \"" . $_POST["site"] . "%\" ";
        }
        if ($_POST["ville"] != "") {

            $sql = $sql . " where v.nomvil like \"" . $_POST["ville"] . "%\" ";
        }

        $sql = $sql . ";";

        $result = $conn->query($sql);
        if ($result === false) {
            echo "Error executing the query: " . $conn->error;
        } else {
            if ($result->num_rows === 0) {
                echo "no results";
            } else {
                // creer les balises a avec le noms des ville
                $resultsArray = [];
                while ($row = $result->fetch_assoc()) {
                    $resultsArray[] = $row;
                }

                for ($i = 0; $i < count($resultsArray); $i++) {
                    echo "<a href='Presentation_ville/presentation.php?nomVille=" . $resultsArray[$i]['nomvil'] . "' alt='" . $resultsArray[$i]['idvil'] . "'>" . $resultsArray[$i]['nomvil']
                        . "</a> <button><i class=\"fa-solid fa-pencil\"></i></button> <button onclick='deleteItem(" . $resultsArray[$i]['idvil']
                        . ")'><i class='fas fa-trash-can' id='trash-icon'></i></button><br>";
                }
            }
        }

        //le form dessous pour sauvgarder au fichiers voyage.sql les changes
        ?>
        <form method="get" action='delete.php' style="display:none;">
            <input id='delete' style='display:none;' name='delete' value=''>
            <button id='deletebutton' type='submit'>
        </form>

    </section>


</body>

</html>