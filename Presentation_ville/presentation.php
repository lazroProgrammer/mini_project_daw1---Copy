<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Informations sur la ville</title>
    <link rel="stylesheet" type="text/css" href="presentation.css">
</head>

<body>
    <?php $conn = mysqli_connect("localhost:3306", "root", "");
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
    $query = 'SELECT * from ville v JOIN pays p ON v.idpay=p.idpay JOIN continent c ON p.idcon=c.idcon where nomvil like "' . $_GET['nomVille'] . '";';
    $result = $conn->query($query);

    if ($result === false) {
        // Error message and additional error information
        echo "Error executing the query: " . $conn->error;
    } else {
        $instance = $result->fetch_assoc();
        if ($instance !== null) {
            $desc = $instance['descvil'];
        }
    }
    ?>
    <?php
    global $conn;
    global $instance;
    $query = "SELECT * from necessaire s where s.idvil =" . $instance['idvil'] . " group by typenec;";
    $result = $conn->query($query);
    if ($result === false) {
        // Error message and additional error information
        echo "Error executing the query: " . $conn->error;
    } else {
        if ($result->num_rows > 0) {
            $items = array();
            while ($necessaire = $result->fetch_assoc()) {
                $items[] = $necessaire;
            }
        }
    }
    ?>
    <?php
    global $conn;
    global $instance;
    $query = "SELECT * from sites s where s.idvil =" . $instance['idvil'] . ";";
    $result = $conn->query($query);
    if ($result === false) {
        // Error message and additional error information
        echo "Error executing the query: " . $conn->error;
    } else {
        if ($result->num_rows > 0) {
            $sitesItems = array();
            while ($sites = $result->fetch_assoc()) {
                $sitesItems[] = $sites;
            }
        }
    }
    ?>
    <header>
        <h1><?php echo $_GET['nomVille']; ?></h1>
        <p><?php
            global $desc;
            echo $desc; ?></p>
    </header>
    <main>
        <p><?php global $instance;
            echo $_GET['nomVille'], ' est une ville de ' . $instance['nompay'] . ' qui est situe a l\'' . $instance['nomcon'] . '.'; ?>
        </p>
        <h2> Quelque sites: </h2>
        <div class='grid'>
            <?php
            global $sitesItems;
            if (isset($sitesItems)) {
                for ($i = 0; $i < count($sitesItems); $i++) {
                    echo '<figure>';
                    echo "<img src='" . $sitesItems[$i]['cheminphoto'] . "' style='max-width: 450px; max-height: 250px;'>";
                    echo "  <figcaption style='color: rgba(50,150,50,0.9);'>  " . $sitesItems[$i]['nomsit'] . "</figcaption>\n";
                    echo '</figure>';
                    echo'<figcaption></figcaption>';
                }
            }
            ?>
        </div>
        <h2> Airoport:</h2>
        <?php
        global $items;
        if (isset($items)) {
            for ($i = 0; $i < count($items); $i++) {
                if ($items[$i]['typenec'] == "airoport") {
                    echo "  <p>  - " . $items[$i]['nomnec'] . ".</p>\n";
                }
            }
        }
        ?>

        <h2> Gares: </h2>
        <?php
        global $items;
        if (isset($items)) {
            for ($i = 0; $i < count($items); $i++) {
                if ($items[$i]['typenec'] == "gare") {
                    echo "  <p>  - " . $items[$i]['nomnec'] . ".</p>\n";
                }
            }
        }
        ?>
        <h2> Hotels: </h2>
        <?php
        global $items;
        if (isset($items)) {
            for ($i = 0; $i < count($items); $i++) {
                if ($items[$i]['typenec'] == "hotel") {
                    echo "  <p>  - " . $items[$i]['nomnec'] . ".</p>\n";
                }
            }
        }
        ?>
        <h2> Restaurants: </h2>
        <?php
        global $items;
        if (isset($items)) {
            for ($i = 0; $i < count($items); $i++) {
                if ($items[$i]['typenec'] == "restaurant") {
                    echo "  <p>  - " . $items[$i]['nomnec'] . ".</p>\n";
                }
            }
        }
        ?>

    </main>

</body>

</html>