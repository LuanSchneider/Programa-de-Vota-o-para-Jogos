<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/votacao.css">
    <title>Votação</title>
</head>
<body>
    <h2>Postagens</h2>
    <div id="postagens">
        <?php
        include("php/conectadb.php");
        $query = "SELECT * FROM postagens";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='post'>";
            echo "<img src='" . htmlspecialchars($row['imagem']) . "' alt='Imagem da postagem' style='width:200px; height:auto;'><br>";
            echo "<p>" . htmlspecialchars($row['descricao']) . "</p>";
            echo "</div>";
        }

        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
