<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (isset($_GET['delete'])) {
        file_put_contents("./database/voyage.sql", $_GET['delete'] ."\n", FILE_APPEND);
    }

    
    ?>
</body>

</html>
<?php
header("Location: index.php");
    exit;
?>