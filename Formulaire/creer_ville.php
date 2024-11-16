<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    // entrer les continents et pays a la base de donnees
    $conn = mysqli_connect("localhost:3306", "root", "");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sqlWithLines = str_replace(';', ";\n", $_POST['sqlOthers']);

    file_put_contents("../database/voyage.sql", $sqlWithLines, FILE_APPEND);
    if ($_POST['sqlOthers'] != '') {
        echo 'pays and continents added to database<br>';
    }
    ?>

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

    $query = "SELECT * FROM pays WHERE nompay = '" . $_POST['pays'] . "';";


    $result = $conn->query($query);

    if ($result === false) {
        echo "Error executing the query: " . $conn->error;
    } else {
        $row = $result->fetch_assoc();
        if ($row !== null) {
            $sqlCommand = "insert into ville(nomvil, descvil, idpay) values(\"" . $_POST['nomVille'] . "\", \""
                . $_POST['descriptif'] . "\", " . $row['idpay'] . ");\n";
            file_put_contents("../database/voyage.sql", $sqlCommand, FILE_APPEND);
            echo 'ville added in database';
        }
    }
    mysqli_next_result($conn);
    // Executer le code de ../database/voyage.sql
    $sqlFile = file_get_contents("../database/voyage.sql");

    if (mysqli_multi_query($conn, $sqlFile)) {
        // liberer le buffer
        while (mysqli_next_result($conn)) {
            if (!mysqli_more_results($conn)) {
                break;
            }
        }
    } else {
        echo "Error executing SQL file: " . mysqli_error($conn);
    }

    //to get idvil
    $query = "SELECT * FROM ville WHERE nomvil=\"" .  $_POST['nomVille'] . "\" and descvil=\""
        . $_POST['descriptif'] . "\" and idpay= " . $row['idpay'] . ";";

    $result = $conn->query($query);
    if ($result === false) {
        // Error message and additional error information
        echo "Error executing the query: " . $conn->error;
    } else {
        $row = $result->fetch_assoc();
        if ($row !== null) {
            $text = str_replace("~", $row["idvil"], $_POST['sqlNecessaire']);
            $text = str_replace(";", ";\n", $text);
            file_put_contents("../database/voyage.sql", $text, FILE_APPEND);
            echo '<br> added necessaire to database';
        }
    }
    //inserer les sites
    $query = "insert into sites(nomsit,cheminphoto,idvil) values( \"!\", \"?\", " . $row['idvil'] . ");\n";

    $siteArray = explode('~', $_POST['sqlSite']);
    $photoArray = explode("<>", $_POST['sqlPhoto']);

    $savedText;
    for ($i = 0; $i < count($siteArray); $i++) {

        $savedText = str_replace('!", "?', $siteArray[$i] . '", "' . $photoArray[$i], $query);
        file_put_contents("../database/voyage.sql", $savedText, FILE_APPEND);
    }
    echo '<br> sites added in database.';

    $conn->close();
    ?>
    <br>
    <br>
    <br>
    <a href="../index.php">page d'accueil</a>
</body>

</html>